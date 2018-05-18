<?php
namespace Api\Model;
use Think\Model;
class GroupModel extends Model{

	/**
	 * 获取当前开启的分组信息
	 */
	public function getGroup($stage_id,$type=1){
	    $where["stage_id"] = $stage_id;
	    $where["group_status"] = 1;
	    $where["group_type"] = 1;
	    $info = $this->where($where)->find();
		return $info;
	}
	
	
	/**
	 * 获取当前期所有分组list
	 */
	public function getGroupList($stage_id,$type=1){
	    $where["stage_id"] = $stage_id;
	    $where["group_type"] = 1;
	    $info = $this->where($where)->select();
	    return $info;
	}
}