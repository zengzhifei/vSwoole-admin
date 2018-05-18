<?php
/**
 * User: zengzhifei
 * Date: 2017/5/27
 * Time: 13:00
 */

namespace Admin\Model;


use Think\Model;

class QaLogModel extends Model
{
    protected $tableName = 'qa_log';

    public function getQaLogCount($where = null)
    {
        if ($where) {
            $count = $this->where($where)->count();
        }
        return $count ? $count : 0;
    }

    public function getQaLogInfo($where = null)
    {
        if ($where) {
            $info = $this->where($where)->find();
        }
        return $info ? $info : false;
    }

    public function getQaLogList($where = null,$field = '*') {
        if ($where) {
            $list = $this->field($field)->where($where)->order('user_id+0')->select();
        }
        return $list ? $list : false;
    }
}