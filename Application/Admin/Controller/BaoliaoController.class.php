<?php
namespace Admin\Controller;
class BaoliaoController extends AdminController{
	

	public function _initialize(){
        //parent::_initialize();
        $this->CheckAdminLogin();
        $userinfo = session('user');
        $this->userId = $userinfo['userid'];
		if(C('IS_CACHE')){
			import("Vendor.Memcache.Memch",'','.php');
			$this->Memcache = new \Memch('CommentVersion');
		}
		$this->assign('menuname', "爆料");
	}
	
	/**
	 * 爆料主体列表
	 */
	public function index(){
// 		echo addons_url('Board://Board/add');exit;
		$p  = I('p',1,'intval');
		$title = I('title',false);
// 		$order_by = I('order_by','created');
// 		$order_sc = I('order_sc','desc');
// 		$limit = I('perpage',C('PAGE_SIZE'),'intval');
		$datetime = I('datetime');
		$objModel = D('Baoliaoobj');
		$baoliaoModel = D('Baoliao');
// 		$order = $order_by.' '.$order_sc;
// 		$param['order_by'] = $order_by;
// 		$param['order_sc'] = $order_sc;
		//如果指定页尺寸，则设置配置问卷参数
// 		if ($limit) {
// 			C('PAGE_SIZE',$limit);
// 		}
		$order = 'ctime desc';
		if ($title) {
			$where['title'] = array('like','%'.$title.'%');
			$param['title'] = $title;
		}
		$where['uid'] = UID;
// 		if ($datetime){
// 			$param['datetime'] = $datetime;
// 			list($stime, $etime) = explode('~', $datetime);
// 			$where['created'][] = array('EGT', $stime." 00:00:00");
// 			$where['created'][] = array('ELT', $etime." 23:59:59");
// 		}
		$objlist = $objModel->getlist('*',$where,$order,$p,C('PAGE_OFFSET'));
		foreach ($objlist['list'] as $k => $v){
			$data['parentid'] = $v['id'];
			$objlist['list'][$k]['total'] = $baoliaoModel->getcounts($data);
			if ($v['img']) {
    			$sortimgid = M("picture")->find($v['img']);
    			$objlist['list'][$k]['imgpath']= $sortimgid["path"];
    		}
		}
		
		$page = $this->page($objlist['count'],$param);
		$show = $page->weishow();
		$this->assign('page',$show);
        $this->assign('p',$p);
        $this->assign('totalpage',$page->totalPages);
		$this->assign('title',$title);
		$this->assign('datetime',$datetime);
// 		$this->assign('order_by',$order_by);
// 		$this->assign('order_sc',$order_sc);
// 		$this->assign('perpage',$limit);
		$this->assign('count',$objlist['count']);
		$this->assign('list',$objlist['list']);
		$this->display('index');
	}
	
	/**
	 * 删除主体
	 */
	public function delobj(){
		if (!IS_AJAX) {
			$data['status'] = -1;
			$data['content'] = "请求非法";
		}else {
			$id = I('i');
			if (!$id) {
				$data['status'] = -1;
				$data['content'] = "参数有误";
			}else {
				$objModel = D('Baoliaoobj');
				$param['id'] = array('in',$id);
				$res = $objModel->delobj($param);
				if ($res) {
					$data['status'] = 1;
					$data['content'] = "删除成功";
				}else {
					$data['status'] = -1;
					$data['content'] = "删除失败";
				}
			}
		}
		$this->ajaxReturn($data);
	}
	
	/**
	 * 修改/添加主体
	 */
	public function saveobj(){
		$objModel = D('Baoliaoobj');
		if (IS_POST) {
			$id     = I('id',0,'intval');
			$msg    = $id ?'修改爆料主体':'增加爆料主体';
			$title  = I('title',false,'trim');
			$desc   = I('desc',false,'trim');
			$img    = I('img',false,'trim');
			$status = I('status',false,trim);
			if (!$title || !$desc || !$img) {
				$this->error('参数不完整,请填写完整');
			}
    		if (!$status) {
    			$status = 0;
    		}else {
    			$status = 1;
    		}
			$data = array(
					'title'  => $title,
					'desc'   => $desc,
					'img'    => $img,
					'status' => $status,
					'uid'    => UID
			);
			if ($id) {
				$where['id'] = $id;
			}
			$res = $objModel->saveobj($data,$where);
			if ($res) {
// 				if(C('IS_CACHE')){
// 					$this->Memcache->updateCache();//更新缓存
// 				}
				$this->ajaxReturn(array('status' => 1 , "info" =>$msg."成功"));
			}else {
				$this->ajaxReturn(array('status' => 0 , "info" =>$msg."失败"));
			}
			
		}else {
			$id = I('id',0,'intval');
			$pagetitle= $id ?'修改爆料主体':'增加爆料主体';
			if ($id) {
				$info = $objModel->getinfobyid($id);
				if ($info) {
	    			$sortimgid = M("picture")->find($info['img']);
	    			$info["path"]= $sortimgid["path"];
	    		}
				$this->assign('objinfo',$info);
			}
			$this->assign('uid',UID);
			$this->assign('title',$pagetitle);
			$this->display();
		}
	}
	
	/**
	 * 爆料列表
	 */
	public function baoliao () {
		$parentid = I('id',0,'intval');
		if (!$parentid) {
			$this->redirect('index');
// 			$this->error('参数错误');
		}else {
			$where['parentid'] = array('eq',$parentid);
			$param['id'] = $parentid;
		}
		$p  = I('p',1,'intval');
		$title = I('title',false);
// 		$order_by = I('order_by','created');
// 		$order_sc = I('order_sc','desc');
// 		$limit = I('perpage',C('PAGE_SIZE'),'intval');
		$datetime = I('datetime');
// 		$objModel = D('Baoliaoobj');
		$baoliaoModel = D('Baoliao');
// 		$order = $order_by.' '.$order_sc;
// 		$param['order_by'] = $order_by;
// 		$param['order_sc'] = $order_sc;
		$order = 'ctime desc';
		if ($title) {
			$where['title'] = array('like','%'.$title.'%');
			$param['title'] = $title;
		}
// 		if ($datetime){
// 			$param['datetime'] = $datetime;
// 			list($stime, $etime) = explode('~', $datetime);
// 			$where['ctime'][] = array('EGT', $stime." 00:00:00");
// 			$where['ctime'][] = array('ELT', $etime." 23:59:59");
// 		}
		$baoliao = $baoliaoModel->getlist('*',$where,$order,$p,C('PAGE_OFFSET'));
// 		print_r($baoliao);exit;
		$page = $this->page($baoliao['count'],$param);
		$show = $page->weishow();
		$this->assign('page',$show);
		$this->assign('p',$p);
		$this->assign('totalpage',$page->totalPages);
		$this->assign('title',$title);
		$this->assign('datetime',$datetime);
// 		$this->assign('order_by',$order_by);
// 		$this->assign('order_sc',$order_sc);
// 		$this->assign('perpage',$limit);
		$this->assign('count',$baoliao['count']);
		$this->assign('list',$baoliao['list']);
		$this->display('baoliao');
	}
	
	/**
	 * 删除爆料
	 */
	public function delbaoliao(){
		if (!IS_AJAX) {
			$data['status'] = -1;
			$data['content'] = "请求非法";
		}else {
			$id = I('i');
			if (!$id) {
				$data['status']  = -1;
				$data['content'] = "参数有误";
			}else {
				$baoliaoModel = D('Baoliao');
				$param['id'] = array('in',$id);
				$res = $baoliaoModel->delbaoliao($param);
				if ($res) {
					$data['status']  = 1;
					$data['content'] = "删除成功";
				}else {
					$data['status']  = -1;
					$data['content'] = "删除失败";
				}
			}
		}
		$this->ajaxReturn($data);
	}
	
	
}