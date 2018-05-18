<?php
namespace Home\Controller;
class BaoliaoController extends HomeController{
	
	/**
	 * !CodeTemplates.overridecomment.nonjd!
	 * @see \Home\Controller\HomeController::_initialize()
	 */
	public function _initialize(){
		parent::_initialize();
		$this->userId=$this->checkUserLogin();
	}
	
	/**
	 * 我的爆料
	 * 前台展示我的爆料列表
	 */
	public function index(){
		$uid = $this->userId;
		$p = I('p',1,intval);
		$offset = C('PAGE_OFFSET');
		$commentModel = D('Baoliao');
		$fields = "*";
		$where['userid'] = $uid;
		$order = 'ctime desc';
		$baoliaolist = $commentModel->getlist($fields,$where,$order);
		$baoliao = array_slice($baoliaolist['list'], ($p-1)*$offset,$offset);
// 		var_dump($baoliao);exit;
		$objModel = D('Baoliaoobj');
		foreach ($baoliao as $k => $v){
			$id = $v['parentid'];
			$objinfo = $objModel->getinfobyid($id);
			if ($objinfo) {
				$baoliao[$k]['pname'] = $objinfo['title'];
				$path = $this->getImageinfo(array("id"=>$objinfo['img']));
				$baoliao[$k]['logo_img'] = $path[0]['path'];
			}
		}
		$parameter = array();
		$total     = $baoliaolist['count'];
		$Page      = $this->page($total,$parameter);
		$show      = $Page->homeshow();
		$this->assign("p",$p);
		$this->assign('count',$total);
		$this->assign("totalpage",$Page->totalPages);
		$this->assign("page",$show);
		$this->assign('total',$total);
		$this->assign('baoliao',$baoliao);
		$this->assign('title','我的爆料');
		$this->display();
	}
}