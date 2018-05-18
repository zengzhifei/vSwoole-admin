<?php
/**
 * User: zengzhifei
 * Date: 2017/5/16
 * Time: 9:48
 */

namespace Admin\Controller;


class GroupController extends HudongAdminController
{
    protected $redis;

    public function _initialize()
    {
        parent::_initialize();

        $this->connectRedis();

        $this->assign('menuname', "分组列表");
    }

    /**
     * 分组首页
     */
    public function index()
    {
        $stage_id = I('stage_id', false);

        if (!$stage_id) {
            $stageInfo = $this->stage;
            $stage_id = $stageInfo ? $stageInfo['stage_id'] : false;
        } else {
            $stageModel = D('Stage');
            $stage_info_where = array('stage_id' => $stage_id);
            $stageInfo = $stageModel->getStageInfo($stage_info_where);
        }

        if ($stage_id) {
            $groupModel = D('Group');
            $where = array('stage_id' => $stage_id);
            $total = $groupModel->getGroupCount($where);
            $Page = $this->page($total, $where);

            $data['stage_info'] = $stageInfo;
            $data['page']['show'] = $Page->weishow();
            $data['page']['totalPage'] = $Page->totalPages;
            $data['page']['p'] = I('p', 1, 'intval');

            $groupList = $groupModel->getGroupList($Page->firstRow, $Page->listRows, $where);
            $playerCountWhere = array('stage_id' => $stage_id, 'is_del' => 0, 'type' => array('IN', array(0, 1)));
            $playerCount = M('player')->where($playerCountWhere)->count();

            $qaGroupCountModel = D('QaGroupCount');
            foreach ($groupList as $key => $value) {
                /*$qaGroupCountWhere = array('stage_id' => $stage_id, 'group_id' => $value['id']);
                $QaGroupCountCount = $qaGroupCountModel->getQaGroupCountCount($qaGroupCountWhere);
                $groupList[$key]['group_init'] = $QaGroupCountCount && $QaGroupCountCount == $playerCount ? 1 : 0;*/
                $groupList[$key]['group_time'] = $value['group_start_time'] && $value['group_end_time'] ? date('Y/m/d H:i:s', $value['group_start_time']) . '-' . date('Y/m/d H:i:s', $value['group_end_time']) : '';
            }

            $data['pageInfo'] = $groupList ? $groupList : null;
            $data['pageParam']['stage_id'] = $stage_id;
        }
        $data['pageTitle'] = '分组列表';
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 添加修改分组页面
     */
    public function addEdit()
    {
        $group_id = I('group_id', false);
        $stage_id = I('stage_id', false);

        if ($group_id) {
            $groupModel = D('group');
            $where = array('id' => $group_id);
            $groupInfo = $groupModel->getGroupInfo($where);
            $stage_id = $groupInfo['stage_id'];
            $groupInfo['group_time'] = $groupInfo['group_start_time'] && $groupInfo['group_end_time'] ? date('Y/m/d H:i:s', $groupInfo['group_start_time']) . '-' . date('Y/m/d H:i:s', $groupInfo['group_end_time']) : '';
            $data['pageInfo'] = $groupInfo ? $groupInfo : null;
        }
        $data['pageParam']['stage_id'] = $stage_id;
        $data['pageTitle'] = $group_id ? '编辑分组' : '添加分组';

        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 保存分组
     */
    public function saveGroup()
    {
        $data = array(
            'stage_id'        => I('stage_id', false),
            'group_type'      => I('group_type', 1),
            'group_type_name' => I('group_type_name', false),
            'group_title'     => I('group_title', false),
            'group_remark'    => I('group_remark', false),
            'group_created'   => I('group_created', time()),
            'group_updated'   => time()
        );
        $group_time = I('group_time', false);
        if ($group_time) {
            list($startTime, $endTime) = explode('-', $group_time);
            $data['group_start_time'] = strtotime($startTime);
            $data['group_end_time'] = strtotime($endTime);
        }

        if (!$data['group_title']) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少分组名称'));
        }
        if (mb_strlen($data['group_remark'], 'utf-8') > 256) {
            $this->ajaxReturn(array('status' => -1, 'info' => '分组备注超过256字数限制'));
        }

        $group_id = I('group_id', false);
        $groupModel = D('group');
        $where = $group_id ? array('id' => $group_id) : null;
        $save_res = $groupModel->saveGroup($data, $where);
        if ($save_res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '保存成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '保存失败'));
        }
    }

    /**
     * 开启关闭分组
     */
    public function switchGroup()
    {
        $group_id = I('group_id', false);
        $group_status = I('group_status', false);

        if (!$group_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少分组ID'));
        }

        $groupModel = D('group');
        $where = array('id' => $group_id);
        $data = array('group_status' => $group_status);
        $res = $groupModel->saveGroup($data, $where);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '操作成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
        }
    }

    /**
     * 开启或关闭所有分组
     */
    public function switchAllGroup()
    {
        $status = I('status', false);
        $stage_id = I('stage_id', false);

        if (!$stage_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少期数ID'));
        }

        $where = array('stage_id' => $stage_id);
        $res = M('group')->where($where)->save(array('group_status' => $status));
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '操作成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
        }
    }

    /**
     * 删除分组
     */
    public function deleteGroup()
    {
        $group_id = I('group_id', false);

        if (!$group_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少分组ID'));
        }

        $groupModel = D('Group');
        $where = array('id' => $group_id);
        $group_info = $groupModel->getGroupInfo($where);
        if ($group_info['group_status'] == 1) {
            $this->ajaxReturn(array('status' => -2, 'info' => '当前分组正在运行'));
        }
        $res = $groupModel->deleteGroup($where);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '删除成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '删除失败'));
        }
    }

    /**
     * 初始化分组答题统计数据
     */
    public function initGroup()
    {
        $group_id = I('group_id', false);
        $stage_id = I('stage_id', false);

        if (!$group_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少分组ID'));
        }

        if (!$stage_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少期数ID'));
        }

        $select_where = array('stage_id' => $stage_id, 'is_del' => 0, 'type' => array('IN', array(0, 1)));
        $list = M('player')->field('number,type,name,player_id')->where($select_where)->select();

        if (count($list) == 0) {
            $this->ajaxReturn(array('status' => -2, 'info' => '当前期没有选手信息'));
        }

        $groupCountModel = D('QaGroupCount');
        $delete_where = array('stage_id' => $stage_id, 'group_id' => $group_id);
        $groupCountModel->deleteQaGroupCount($delete_where);

        foreach ($list as $key => $value) {
            $saveData[] = array(
                'stage_id'    => $stage_id,
                'group_id'    => $group_id,
                'user_id'     => $value['number'],
                'user_type'   => $value['type'],
                'user_name'   => $value['name'],
                'player_id'   => $value['player_id'],
                'create_time' => time()
            );
        }
        $save_res = $groupCountModel->saveQaGroupCountAll($saveData);

        if ($save_res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '初始化成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '初始化失败'));
        }
    }


    /**
     * 开启/关闭虚拟榜单
     */
    public function changeStatus()
    {
        $id = I("id", false);
        $status = I("status", false);
        $where['id'] = $id;
        $data['is_false'] = $status;
        $data['group_updated'] = time();
        $result = M("group")->where($where)->save($data);
        if ($result) {
            $this->ajaxReturn(array('code' => 1, 'message' => '设置成功'));
        } else {
            $this->ajaxReturn(array('code' => -2, 'message' => '设置失败'));
        }
    }

    /**
     * 获取期下总分数列表
     */
    protected function getAllList($stage_id, $limit)
    {
        $where = array("stage_id" => $stage_id, "user_type" => 0);
        $order = "sum(user_score) desc";
        $group = "user_id";
        $field = "user_id,user_right_count,sum(user_score) as user_score,player_id,user_name";
        $list = M("qa_group_count")->where($where)->group($group)->order($order)->field($field)->limit($limit)->select();

        return $list;
    }

    /*
     * 导出评论数据
    */
    public function exportList()
    {
        set_time_limit(0);
        $stage_id = I('stage_id', false);

        if (!$stage_id) {
            $stageInfo = $this->getStartStage();
            $stage_id = $stageInfo ? $stageInfo['stage_id'] : false;
        } else {
            $stageModel = D('Stage');
            $stage_info_where = array('stage_id' => $stage_id);
            $stageInfo = $stageModel->getStageInfo($stage_info_where);
        }
        if ($stageInfo["stage_remark"] == "总榜") {
            $list = $this->getAllList($stage_id, 72);
            $filename = "本期总榜_" . date('Ymd') . ".csv";
        } else {
            $group_id = I("group_id", false);
            if (!$group_id) {
                $this->error("缺少分组id");
            }
            $filename = "分组排行_" . $group_id . "_" . date('Ymd') . ".csv";
            $order = "user_score desc";
            $list = M("qa_group_count")->where(array("group_id" => $group_id, "user_type" => 0))->order($order)->field("user_id,user_name,user_right_count,user_score,player_id")->limit(72)->select();
        }
        if ($list) {
            foreach ($list as $k => $v) {
                $num = str_replace(",", "，", $k + 1);
                $num = str_replace(array("\r\n", "\r", "\n"), '', $num);

                $number = str_replace(",", "，", $v["player_id"]);
                $number = str_replace(array("\r\n", "\r", "\n"), '', $number);

                $username = str_replace(",", "，", $v["user_name"]);
                $username = str_replace(array("\r\n", "\r", "\n"), '', $username);

                $score = str_replace(",", "，", $v["user_score"]);
                $score = str_replace(array("\r\n", "\r", "\n"), '', $score);

                $str .= $num . "," . $number . "," . trim($username) . "," . $score . "\n";
            }
        } else {
            $str = "暂无数据";
        }

        $data = mb_convert_encoding($str, "gb2312", "UTF-8");
        $title = "排名, 编号, 姓名, 分数\n";

        $this->export_csv($title, $filename, $data);
    }

    /**
     * 关闭所有分组
     */
    public function closeAllGroup($stage_id)
    {
        if ($stage_id) {
            $groupModel = D('Group');
            $where = array('stage_id' => $stage_id);
            $data = array('group_status' => 0);

            return $groupModel->saveGroup($data, $where);
        }
    }

}