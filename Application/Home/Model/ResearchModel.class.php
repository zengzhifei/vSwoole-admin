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
 * 调查模型
 */
class ResearchModel extends Model{
	function getIndexResearch(){
		$where['is_show'] = array('eq',1);
		$where['starttime'] = array('lt',time());
		$where['endtime'] = array('gt',time());
		$order = 'creattime DESC';
		$list = $this->where($where)->field('id,title,imgurl')->limit(0,6)->order($order)->select();
		return $list;
	}
	
	function getMyResearchCount($uid){
	    $where['a.userid'] = $uid;
	    $where['b.is_show'] = 1;
	    $data = M('research_log as a')
	    ->where($where)
	    ->group('a.researchid')
	    ->join('wei_research as b on b.id=a.researchid')
	    ->select();
	    return count($data);
	}
	
	function getMyResearch($uid,$p,$firstRow,$listRows){
	    $where['a.userid'] = $uid;
	    $where['b.is_show'] = 1;
	    $data = M('research_log as a')
	    ->where($where)
	    ->group('a.researchid')
	    ->join('wei_research as b on b.id=a.researchid')
	    ->limit($firstRow.','.$listRows)
	    ->select();
	    return $data;
	}
	
	public function getChsetResearch($research,$uid){
	    $where['researchid'] = $research;
	    $where['userid'] = $uid;
	    $data = M('research_log as a')->where($where)->group('time')->select();
	    return count($data);
	}
}
