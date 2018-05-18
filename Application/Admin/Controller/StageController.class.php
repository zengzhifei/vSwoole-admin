<?php
/**
 * Created by PhpStorm.
 * User: zengzhifei
 * Date: 2017/5/12
 * Time: 11:33
 */

namespace Admin\Controller;


class StageController extends HudongAdminController
{
    public function _initialize()
    {
        parent::_initialize();

        $this->assign('menuname', "期数列表");
    }

    /**
     * 期数首页
     */
    public function index()
    {
        $column_id = I('column_id', false);

        if (!$column_id) {
            $columnInfo = $this->column;
            $column_id = $columnInfo ? $columnInfo['column_id'] : false;
        } else {
            $columnInfo = D('column')->getColumnInfo(array('column_id' => $column_id));
        }

        if ($column_id) {
            $where['column_id'] = $column_id;
            $find_stage_name = I('find_stage_name', false);
            $find_stage_name && $where['stage_name'] = array('LIKE', '%' . $find_stage_name . '%');

            $stageModel = D('stage');
            $total = $stageModel->getStageCount();
            $Page = $this->page($total, $where);
            $data['pageFind']['stage_name'] = $find_stage_name;
            $data['page']['show'] = $Page->weishow();
            $data['page']['totalPage'] = $Page->totalPages;
            $data['page']['p'] = I('p', 1, 'intval');

            $stageList = $stageModel->getStageList($Page->firstRow, $Page->listRows, $where);
            foreach ($stageList as $key => $value) {
                $stageList[$key]['stage_date'] = $value['stage_start_time'] && $value['stage_end_time'] ? date('Y/m/d H:i:s', $value['stage_start_time']) . '-' . date('Y/m/d H:i:s', $value['stage_end_time']) : '';
            }
            $data['pageInfo'] = $stageList ? $stageList : null;
            $data['column_info'] = $columnInfo;
        }

        $data['pageTitle'] = '期数列表';
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 添加/编辑期数
     */
    public function addEdit()
    {
        $column_id = I('column_id', false);
        $stage_id = I('stage_id', false);
        $data['pageTitle'] = $stage_id ? '编辑期数' : '添加期数';

        if (!$column_id) {
            $column_id = $this->column['column_id'];
        }
        if ($stage_id) {
            $stageInfo = D('stage')->getStageInfo(array('stage_id' => $stage_id));
            $stageInfo['stage_date'] = $stageInfo['stage_start_time'] && $stageInfo['stage_end_time'] ? date('Y/m/d H:i:s', $stageInfo['stage_start_time']) . '-' . date('Y/m/d H:i:s', $stageInfo['stage_end_time']) : '';
            $data['pageInfo'] = $stageInfo ? $stageInfo : null;
        }

        $this->assign('data', $data);
        $this->assign('column_id', $column_id);
        $this->display();
    }

    /**
     * 保存期数信息
     */
    public function saveStage()
    {
        $stage_id = I('stage_id', false);
        $data = array(
            'column_id'     => I('column_id', false),
            'stage_id'      => $stage_id,
            'stage_name'    => I('stage_name', false),
            'stage_date'    => I('stage_date', time(), 'strtotime'),
            'stage_remark'  => I('stage_remark', false),
            'stage_created' => I('stage_created', time()),
            'stage_updated' => time()
        );
        $stage_date = I('stage_date', false);
        if ($stage_date) {
            list($startTime, $endTime) = explode('-', $stage_date);
            $data['stage_start_time'] = strtotime($startTime);
            $data['stage_end_time'] = strtotime($endTime);
        }

        if (!$data['stage_id']) {
            $data['stage_id'] = $this->makeStage();
        }
        if (!$data['stage_name']) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少期数名称'));
        }
        if (mb_strlen($data['stage_remark'], 'utf-8') > 128) {
            $this->ajaxReturn(array('status' => -2, 'info' => '期数备注超过128字数限制'));
        }

        $stageModel = D('stage');
        $where = $stage_id ? array('stage_id' => $stage_id) : null;
        $save_res = $stageModel->saveStage($data, $where);
        if ($save_res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '保存成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '保存失败'));
        }
    }

    /**
     * 开启关闭期数
     */
    public function switchStage()
    {
        $stageModel = D('stage');
        $stage_id = I('stage_id', false);
        $stage_status = I('stage_status', false);

        if (!$stage_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少期数ID'));
        }
        if ($stage_status == 1) {
            if (!$this->column) {
                $this->ajaxReturn(array('status' => -2, 'info' => '当前没有开启的栏目'));
            }
            if ($this->stage) {
                $this->ajaxReturn(array('status' => -3, 'info' => '当前已有开启的期数'));
            }
            $stageInfo = $stageModel->getStageInfo(array('stage_id' => $stage_id));
            if ($stageInfo['column_id'] != $this->column['column_id']) {
                $this->ajaxReturn(array('status' => -4, 'info' => '当前组所属栏目未开启'));
            }
        } else if ($stage_status == 0) {
            R('Group/closeAllGroup',array($stage_id));
            R('Qa/closeAllQa',array($stage_id));
        }

        $where = array('stage_id' => $stage_id);
        $data = array('stage_status' => $stage_status);
        $res = $stageModel->saveStage($data, $where);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '操作成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
        }
    }

    /**
     * 删除期数
     */
    public function deleteStage()
    {
        $stage_id = I('stage_id', false);

        if (!$stage_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少期数ID'));
        }

        $stageModel = D('stage');
        $where = array('stage_id' => $stage_id);
        $stage_info = $stageModel->getStageInfo($where);
        if ($stage_info['stage_status'] == 1) {
            $this->ajaxReturn(array('status' => -2, 'info' => '当前期正在运行'));
        }
        $res = $stageModel->deleteStage($where);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '删除成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '删除失败'));
        }
    }

    /**
     * 生成期数ID
     */
    private function makeStage()
    {
        $stage_prefix = C('STAGE_PREFIX');

        return uniqid($stage_prefix . time());
    }
}