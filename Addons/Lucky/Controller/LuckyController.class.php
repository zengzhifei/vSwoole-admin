<?php

namespace Addons\Lucky\Controller;
use Home\Controller\AddonsController;
use Think\Page;

class LuckyController extends AddonsController
{
	
	public function __construct()
	{
		parent::__construct();
		
		$this->CheckAdminLogin();
        $userinfo = session('user');
        $this->userId = $userinfo['userid'];
        $this->assign('uid',$userinfo['userid']);
	}
	
	public function index()
	{
		$LuckyModel = D('Addons://Lucky/Lucky');
		
		$lucky_title = I('lucky_title',false);
		$p    = I('p',1);
        if($lucky_title){
            $parameter['lucky_title'] = $lucky_title;
            $this->assign('lucky_title',$lucky_title);
        }
        $count     = $LuckyModel->getLuckyCount($lucky_title,$this->userId);
		$Page      = $this->page($count,$parameter);
		$pageList      = $Page->weishow();
		$data_list  = $LuckyModel->getLuckylist($lucky_title,$this->userId,$p,$Page->firstRow,$Page->listRows);
		$this->assign("p",$p);
		$nowtime = strtotime(date("Y/m/d"));
		$this->assign("totalpage",$Page->totalPages);
		$this->assign('page', $pageList);
		$this->assign('list', $data_list);
		$this->assign('nowtime', $nowtime);
		$this->display("index");
	}
	
	public function modify()
	{
		$lucky_id = I('lucky_id',0,'intval');
		$LuckyModel = D('Addons://Lucky/Lucky');
		if (IS_POST){
			$data = array();
			$data['lucky_title'] = I('lucky_title');
			$data['lucky_rules'] = I('lucky_rules');
			$data['wining_remark'] = I('wining_remark');
			$data['award_remark'] = I('award_remark');
			$data['start_time'] = strtotime(I('start_time'));
			$data['end_time'] = strtotime(I('end_time'));
			$data['ep_lucky_number'] = I('ep_lucky_number');
			$data['lucky_number'] = I('lucky_number');
			$data['background'] = I('picurl');
			$data['repeat_note'] = I('repeat_note');
			$data['end_topic'] = I('end_topic');
			$data['end_remark'] = I('end_remark');
			$data['is_repeat'] = I('is_repeat');
			$data['uid'] = I('uid');
			if ($lucky_id){
				$data['id'] = $lucky_id;
			}
			$ret = $LuckyModel->setter($data, $lucky_id);
			if ($ret === false){
				$data = array('status'=>-1,'info'=>'提交失败');
			}else{
			    $data = array('status'=>1,'info'=>'提交成功');
			}
			$this->ajaxReturn($data);
		}else{
			if ($lucky_id){
			    $luckyinfo  = $LuckyModel->getLuckyInfoById($lucky_id);
			    $where['id'] = $luckyinfo['background'];
			    $imgurl = $this->getImageinfo($where);
    			if(!empty($imgurl[0]['path'])){
                    $imgurl[0]['path'] = C('BASE_URL').__ROOT__.$imgurl[0]['path'];
                }else{
                    $imgurl[0]['path'] = $imgurl[0]['url'];
                }
				$data = $LuckyModel->getter($lucky_id);
				$this->assign('data', $data);
				$this->assign('luckyimginfo',$imgurl[0]);
			}
		}
		$this->display();
	}
	/**
	 * 删除抽奖
	 */
	public function del()
	{
		$id = I('id',0,'intval');
        if($id){
            $luckyModel = D( 'Addons://Lucky/Lucky' );
            $result = $luckyModel->delete($id);
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
     * 批量删除抽奖
     */
    public function deleteDraws(){
        $id = I('id',false);
        if($id){
            $luckyModel = D( 'Addons://Lucky/Lucky' );
            $result = $luckyModel->deleteDraw($id);
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
	 * 活动开始
	 */
	public function updateStart()
	{
		$id = I('id',0,'intval');
		$start_time = I('start_time', 0);
        if($id){
            $luckyModel = D( 'Addons://Lucky/Lucky' );
            $result = $luckyModel->updateStarttime($id,$start_time);
            if($result){
                $data=array('status'=>1,'info'=>'修改成功');
            }else{
                $data=array('status'=>-1,'info'=>'修改失败');
            }
        }else{
            $data=array('status'=>-1,'info'=>'缺少活动ID');
        }
        $this->ajaxReturn($data);
	}
	/**
	 * 活动结束
	 */
	public function updateEnd()
	{
		$id = I('id',0,'intval');
		$end_time = I('end_time', 0);
        if($id){
            $luckyModel = D( 'Addons://Lucky/Lucky' );
            $result = $luckyModel->updateEndtime($id,$end_time);
            if($result){
                $data=array('status'=>1,'info'=>'修改成功');
            }else{
                $data=array('status'=>-1,'info'=>'修改失败');
            }
        }else{
            $data=array('status'=>-1,'info'=>'缺少活动ID');
        }
        $this->ajaxReturn($data);
	}

}
