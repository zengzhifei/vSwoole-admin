<?php
namespace Admin\Controller;
use User\Api\UserApi as UserApi;

class BonuslogController extends AdminController
{
    
    public function _initialize(){
        $this->CheckAdminLogin();
        $userinfo = session('user');
        $this->userId =$userinfo['userid'];
        $this->assign('uid',$this->userId);
	}
    /**
     * 中奖列表
     */
    public function index(){
        $bonus_id = I('bonus_id',0,'intval');
        $id = I('id',0,'intval');
        $p    = I('p',1);
        $luckyLogModel = D('Bonuslog');
        $luckyPrizeModel = D('Bonusprize');
        $where = array();
        $parameter=array();
		$where['bonus_id'] = $bonus_id;
		$parameter['bonus_id'] = $bonus_id;
		//$parameter[''] = "m/Home";
		$order = "bonus_id DESC";
		$count     = $luckyLogModel->where($where)->count();
		$Page      = $this->page($count,$parameter);
		$pageList      = $Page->weishow();
		$select_tab = $luckyPrizeModel->getprizeinfo($bonus_id);
		$data_list      = $luckyLogModel->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($data_list as $k => $v){
	        $prizename = $luckyPrizeModel->getPrizeName($v['lottery_id']);
	        if ($prizename){
	            $data_list[$k]['name'] = $prizename['title'] . '-' . $prizename['name'];
	        }
		}
		$this->assign('bonus_id', $bonus_id);
		$this->assign("p",$p);
		$this->assign("totalpage",$Page->totalPages);
		$this->assign("page",$pageList);
		$this->assign('list', $data_list);
		$this->assign('select_tab', $select_tab);
		$this->display('Bonus/logindex');
    }
 	/**
     * 删除中奖用户
     */
    public function deletebonuswinner(){
       $uid = I('uid',false);
        if($uid){
            $luckyLogModel = D( 'Bonuslog');
            $result = $luckyLogModel->deleteWinner($uid);
            if($result){
                $data=array('status'=>1,'info'=>'删除成功');
            }else{
                $data=array('status'=>-1,'info'=>'删除失败');
            }
        }else{
            $data=array('status'=>-1,'info'=>'缺少用户ID');
        }
        $this->ajaxReturn($data);
        
    }
	/**
     * 发奖
     */
    public function awardPrize(){
       $uid = I('uid',false);
       $bonus_id = I('bonus_id',0,'intval');
       $award_flag = I('award_flag',0,'intval');
        if($uid){
            $luckyLogModel = D( 'Bonuslog');
            $result = $luckyLogModel->updatPrize($uid,$award_flag,$bonus_id);
            if($result){
                $data=array('status'=>1,'info'=>'发奖成功');
            }else{
                $data=array('status'=>-1,'info'=>'发奖失败');
            }
        }else{
            $data=array('status'=>-1,'info'=>'缺少用户ID');
        }
        $this->ajaxReturn($data);
        
    }
    
    public function batchReSend(){
        $bonus_id = I("bonus_id");
        $model = D('Bonuslog');
        $where['bonus_id'] = $bonus_id;
        $where['award_flag'] = 0;
        $result = $model->where($where)->select();
        if($result){
            foreach($result as $k=>$v){
                $data['openId'] = $v['uid'];
                $data['amount'] = $v['bonus_money'];
                $httpstr = http(C('BONUS_URL'), $data, 'GET', array("Content-type: text/html; charset=utf-8"));
                if($httpstr == "success"){
                    $datas['award_flag'] = 1;
                    $wheres['uid'] = $v['uid'];
                    $model->where($where)->save($datas);
                }
                //print_r($httpstr);
                //调接口发红包
            }
            $data=array('status'=>1,'info'=>'批量重发成功');
        }else{
            $data=array('status'=>1,'info'=>'没有未发奖用户');
        }       
        $this->ajaxReturn($data);
    }
}