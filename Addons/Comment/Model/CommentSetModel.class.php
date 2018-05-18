<?php
namespace Addons\Comment\Model;
use Think\Model;
class CommentSetModel extends Model{

	protected $tableName = 'comment_set';
	
	public function getcommentsetinfo($field = '*',$where){
		return $this->field($field)->where($where)->find();
	}
	
	public function savecommentset($data, $uid, $is_save = 0){
		if ($is_save) {
			$where['uid'] = $uid;
			$data['utime'] = time();
			$res = $this->where($where)->save($data);
		}else {
			$data['uid'] = $uid;
			$data['ctime'] = time();
			$res = $this->add($data);
		}
		return $res;
	}
}