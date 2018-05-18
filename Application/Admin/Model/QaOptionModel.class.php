<?php
/**
 * User: zengzhifei
 * Date: 2017/5/19
 * Time: 18:12
 */

namespace Admin\Model;

use Think\Model;

class QaOptionModel extends Model
{
    protected $tableName = 'qa_option';

    //保存问答信息
    public function saveQaOption($data, $where = null)
    {
        if ($where) {
            $res = $this->where($where)->save($data);
        } else {
            $res = $this->add($data);
        }
        return $res;
    }

    //批量保存问答信息
    public function saveQaOptionAll($data)
    {
        return $this->addAll($data);
    }

    //获取指定问答信息
    public function getQaOptionInfo($where)
    {
        return $this->where($where)->order('id')->select();
    }

    //获取问答列表信息
    public function getQaOptionList($firstRows, $listRows, $where = null, $order = 'id')
    {
        $list  = $this->where($where)->order($order)->limit($firstRows.','.$listRows)->field('*')->select();
        return $list;
    }

    //获取问答总数
    public function getQaOptionCount()
    {
        return $this->count();
    }

    //删除问答
    public function deleteQaOption($where)
    {
        if ($where) {
            $delete_res = $this->where($where)->delete();
        }
        return $delete_res;
    }

}