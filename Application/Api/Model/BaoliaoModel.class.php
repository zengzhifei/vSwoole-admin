<?php
namespace Api\Model;
use Think\Model;
class BaoliaoModel extends Model{
	
	/**
	 * 修改、添加爆料
	 */
	public function savebaoliao($data){
	    $result = $this->add($data);
	    if($result){
	        action_log('add_baoliao', 'member', $data['userid'], $data['userid']);
	    }
		return $result;
	}
}