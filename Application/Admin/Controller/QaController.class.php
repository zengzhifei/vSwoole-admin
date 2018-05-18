<?php
/**
 * User: zengzhifei
 * Date: 2017/5/16
 * Time: 16:55
 */

namespace Admin\Controller;


class QaController extends HudongAdminController
{
    public function _initialize()
    {
        parent::_initialize();

        $this->connectRedis();

        $this->assign('menuname', "问答列表");
    }

    /**
     * 问答首页
     */
    public function index()
    {
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);

        if (!$stage_id) {
            $stage_info = $this->stage;
            $stage_id = $stage_info ? $stage_info['stage_id'] : false;
            $data['stage_info'] = $stage_info;
        }

        if ($stage_id && $group_id) {
            if (!$data['stage_info']) {
                $stageModel = D('stage');
                $stage_where = array('stage_id' => $stage_id);
                $stage_info = $stageModel->getStageInfo($stage_where);
                $data['stage_info'] = $stage_info;
            }
            if (!$data['group_info']) {
                $groupModel = D('group');
                $group_where = array('id' => $group_id);
                $group_info = $groupModel->getGroupInfo($group_where);
                $data['group_info'] = $group_info;
            }
            if ($stage_info) {
                $columnModel = D('column');
                $column_where = array('column_id' => $stage_info['column_id']);
                $column_info = $columnModel->getColumnInfo($column_where);
                $data['column_info'] = $column_info;
            }

            $qaModel = D('Qa');
            $where = array('stage_id' => $stage_id, 'group_id' => $group_id);
            $total = $qaModel->getQaCount($where);
            $Page = $this->page($total, $where);

            $data['page']['show'] = $Page->weishow();
            $data['page']['totalPage'] = $Page->totalPages;
            $data['page']['p'] = I('p', 1, 'intval');

            $qaList = $qaModel->getQaList($Page->firstRow, $Page->listRows, $where);

            $qaOptionModel = D('QaOption');
            $qaLogModel = D('QaLog');

            if ($qaList) {
                $qa_list_ids = $this->redis->hKeys(get_redis_key('QA.QA_LIST', $stage_info['stage_id']));
                foreach ($qaList as $key => $qa) {
                    //题面图片
                    if ($qa['qa_subject_img'] > 0) {
                        $img_where = array('id' => $qa['qa_subject_img']);
                        $img_info = $this->getImageinfo($img_where);
                        $qaList[$key]['qa_subject_img'] = C('PAGE_URL') . $img_info[0]['path'];
                    }
                    //答题时区
                    $qaList[$key]['qa_time'] = $qa['qa_start_time'] && $qa['qa_end_time'] ? date('Y/m/d H:i:s', $qa['qa_start_time']) . '-' . date('Y/m/d H:i:s', $qa['qa_end_time']) : '';
                    //发答题时区
                    $qaList[$key]['qa_res_time'] = $qa['qa_res_time'] ? date('Y/m/d H:i:s', $qa['qa_res_time']) : '';
                    //选项
                    $qaOption_where = array('qa_id' => $qa['id']);
                    $qaOption_info = $qaOptionModel->getQaOptionInfo($qaOption_where);
                    foreach ($qaOption_info as $option_key => $option_value) {
                        if ($option_value['option_img'] > 0) {
                            $option_img_where = array('id' => $option_value['option_img']);
                            $option_img_info = $this->getImageinfo($option_img_where);
                            $qaOption_info[$option_key]['option_img'] = C('PAGE_URL') . $option_img_info[0]['path'];
                        }
                    }
                    $qaList[$key]['qa_options'] = $qaOption_info;
                    $qaList[$key]['qa_right_key'] = json_decode($qa['qa_right_key'], true);
                    $qaList[$key]['qa_bind_modules'] = json_decode($qa['qa_bind_modules'], true);
                    //得分
                    /* $qa_log_xs_where = array('qa_id' => $qa['id'], 'user_type' => 1004);
                     $xs_info = $qaLogModel->getQaLogInfo($qa_log_xs_where);
                     $qaList[$key]['qa_xs_name'] = $xs_info ? $xs_info['user_name'] : '未答题';
                     $qaList[$key]['qa_xs_right'] = $xs_info ? $xs_info['is_right'] : -1;
                     $qa_log_where = array('qa_id' => $qa['id'], 'user_type' => 1003, 'is_right' => 1);
                     $right_count = $qaLogModel->getQaLogCount($qa_log_where);
                     $qaList[$key]['qa_xs_score'] = $qa['qa_is_used'] == 1 ? 100 - $right_count : '未开始';*/
                    //预热状态
                    $qaList[$key]['qa_sync_status'] = $qa_list_ids && in_array($qa['id'], $qa_list_ids) ? 1 : 0;
                }
            }
            $data['pageInfo'] = $qaList ? $qaList : null;
            $data['pageParam']['stage_id'] = $stage_id;
            $data['pageParam']['group_id'] = $group_id;
        }

        $data['pageTitle'] = '问答列表';
        $this->assign('data', $data);
        $this->assign('group_id', $group_id);
        $this->display();
    }

    /**
     * 添加 / 编辑问答
     */
    public function addEdit()
    {
        $qaId = I('qa_id', false);
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);

        if ($qaId && $qaId > 0) {
            $qaModel = D('Qa');
            $where = array('id' => $qaId);
            $qa_info = $qaModel->getQaInfo($where);
            if ($qa_info) {
                if ($qa_info['qa_subject_img'] > 0) {
                    $img_where = array('id' => $qa_info['qa_subject_img']);
                    $img_info = $this->getImageinfo($img_where);
                    $qa_info['qa_subject_img_view'] = C('PAGE_URL') . $img_info[0]['path'];
                }
                $qaOptionModel = D('QaOption');
                $qaOption_where = array('qa_id' => $qa_info['id']);
                $qaOption_info = $qaOptionModel->getQaOptionInfo($qaOption_where);
                foreach ($qaOption_info as $option_key => $option_value) {
                    if ($option_value['option_img'] > 0) {
                        $option_img_where = array('id' => $option_value['option_img']);
                        $option_img_info = $this->getImageinfo($option_img_where);
                        $qaOption_info[$option_key]['option_img_view'] = C('PAGE_URL') . $option_img_info[0]['path'];
                    }
                }
                $qa_info['qa_time'] = $qa_info['qa_start_time'] && $qa_info['qa_end_time'] ? date('Y/m/d H:i:s', $qa_info['qa_start_time']) . '-' . date('Y/m/d H:i:s', $qa_info['qa_end_time']) : '';
                $qa_info['qa_res_time'] = $qa_info['qa_res_time'] ? date('Y/m/d H:i:s', $qa_info['qa_res_time']) : '';
                $qa_info['qa_right_key'] = json_decode($qa_info['qa_right_key'], true);
                $qa_info['qa_bind_modules'] = json_decode($qa_info['qa_bind_modules'], true);
                $qa_info['qa_options'] = $qaOption_info;
                $data['pageInfo'] = json_encode($qa_info);
            }
        }

        $data['pageTitle'] = $qaId ? '编辑问答' : '添加问答';
        $data['pageParam']['stage_id'] = $stage_id;
        $data['pageParam']['group_id'] = $group_id;
        R('Module/showModules');

        $this->assign('data', $data);
        $this->assign('stage_id', $stage_id);
        $this->display();
    }

    /**
     * 保存问答
     */
    public function saveQa()
    {
        $data = array(
            'stage_id'        => I('stageId', false),
            'group_id'        => I('groupId', false),
            'qa_type'         => I('qaType', false),
            'qa_type_name'    => I('qaTypeName', false),
            'qa_subject'      => I('qaSubject', false, 'json_filter'),
            'qa_subject_img'  => I('qaSubjectImg', false),
            'qa_title'        => I('qaTitle', false, 'json_filter'),
            'qa_countdown'    => I('qaCountdown', 0, 'json_filter'),
            'qa_res_time'     => I('qaResTime', false) ? strtotime(I('qaResTime')) : '',
            'qa_right_key'    => I('qaAnswer', false) ? json_encode(I('qaAnswer')) : '',
            'qa_answer_sort'  => I('qaAnswerSort', 0),
            'qa_extend'       => I('qaExtend', false, 'json_filter'),
            'qa_extend_zcr'   => I('qaExtendZcr', false, 'json_filter'),
            'qa_remark'       => I('qaRemark', false, 'json_filter'),
            'qa_bind_modules' => I('qaBindModules', false),
            'qa_created'      => I('qaCreated', false) ? I('qaCreated') : time(),
            'qa_updated'      => time()
        );
        $data['qa_bind_modules'] = $data['qa_bind_modules'] && count($data['qa_bind_modules']) ? json_encode($data['qa_bind_modules']) : '';
        $qa_time = I('qaTime', false);
        if ($qa_time) {
            list($startTime, $endTime) = explode('-', $qa_time);
            $data['qa_start_time'] = strtotime($startTime);
            $data['qa_end_time'] = strtotime($endTime);
        }

        if (!$data['stage_id'] || !$data['group_id']) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少期数ID或分组ID'));
        }
        if (!$data['qa_type']) {
            $this->ajaxReturn(array('status' => -2, 'info' => '缺少问答类型'));
        }
        if (!$data['qa_subject']) {
            $this->ajaxReturn(array('status' => -3, 'info' => '缺少问答题面'));
        }

        $qa_id = I('qaId', false);
        $where = $qa_id ? array('id' => $qa_id) : null;
        $qaModel = D('qa');
        $save_qa_res = $qaModel->saveQa($data, $where);

        if ($save_qa_res) {
            $qa_id = $qa_id ? $qa_id : $save_qa_res;
            $options = I('qaOptions', false, 'json_filter');
            $options_img = I('qaOptionsImg', false);
            $data_options = array();
            if ($options) {
                foreach ($options as $key => $value) {
                    foreach ($value as $k => $v) {
                        $data_options[] = array(
                            'qa_id'         => $qa_id,
                            'option_number' => $k,
                            'option_title'  => $v,
                            'option_img'    => $options_img && $options_img[$key][$k] ? $options_img[$key][$k] : ''
                        );
                    }
                }
            }
            if ($options_img) {
                foreach ($options_img as $key => $value) {
                    foreach ($value as $k => $v) {
                        if (!$options[$key][$k]) {
                            $data_options[] = array(
                                'qa_id'         => $qa_id,
                                'option_number' => $k,
                                'option_title'  => '',
                                'option_img'    => $v
                            );
                        }
                    }
                }
            }

            $delete_options_where = array('qa_id' => $qa_id);
            $qaOptionModel = D('QaOption');
            $qaOptionModel->deleteQaOption($delete_options_where);
            if ($data_options) {
                $save_options_res = $qaOptionModel->saveQaOptionAll($data_options);
            }

            $this->ajaxReturn(array('status' => 1, 'info' => '保存成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '保存失败'));
        }
    }

    /**
     * 开启关闭问答
     */
    public function switchQa()
    {
        $qa_id = I('qa_id', false);
        $qa_status = I('qa_status', false);
        $status_type = I('status_type', 0);

        if (!$qa_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少问答ID'));
        }

        $qaModel = D('qa');

        if ($qa_status == 1) {
            $close_all_where = array('stage_id' => $this->stage['stage_id'], 'id' => array('NEQ', $qa_id));
            $close_all_data = array('qa_player_status' => 0, 'qa_normal_status' => 0);
            $close_res = $qaModel->saveQa($close_all_data, $close_all_where);
        }

        $where = array('id' => $qa_id);
        if ($status_type == 1 || $status_type == 2) {
            $do_status_type = $status_type == 1 ? 'qa_player_status' : 'qa_normal_status';
            $data = array($do_status_type => $qa_status, 'qa_is_used' => 1);
        } else {
            $data = array('qa_player_status' => $qa_status, 'qa_normal_status' => $qa_status, 'qa_is_used' => 1);
        }
        $res = $qaModel->saveQa($data, $where);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '操作成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
        }
    }

    /**
     * 刷新问答
     * 更新问答时间字段，返回md5值产生变化，达到刷新题目目的。
     */
    public function refresh()
    {
        $qa_id = I('qa_id', false);

        if (!$qa_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少问答ID'));
        }

        $qaModel = D('Qa');
        $where = array('id' => $qa_id);
        $data = array('qa_updated' => time());
        $res = $qaModel->saveQa($data, $where);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '刷新成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '刷新失败'));
        }
    }

    /**
     * 删除问答及选项
     */
    public function deleteQa()
    {
        $qa_id = I('qa_id', false);

        if (!$qa_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少问答ID'));
        }

        $qaModel = D('Qa');
        $where = array('id' => $qa_id);
        $qa_info = $qaModel->getQaInfo($where);
        if ($qa_info['qa_player_status'] == 1 || $qa_info['qa_normal_status'] == 1) {
            $this->ajaxReturn(array('status' => -2, 'info' => '当前问答正在运行'));
        }
        $res = $qaModel->deleteQa($where);

        if ($res) {
            $qaOptionModel = D('QaOption');
            $where = array('qa_id' => $qa_id);
            $delete_option_res = $qaOptionModel->deleteQaOption($where);
            $this->ajaxReturn(array('status' => 1, 'info' => '删除问答成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '删除问答失败'));
        }

    }

    /**
     * 获取问答题目内容
     */
    public function getQaInfo()
    {
        $qa_id = I('qa_id' . false);

        if (!$qa_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少qaId'));
        }

        $where = array('id' => $qa_id);
        $qaModel = D('Qa');
        $qa = $qaModel->getQaInfo($where);

        if (!$qa) {
            $this->ajaxReturn(array('status' => 0, 'info' => '没有问答信息'));
        } else {
            //题面图片
            if ($qa['qa_subject_img'] > 0) {
                $img_where = array('id' => $qa['qa_subject_img']);
                $img_info = $this->getImageinfo($img_where);
                $qa['qa_subject_img'] = C('PAGE_URL') . $img_info[0]['path'];
            }
            //选项
            $qaOptionModel = D('QaOption');
            $qaOption_where = array('qa_id' => $qa['id']);
            $qaOption_info = $qaOptionModel->getQaOptionInfo($qaOption_where);
            foreach ($qaOption_info as $option_key => $option_value) {
                if ($option_value['option_img'] > 0) {
                    $option_img_where = array('id' => $option_value['option_img']);
                    $option_img_info = $this->getImageinfo($option_img_where);
                    $qaOption_info[$option_key]['option_img'] = C('PAGE_URL') . $option_img_info[0]['path'];
                }
            }
            $qa['qa_options'] = $qaOption_info;
            $qa['qa_right_key'] = json_decode($qa['qa_right_key'], true);
            $qa['qa_bind_modules'] = json_decode($qa['qa_bind_modules'], true);
            $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $qa));
        }
    }

    /**
     *
     * 答题详情
     */
    public function detail()
    {
        $qa_id = I('qa_id' . false);

        if (!$qa_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少qaId'));
        }

        $where = array('qa_id' => $qa_id);
        $qaLogModel = D('QaLog');
        $list = $qaLogModel->getQaLogList($where);

        if (!$list) {
            $this->ajaxReturn(array('status' => 0, 'info' => '没有答题数据'));
        }

        foreach ($list as $key => $value) {
            if ($value['user_type'] == 1003) {
                $data['brt'][$value['user_id']] = $value;
            } else if ($value['user_type'] == 1004) {
                $data['xs'][$key] = $value;
            } else if ($value['user_type'] == 1005) {
                $data['ysj'][$key] = $value;
            }
        }

        $this->ajaxReturn(array('status' => 1, 'info' => '获取成功', 'data' => $data));
    }

    /**
     * 备份数据库
     */
    public function bakDb()
    {
        //exec("/home/php/bkdb.sh", $out, $status);
        if ($status == 0) {
            $this->ajaxReturn(array('status' => 1, 'info' => '操作成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
        }
    }

    /**
     * 同步缓存
     */
    public function sync()
    {
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);
        $sync_status = I('sync_status', 0);
        if ($stage_id === false) {
            $this->ajaxReturn(array("status" => -1, "msg" => "缺少期数ID"));
        }
        /*if ($group_id === false) {
            $this->ajaxReturn(array("status" => -2, "msg" => "缺少分组ID"));
        }*/

        /*$group_status = M('group')->field('group_status')->where(array('id' => $group_id))->find();
        if ($group_status == 0) {
            $this->ajaxReturn(array("status" => -3, "msg" => "当前分组未开启"));
        }*/
        $group_info = M('group')->where(array('stage_id' => $stage_id, 'group_status' => 1))->select();
        if (!$group_info) {
            $this->ajaxReturn(array("status" => -3, "msg" => "当前期没有开启的分组"));
        }
        $stage_info = M('stage')->where(array('stage_id' => $stage_id))->find();
        if ($stage_info['stage_status'] == 0) {
            $this->ajaxReturn(array("status" => -4, "msg" => "当前期数未开启"));
        }
        $column_status = M('column')->where(array('column_id' => $stage_info['column_id']))->find();
        if ($column_status == 0) {
            $this->ajaxReturn(array("status" => -5, "msg" => "当前栏目未开启"));
        }

        if ($sync_status == 1) {
            $this->redis->hSet(get_redis_key('QA.QA_STAGE_INFO'), $stage_id, json_encode($stage_info));
            foreach ($group_info as $k => $v) {
                $this->redis->hSet(get_redis_key('QA.QA_GROUP_INFO'), $v['id'], json_encode($v));
            }
        } else if ($sync_status == 0) {
            $this->redis->hDel(get_redis_key('QA.QA_STAGE_INFO'), $stage_id);
            foreach ($group_info as $k => $v) {
                $this->redis->hDel(get_redis_key('QA.QA_GROUP_INFO'), $v['id']);
            }
        }

        if ($sync_status == 1) {
            $group_id = array('IN', array_column($group_info, 'id'));
            $qaList = M('qa')->where(array('stage_id' => $stage_id, 'group_id' => $group_id))->order('id ASC')->select();
            if ($qaList) {
                $qaOptionModel = D('QaOption');
                $this->redis->del(get_redis_key('QA.QA_LIST', $stage_id));
                $group_names = array_column($group_info, 'group_title', 'id');
                foreach ($qaList as $key => $qa) {
                    //题面图片
                    if ($qa['qa_subject_img'] > 0) {
                        $img_where = array('id' => $qa['qa_subject_img']);
                        $img_info = $this->getImageinfo($img_where);
                        $qa['qa_subject_img'] = C('PAGE_URL') . $img_info[0]['path'];
                    }
                    //选项
                    $qaOption_where = array('qa_id' => $qa['id']);
                    $qaOption_info = $qaOptionModel->getQaOptionInfo($qaOption_where);
                    foreach ($qaOption_info as $option_key => $option_value) {
                        if ($option_value['option_img'] > 0) {
                            $option_img_where = array('id' => $option_value['option_img']);
                            $option_img_info = $this->getImageinfo($option_img_where);
                            $qaOption_info[$option_key]['option_img'] = C('PAGE_URL') . $option_img_info[0]['path'];
                        }
                    }
                    $qa['qa_options'] = $qaOption_info;
                    $qa['qa_right_key'] = json_decode($qa['qa_right_key'], true);
                    $qa['qa_bind_modules'] = $qa['qa_bind_modules'] ? json_decode($qa['qa_bind_modules'], true) : '';
                    $qa['group_name'] = $group_names[$qa['group_id']];

                    //写入
                    $this->redis->hSet(get_redis_key('QA.QA_LIST', $stage_id), $qa['id'], json_encode($qa));
                }
                $this->ajaxReturn(array("status" => 1, "msg" => "操作成功"));
            } else {
                $this->ajaxReturn(array("status" => -5, "msg" => "数据不存在"));
            }
        } else if ($sync_status == 0) {
            $this->redis->del(get_redis_key('QA.QA_LIST', $stage_id));
            $this->ajaxReturn(array("status" => 1, "msg" => "操作成功"));
        }
    }

    /**
     * 推送答题
     */
    public function sendQa()
    {
        $column_id = I('column_id', false);
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);
        $qa_id = I('qa_id', false);

        if (!$column_id) {
            $this->ajaxReturn(array('status' => -1, 'msg' => '缺少栏目'));
        }
        if (!$stage_id) {
            $this->ajaxReturn(array('status' => -2, 'msg' => '缺少期数'));
        }
        if (!$group_id) {
            $this->ajaxReturn(array('status' => -3, 'msg' => '缺少期数'));
        }
        if (!$qa_id) {
            $this->ajaxReturn(array('status' => -4, 'msg' => '缺少题目'));
        }

        $columnModel = M('column');
        $stageModel = M('stage');
        $groupModel = M('group');
        $qaModel = M('qa');

        $column = $columnModel->field('column_status')->where(array('column_id' => $column_id))->find();
        if (!$column || $column['column_status'] == 0) {
            $this->ajaxReturn(array('status' => -5, 'msg' => '当前栏目没有开启'));
        }
        $stage = $stageModel->field('stage_status')->where(array('stage_id' => $stage_id))->find();
        if (!$stage || $stage['stage_status'] == 0) {
            $this->ajaxReturn(array('status' => -6, 'msg' => '当前期数没有开启'));
        }
        $group = $groupModel->field('group_status')->where(array('id' => $group_id))->find();
        if (!$group || $group['group_status'] == 0) {
            $this->ajaxReturn(array('status' => -7, 'msg' => '当前分组没有开启'));
        }

        $qa = $this->redis->hGet(get_redis_key('QA.QA_LIST', $stage_id), $qa_id);
        if ($qa) {
            $qa = json_decode($qa, true);
            $now = $this->getNowTime();
            $qa = pack_push_qa($qa, $now);
            $cmd = C('QA.CMD');
            $res = webSocket_push($cmd['PUSH_QA'], $qa);
            $res = json_decode($res, true);
            if ($res['code'] == 0) {
                $qa_current = array('column_id' => $column_id, 'stage_id' => $stage_id, 'group_id' => $group_id, 'qa_id' => $qa_id);
                $this->redis->set(get_redis_key('QA.QA_CURRENT'), json_encode($qa_current));
                $update = array('qa_is_used' => 1, 'qa_normal_status' => 1, 'qa_used_time' => time());
                $where = array('id' => $qa_id);
                $update_res = $qaModel->where($where)->save($update);
                if ($update_res) {
                    $this->ajaxReturn(array('status' => 1, 'msg' => '推送成功'));
                } else {
                    $this->ajaxReturn(array('status' => 0, 'msg' => '推送成功,状态更新失败'));
                }
            } else {
                $this->ajaxReturn(array('status' => 0, 'msg' => '推送失败'));
            }
        } else {
            $this->ajaxReturn(array('status' => 0, 'msg' => '当前题目未预热'));
        }
    }

    /**
     * 推送答案
     */
    public function sendQaRes()
    {
        $column_id = I('column_id', false);
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);
        $qa_id = I('qa_id', false);

        if (!$column_id) {
            $this->ajaxReturn(array('status' => -1, 'msg' => '缺少栏目'));
        }
        if (!$stage_id) {
            $this->ajaxReturn(array('status' => -2, 'msg' => '缺少期数'));
        }
        if (!$group_id) {
            $this->ajaxReturn(array('status' => -3, 'msg' => '缺少期数'));
        }
        if (!$qa_id) {
            $this->ajaxReturn(array('status' => -4, 'msg' => '缺少题目'));
        }

        $columnModel = M('column');
        $stageModel = M('stage');
        $groupModel = M('group');
        $qaModel = M('qa');

        $column = $columnModel->field('column_status')->where(array('column_id' => $column_id))->find();
        if (!$column || $column['column_status'] == 0) {
            $this->ajaxReturn(array('status' => -5, 'msg' => '当前栏目没有开启'));
        }
        $stage = $stageModel->field('stage_status')->where(array('stage_id' => $stage_id))->find();
        if (!$stage || $stage['stage_status'] == 0) {
            $this->ajaxReturn(array('status' => -6, 'msg' => '当前期数没有开启'));
        }
        $group = $groupModel->field('group_status')->where(array('id' => $group_id))->find();
        if (!$group || $group['group_status'] == 0) {
            $this->ajaxReturn(array('status' => -7, 'msg' => '当前分组没有开启'));
        }

        $qa_info = $qaModel->field('id,qa_remark')->where(array('id' => $qa_id))->find();
        if ($qa_info) {
            $qa_id = $qa_info['id'];
            $data = array('column_id' => $column_id, 'stage_id' => $stage_id, 'group_id' => $group_id, 'qa_id' => $qa_id);
            $cmd = C('QA.CMD');
            $res = webSocket_push($cmd['PUSH_QA_ANSWER'], $data);
            $res = json_decode($res, true);
            if ($res['code'] == 0) {
                if (strtoupper($qa_info['qa_remark']) == 'END' || strtoupper($qa_info['qa_remark']) == 'STAGE_END') {
                    $used_group_list = $this->redis->hGet(get_redis_key('QA.QA_USED_STAGE_GROUP'), $stage_id);
                    $used_group_list = $used_group_list ? json_decode($used_group_list, true) : array();
                    array_push($used_group_list, $group_id);
                    $this->redis->hSet(get_redis_key('QA.QA_USED_STAGE_GROUP'), $stage_id, json_encode($used_group_list));
                }
                $update = array('qa_res_is_pushed' => 1, 'qa_res_pushed_time' => time());
                $where = array('id' => $qa_id);
                $update_res = $qaModel->where($where)->save($update);
                if ($update_res) {
                    $this->ajaxReturn(array('status' => 1, 'msg' => '推送成功'));
                } else {
                    $this->ajaxReturn(array('status' => 0, 'msg' => '推送成功,状态更新失败'));
                }
            } else {
                $this->ajaxReturn(array('status' => 0, 'msg' => '推送失败'));
            }
        } else {
            $this->ajaxReturn(array('status' => -8, 'msg' => '题目不存在'));
        }
    }

    /**
     * 重置题目状态
     */
    public function initQa()
    {
        $stage_id = I('stage_id', false);
        $group_id = I('group_id', false);

        if (!$stage_id) {
            $this->ajaxReturn(array('status' => -1, 'msg' => '缺少参数：stage_id'));
        }
        if (!$group_id) {
            $this->ajaxReturn(array('status' => -1, 'msg' => '缺少参数：group_id'));
        }

        $where = array('stage_id' => $stage_id, 'group_id' => $group_id);
        $update = array(
            'qa_player_status'   => 0,
            'qa_normal_status'   => 0,
            'qa_is_used'         => 0,
            'qa_used_time'       => '',
            'qa_res_is_pushed'   => 0,
            'qa_res_pushed_time' => ''
        );
        $res = M('qa')->where($where)->save($update);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'msg' => '重置成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'msg' => '重置失败'));
        }
    }

    /**
     * 关闭所有题目
     */
    public function closeAllQa($stage_id, $group_id)
    {
        if ($stage_id) {
            $groupModel = D('Qa');
            $where = array('stage_id' => $stage_id);
            $group_id && $where['group_id'] = $group_id;
            $data = array('qa_player_status' => 0, 'qa_normal_status' => 0);

            return $groupModel->saveQa($data, $where);
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

}