<?php

namespace Api\Controller;

use Think\Exception;
use Think\Log;
use Think\Daemon;

class DaemonController extends ApiBaseController
{
    private static $dbWaitTime = null;
    private static $reConnectDb = array();

    public function _initialize()
    {
        if (PHP_SAPI != 'cli') {
            die('CLI ONLY');
        }
        set_time_limit(0);
        ob_end_flush();
        $this->connectRedis();
    }

    protected function dbReConnect($sleepTime)
    {
        if (!self::$dbWaitTime) {
            $dbWaitTime = M()->query("show  global  variables like  'wait_timeout'");
            if ($dbWaitTime[0] && $dbWaitTime[0]['variable_name'] == 'wait_timeout') {
                self::$dbWaitTime = $dbWaitTime[0]['value'];
            }
        }
        $backtrace = debug_backtrace();
        $process = $backtrace[1]['function'];
        if (!isset(self::$reConnectDb[$process])) {
            $dbInfo = array('dbUnusedTime' => time());
            self::$reConnectDb[$process] = $dbInfo;
        } else {
            if ((time() - self::$reConnectDb[$process]['dbUnusedTime']) > ($sleepTime / 1000000) || (time() - self::$reConnectDb[$process]['dbUnusedTime']) > (self::$dbWaitTime * 0.8)) {
                self::$dbWaitTime == null;
                unset(self::$reConnectDb[$process]);
            }
        }
    }

    /**
     * 获取当前时间+偏移量
     */
    private function getNowTime()
    {
        $push_offset = $this->redis->get(get_redis_key('QA.PUSH_OFFSET'));
        $now = $push_offset && is_numeric($push_offset) && is_int($push_offset / 1) ? time() + $push_offset : time();

        return $now;
    }

    /**
     * 推送答题
     */
    public function pushQa()
    {

        $type = 'pushQa';
        $daemon = new Daemon($type . $type);
        if ($daemon->start()) {
            $columnModel = M('column');
            $stageModel = M('stage');
            $groupModel = M('group');
            $qaModel = M('qa');
            while ($daemon->checkRunning()) {
                try {
                    $column_info = $columnModel->field('column_id')->where(array('column_status' => 1))->find();
                    if ($column_info) {
                        $column_id = $column_info['column_id'];
                        $stage_info = $stageModel->field('stage_id')->where(array('column_id' => $column_id, 'stage_status' => 1))->find();
                        if ($stage_info) {
                            $stage_id = $stage_info['stage_id'];
                            $group_info = $groupModel->field('id')->where(array('stage_id' => $stage_id, 'group_status' => 1))->select();
                            if ($group_info) {
                                $group_id = array_column($group_info, 'id');
                                $now = $this->getNowTime();
                                $where = array(
                                    'stage_id'         => $stage_id,
                                    'group_id'         => array('IN', $group_id),
                                    'qa_start_time'    => array('ELT', $now),
                                    'qa_end_time'      => array('EGT', $now),
                                    'qa_is_used'       => 0,
                                    'qa_normal_status' => 0
                                );
                                $qa_info = $qaModel->field('id,group_id,qa_remark')->where($where)->find();
                                if ($qa_info) {
                                    $qa_id = $qa_info['id'];
                                    $qa = $this->redis->hGet(get_redis_key('QA.QA_LIST', $stage_id), $qa_id);
                                    if ($qa) {
                                        $qa = json_decode($qa, true);
                                        $qa = pack_push_qa($qa, $now);
                                        $cmd = C('QA.CMD');
                                        $res = webSocket_push($cmd['PUSH_QA'], $qa);
                                        $res = json_decode($res, true);
                                        if ($res['code'] == 0) {
											if (strtoupper($qa_info['qa_remark']) == 'END' || strtoupper($qa_info['qa_remark']) == 'STAGE_END') {
                                                $used_group_list = $this->redis->hGet(get_redis_key('QA.QA_USED_STAGE_GROUP'), $stage_id);
                                                $used_group_list = $used_group_list ? json_decode($used_group_list, true) : array();
                                                array_push($used_group_list, $qa_info['group_id']);
                                                $this->redis->hSet(get_redis_key('QA.QA_USED_STAGE_GROUP'), $stage_id, json_encode($used_group_list));
                                            }
                                            $qa_current = array('column_id' => $column_id, 'stage_id' => $stage_id, 'group_id' => $qa_info['group_id'], 'qa_id' => $qa_id);
                                            $this->redis->set(get_redis_key('QA.QA_CURRENT'), json_encode($qa_current));
                                            $update = array('qa_is_used' => 1, 'qa_normal_status' => 1, 'qa_used_time' => time());
                                            $where = array('id' => $qa_id);
                                            $update_res = $qaModel->where($where)->save($update);
                                            !$update_res && Log::write('fail:题目推送成功，状态更新失败-' . $qa_id, 'WARN', '', C('LOG_PATH') . 'PushQa_' . date('y_m_d') . '.log');
                                        } else {
                                            Log::write('fail:题目推送失败-' . $qa_id, 'WARN', '', C('LOG_PATH') . 'PushQa_' . date('y_m_d') . '.log');
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $columnModel->reConnect();
                    $stageModel->reConnect();
                    $groupModel->reConnect();
                    $qaModel->reConnect();
                    Log::write('fail：' . $e->getMessage(), 'WARN', '', C('LOG_PATH') . 'PushQa_' . date('y_m_d') . '.log');
                }
                usleep(100000);
            }
            $daemon->stop();
            unset ($daemon);
        } else {
            Log::write('fail:daemon lock', 'WARN', '', C('LOG_PATH') . 'PushQa_' . date('y_m_d') . '.log');
        }
    }

    /**
     * 推送答题结果
     */
    public function pushQaResult()
    {

        $type = 'pushQaResult';
        $daemon = new Daemon($type . $type);
        if ($daemon->start()) {
            $columnModel = M('column');
            $stageModel = M('stage');
            $groupModel = M('group');
            $qaModel = M('qa');
            while ($daemon->checkRunning()) {
                try {
                    $column_info = $columnModel->field('column_id')->where(array('column_status' => 1))->find();
                    if ($column_info) {
                        $column_id = $column_info['column_id'];
                        $stage_info = $stageModel->field('stage_id')->where(array('column_id' => $column_id, 'stage_status' => 1))->find();
                        if ($stage_info) {
                            $stage_id = $stage_info['stage_id'];
                            $group_info = $groupModel->field('id')->where(array('stage_id' => $stage_id, 'group_status' => 1))->select();
                            if ($group_info) {
                                $group_id = array_column($group_info, 'id');
                                $now = $this->getNowTime();
                                $where = array(
                                    'stage_id'         => $stage_id,
                                    'group_id'         => array('IN', $group_id),
                                    'qa_res_time'      => array('ELT', $now),
                                    'qa_is_used'       => 1,
                                    'qa_normal_status' => 1,
                                    'qa_res_is_pushed' => 0
                                );
                                $qa_info = $qaModel->field('id,group_id,qa_remark')->where($where)->find();
                                if ($qa_info) {
                                    $qa_id = $qa_info['id'];
                                    $data = array('column_id' => $column_id, 'stage_id' => $stage_id, 'group_id' => $qa_info['group_id'], 'qa_id' => $qa_id);
                                    $cmd = C('QA.CMD');
                                    $res = webSocket_push($cmd['PUSH_QA_ANSWER'], $data);
                                    $res = json_decode($res, true);
                                    if ($res['code'] == 0) {
                                        if (strtoupper($qa_info['qa_remark']) == 'END' || strtoupper($qa_info['qa_remark']) == 'STAGE_END') {
                                            $used_group_list = $this->redis->hGet(get_redis_key('QA.QA_USED_STAGE_GROUP'), $stage_id);
                                            $used_group_list = $used_group_list ? json_decode($used_group_list, true) : array();
                                            array_push($used_group_list, $qa_info['group_id']);
                                            $this->redis->hSet(get_redis_key('QA.QA_USED_STAGE_GROUP'), $stage_id, json_encode($used_group_list));
                                        }
                                        $update = array('qa_res_is_pushed' => 1, 'qa_res_pushed_time' => time());
                                        $where = array('id' => $qa_id);
                                        $update_res = $qaModel->where($where)->save($update);
                                        !$update_res && Log::write('fail:题目结果推送成功，状态更新失败-' . $qa_id, 'WARN', '', C('LOG_PATH') . 'PushQaRes_' . date('y_m_d') . '.log');
                                    } else {
                                        Log::write('fail:题目结果推送失败-' . $qa_id, 'WARN', '', C('LOG_PATH') . 'PushQaRes_' . date('y_m_d') . '.log');
                                    }
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $columnModel->reConnect();
                    $stageModel->reConnect();
                    $groupModel->reConnect();
                    $qaModel->reConnect();
                    Log::write('fail：' . $e->getMessage(), 'WARN', '', C('LOG_PATH') . 'PushQaRes_' . date('y_m_d') . '.log');
                }
                usleep(100000);
            }
            $daemon->stop();
            unset ($daemon);
        } else {
            Log::write('fail:daemon lock', 'WARN', '', C('LOG_PATH') . 'PushQaRes_' . date('y_m_d') . '.log');
        }
    }

    /**
     * 答题记录入库
     */
    public function qaLog()
    {
        $type = 'qaLog';
        $daemon = new Daemon($type . $type);
        if ($daemon->start()) {
            $qaLogModel = M('qa_log');
            while ($daemon->checkRunning()) {
                try {
                    if ($this->redis->lLen(get_redis_key('QA.QA_ANSWER_QUEUE'))) {
                        $data = $this->redis->rPop(get_redis_key('QA.QA_ANSWER_QUEUE'));
                        $this->redis->lPush(get_redis_key('QA.QA_ANSWER_CLONE_QUEUE'), $data);
                        $add_data = json_decode($data, true);
                        $add_data['answer_key'] = json_encode($add_data['answer_key']);
                        $res = $qaLogModel->add($add_data);
                        if ($res) {
                            $this->redis->lRem(get_redis_key('QA.QA_ANSWER_CLONE_QUEUE'), $data, 1);
                        } else {
                            Log::write('set qa log fail：' . $add_data['qa_id'] . '-' . $add_data['user_id'], 'WARN', '', C('LOG_PATH') . 'QaLog_' . date('y_m_d') . '.log');
                        }
                    } else if ($this->redis->lLen(get_redis_key('QA.QA_ANSWER_CLONE_QUEUE'))) {
                        $data = $this->redis->rPop(get_redis_key('QA.QA_ANSWER_CLONE_QUEUE'));
                        $this->redis->lPush(get_redis_key('QA.QA_ANSWER_QUEUE'), $data);
                        $add_data = json_decode($data, true);
                        $add_data['answer_key'] = json_encode($add_data['answer_key']);
                        $res = $qaLogModel->add($add_data);
                        if ($res) {
                            $this->redis->lRem(get_redis_key('QA.QA_ANSWER_QUEUE'), $data, 1);
                        } else {
                            Log::write('set qa log fail：' . $add_data['qa_id'] . '-' . $add_data['user_id'], 'WARN', '', C('LOG_PATH') . 'QaLog_' . date('y_m_d') . '.log');
                        }
                    }
                } catch (\Exception $e) {
                    $qaLogModel->reConnect();
                    Log::write('fail：' . $e->getMessage(), 'WARN', '', C('LOG_PATH') . 'QaLog_' . date('y_m_d') . '.log');
                }
                usleep(100000);
            }
            $daemon->stop();
            unset ($daemon);
        } else {
            Log::write('fail:daemon lock', 'WARN', '', C('LOG_PATH') . 'QaLog_' . date('y_m_d') . '.log');
        }
    }

    /**
     * 奖品领取记录
     */
    public function qaLuckyPrize()
    {
        $type = 'qaLuckyPrize';
        $daemon = new Daemon($type . $type);
        if ($daemon->start()) {
            $qaLuckyPrizeModel = M('qa_lucky_user');
            while ($daemon->checkRunning()) {
                try {
                    if ($this->redis->lLen(get_redis_key('QA.QA_LUCKY_USER_GET_PRIZE_QUEUE'))) {
                        $data = $this->redis->rPop(get_redis_key('QA.QA_LUCKY_USER_GET_PRIZE_QUEUE'));
                        $this->redis->lPush(get_redis_key('QA.QA_LUCKY_USER_GET_PRIZE_CLONE_QUEUE'), $data);
                        $add_data = json_decode($data, true);
                        if ($add_data['user_lucky_type'] == 1) {
                            $where = array('user_id' => $add_data['user_id'], 'user_lucky_type' => $add_data['user_lucky_type'], 'group_id' => $add_data['type_id']);
                        } else if ($add_data['user_lucky_type'] == 2) {
                            $where = array('user_id' => $add_data['user_id'], 'user_lucky_type' => $add_data['user_lucky_type'], 'stage_id' => $add_data['type_id']);
                        } else if ($add_data['user_lucky_type'] == 3) {
                            $where = array('user_id' => $add_data['user_id'], 'user_lucky_type' => $add_data['user_lucky_type'], 'column_id' => $add_data['type_id']);
                        }
                        $res = $qaLuckyPrizeModel->where($where)->save(array('user_lucky' => $add_data['user_lucky'], 'user_lucky_status' => 1));
                        if ($res) {
                            $this->redis->lRem(get_redis_key('QA.QA_LUCKY_USER_GET_PRIZE_CLONE_QUEUE'), $data, 1);
                        } else {
                            Log::write('set qa log fail：' . $add_data['user_lucky'], 'WARN', '', C('LOG_PATH') . 'qaLuckyPrize_' . date('y_m_d') . '.log');
                        }
                    } else if ($this->redis->lLen(get_redis_key('QA.QA_LUCKY_USER_GET_PRIZE_CLONE_QUEUE'))) {
                        $data = $this->redis->rPop(get_redis_key('QA.QA_LUCKY_USER_GET_PRIZE_CLONE_QUEUE'));
                        $this->redis->lPush(get_redis_key('QA.QA_LUCKY_USER_GET_PRIZE_QUEUE'), $data);
                        $add_data = json_decode($data, true);
                        if ($add_data['user_lucky_type'] == 1) {
                            $where = array('user_lucky_type' => $add_data['user_lucky_type'], 'group_id' => $add_data['type_id']);
                        } else if ($add_data['user_lucky_type'] == 2) {
                            $where = array('user_lucky_type' => $add_data['user_lucky_type'], 'stage_id' => $add_data['type_id']);
                        } else if ($add_data['user_lucky_type'] == 3) {
                            $where = array('user_lucky_type' => $add_data['user_lucky_type'], 'column_id' => $add_data['type_id']);
                        }
                        $res = $qaLuckyPrizeModel->where($where)->save(array('user_lucky' => $add_data['user_lucky'], 'user_lucky_status' => 1));
                        if ($res) {
                            $this->redis->lRem(get_redis_key('QA.QA_LUCKY_USER_GET_PRIZE_QUEUE'), $data, 1);
                        } else {
                            Log::write('set qa log fail：' . $add_data['user_lucky'], 'WARN', '', C('LOG_PATH') . 'qaLuckyPrize_' . date('y_m_d') . '.log');
                        }
                    }
                } catch (\Exception $e) {
                    $qaLuckyPrizeModel->reConnect();
                    Log::write('fail：' . $e->getMessage(), 'WARN', '', C('LOG_PATH') . 'qaLuckyPrize_' . date('y_m_d') . '.log');
                }
                usleep(100000);
            }
            $daemon->stop();
            unset ($daemon);
        } else {
            Log::write('fail:daemon lock', 'WARN', '', C('LOG_PATH') . 'qaLuckyPrize_' . date('y_m_d') . '.log');
        }
    }
}