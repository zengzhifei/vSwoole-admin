<?php
/**
 * User: zengzhifei
 * Date: 2017/7/5
 * Time: 11:29
 */

namespace Admin\Model;


use Think\Model;

class QaGroupCountModel extends Model
{
    protected $tableName = 'qa_group_count';

    public function saveQaGroupCount($data, $where = null)
    {
        return $where ? $this->where($where)->save($data) : $this->add($data);
    }

    public function deleteQaGroupCount($where)
    {
        return $this->where($where)->delete();
    }

    public function saveQaGroupCountAll($data)
    {
        return $this->addAll($data);
    }

    public function getQaGroupCountCount($where)
    {
        return $this->where($where)->count();
    }

}