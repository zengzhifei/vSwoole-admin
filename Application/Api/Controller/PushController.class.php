<?php

namespace Api\Controller;

class PushController extends ApiBaseController
{

    /**
     * 当前最高分接口
     */
    public function getTopScore()
    {
        $where["stage_id"] = $this->stage_id;
        $where["type"] = 1;
        $order = "score desc";
        $playInfo = M("player")->where($where)->order($order)->limit(1)->find();
        $data = array("stage_id" => $this->stage_id, "maxMark" => $playInfo["score"]);
        if ($playInfo) {
            $ret = array("code" => "1", "msg" => "success", "data" => $data);
        } else {
            $ret = array("code" => "0", "msg" => "fail");
        }
        $this->ajaxReturn($ret, $this->format);
    }

    /**
     * 当前选手得分
     */
    public function getPlayerScore()
    {
        $where["stage_id"] = $this->stage_id;
        $where["type"] = 1;
        $where["is_start"] = 1;
        $playInfo = M("player")->where($where)->field("number")->select();
        $array = array();
        foreach ($playInfo as $k => $v) {
            $array[$k] = $v["number"];
        }

        $where["stage_id"] = $this->stage_id;
        $where["group_status"] = 1;
        $groupinfo = M("group")->where($where)->field("id")->find();
        $group_id = $groupinfo["id"];//获取当前开启的分组id
        $wheres['user_id'] = array('in', implode(",", $array));
        $wheres["group_id"] = $group_id;
        $countInfo = M("qa_group_count")->where($wheres)->field("user_id,user_name,user_right_count,user_score,player_id")->select();
        foreach ($countInfo as $k => $v) {
            $countInfo[$k]["head_img"] = C("HEAD_IMG_URL") . $v["player_id"] . ".png";
        }

        if ($countInfo) {
            $ret = array("code" => "1", "msg" => "success", "data" => $countInfo);
        } else {
            $ret = array("code" => "0", "msg" => "fail");
        }
        $this->ajaxReturn($ret, $this->format);
    }

    /**
     * 百人团得分接口
     */
    public function getGroupList()
    {
        $where["stage_id"] = $this->stage_id;
        $where["type"] = 0;
        $where["is_del"] = 0;
        $order = "number+0 asc";
        $group_model = D("Group");
        $groupInfo = $group_model->getGroup($this->stage_id); //获取题分组信息
        if (!$groupInfo) {
            $this->ajaxReturn($ret = array("code" => "0", "msg" => "没有开启的分组"), $this->format);
        }
        $group_id = $groupInfo["id"];//组id

        $qa_model = D("Qa");
        $qaInfo = $qa_model->getQa($this->stage_id, $group_id, "br"); //获取百人团推送题信息
        $qa_id = $qaInfo["id"];//题id
        if (!$qaInfo) {
            $this->ajaxReturn($ret = array("code" => "0", "msg" => "没有开启的题目"), $this->format);
        }

        $playInfo = M("player")->where($where)->order($order)->field("number")->limit(72)->select(); //获取百人团list
        $info = array(); //@todo  联查答题log表

        $log_model = D("qa_log");
        $group_log = $log_model->getGroupInfo($this->stage_id, $group_id, $qa_id, "1003");//获取百人团答题log

        $info = array();
        if (!$group_log) {
            foreach ($playInfo as $k => $v) {
                $info[$k] = 0;
            }
        } else {
            foreach ($playInfo as $k => $v) {
                $is_right = 0;
                foreach ($group_log as $ks => $vs) {
                    if ($v["number"] == $vs["user_id"]) {
                        $is_right = intval($vs["is_right"]);
                    }
                }
                $info[$k] = $is_right;
            }
        }

        $data = array("stage_id" => $this->stage_id, "group_id" => $group_id, "qa_id" => $qa_id, "info" => $info);
        if ($playInfo) {
            $ret = array("code" => "1", "msg" => "success", "data" => $data);
        } else {
            $ret = array("code" => "0", "msg" => "fail");
        }
        $this->ajaxReturn($ret, $this->format);
    }

    /**
     * 获取虚拟榜单用户列表
     */
    protected function getPlayList($limit)
    {
        $where["stage_id"] = $this->stage_id;
        $where['type'] = 0;
        $where["is_del"] = 0;
        $order = "sort asc";
        $play_list = M("player")->where($where)->order($order)->field("name,player_id,number")->limit($limit)->select();
        return $play_list;
    }

    /**
     * 获取期下总分数列表
     */
    protected function getAllList($limit)
    {
        $where = array("stage_id" => $this->stage_id, "user_type" => 0);
        $order = "sum(user_score) desc";
        $group = "user_id";
        $field = "user_id,user_right_count,sum(user_score) as user_score,player_id,user_name";
        $list = M("qa_group_count")->where($where)->group($group)->order($order)->field($field)->limit($limit)->select();
        return $list;
    }

    /**
     * 获取百人团top5接口
     */
    public function getTop5()
    {
        $limit = I("limit", 10);
        $groupinfo = M("group")->where(array("stage_id" => $this->stage_id, "group_status" => 1))->field("id,is_false")->find();
        $group_id = $groupinfo["id"];//获取当前开启的分组id
        if (!$group_id) {
            $this->ajaxReturn(array("code" => "0", "msg" => "no group_id"), $this->format);
        }
        if ($groupinfo["is_false"] == 1) { //开启虚拟榜单
            $play_list = $this->getPlayList($limit);//获取虚拟榜单用户列表

            if ($this->stage_desc == "总榜") {  //期下分数综合列表,取期下的分数合
                $list = $this->getAllList($limit);
            } else {  //获取分组下分数列表
                $order = "user_score desc";//获取真实榜单成绩
                $list = M("qa_group_count")->where(array("group_id" => $group_id, "user_type" => 0))->order($order)->field("user_id,user_right_count,user_score,player_id")->limit($limit)->select();
            }

            foreach ($list as $k => $v) {
                $list[$k]["user_name"] = $play_list[$k]["name"];
                $list[$k]["player_id"] = $play_list[$k]["player_id"];
		$list[$k]["user_id"] = $play_list[$k]["number"];
            }
        } else { //真实榜单
            if ($this->stage_desc == "总榜") {
                $list = $this->getAllList($limit);
            } else {
                $order = "user_score desc";
                $list = M("qa_group_count")->where(array("group_id" => $group_id, "user_type" => 0))->order($order)->field("user_id,user_name,user_right_count,user_score,player_id")->limit($limit)->select();
            }

        }
       
         $order = "user_score desc";
	 $xs_list = M("qa_group_count")->where(array("group_id" => $group_id, "user_type" => 1))->order($order)->field("user_id,user_name,user_right_count,user_score,player_id")->limit($limit)->select();

        foreach ($list as $k => $v) {
            $list[$k]["user_head"] = C("HEAD_IMG_URL") . $v["player_id"] . ".png";
        }
        foreach ($xs_list as $k => $v) {
            $xs_list[$k]["user_head"] = C("HEAD_IMG_URL") . $v["player_id"] . ".png";
        }
        if ($list || $xs_list) {
            $data = array(
                'brt'      => $list ? $list : '',
                'xs'       => $xs_list ? $xs_list : '',
                'stage_id' => $this->stage_id,
                'group_id' => $group_id
            );
            $ret = array("code" => "1", "msg" => "success", "data" => $data);
        } else {
            $ret = array("code" => "0", "msg" => "fail");
        }
        $this->ajaxReturn($ret, $this->format);
    }


    /*
     * 获取本期主持人流程
     */
    public function getProcess()
    {
        $where["stage_id"] = $this->stage_id;
        $order = "process_order ASC,id ASC";
        $list = M("process")->where($where)->order($order)->find();

        if ($list) {
            $ret = array("code" => "1", "msg" => "success", "data" => $list);
        } else {
            $ret = array("code" => "0", "msg" => "fail");
        }
        $this->ajaxReturn($ret, $this->format);
    }

    /**
     * 验证客户端登录信息
     * 1001：主持人
     * 1002：嘉宾
     * 1003：百人团
     * 1004：选手
     * 1005：艺术家
     * zengzhifei
     */
    public function checkLogin()
    {
        $account = I('account', false);

        if (false === $account) {
            $ret = array('code' => -1, 'msg' => 'empty param: account');
        } else {
            $where = array('stage_id' => $this->stage_id, 'number' => $account, 'is_del' => 0);
            $playerInfo = M('player')->field('type')->where($where)->find();
            if ($playerInfo) {
                //百人团
                if ($playerInfo['type'] == 0) {
                    $data = array('user_type' => 1003, 'user_id' => $account);
                    //选手
                } else if ($playerInfo['type'] == 1) {
                    $data = array('user_type' => 1004, 'user_id' => $account);
                    //艺术家
                } else if ($playerInfo['type'] == 3) {
                    $data = array('user_type' => 1005, 'user_id' => $account);
                    //主持人
                } else if ($playerInfo['type'] == 4) {
                    $data = array('user_type' => 1001, 'user_id' => $account);
                    //嘉宾
                } else if ($playerInfo['type'] == 5) {
                    $data = array('user_type' => 1002, 'user_id' => $account);
                    //类型未知
                } else {
                    $data = false;
                }
            }
            $ret = $data ? array('code' => 1, 'msg' => 'check success', 'data' => $data) : array('code' => 0, 'msg' => 'check fail');
        }

        $this->ajaxReturn($ret, $this->format);
    }

    /**
     * 获取选手百人团艺术家当前问答题目
     *  1003：百人团
     *  1004：选手
     *  1005：艺术家
     * zengzhifei
     */
    public function getQa()
    {
        //验证开启期数
        $stage_id = $this->stage_id;
        if (!$stage_id) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'not start stage'), $this->format);
        }

        //验证接口获取数据类型
        $allow_user_type = array(1003, 1004, 1005);
        $user_type = I('user_type');
        if (!in_array($user_type, $allow_user_type)) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'error param: user_type'), $this->format);
        }

        //验证开启分组
        $group_info = M('group')->field('id,group_type')->where(array('stage_id' => $stage_id, 'group_status' => 1))->find();
        if (!$group_info) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'not start group'), $this->format);
        }

        //验证推送状态
        $query_type = $user_type == 1004 ? 'qa_player_status' : 'qa_normal_status';
        $where = array('stage_id' => $stage_id, 'group_id' => $group_info['id'], 'qa_is_used' => 1, $query_type => 1);
        $qa_info = M('qa')->where($where)->find();
        if (!$qa_info) {
            $this->ajaxReturn(array('code' => 0, 'msg' => 'get fail'), $this->format);
        }

        //返回数据包装
	unset($qa_info['qa_normal_status']);
	unset($qa_info['qa_player_status']);
        $qa_info['group_type'] = $group_info['group_type'];

        //返回数据格式处理
        foreach ($qa_info as $key => $value) {
            $check_value = str_replace(" ", "", $value);
            mb_strlen($check_value, 'UTF8') <= 0 && $qa_info[$key] = '';
        }

        //返回题目答案处理
        $qa_info['qa_right_key'] != '' && $qa_info['qa_right_key'] = json_decode($qa_info['qa_right_key'], true);

        //返回题目图片处理
        if ($qa_info['qa_subject_img'] && $qa_info['qa_subject_img'] != 0) {
            $subject_img_info = $this->getImageinfo(array('id' => $qa_info['qa_subject_img']));
            $qa_info['qa_subject_img'] = $subject_img_info ? C('PAGE_URL') . $subject_img_info[0]['path'] : '0';
        }

        //题目选项获取
        $option_where = array('qa_id' => $qa_info['id']);
        $qa_options = M('qa_option')->where($option_where)->order('id')->select();

        //题目选项处理
        if ($qa_options) {
            foreach ($qa_options as $key => $value) {
                if ($value['option_img'] && $value['option_img'] != 0) {
                    $option_img_info = $this->getImageinfo(array('id' => $value['option_img']));
                    $qa_options[$key]['option_img'] = $option_img_info ? C('PAGE_URL') . $option_img_info[0]['path'] : '0';
                }
                $qa_options[$key]['option_title'] = $value['option_title'] ? $value['option_title'] : '';
            }
        }
        $qa_info['qa_options'] = $qa_options ? $qa_options : '';

        //HashID
        $qa_info_string = json_encode($qa_info);
        $qa_info['hash_id'] = md5($qa_info_string);

        $this->ajaxReturn(array('code' => 1, 'msg' => 'get success', 'data' => $qa_info), $this->format);
    }

    /**
     * 嘉宾 / 主持人获取问答题目列表
     * 1001：主持人 1002：嘉宾
     * zengzhifei
     */
    public function getQaList()
    {
        //验证开启期数
        $stage_id = $this->stage_id;
        if (!$stage_id) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'not start stage'), $this->format);
        }

        //验证接口获取数据类型
        $allow_user_type = array(1001, 1002);
        $user_type = I('user_type');
        if (!in_array($user_type, $allow_user_type)) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'error param: user_type'), $this->format);
        }

        //验证开启分组
        $group_info = M('group')->field('id,group_type')->where(array('stage_id' => $stage_id, 'group_status' => 1))->find();
        if (!$group_info) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'not start group'), $this->format);
        }

        //验证返回分组数据列表
        $where = array('stage_id' => $stage_id, 'group_id' => $group_info['id']);
        $qa_list = M('qa')->where($where)->select();
        if (!$qa_list) {
            $this->ajaxReturn(array('code' => 0, 'msg' => 'get fail'), $this->format);
        }

        //获取选手答题数据列表
        $xs_answer_where = array('stage_id' => $stage_id, 'group_id' => $group_info['id'], 'user_type' => 1004);
        $xs_answer_list = M('qa_log')->field('qa_id,user_id,user_name,player_id,answer_key,is_right,answer_duration')->where($xs_answer_where)->order('user_id')->select();

        //redis链接
        $this->redis = new \Redis();
        $this->redis->pconnect(C("REDIS_HOST"), C("REDIS_PORT"));
        C("REDIS_AUTH") && $this->redis->auth(C("REDIS_AUTH"));

        $qaOptionModel = M('qa_option');
        foreach ($qa_list as $qa_list_key => $qa) {
            //返回列表数据格式处理
            foreach ($qa as $qa_key => $qa_value) {
                $check_qa_value = str_replace(" ", "", $qa_value);
                mb_strlen($check_qa_value, 'UTF8') <= 0 && $qa_list[$qa_list_key][$qa_key] = '';
            }

            //返回列表题目答案处理
            $qa_list[$qa_list_key]['qa_right_key'] != '' && $qa_list[$qa_list_key]['qa_right_key'] = json_decode($qa_list[$qa_list_key]['qa_right_key'], true);

            //返回列表题目图片处理
            if ($qa['qa_subject_img'] && $qa['qa_subject_img'] != 0) {
                $subject_img_info = $this->getImageinfo(array('id' => $qa['qa_subject_img']));
                $qa_list[$qa_list_key]['qa_subject_img'] = $subject_img_info ? C('PAGE_URL') . $subject_img_info[0]['path'] : '0';
            }

            //返回列表数据包装
            $qa_list[$qa_list_key]['group_type'] = $group_info['group_type'];

            //返回列表题目选项
            $option_where = array('qa_id' => $qa['id']);
            $qa_options = $qaOptionModel->where($option_where)->order('id')->select();

            //返回列表题目选手答案
            if ($xs_answer_list) {
                foreach ($xs_answer_list as $xs_answer_list_key => $xs_answer) {
                    if ($xs_answer['qa_id'] == $qa['id']) {
                        $xs_answer['user_head'] = C('HEAD_IMG_URL') . $xs_answer['player_id'] . '.png';
                        $xs_answer['answer_key'] = json_decode($xs_answer['answer_key'], true);
                        $xs_score = $qa['qa_countdown'] * 1000 - intval($xs_answer['answer_duration']);
                        $xs_answer['current_score'] = $xs_answer['is_right'] == 1 ? round($xs_score / 1000, 2) + C('USER_BASE_SCORE') : 0;
                        $xs_answer_data[$xs_answer['qa_id']][$xs_answer['user_id']] = $xs_answer;
                    }
                }
            }
            $qa_list[$qa_list_key]['qa_xs_answer'] = $xs_answer_data[$qa['id']] ? $xs_answer_data[$qa['id']] : '';

            //返回列表题目百人团答题情况
            $brt_count_where = array('stage_id' => $stage_id, 'group_id' => $group_info['id'], 'user_type' => 1003, 'qa_id' => $qa['id'], 'is_right' => 1);
            $right_count = M('qa_log')->where($brt_count_where)->count();
            $user_count = $this->redis->hGet('UserList', getUserCount($group_info['id']));
            $user_count = $user_count ? $user_count : 72;
            $error_count = $user_count - $right_count;
            $qa_list[$qa_list_key]['qa_brt_answer_count'] = $qa['qa_is_used'] == 1 ? array('right_count' => $right_count, 'error_count' => $error_count) : '';

            //列表题目选项处理
            if ($qa_options) {
                foreach ($qa_options as $k => $v) {
                    if ($v['option_img'] && $v['option_img'] != 0) {
                        $option_img_info = $this->getImageinfo(array('id' => $v['option_img']));
                        $qa_options[$k]['option_img'] = $option_img_info ? C('PAGE_URL') . $option_img_info[0]['path'] : '0';
                    }
                    $qa_options[$k]['option_title'] = $v['option_title'] ? $v['option_title'] : '';
                }
            }
            $qa_list[$qa_list_key]['qa_options'] = $qa_options ? $qa_options : '';
        }

        //HashId
        $listString = json_encode($qa_list);
        $hash_id = md5($listString);

        //数据组装
        $data['list'] = $qa_list;
        $data['stage_id'] = $stage_id;
        $data['group_id'] = $group_info['id'];
        $data['hash_id'] = $hash_id;

        $this->ajaxReturn(array('code' => 1, 'msg' => 'get success', 'data' => $data), $this->format);
    }

    /**
     * 记录选手 / 百人团答题结果
     * 1003：百人团 1004：选手 1005：艺术家
     * zengzhifei
     */
    public function setQa()
    {
        //答题数据获取
        $data = array(
            'stage_id'        => I('stage_id', $this->stage_id),
            'group_id'        => I('group_id', false),
            'qa_id'           => I('qa_id', false),
            'user_type'       => I('user_type', false),
            'user_id'         => I('user_id', 0),
            'user_name'       => I('user_name', ''),
            'player_id'       => I('player_id', ''),
            'answer_key'      => I('answer_key', ''),
            'is_right'        => I('is_right', ''),
            'answer_duration' => I('duration', 0),
            'time'            => time()
        );

        //验证开启分组
        if (!$data['group_id']) {
            $group_info = M('group')->field('id')->where(array('stage_id' => $data['stage_id'], 'group_status' => 1))->find();
            if ($group_info) {
                $data['group_id'] = $group_info['group_id'];
            } else {
                $this->ajaxReturn(array('code' => -1, 'msg' => 'not start group'), $this->format);
            }
        }
        //验证问答ID必传
        if (!$data['qa_id']) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'empty param: qa_id'), $this->format);
        }
        //验证答题选手类型必传
        if (!$data['user_type']) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'empty param: user_type'), $this->format);
        }
        //验证答题选手ID必传
        if (!$data['user_id']) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'empty param: user_id'), $this->format);
        }
        //验证答题用时必传
        if ($data['answer_duration'] <= 0) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'empty param: answer_duration'), $this->format);
        }
        
        $this->redis = new \Redis();
        $this->redis->pconnect(C("REDIS_HOST"), C("REDIS_PORT"));
        C("REDIS_AUTH") && $this->redis->auth(C("REDIS_AUTH"));
        $result = $this->redis->get(getIsQa($data['user_id'],$data['qa_id']));
        if($result){
            $this->ajaxReturn(array('code' => -1, 'msg' => 'repeat submit'), $this->format);
        }
        $this->redis->set(getIsQa($data['user_id'],$data['qa_id']),1);

        //验证是否重复提交
        $qaLogModel = M('qa_log');
        $check_where = array('qa_id' => $data['qa_id'], 'user_id' => $data['user_id']);
        $check_res = $qaLogModel->where($check_where)->find();
        if ($check_res) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'repeat submit'), $this->format);
        }
        
        //答题人信息获取
        $player_where = array('stage_id' => $data['stage_id'], 'is_del' => 0, 'number' => $data['user_id']);
        $playerInfo = M('player')->field('name,player_id')->where($player_where)->find();
        $data['user_name'] = $playerInfo['name'];
        $data['player_id'] = $playerInfo['player_id'];

        //选手答案格式转换
        if (I('qa_client') == 1) {
            $data['answer_key'] = json_decode($_POST['answer_key'], true);
        }

        //答案解析
        $this_qa_info = M('qa')->field('qa_type,qa_countdown,qa_right_key')->where(array('id' => $data['qa_id']))->find();
        if (is_array($data['answer_key']) && count($data['answer_key']) > 0) {
            if ($data['user_type'] != 1004 || $data['is_right'] === '') {
                $qa_right_key = json_decode($this_qa_info['qa_right_key'], true);
                //宫格
                if (in_array($this_qa_info['qa_type'], [11, 12, 13])) {
                    if ($data['qa_id'] == 247) {
                        $init_answer = array_map(function ($v) { 
                            return $v == 4 ? 1 : $v;
                        }, $qa_right_key);
                        $user_answer = array_map(function ($v) { 
                            return $v == 4 ? 1 : $v;
                        }, $data['answer_key']);
                        $data['is_right'] = $init_answer == $user_answer ? 1 : 0;
                    } else {
                        $data['is_right'] = $qa_right_key == $data['answer_key'] ? 1 : 0;
                    }

                //连线
                } else if (in_array($this_qa_info['qa_type'], [7, 14])) {
                    $data['is_right'] = 1;
                    foreach ($qa_right_key as $key => $value) {
                        if ($data['answer_key'][$key] != $value) {
                            $data['is_right'] = 0;
                            break;
                        }
                    }

                //其他
                } else {
                    $this_answer_key = $data['answer_key'];
                    if ($data['qa_id'] != 248) {
                        sort($qa_right_key);
                        sort($this_answer_key);
                    }                   
                    $data['is_right'] = $qa_right_key == $this_answer_key ? 1 : 0;
                }
            }
        } else {
            $data['is_right'] = 0;
        }
        $data['answer_key'] = is_array($data['answer_key']) && count($data['answer_key']) > 0 ? json_encode($data['answer_key']) : '';

        //答题时间处理
        $data['answer_duration'] = intval($data['answer_duration']) > $this_qa_info['qa_countdown'] * 1000 ? $this_qa_info['qa_countdown'] * 1000 : intval($data['answer_duration']);

        //保存答题日志
        $save_log_res = $qaLogModel->add($data);

        //保存答题统计
        if ($save_log_res) {
            /* $setInc_where = array('stage_id' => $data['stage_id'], 'group_id' => $data['group_id'], 'user_id' => $data['user_id']);
             $setInc_right_count = $data['is_right'] == 1 ? 1 : 0;
             $setInc_score = $data['is_right'] == 1 ? intval($data['answer_duration']) : $this_qa_info['qa_countdown'] * 1000;
             $countData['user_right_count'] = array('exp', "user_right_count+{$setInc_right_count}");
             $countData['user_score'] = array('exp', "user_score+{$setInc_score}");*/

            if (intval($data['is_right']) === 1) {
                $setInc_where = array('stage_id' => $data['stage_id'], 'group_id' => $data['group_id'], 'user_id' => $data['user_id']);
                $setInc_score = $this_qa_info['qa_countdown'] * 1000 - intval($data['answer_duration']);
                $setInc_score = round($setInc_score / 1000, 2) + C('USER_BASE_SCORE');
                $countData['user_right_count'] = array('exp', "user_right_count+1");
                $countData['user_score'] = array('exp', "user_score+{$setInc_score}");
                $save_count = M('qa_group_count')->where($setInc_where)->save($countData);
            }
            if (intval($data['is_right']) != 1 || $save_count) {
                $this->ajaxReturn(array('code' => 1, 'msg' => 'set success'), $this->format);
            }
        }

        $this->ajaxReturn(array('code' => 0, 'msg' => 'set fail'), $this->format);
    }

    /**
     * @param $stage_id
     * @param bool $user_id
     * @return bool
     * 新心跳时间
     * zengzhifei
     */
    public function updateHeartTime()
    {
        $stage_id = $this->stage_id;
        $user_id = I('user_id', false);

        if ($user_id) {
            $where = array('stage_id' => $stage_id, 'is_del' => 0, 'number' => $user_id);
            $data = array('heart_time' => time());
            $update_res = M('player')->where($where)->save($data);
            if ($update_res) {
                $this->ajaxReturn(array('code' => 1, 'msg' => 'update heart time success'), $this->format);
            }
        }

        $this->ajaxReturn(array('code' => 0, 'msg' => 'update heart time fail'), $this->format);
    }

    /**
     * 获取排行榜百人团坐标
     *
     */
    public function getTopPlace()
    {
        //$limit = I("limit", 6);
        $where["stage_id"] = $this->stage_id;
        $where['type'] = 0;
        $where["is_del"] = 0;
        $order = "sort asc,right_num desc,duration asc";
        //获取2-6
        $list = M("player")->where($where)->order($order)->field("number")->limit(1, 5)->select();
        //echo "<pre>";print_r($list);


        $wheres["stage_id"] = $this->stage_id;
        $wheres["type"] = 0;
        $orders = "number+0 asc";
        $wheres["is_del"] = 0;
        $playInfo = M("player")->where($wheres)->order($orders)->field("number")->limit(100)->select(); //获取百人团list
        //echo "<pre>";print_r($playInfo);
        $info = array();

        foreach ($playInfo as $k => $v) {
            $place = 0;
            foreach ($list as $ks => $vs) {
                if ($v["number"] == $vs["number"]) {
                    //echo $vs["number"];echo "<br/>";
                    $place = 1;
                }
            }
            $info[$k] = $place;
        }
        $data = array("info" => $info);
        $this->ajaxReturn(array("code" => "1", "msg" => "success", "data" => $data), $this->format);
    }


    /**
     * 前端监控连接超时接口
     */
    public function getMonitor()
    {
        $field = 'number,heart_time';
        $where = array('stage_id' => $this->stage_id, 'is_del' => 0);
        $order = "number+0";
        $list = M('player')->field($field)->where($where)->order($order)->select();
        foreach ($list as $key => $value) {
            $timeFix = time() - $value['heart_time'];
	    $list[$key]['fixTime'] = $timeFix;
            if ($timeFix <= 20) unset($list[$key]);
        }

        $this->ajaxReturn(array('status' => 1, 'info' => 'get success', 'data' => $list), $this->format);
    }

    /**
     * 获取选手信息接口
     */
    public function getUserInfo()
    {
        $where = array('stage_id' => $this->stage_id, 'is_del' => 0, 'type' => 0);
        $list = M('player')->field('name,number,player_id')->where($where)->order('number+0 asc')->select();
        foreach ($list as $key => $value) {
            $list[$key]['user_head'] = C('HEAD_IMG_URL') . $value['player_id'] . '.png';
        }
        $this->ajaxReturn(array('status' => 1, 'info' => 'get success', 'data' => $list), $this->format);
    }

    /**
     * 测试取题接口
     */
    public function testGetQa()
    {
        //验证开启期数
        $stage_id = $this->stage_id;
        if (!$stage_id) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'not start stage'), $this->format);
        }

        //验证开启分组
        $group_info = M('group')->field('id,group_type')->where(array('stage_id' => $stage_id, 'group_status' => 1))->find();
        if (!$group_info) {
            $this->ajaxReturn(array('code' => -1, 'msg' => 'not start group'), $this->format);
        }

        //验证推送状态
        $query_type = intval(I('number')) - 1;
        $where = array('stage_id' => $stage_id, 'group_id' => $group_info['id']);
        $qa_info = M('qa')->where($where)->order('id')->limit($query_type, 1)->select();
        $qa_info = $qa_info[0];
        if (!$qa_info) {
            $this->ajaxReturn(array('code' => 0, 'msg' => 'get fail'), $this->format);
        }

        //返回数据包装
        $qa_info['group_type'] = $group_info['group_type'];

        //返回数据格式处理
        foreach ($qa_info as $key => $value) {
            $check_value = str_replace(" ", "", $value);
            mb_strlen($check_value, 'UTF8') <= 0 && $qa_info[$key] = '';
        }

        //返回题目答案处理
        $qa_info['qa_right_key'] != '' && $qa_info['qa_right_key'] = json_decode($qa_info['qa_right_key'], true);

        //返回题目图片处理
        if ($qa_info['qa_subject_img'] && $qa_info['qa_subject_img'] != 0) {
            $subject_img_info = $this->getImageinfo(array('id' => $qa_info['qa_subject_img']));
            $qa_info['qa_subject_img'] = $subject_img_info ? C('PAGE_URL') . $subject_img_info[0]['path'] : '0';
        }

        //题目选项获取
        $option_where = array('qa_id' => $qa_info['id']);
        $qa_options = M('qa_option')->where($option_where)->order('id')->select();

        //题目选项处理
        if ($qa_options) {
            foreach ($qa_options as $key => $value) {
                if ($value['option_img'] && $value['option_img'] != 0) {
                    $option_img_info = $this->getImageinfo(array('id' => $value['option_img']));
                    $qa_options[$key]['option_img'] = $option_img_info ? C('PAGE_URL') . $option_img_info[0]['path'] : '0';
                }
                $qa_options[$key]['option_title'] = $value['option_title'] ? $value['option_title'] : '';
            }
        }
        $qa_info['qa_options'] = $qa_options ? $qa_options : '';

        //HashID
        $qa_info_string = json_encode($qa_info);
        $qa_info['hash_id'] = md5($qa_info_string);

        $this->ajaxReturn(array('code' => 1, 'msg' => 'get success', 'data' => $qa_info), $this->format);
    }
}
