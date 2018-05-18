<?php
/**
 * User: zengzhifei
 * Date: 2017/5/19
 * Time: 16:22
 */

namespace Admin\Model;

use Think\Model;

class QaModel extends Model
{
    protected $tableName = 'qa';

    //保存问答信息
    public function saveQa($data, $where = null)
    {
        if ($where) {
            $res = $this->where($where)->save($data);
        } else {
            $res = $this->add($data);
        }
        return $res;
    }

    //获取指定问答信息
    public function getQaInfo($where)
    {
        return $this->where($where)->find();
    }

    //获取问答列表信息
    public function getQaList($firstRows, $listRows, $where = null, $order = 'id')
    {
        $list  = $this->where($where)->order($order)->limit($firstRows.','.$listRows)->field('*')->select();
        return $list;
    }

    //获取问答总数
    public function getQaCount($where)
    {
        return $this->where($where)->count();
    }

    //删除问答
    public function deleteQa($where)
    {
        if ($where) {
            $delete_res = $this->where($where)->delete();
        }
        return $delete_res;
    }

}