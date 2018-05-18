<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;

/**
 * 投票模型
 */
class VoteModel extends Model{
    public function _initialize(){
        parent::_initialize();
        if(C('IS_CACHE')){
            import("Vendor.Memcache.Memch",'','.php');
            $this->Memcache = new \Memch('voteVersion');
        }
    }
    
    /*
     * 获取首页的投票数据
     */
	function getIndexVote(){
	    if(C('IS_CACHE')){
	        $cachename = 'IndexVote';
	        $list = $this->Memcache->getCache($cachename);
	        if(!$list){
	            $where['is_show'] = array('eq',1);
	            $where['is_end'] = array('eq',2);
	            $where['starttime'] = array('lt',time());
	            $where['endtime'] = array('gt',time());
	            $order = 'creattime DESC';
	            $list = $this->where($where)->field('id,title,imgurl')->limit(0,6)->order($order)->select();
	            if($list){
	                $this->Memcache->setCache($cachename, $list);
	            }
	        }
	    }else{
	        $where['is_show'] = array('eq',1);
	        $where['is_end'] = array('eq',2);
	        $where['starttime'] = array('lt',time());
	        $where['endtime'] = array('gt',time());
	        $order = 'creattime DESC';
	        $list = $this->where($where)->field('id,title,imgurl')->limit(0,6)->order($order)->select();
	    }
		
		return $list;
	}
	
	/*
	 * 获取我的投票的次数
	 */
	
	function getMyVoteCount($uid){
	    $where['a.userid'] = $uid;
	    $where['b.is_show'] = 1;
	    $count = M('vote_log as a')->where($where)->group('a.voteid')->join('wei_vote as b on b.id=a.voteid')->select();
	    return count($count);
	}
	/*
	 * 获取我的投票列表
	 */
	function getMyVote($uid,$p,$firstRow,$listRows){
	    $where['a.userid'] = $uid;
	    $where['b.is_show'] = 1;
	    $data = M('vote_log as a')
	           ->where($where)
	           ->group('a.voteid')
	           ->join('wei_vote as b on b.id=a.voteid')
	           ->limit($firstRow.','.$listRows)
	           ->select();
	    return $data;
	}
	
	public function getChsetOption($voteid,$uid){
	    $where['a.voteid'] = $voteid;
	    $where['a.userid'] = $uid;
	    $data = M('vote_log as a')->field("a.optionid,count(a.id) as count,b.title")->where($where)->group('a.optionid')->join('wei_vote_option as b on b.id=a.optionid')->select();
	    return $data;
	}
}
