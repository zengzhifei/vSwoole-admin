<?php

namespace Addons\Comment\Model;
use Think\Model;

/**
 * Comment模型
 */
class CommentpraiseModel extends Model{
    
    //定义主表
    protected  $tableName='comment_praise';
    
  
    
    /**
     * 根据where条件，获取点赞总数
     */
    public function getpraisecount($where = array()){
        return $this->where($where)->count();
    }
    
    /**
     * 根据where条件，获取一条记录
     */
    public function getpraiseinfo($where = array()){
        return $this->where($where)->select();
    }
    
    /**
     * 根据uid和commentid查询是否有这条记录，如果没有则新加，如果有则删除
     */
    public function  changepraise($data){
        $count = $this->where($data)->count();
        if($count){
            return $this->where($data)->delete();
        }else{
            return $this->add($data);
        }
    }
}
