<?php
namespace Home\Model;
use Think\Model;
class BaoliaoobjModel extends Model{
	
	protected $tableName = 'baoliaoobj';
	
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
	
	/**
	 * 根据ID查单条数据
	 */
	public function getinfobyid($id){
		return $this->find($id);
	}
}