<?php
namespace Addons\Lucky\Controller;;
use Home\Controller\AddonsController;
use Think\Page;

class LogController extends AddonsController
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
     * 中奖列表
     */
    public function index(){
        $luck_id = I('lucky_id',0,'intval');
        $id = I('id',0,'intval');
        $p    = I('p',1);
        $luckyLogModel = D('Addons://Lucky/LuckyLog');
        $luckyPrizeModel = D('Addons://Lucky/LuckyPrize');
        $where = array();
        $parameter=array();
		$where['luck_id'] = $luck_id;
		$parameter['lucky_id'] = $luck_id;
		 $parameter[''] = "m/Home";
		$order = "luck_id DESC";
		$count     = $luckyLogModel->where($where)->count();
		$Page      = $this->page($count,$parameter);
		$pageList      = $Page->weishow();
		$select_tab = $luckyPrizeModel->getprizeinfo($luck_id);
		$data_list      = $luckyLogModel->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($data_list as $k => $v){
	        $prizename = $luckyPrizeModel->getPrizeName($v['lottery_id']);
	        if ($prizename){
	            $data_list[$k]['name'] = $prizename['title'] . '-' . $prizename['name'];
	        }
		}
		$this->assign('luck_id', $luck_id);
		$this->assign("p",$p);
		$this->assign("totalpage",$Page->totalPages);
		$this->assign("page",$pageList);
		$this->assign('list', $data_list);
		$this->assign('select_tab', $select_tab);
		$this->display();
    }
 	/**
     * 删除中奖用户
     */
    public function deleteLuckyWinner(){
       $uid = I('uid',false);
        if($uid){
            $luckyLogModel = D( 'Addons://Lucky/LuckyLog');
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
       $luck_id = I('luck_id',0,'intval');
       $award_flag = I('award_flag',0,'intval');
        if($uid){
            $luckyLogModel = D( 'Addons://Lucky/LuckyLog');
            $result = $luckyLogModel->updatPrize($uid,$award_flag,$luck_id);
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
}