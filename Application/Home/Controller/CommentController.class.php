<?php
namespace Home\Controller;

/**
 * 前台  ++评论++  的控制控制器
 * 主要获取  ++评论++  相关的数据操作
 */
class CommentController extends HomeController {
    
    public function _initialize(){
        parent::_initialize();
        $this->userId=$this->checkUserLogin();
    }
    
    
    /**
     * 我的评论
     * 前台展示我的评论列表
     */
    public function index(){
        $uid = $this->userId;
    	$p = I('p',1,intval);
    	$offset = C('PAGE_OFFSET'); 
    	$commentModel = D('Comment');
    	$userinfo = $commentModel->getcommentlist($uid);
    	$userids = array_slice($userinfo, ($p-1)*$offset,$offset);
    	$topicModel = D('Commenttopic');
    	foreach ($userids as $k => $v){
    		$where['tid'] = $v['topicid'];
    		$order = 'updatetime desc';
    		$topiclist  = $topicModel->gettopic($where,"*",$order);
    		$userids[$k]['topicname'] = $topiclist[0]['topicname'];
    		$path = $this->getImageinfo(array("id"=>$topiclist[0]['logo_img']));
    		$userids[$k]['logo_img'] = $path[0]['path'];
    	}
    	$parameter = array();
    	$total= count($userinfo);
    	$Page= $this->page($total,$parameter);
    	$show= $Page->homeshow();
    	$this->assign("p",$p);
	    $this->assign('count',count($userinfo));
    	$this->assign("totalpage",$Page->totalPages);
    	$this->assign("page",$show);
    	$this->assign('total',$total);
    	$this->assign('userinfo',$userids);
        $this->assign('title','我的评论');
        $this->display();
    }


































//End Class
}