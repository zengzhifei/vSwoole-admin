<?php
namespace Home\Model;
use Think\Model;

/**
 * 评论模型
 */
class CommentModel extends Model{
    
    
    
    
    /**
     * 根据用户ID获取评论信息
     * @param unknown $uid
     * @return unknown
     */
    public function getcommentlist($uid){
    	if ($uid) {
    		$where['uid'] = $uid;
    	}	
    	$res = $this->where($where)
			    	->field("*")
			    	->order(" commenttime desc")
			    	->select();
    	return $res;
    }





























//End Class
}