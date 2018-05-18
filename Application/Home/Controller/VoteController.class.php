<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 前台投票的控制控制器
 * 主要获取投票相关的数据操作
 */
class VoteController extends HomeController {
    
    public function _initialize(){
        parent::_initialize();
        $this->userId=$this->checkUserLogin();
    }
    
    public function index(){
        $VoteModel = D('Vote');
        $p    = I('p',1,'intval');
        $count= $VoteModel->getMyVoteCount($this->userId);
        $Page      = $this->page($count);
        $show      = $Page->homeshow();
        $data=$VoteModel->getMyVote($this->userId,$p,$Page->firstRow,$Page->listRows);
        foreach($data as $key=>$value){
	        $imgwhere['id'] = array('eq',$value['imgurl']);
	        $imginfo = $this->getImageinfo($imgwhere);
	        if($imginfo[0]['path']){
	            $data[$key]['imgpath'] = __ROOT__.$imginfo[0]['path'];
	        }
	        if($imginfo[0]['url']){
	            $data[$key]['imgpath'] = $imginfo[0]['url'];
	        }
	        $data[$key]['optiondata'] = $VoteModel->getChsetOption($value['voteid'],$this->userId);
	        /* $data[$key]['url'] = addons_url('Vote://Show/show',array('voteid'=>$value['id'])); */
	    }
	    $this->assign('page',$show);
	    $this->assign('count',$count);
        $this->assign('list',$data);
        $this->assign('title','我的投票');
        $this->display();
    }

}