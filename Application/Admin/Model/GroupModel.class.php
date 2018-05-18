<?php
/**
 * Created by PhpStorm.
 * User: zengzhifei
 * Date: 2017/5/16
 * Time: 15:13
 */

namespace Admin\Model;


use Think\Model;

class GroupModel extends Model
{
    protected $tableName = 'group';

    //保存分组信息
    public function saveGroup($data, $where = null)
    {
        if ($where) {
            $res = $this->where($where)->save($data);
        } else {
            $res = $this->add($data);
        }
        return $res;
    }

    //获取指定分组信息
    public function getGroupInfo($where)
    {
        return $this->where($where)->find();
    }

    //获取分组列表信息
    public function getGroupList($firstRows, $listRows, $where = null, $order = 'group_created')
    {
        $list  = $this->where($where)->order($order)->limit($firstRows.','.$listRows)->field('*')->select();
        return $list;
    }

    //获取分组总数
    public function getGroupCount($where)
    {
        return $this->where($where)->count();
    }

    //删除分组
    public function deleteGroup($where)
    {
        if ($where) {
            $delete_res = $this->where($where)->delete();
        }
        return $delete_res;
    }

}