<?php
/**
 * Created by PhpStorm.
 * User: liuxiaomeng
 * Date: 2017/11/24
 * Time: 15:33
 */

namespace Admin\Controller;


class ColumnController extends HudongAdminController
{
    public function _initialize(){
        parent::_initialize();
        $this->assign('menuname', "栏目列表");
    
    }
    /**
     * 栏目首页
     */
    public function index()
    {
        $columnModel = D('column');

        $find_column_name = I('find_column_name', false);
        $where = $find_column_name ? array('column_name' => array('LIKE', '%' . $find_column_name . '%')) : null;
        $total = $columnModel->getColumnCount();
        $Page = $this->page($total, $where);
        $data['pageFind']['column_name'] = $find_column_name;
        $data['page']['show'] = $Page->weishow();
        $data['page']['totalPage'] = $Page->totalPages;
        $data['page']['p'] = I('p', 1, 'intval');

        $columnList = $columnModel->getColumnList($Page->firstRow, $Page->listRows, $where);
        $data['pageTitle'] = '栏目列表';
        $data['pageInfo'] = $columnList ? $columnList : null;
        //dump($data);
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 添加/编辑栏目
     */
    public function addEdit()
    {
        $column_id = I('column_id', false);
        $data['pageTitle'] = $column_id ? '编辑栏目' : '添加栏目';
        if ($column_id) {
            $columnModel = D('column');
            $where = array('column_id' =>  $column_id);
            $columnInfo = $columnModel->getColumnInfo($where);
            $data['pageInfo'] = $columnInfo ? $columnInfo : null;
        }

        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 保存栏目信息
     */
    public function saveColumn()
    {
        $column_id = I('column_id', false);
        $data = array(
            'column_id'      => $column_id,
            'column_name'    => I('column_name', false),
            'column_date'    => I('column_date', time(), 'strtotime'),
            'column_remark'  => I('column_remark', false),
            'column_created' => I('column_created', time()),
            'column_updated' => time()
        );

        //生成栏目id
      if (!$data['column_id']) {
            $data['column_id'] = $this->makeStage();
        }
        if (!$data['column_name']) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少栏目名称'));
        }
        if (mb_strlen($data['column_remark'], 'utf-8') > 128) {
            $this->ajaxReturn(array('status' => -2, 'info' => '栏目备注超过128字数限制'));
        }

        $columnModel = D('column');
        $where = $column_id ? array('column_id' => $column_id) : null;
        $save_res = $columnModel->saveColumn($data, $where);
        if ($save_res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '保存成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '保存失败'));
        }
    }

    /**
     * 开启关闭栏目
     */
    public function switchColumn()
    {
        $column_id = I('column_id', false);
        $column_status = I('column_status', false);
        $columnModel = D('column');
        if (!$column_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少栏目ID'));
        }
        if ($column_status == 1) {
            if(M('Column')->where('column_status=1')->getField('id')){
                $this->ajaxReturn(array('status' => -3, 'info' => '当前已有栏目开启！'));

            }
            $where1 = array('column_id'=>$column_id);
            $get_res = $columnModel->getColumnInfo($where1);
            //$get_res = $this->getStartColumn();
            if ($get_res['column_status'] == 1 ) {
                $this->ajaxReturn(array('status' => -2, 'info' => '当前栏目已开启'));
            }
        }


        $where = array('column_id' => $column_id);
        $data = array('column_status' => $column_status);
        $handle_res = $columnModel->saveColumn($data, $where);
        if ($handle_res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '操作成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
        }
    }

    /**
     * 删除栏目
     */
    public function deleteColumn()
    {
        $column_id = I('column_id', false);

        if (!$column_id) {
            $this->ajaxReturn(array('status' => -1, 'info' => '缺少栏目'));
        }

        $columnModel = D('column');
        $where = array('column_id' => $column_id);
        $column_info = $columnModel->getColumnInfo($where);
        if ($column_info['column_status'] == 1) {
            $this->ajaxReturn(array('status' => -2, 'info' => '当前栏目正在运行'));
        }
        $delete_res = $columnModel->deletecolumn($where);
        if ($delete_res) {
            $this->ajaxReturn(array('status' => 1, 'info' => '删除成功'));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '删除失败'));
        }
    }

    /**
     * 生成栏目ID
     */
    private function makeStage()
    {
        $column_prefix = C('COLUMN_PREFIX');
        return uniqid($column_prefix . time());
    }
}