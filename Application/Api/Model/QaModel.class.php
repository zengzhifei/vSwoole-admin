<?php
namespace Api\Model;
use Think\Model;
class QaModel extends Model{
	
	/**
	 * 获取当前开启的选手题信息
	 * type=xs 获取推送选手题信息
	 * type=br 获取推送百人团题信息
	 */
	public function getQa($stage_id,$group_id,$type){
	    $where["stage_id"] = $stage_id;
	    $where["group_id"] = $group_id;
	    if($type == "xs"){
	        $where["qa_player_status"] = 1;
	    }elseif ($type == "br"){
	        $where["qa_normal_status"] = 1;
	    }
	    
	    $info = $this->where($where)->find();
		return $info;
	}
	
	/**
	 * 获取已答题数
	 * 
	 */
	public function getUseQaCount($stage_id,$group_id_str){
	    $where["stage_id"] = $stage_id;
	    $where["qa_is_used"] = 1;
	    $where['group_id'] = array('IN',$group_id_str);
	    $count = $this->where($where)->count();
	    return $count;
	}
}