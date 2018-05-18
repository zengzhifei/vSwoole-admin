<?php
namespace Api\Model;
use Think\Model;
class QaLogModel extends Model{
    
    /**
     * 获取百人团答题信息
     */
    public function getGroupInfo($stage_id,$group_id,$qa_id,$user_type='1003'){
        $where["stage_id"] = $stage_id;
        $where["group_id"] = $group_id;
        $where["qa_id"] = $qa_id;
        $where["user_type"] = $user_type;
        $order = "user_id+0 asc";
        $info = $this->where($where)->order($order)->field("user_id,is_right")->limit(100)->select();
        return $info;
    }

}