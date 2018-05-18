<?php
/**
 * Created by PhpStorm.
 * User: liuxiaomeng
 * Date: 2017/5/12
 * Time: 15:13
 */

namespace Admin\Model;


use Think\Model;

class ColumnModel extends Model
{
    protected $tableName = 'column';

    //保存栏目信息
    public function saveColumn($data, $where = null)
    {
        if ($where) {
            $res = $this->where($where)->save($data);
        } else {
            $res = $this->add($data);
        }
        return $res;
    }

    //获取指定栏目信息
    public function getColumnInfo($where)
    {
        return $this->where($where)->find();
    }

    //获取栏目列表信息
    public function getColumnList($firstRows, $listRows, $where = null, $order = 'column_created')
    {
        $list  = $this->where($where)->order($order)->limit($firstRows.','.$listRows)->field('*')->select();
        return $list;
    }

    //获取栏目总数
    public function getColumnCount()
    {
        return $this->count();
    }

    //删除栏目
    public function deleteColumn($where)
    {
        if ($where) {
            $delete_res = $this->where($where)->delete();
        }
        return $delete_res;
    }

}