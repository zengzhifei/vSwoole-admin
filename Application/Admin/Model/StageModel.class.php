<?php
/**
 * Created by PhpStorm.
 * User: zengz
 * Date: 2017/5/12
 * Time: 15:13
 */

namespace Admin\Model;


use Think\Model;

class StageModel extends Model
{
    protected $tableName = 'stage';

    //保存期数信息
    public function saveStage($data, $where = null)
    {
        if ($where) {
            $res = $this->where($where)->save($data);
        } else {
            $res = $this->add($data);
        }
        return $res;
    }

    //获取指定期数信息
    public function getStageInfo($where)
    {
        return $this->where($where)->find();
    }

    //获取期数列表信息
    public function getStageList($firstRows, $listRows, $where = null, $order = 'stage_created')
    {
        $list  = $this->where($where)->order($order)->limit($firstRows.','.$listRows)->field('*')->select();
        return $list;
    }

    //获取期数总数
    public function getStageCount()
    {
        return $this->count();
    }

    //删除期数
    public function deleteStage($where)
    {
        if ($where) {
            $delete_res = $this->where($where)->delete();
        }
        return $delete_res;
    }

}