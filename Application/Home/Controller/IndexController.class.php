<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {
    
    public function _initialize(){
        parent::_initialize();
        $this->userId=$this->checkUserLogin();
    }
	public function index(){
	    //签到相关
	    $checkinModel = D('checkin');
	    $checkinUserinfo = $checkinModel->getCheckinfUserInfo($this->userId);
	    if(!$checkUserinfo && !is_array($checkinUserinfo)){
	        $checkinUserinfo['ischeckined'] = 'fail';
	        $checkinUserinfo['checkin_days'] = 0;
	        $checkinUserinfo['checkin_total'] = 0;
	    }
	    $userCheckinLog = $checkinModel->getUserCheckLog($this->userId);
	    $calendar = $checkinModel->makecalendar($userCheckinLog);
	    
	    //获取投票数据
	    $voteModel = D('Vote');
	    $voteData = $voteModel->getIndexVote();
	    foreach($voteData as $key=>$value){
	        $imgwhere['id'] = array('eq',$value['imgurl']);
	        $imginfo = $this->getImageinfo($imgwhere);
	        if($imginfo[0]['path']){
	            $voteData[$key]['imgpath'] = __ROOT__.$imginfo[0]['path'];
	        }
	        if($imginfo[0]['url']){
	            $voteData[$key]['imgpath'] = $imginfo[0]['url'];
	        }
	        $voteData[$key]['url'] = addons_url('Vote://Show/show',array('voteid'=>$value['id']));
	    }
	    
	    //获取调查的数据
	    $researchModel = D('Research');
	    $researchData = $researchModel->getIndexResearch();
	    foreach($researchData as $key=>$value){
	        $imgwhere['id'] = array('eq',$value['imgurl']);
	        $imginfo = $this->getImageinfo($imgwhere);
	        if($imginfo[0]['path']){
	            $researchData[$key]['imgpath'] = __ROOT__.$imginfo[0]['path'];
	        }
	        if($imginfo[0]['url']){
	            $researchData[$key]['imgpath'] = $imginfo[0]['url'];
	        }
	        $researchData[$key]['url'] = addons_url('Research://Show/index',array('rid'=>$value['id']));
	    }
	    $this->assign('researchlist',$researchData);
	    $this->assign('votelist',$voteData);
	    $this->assign('calendar',$calendar);
	    $this->assign('checkinuser',$checkinUserinfo);
	    $this->assign('title','我的主页');
		$this->display();
	}
	
	public function calendar(){
	    $checkinModel = D('checkin');
	    $timestamp = I('timestamp',time());
	    $userCheckinLog = $checkinModel->getUserCheckLog($this->userId,$timestamp);
	    $calendar = $checkinModel->makecalendar($userCheckinLog, $timestamp);
	    $this->ajaxReturn($calendar);
	}
	
	//签到
	public function checkin(){
	    $checkinModel = D('checkin');
	    $userinfo = $checkinModel->getCheckinfUserInfo($this->userId);
	    if($userinfo){
    	    if($userinfo['ischeckined']){
    	        $this->ajaxReturn(array('msg'=>'今日已签到，请不要重复签到','status'=>0));
    	    }
	    }
	    $result = $checkinModel->checkin($this->userId,$userinfo);
	    switch($result){
	        case is_array($result):
	            $data = array('msg'=>'签到成功','status'=>'success','data'=>$result); break;
	        case  -1:
	            $data = array('msg'=>'用户ＩＤ无效'); break;
	        case -2:
	            $data = array('msg'=>'今日已签到，请不要重复签到'); break;
	        default:
	            $data = array('msg'=>'签到失败');
	    }
	    $this->ajaxReturn($data);
	}

}