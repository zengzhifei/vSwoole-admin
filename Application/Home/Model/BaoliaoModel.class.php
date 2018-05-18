<?php
namespace Home\Model;
use Think\Model;
class BaoliaoModel extends Model{
	
	protected $tableName = 'baoliao';
	
	/**
	 * 列表
	 */
	public function getlist($field = '*', $where, $order, $p, $limit){
		if ($p) {
			$list  = $this->field($field)->where($where)->order($order)->page($p, $limit)->select();
		}else {
			$list  = $this->field($field)->where($where)->order($order)->select();
		}
		$count = $this->where($where)->count();
		return $data = array('list'=>$list, 'count'=>$count);
	}
}