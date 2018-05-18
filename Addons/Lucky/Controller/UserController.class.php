<?php
namespace Addons\Lucky\Controller;;
use Home\Controller\AddonsController;
use Think\Page;

class UserController extends AddonsController
{
    
    public function __construct()
	{
		parent::__construct();
		
		$this->CheckAdminLogin();
        $userinfo = session('user');
        $this->userId = $userinfo['userid'];
        $this->assign('uid',$userinfo['userid']);
	}
    /**
     * 抽奖参与者列表
     */
    public function index(){
        $luck_id = I('lucky_id',0,'intval');
        
        $luckyUserModel = D('Addons://Lucky/LuckyUser');
        $luckyLogModel = D('Addons://Lucky/LuckyLog');
        $luckyPrizeModel = D('Addons://Lucky/LuckyPrize');
        $where = array();
        $parameter=array();
        $where['luck_id'] = $luck_id;
        $parameter['lucky_id'] = $luck_id;
        $parameter[''] = "m/Home";
		$p    = I('p',1,'intval');
		$order = 'luck_id DESC';
		$count     = $luckyUserModel->where($where)->count();
		$Page      = $this->page($count,$parameter);
		$pageList      = $Page->weishow();
		$select_tab = $luckyPrizeModel->getprizeinfo($luck_id);
		$list      = $luckyUserModel->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
		//获取用户当天抽奖次数
		if ($list){
		    foreach ($list as $key => $value){
		        $list[$key]['ep_num'] = $luckyLogModel->getLuckyDrawCount(array('luck_id' => $luck_id, 'uid' => $value['uid'], 'created_date' => date('Y-m-d')));
		    }
		}
		$this->assign('page', $pageList);
		$this->assign("p",$p);
		$this->assign("totalpage",$Page->totalPages);
		$this->assign('luck_id', $luck_id);
		$this->assign('select_tab', $select_tab);
		$this->assign('list', $list);
		$this->display();
    }
    
    /**
     * 删除参与抽奖用户
     */
    public function deleteLuckyUser(){
       $uid = I('uid',false);
        if($uid ){
            $luckyUserModel = D( 'Addons://Lucky/LuckyUser' );
            $result = $luckyUserModel->deleteLuckyUser($uid);
            if($result){
                $data=array('status'=>1,'info'=>'删除成功');
            }else{
                $data=array('status'=>-1,'info'=>'删除失败');
            }
        }else{
            $data=array('status'=>-1,'info'=>'缺少抽奖活动ID');
        }
        $this->ajaxReturn($data);
        
    }
	/**
     * 禁止/解禁用户参与抽奖
     */
    public function upUserStatus(){
       $uid = I('uid',false);
       $luck_id = I('luck_id',0);
       $del_flag = I('del_flag',0);
        if($uid){
            $luckyUserModel = D( 'Addons://Lucky/LuckyUser');
            $result = $luckyUserModel->updateUserStatus($uid,$del_flag,$luck_id);
            if($result){
                $data=array('status'=>1,'info'=>'操作成功');
            }else{
                $data=array('status'=>-1,'info'=>'操作失败');
            }
        }else{
            $data=array('status'=>-1,'info'=>'缺少用户ID');
        }
        $this->ajaxReturn($data);
        
    }
    
}