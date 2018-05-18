<?php
namespace Api\Controller;
class BaoliaoController extends ApiBaseController{
	
	/**
	 * 添加爆料(入库)
	 */
	public function addbaoliao() {
// 		print_r(I('post.'));exit;
		$uid      = I('userid',false,'trim');
		$title    = I('title',false,'trim');
		$content  = I('content',false,'trim');
		$parentid = I('parentid',0,'intval');
		$ip       = I('ip',getIp(),'trim');
		$ctime    = I('ctime',time(),'trim');
		if(!$title || !$content || !$parentid){
			$datas = array('status'=>'-1','content'=>'参数不正确');
		}else {
			$data  = array(
				'title'    => $title,
				'content'  => $content,
				'userid'   => $uid,
				'ctime'    => $ctime,
				'ip'       => $ip,
				'parentid' => $parentid
			);
// 			var_dump($data);
			$addbaoliao = D('Baoliao');
			$res = $addbaoliao->savebaoliao($data);

			if($res){
				$datas = array('status'=>'1','content'=>'爆料发布成功');
			}else{
				$datas = array('status'=>'-1','content'=>'爆料失败');
			}
		}
		$this->ajaxReturn($datas);
	}
	
	/**
	 * 添加爆料(入队列)
	 */
	public function savebaoliao() {
		// 		print_r(I('post.'));exit;
		$uid      = I('userid',false,'trim');
		$title    = I('title',false,'trim');
		$content  = I('content',false,'trim');
		$parentid = I('parentid',0,'intval');
		$ip       = I('ip',getIp(),'trim');
		$ctime    = I('ctime',time(),'trim');
		if(!$title || !$content || !$parentid){
			$datas = array('status'=>'-1','content'=>'参数不正确');
		}else {
			$data  = array(
					'title'    => $title,
					'content'  => $content,
					'userid'   => $uid,
					'ctime'    => $ctime,
					'ip'       => $ip,
					'parentid' => $parentid
			);
			// 			var_dump($data);
			$queuename  = 'baoliao_queue';
// 			$addbaoliao = D('Baoliao');
			$res = sendToQueue($queuename,$data);
			
			if($res){
				$datas = array('status'=>'1','content'=>'爆料发布成功');
			}else{
				$datas = array('status'=>'-1','content'=>'爆料失败');
			}
		}
		$this->ajaxReturn($datas);
	}

	public function insertbaoliao()
	{
		$queuename  = 'baoliao_queue';
		$data = getFromQueue($queuename);
		if ($data) {
			$baoliaoModel = D('Baoliao');
			$res = $baoliaoModel->savebaoliao($data);
			if ($res) {
				return true;
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
	
	public function getobjlist(){
		$id = I('id',0,'trim');
		
	}
}