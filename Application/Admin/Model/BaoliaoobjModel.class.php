<?php
namespace Admin\Model;
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
	
	/**
	 * 修改、添加
	 */
	public function saveobj($data, $where){
		if ($where) {
			$res = $this->where($where)->save($data);
		}else {
			$data['ctime'] = time();
			$res = $this->add($data);
		}
		return $res;
	}
	
	/**
	 * 根据条件删除
	 * @param unknown $where
	 * @return Ambigous <\Think\mixed, boolean, unknown>
	 */
	public function delobj($where){
		return $this->where($where)->delete();
	}
}