<?php
namespace Admin\Model;
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
	
	/**
	 * 根据ID查单条数据
	 */
	public function getinfobyid($id){
		return $this->find($id);
	}
	
	/**
	 * 根据条件获取条数
	 */
	public function getcounts($where){
		return $this->where($where)->count();
	}
	
	/**
	 * 修改、添加爆料
	 */
	public function savebaoliao($data, $where){
		if ($where) {
			$res = $this->where($where)->save($data);
		}else {
			$res = $this->add($data);
		}
		return $res;
	}
	
	/**
	 * 根据条件删除爆料
	 * @param unknown $where
	 * @return Ambigous <\Think\mixed, boolean, unknown>
	 */
	public function delbaoliao($where){
		return $this->where($where)->delete();
	}
}