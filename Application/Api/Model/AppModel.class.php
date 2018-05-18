<?php

namespace Api\Model;
use Think\Model;


class AppModel extends Model{

   /**
    * 获取抽奖信息
    */ 
   public function getDrawInfo($where){
       $where['is_show'] = 1;
       $where ['endtime'] = array ('gt',time());
       $model = M("lucky");
       $data = $model->where($where)->order("created desc")->field("id,lucky_title")->select();
       if(is_array($data)){
           return $data;
       }
       return array();
   }
   
   /**
    * 获取评论信息
    */
   public function getCommentInfo($where){
       $where['s.uid'] = $where['uid'];
       $model = M("comment_topic");
       $data = $this->table('wei_comment_topic as t')
                    ->join('wei_comment_sort as s on s.sid = t.sid')
                    ->field("t.tid,t.topicname")
                    ->where($where)
                    ->order('t.createtime desc')
                    ->select();
       if(is_array($data)){
           return $data;
       }
       return array();
   }
   /**
    * 获取投票信息
    */
   public function getVoteInfo($where){
       $where['is_end'] = 2;
       $where ['endtime'] = array ('gt',time());
       $model = M("vote");
       $data = $model->where($where)->order("creattime desc")->field("id,title")->select();
       if(is_array($data)){
           return $data;
       }
       return array();
   }
   /**
    * 获取调查信息
    */
   public function getResearchInfo($where){
       $where ['endtime'] = array ('gt',time());
       $model = M("research");
       $data = $model->where($where)->order("creattime desc")->field("id,title")->select();
       if(is_array($data)){
           return $data;
       }
       return array();
   }

}
