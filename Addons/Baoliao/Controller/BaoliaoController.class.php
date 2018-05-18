<?php

namespace Addons\Baoliao\Controller;
use Home\Controller\AddonsController;
class BaoliaoController extends AddonsController{
	
	public $userId;
	
	public function _initialize(){
        parent::_initialize();
        $this->checkUserLogin();
        $userinfo = session('user');
        $this->userId = is_login();
    }
	
	/**
	 * 展示爆料主体
	 */
	public function index() {
		$model = M('Baoliaoobj');
		$where['status'] = 1;
		$list = $model->where($where)->order('ctime desc')->select();
		foreach ($list as $k => $v){
    		$sortimgid = M("picture")->find($v['img']);
    		$list[$k]['imgpath']= __ROOT__.$sortimgid["path"];
    		$list[$k]['url'] = addons_url('Baoliao://Baoliao/baoliao',array('id'=>$v['id']));
		}
		$this->assign('list',$list);
		$this->display();
	}
	
	/**
	 * 添加爆料方法
	 */
	public function baoliao() {
		if (IS_POST) {
// 			echo $this->userId;
// 			var_dump(I('post.'));exit;
			$param['title']    = I('title',false,'trim');
			$param['content']  = I('content',false,'trim');
			$param['parentid'] = I('id',0,'trim');
			$param['ctime']    = time();
			$param['userid']   = $this->userId;
			$param['ip']       = $this->getIp();
			if ($param['content']) {
				$res = sendCurlRequest(U('Api/Baoliao/addbaoliao'), $param, 'post');
				$res = json_decode($res,true);
			}else {
				$this->error('message can not be empty');
			}
			if ($res['status'] == '1') {
				$this->success('爆料提交成功，谢谢参与','index');
			}else {
				$this->error('爆料提交失败');
			}
		}else {
			$id = I('id',0,'trim');
			$this->assign('id',$id);
			$this->display();
		}
	}
	
	//获取客户端真实IP
	function getIp() {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
		else
		if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else
		if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		else
		if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = "unknown";
		return $ip;
	}
}
