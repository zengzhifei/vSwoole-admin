<?php
/**
 * Created by PhpStorm.
 * User: zengz
 * Date: 2018/1/17
 * Time: 9:15
 */

namespace Admin\Controller;


class QaLuckyController extends HudongAdminController
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

        $this->connectRedis();

        $this->assign('menuname', "中奖列表");
    }

    public function index()
    {
        $column = $this->column;
        $stage = $this->stage;
        $qa_lucky_list_type = I('qa_lucky_list_type', false);
        if ($column && $stage) {
            $column_id = $column['column_id'];
            $stage_id = $stage['stage_id'];
            $qa_current = $this->redis->get(get_redis_key('QA.QA_CURRENT'));
            if ($qa_current) {
                $qa_current = json_decode($qa_current, true);
                $group_id = $qa_current['column_id'] == $column_id && $qa_current['stage_id'] == $stage_id ? $qa_current['group_id'] : false;
                if ($group_id) {
                    $group = M('group')->where(array('id' => $group_id))->find();
                }
            }
            if ($qa_lucky_list_type) {
                $qaLuckyUserModel = M('qa_lucky_user');
                switch ($qa_lucky_list_type) {
                    case 1:
                        $find_group_id = I('group_id', false);
                        if ($find_group_id) {
                            $where = array('user_lucky_type' => 1, 'group_id' => $find_group_id);
                            $p = I('p', 1, 'intval');
                            $count = $qaLuckyUserModel->where($where)->count();
                            $Page = $this->page($count);
                            $show = $Page->weishow();
                            $lucky_user_list = $qaLuckyUserModel->where($where)->order('user_ranking+0 asc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
                        }
                        break;
                    case 2:
                        $find_stage_id = I('stage_id', false);
                        if ($find_stage_id) {
                            $where = array('user_lucky_type' => 2, 'stage_id' => $find_stage_id);
                            $p = I('p', 1, 'intval');
                            $count = $qaLuckyUserModel->where($where)->count();
                            $Page = $this->page($count);
                            $show = $Page->weishow();
                            $lucky_user_list = $qaLuckyUserModel->where($where)->order('user_ranking+0 asc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
                        }
                        break;
                    case 3:
                        $find_column_id = I('column_id', false);
                        if ($find_column_id) {
                            $where = array('user_lucky_type' => 3, 'column_id' => $find_column_id);
                            $p = I('p', 1, 'intval');
                            $count = $qaLuckyUserModel->where($where)->count();
                            $Page = $this->page($count);
                            $show = $Page->weishow();
                            $lucky_user_list = $qaLuckyUserModel->where($where)->order('user_ranking+0 asc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
                        }
                        break;
                }
            }
        }

        if ($column && $stage) {
            $group_name = $group ? $group['group_title'] : '活动未开始';
            if ($qa_lucky_list_type == 1) {
                $title = $column['column_name'] . '-' . $stage['stage_name'] . '-' . $group_name . '名单';
            } else if ($qa_lucky_list_type == 2) {
                $title = $column['column_name'] . '-' . $stage['stage_name'] . '名单';
            } else if ($qa_lucky_list_type == 3) {
                $title = $column['column_name'] . '总名单';
            } else {
                $title = '请选择抽奖名单类型';
            }
        } else {
            $title = '[栏目或期数未开启]';
        }

        $this->assign('title', $title);
        $this->assign('qa_lucky_list_type', $qa_lucky_list_type);
        $this->assign('column_id', $column_id);
        $this->assign('stage_id', $stage_id);
        $this->assign('group_id', $group_id);
        $this->assign('lucky_user_list', $lucky_user_list);
        $this->assign('p', $p);
        $this->assign('totalPage', $Page->totalPages);
        $this->assign('show', $show);
        $this->display();
    }

    /**
     * 生成中奖用户列表
     */
    public function luckyListCreate()
    {
        $column_id = I('column_id', false);
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);
        $ranking_start = I('ranking_start', false);
        $ranking_end = I('ranking_end', false);
        $qa_lucky_list_number = I('qa_lucky_list_number', false);
        $qa_lucky_list_type = I('qa_lucky_list_type', false);

        if (!$column_id || !$stage_id || !$group_id) {
            $this->ajaxReturn(array('status' => -1, 'msg' => '请在节目开始后操作'));
        }

        if (!in_array($qa_lucky_list_type, array(1, 2, 3)) || !$ranking_start || !$ranking_end || !$qa_lucky_list_number) {
            $this->ajaxReturn(array('status' => -1, 'msg' => '参数无效'));
        }

        if (($qa_lucky_list_number - 1) > ($ranking_end - $ranking_start)) {
            $this->ajaxReturn(array('status' => -2, 'msg' => '生成总数不能大于排名区间'));
        }

        switch ($qa_lucky_list_type) {
            case 1:
                $get_ranking_key = 'QA.GROUP_QA_RANKING_LIST';
                $get_ranking_id = $group_id;
                break;
            case 2:
                $get_ranking_key = 'QA.STAGE_QA_RANKING_LIST';
                $get_ranking_id = $stage_id;
                break;
            case 3:
                $get_ranking_key = 'QA.TOTAL_QA_RANKING_LIST';
                $get_ranking_id = false;
                break;
        }

        $max_ranking_count = $this->redis->zCard(get_redis_key($get_ranking_key, $get_ranking_id));
        $ranking_end = $ranking_end > $max_ranking_count ? $max_ranking_count : $ranking_end;
        $qa_lucky_list_number = ($qa_lucky_list_number - 1) > ($ranking_end - $ranking_start) ? $ranking_end - $ranking_start + 1 : $qa_lucky_list_number;

        $rand_init_array = range($ranking_start, $ranking_end);
        $rand_array = array_rand($rand_init_array, $qa_lucky_list_number);
        $rand_array_key = is_array($rand_array) ? $rand_array : array($rand_array);
        $lucky_list = array();
		       
		shuffle($rand_array_key);

        foreach ($rand_array_key as $key => $ranking_key) {
            $ranking = $rand_init_array[$ranking_key];
            $ranking_user = $this->redis->zRevRange(get_redis_key($get_ranking_key, $get_ranking_id), $ranking - 1, $ranking - 1);
            $user_id = $ranking_user[0];
            $ranking_user_info = $this->redis->hGet(get_redis_key('QA.QA_USER_INFO'), $user_id);
            $ranking_user_info = json_decode($ranking_user_info, true);
            $lucky_list[$key] = array(
                'column_id'       => $column_id,
                'stage_id'        => $stage_id,
                'group_id'        => $group_id,
                'user_id'         => $user_id,
                'user_name'       => $ranking_user_info['user_name'] ? $ranking_user_info['user_name'] : '',
                'user_source'     => $ranking_user_info['user_source'] ? $ranking_user_info['user_source'] : '',
                'user_phone'      => $ranking_user_info['user_phone'] ? $ranking_user_info['user_phone'] : '',
                'user_head'       => $ranking_user_info['user_head'] ? $ranking_user_info['user_head'] : '',
                'user_age'        => $ranking_user_info['user_age'] ? $ranking_user_info['user_age'] : '',
                'user_sex'        => $ranking_user_info['user_sex'] ? $ranking_user_info['user_sex'] : '',
                'user_city'       => $ranking_user_info['user_city'] ? $ranking_user_info['user_city'] : '',
                'user_ranking'    => $ranking,
                'user_lucky_type' => $qa_lucky_list_type,
                'user_create'     => time()
            );
        }
		
        if (count($lucky_list)) {
            $qaLuckyUserModel = M('qa_lucky_user');
            switch ($qa_lucky_list_type) {
                case 1:
                    $where = array('user_lucky_type' => 1, 'group_id' => $group_id);
                    break;
                case 2:
                    $where = array('user_lucky_type' => 2, 'stage_id' => $stage_id);
                    break;
                case 3:
                    $where = array('user_lucky_type' => 3, 'column_id' => $column_id);
                    break;
            }

            $del_res = $qaLuckyUserModel->where($where)->delete();
            $add_res = $qaLuckyUserModel->addAll($lucky_list);
            if ($add_res) {
                $this->ajaxReturn(array('status' => 1, 'msg' => '生成成功'));
            }
        }
        $this->ajaxReturn(array('status' => 0, 'msg' => '生成失败'));
    }

    /**
     * 删除中奖用户
     */
    public function deleteLuckyUser()
    {
        $user_ids = I('lucky_user', false);
        $qa_lucky_list_type = I('qa_lucky_list_type', false);
        $column_id = I('column_id', false);
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);
        if ($user_ids) {
            $qaLuckyUserModel = M('qa_lucky_user');
            $field = 'user_id';
            $lucky_user_list = $qaLuckyUserModel->field($field)->where(array('id' => array('IN', $user_ids)))->select();
            if ($lucky_user_list) {
                if ($qa_lucky_list_type == 1) {
                    $delKey = get_redis_key('QA.GROUP_QA_LUCKY_USER', $group_id);
                } else if ($qa_lucky_list_type == 2) {
                    $delKey = get_redis_key('QA.STAGE_QA_LUCKY_USER', $stage_id);
                } else if ($qa_lucky_list_type == 3) {
                    $delKey = get_redis_key('QA.TOTAL_QA_LUCKY_USER', $column_id);
                }
                foreach ($lucky_user_list as $value) {
                    $this->redis->zRem($delKey, $value['user_id']);
                }
                $res = $qaLuckyUserModel->where(array('id' => array('IN', $user_ids)))->delete();
                if ($res) {
                    $this->ajaxReturn(array('status' => 1, 'msg' => '删除成功'));
                }
            }
        }
        $this->ajaxReturn(array('status' => 0, 'msg' => '删除失败'));
    }

    /**
     * 中奖用户写入缓存
     */
    public function syncQaLuckyUserList()
    {
        $column_id = I('column_id', false);
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);
        $qa_lucky_list_type = I('qa_lucky_list_type', false);

        if (!$column_id || !$stage_id || !$group_id) {
            $this->ajaxReturn(array('status' => -1, 'msg' => '请在节目开始后操作'));
        }

        if (!in_array($qa_lucky_list_type, array(1, 2, 3))) {
            $this->ajaxReturn(array('status' => -1, 'msg' => '参数无效'));
        }

        $qaLuckyUserModel = M('qa_lucky_user');
        switch ($qa_lucky_list_type) {
            case 1:
                $where = array('user_lucky_type' => 1, 'group_id' => $group_id);
                $lucky_list_key = get_redis_key('QA.GROUP_QA_LUCKY_USER', $group_id);
                break;
            case 2:
                $where = array('user_lucky_type' => 2, 'stage_id' => $stage_id);
                $lucky_list_key = get_redis_key('QA.STAGE_QA_LUCKY_USER', $stage_id);
                break;
            case 3:
                $where = array('user_lucky_type' => 3, 'column_id' => $column_id);
                $lucky_list_key = get_redis_key('QA.TOTAL_QA_LUCKY_USER', $column_id);
                break;
        }
        $field = 'user_id,user_ranking';
        $lucky_user_list = $qaLuckyUserModel->field($field)->where($where)->order('user_ranking+0 asc')->select();
        if (!$lucky_user_list) {
            $this->ajaxReturn(array('status' => -2, 'msg' => '没有生成中奖用户名单'));
        }

        $this->redis->del($lucky_list_key);
        foreach ($lucky_user_list as $key => $value) {
            $this->redis->zAdd($lucky_list_key, $value['user_ranking'], $value['user_id']);
        }

        if ($this->redis->zCard($lucky_list_key) == count($lucky_user_list)) {
            $qaLuckyUserModel->where($where)->save(array('user_status' => 1));
            $this->ajaxReturn(array('status' => 1, 'msg' => '同步成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'msg' => '同步失败'));
        }
    }

    //导出中奖名单
    public function exportQaLuckyUserList()
    {
        set_time_limit(0);

        $column_id = I('column_id', false);
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);
        $qa_lucky_list_type = I('qa_lucky_list_type', false);
        switch ($qa_lucky_list_type) {
            case 1:
                $where = array('user_lucky_type' => 1, 'group_id' => $group_id);
                break;
            case 2:
                $where = array('user_lucky_type' => 2, 'stage_id' => $stage_id);
                break;
            case 3:
                $where = array('user_lucky_type' => 3, 'column_id' => $column_id);
                break;
        }

        if ($where) {
            $qaLuckyUserModel = M('qa_lucky_user');
            $lucky_user_list = $qaLuckyUserModel->where($where)->select();
            $str = '';
            foreach ($lucky_user_list as $k => $v) {
                $user_name = str_replace(",", "，", $v["user_name"]);
                $user_name = str_replace(array("\r\n", "\r", "\n"), '', $user_name);
                $user_source = $v['user_source'] == 1 ? 'APP' : '其他';
                $user_phone = $v['user_phone'];
                $user_head = $v['user_head'];
                $user_age = $v['user_age'];
                $user_sex = $v['user_sex'];
                $user_city = $v['user_city'];
                $user_lucky = $v['user_lucky'];
                $user_lucky_status = $v['user_lucky_status'] == 1 ? '已领奖' : '未领奖';
                $user_status = $v['user_status'] == 1 ? '已确认' : '未确认';
                $user_ranking = $v['user_ranking'];

                $str .= $user_ranking . "," . $user_name . "," . $user_phone . "," . $user_head . "," . $user_age . "," . $user_sex . "," . $user_city . "," . $user_source . "," . $user_status . "," . $user_lucky_status . "," . $user_lucky . "\n";
            }

        } else {
            $str = "暂无数据";
        }

        $data = mb_convert_encoding($str, "gb2312", "UTF-8");
        $title = "排名, 昵称, 电话, 头像, 年龄,性别, 详细地址,来源, 是否确认,是否领奖,中奖码\n";
        $filename = "中国诗词大会-中奖名单.csv";
        $this->export_csv($title, $filename, $data);
    }

    //中奖纪录
    public function qaLuckyLog()
    {
        $this->assign('menuname', "中奖纪录");
        $column = $this->column;
        if ($column) {
            $column_id = $column['column_id'];
            $stage_list = M('stage')->where(array('column_id' => $column_id))->select();
            $find_column_id = I('find_column_id', false);
            $find_stage_id = I('find_stage_id', false);
            $find_group_id = I('find_group_id', false);
            if ($find_column_id && !$find_stage_id && !$find_group_id) {
                $where = array('column_id' => $find_column_id, 'user_lucky_type' => 3);
            } else if ($find_column_id && $find_stage_id && !$find_group_id) {
                $where = array('stage_id' => $find_stage_id, 'user_lucky_type' => 2);
            } else if ($find_column_id && $find_stage_id && $find_group_id) {
                $where = array('group_id' => $find_group_id, 'user_lucky_type' => 1);
            }
            if ($where) {
                $qaLuckyUserModel = M('qa_lucky_user');
                $p = I('p', 1, 'intval');
                $total = $qaLuckyUserModel->where($where)->count();
                $Page = $this->page($total);
                $show = $Page->weishow();
                $totalPage = $Page->totalPages;

                $lucky_user_list = $qaLuckyUserModel->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            }
            if ($find_stage_id) {
                $group_list = M('group')->where(array('stage_id' => $find_stage_id))->select();
            }
        }
        $this->assign('column', $column);
        $this->assign('stage_list', $stage_list);
        $this->assign('group_list', $group_list);
        $this->assign('find_column_id', $find_column_id);
        $this->assign('find_stage_id', $find_stage_id);
        $this->assign('find_group_id', $find_group_id);
        $this->assign('lucky_user_list', $lucky_user_list);
        $this->assign('p', $p);
        $this->assign('totalPage', $totalPage);
        $this->assign('show', $show);
        $this->display('luckyLog');
    }

    /**
     * 奖品页
     */
    public function luckyPrize()
    {
        $this->assign('menuname', "奖品管理");
        $column = $this->column;
        if ($column) {
            $column_id = $column['column_id'];
            $stage_list = M('stage')->where(array('column_id' => $column_id))->select();
            $qa_lucky_prize_type = I('qa_lucky_prize_type', false);
            $qa_lucky_prize_type && $where['lucky_prize_type'] = $qa_lucky_prize_type;
            $find_grade_id = I('find_grade_id', false);
            $find_grade_id && $where['lucky_prize_grade'] = $find_grade_id;
            $find_column_id = I('find_column_id', false);
            $find_stage_id = I('find_stage_id', false);
            $find_group_id = I('find_group_id', false);
            if ($find_column_id && !$find_stage_id && !$find_group_id) {
                $where['column_id'] = $find_column_id;
            } else if ($find_column_id && $find_stage_id && !$find_group_id) {
                $where['column_id'] = $find_column_id;
                $where['stage_id'] = $find_stage_id;
            } else if ($find_column_id && $find_stage_id && $find_group_id) {
                $where['column_id'] = $find_column_id;
                $where['stage_id'] = $find_stage_id;
                $where['group_id'] = $find_group_id;
            }
            if ($where) {
                $qaLuckyPrizeModel = M('qa_lucky_prize');
                $p = I('p', 1, 'intval');
                $total = $qaLuckyPrizeModel->where($where)->count();
                $Page = $this->page($total);
                $show = $Page->weishow();
                $totalPage = $Page->totalPages;

                $lucky_prize_list = $qaLuckyPrizeModel->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            }
            if ($find_stage_id) {
                $group_list = M('group')->where(array('stage_id' => $find_stage_id))->select();
            }

            $lucky_prize_grade = array();
            for ($i = 1; $i <= 10; $i++) {
                $lucky_prize_grade[$i]['grade_id'] = $i;
                $lucky_prize_grade[$i]['grade_name'] = $i . '等奖';
            }
        }
        $this->assign('column', $column);
        $this->assign('stage_list', $stage_list);
        $this->assign('group_list', $group_list);
        $this->assign('qa_lucky_prize_type', $qa_lucky_prize_type);
        $this->assign('find_grade_id', $find_grade_id);
        $this->assign('find_column_id', $find_column_id);
        $this->assign('find_stage_id', $find_stage_id);
        $this->assign('find_group_id', $find_group_id);
        $this->assign('lucky_prize_list', $lucky_prize_list);
        $this->assign('lucky_prize_grade', $lucky_prize_grade);
        $this->assign('p', $p);
        $this->assign('totalPage', $totalPage);
        $this->assign('show', $show);
        $this->display();
    }

    //导入奖品名单
    public function importPrize()
    {
        set_time_limit(0);
        $prize_list = $_FILES['prize_list'];
        $qa_lucky_prize_type = I('qa_lucky_prize_type', false);
        $find_grade_id = I('find_grade_id', false);
        $find_column_id = I('find_column_id', false);
        $find_stage_id = I('find_stage_id', false);
        $find_group_id = I('find_group_id', false);
        if ($qa_lucky_prize_type == 1 && $find_column_id && $find_stage_id && $find_group_id) {
            $where['lucky_prize_type'] = $qa_lucky_prize_type;
            $where['column_id'] = $find_column_id;
            $where['stage_id'] = $find_stage_id;
            $where['group_id'] = $find_group_id;
        } else if ($qa_lucky_prize_type == 2 && $find_column_id && $find_stage_id) {
            $where['lucky_prize_type'] = $qa_lucky_prize_type;
            $where['column_id'] = $find_column_id;
            $where['stage_id'] = $find_stage_id;
        } else if ($qa_lucky_prize_type == 3 && $find_column_id) {
            $where['lucky_prize_type'] = $qa_lucky_prize_type;
            $where['column_id'] = $find_column_id;
        } else {

            $this->ajaxReturn(array('status' => -1, 'msg' => '没有选择导入奖品的类型相关参数'));
        }
        $data = array();
        if ($prize_list['tmp_name']) {
            $prize_list = file_get_contents($prize_list['tmp_name']);
            $prize_list = explode("\r\n", $prize_list);
            foreach ($prize_list as $key => $prize) {
                $prize_info = explode(" ", $prize);
                $data[] = array(
                    'column_id'          => $find_column_id,
                    'stage_id'           => $find_stage_id,
                    'group_id'           => $find_group_id,
                    'lucky_prize_type'   => $qa_lucky_prize_type,
                    'lucky_prize_title'  => mb_detect_encoding($prize_info[0], array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5')) ? mb_convert_encoding($prize_info[0], 'UTF-8', mb_detect_encoding($prize_info[0], array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'))) : $prize_info[0],
                    'lucky_prize_number' => $prize_info[1],
                    'lucky_prize_key'    => $prize_info[2],
                    'lucky_prize_grade'  => $find_grade_id,
                    'operate_time'       => time()
                );
            }
            $res = M('qa_lucky_prize')->addAll($data);
            if ($res) {
                if ($qa_lucky_prize_type == 1) {
                    $lucky_prize_list_key = get_redis_key('QA.QA_LUCKY_PRIZE_QUEUE', array('group_id' => $find_group_id, 'grade_id' => $find_grade_id));
                } else if ($qa_lucky_prize_type == 2) {
                    $lucky_prize_list_key = get_redis_key('QA.QA_LUCKY_PRIZE_QUEUE', array('stage_id' => $find_stage_id, 'grade_id' => $find_grade_id));
                } else if ($qa_lucky_prize_type == 3) {
                    $lucky_prize_list_key = get_redis_key('QA.QA_LUCKY_PRIZE_QUEUE', array('column_id' => $find_column_id, 'grade_id' => $find_grade_id));
                }
                $this->redis->del($lucky_prize_list_key);
                $lucky_prize_list = M('qa_lucky_prize')->where($where)->select();
                foreach ($lucky_prize_list as $value) {
                    $this->redis->rPush($lucky_prize_list_key, json_encode($value));
                }
                $this->ajaxReturn(array('status' => 1, 'msg' => '成功'));
            } else {
                $this->ajaxReturn(array('status' => 0, 'msg' => '导入失败'));
            }
        } else {
            $this->ajaxReturn(array('status' => 0, 'msg' => '上传文件失败'));
        }
    }

    /**
     * 删除奖品列表
     */
    public function deleteLuckyPrize()
    {
        $qa_lucky_prize_type = I('qa_lucky_prize_type', false);
        $find_grade_id = I('find_grade_id', false);
        $find_column_id = I('find_column_id', false);
        $find_stage_id = I('find_stage_id', false);
        $find_group_id = I('find_group_id', false);
        if ($qa_lucky_prize_type == 1 && $find_column_id && $find_stage_id && $find_group_id) {
            $where['lucky_prize_type'] = $qa_lucky_prize_type;
            $where['column_id'] = $find_column_id;
            $where['stage_id'] = $find_stage_id;
            $where['group_id'] = $find_group_id;
        } else if ($qa_lucky_prize_type == 2 && $find_column_id && $find_stage_id) {
            $where['lucky_prize_type'] = $qa_lucky_prize_type;
            $where['column_id'] = $find_column_id;
            $where['stage_id'] = $find_stage_id;
        } else if ($qa_lucky_prize_type == 3 && $find_column_id) {
            $where['lucky_prize_type'] = $qa_lucky_prize_type;
            $where['column_id'] = $find_column_id;
        } else {
            $this->ajaxReturn(array('status' => -1, 'msg' => '没有选择删除奖品的类型相关参数'));
        }
        if ($find_grade_id) {
            $where['lucky_prize_grade'] = $find_grade_id;
            $res = M('qa_lucky_prize')->where($where)->delete();
            if ($res) {
                if ($qa_lucky_prize_type == 1) {
                    $this->redis->del(get_redis_key('QA.QA_LUCKY_PRIZE_QUEUE', array('group_id' => $find_group_id, 'grade_id' => $find_grade_id)));
                } else if ($qa_lucky_prize_type == 2) {
                    $this->redis->del(get_redis_key('QA.QA_LUCKY_PRIZE_QUEUE', array('stage_id' => $find_stage_id, 'grade_id' => $find_grade_id)));
                } else if ($qa_lucky_prize_type == 3) {
                    $this->redis->del(get_redis_key('QA.QA_LUCKY_PRIZE_QUEUE', array('column_id' => $find_column_id, 'grade_id' => $find_grade_id)));
                }
                $this->ajaxReturn(array('status' => 1, 'msg' => '删除成功'));
            } else {
                $this->ajaxReturn(array('status' => 0, 'msg' => '删除失败'));
            }
        } else {
            $res = M('qa_lucky_prize')->where($where)->delete();
            if ($res) {
                if ($qa_lucky_prize_type == 1) {
                    $delKeys = $this->redis->keys(get_redis_key('QA.QA_LUCKY_PRIZE_QUEUE', array('group_id' => $find_group_id)) . '*');
                } else if ($qa_lucky_prize_type == 2) {
                    $delKeys = $this->redis->keys(get_redis_key('QA.QA_LUCKY_PRIZE_QUEUE', array('stage_id' => $find_stage_id)) . '*');
                } else if ($qa_lucky_prize_type == 3) {
                    $delKeys = $this->redis->keys(get_redis_key('QA.QA_LUCKY_PRIZE_QUEUE', array('column_id' => $find_column_id)) . '*');
                }
                $this->redis->del(array_reduce($delKeys, 'array_merge', array()));
                $this->ajaxReturn(array('status' => 1, 'msg' => '删除成功'));
            } else {
                $this->ajaxReturn(array('status' => 0, 'msg' => '删除失败'));
            }
        }
    }
}