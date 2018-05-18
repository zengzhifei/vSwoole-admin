<?php
namespace Home\Model;
use Think\Model;

/**
 * 评论   话题   模型
 */
class CommenttopicModel extends Model{
    
    protected $tableName = 'comment_topic';
    
    
	/**
	 * 根据where条件、获取一组信息
	 */
	public  function gettopic($where = array() , $field = "*"){
	    return $this->where($where)->field($field)->select();
	}




























//End  Class
}