<?php
namespace Admin\Controller;
use User\Api\UserApi as UserApi;

class BonusController extends AdminController{

    public function _initialize(){
        $this->CheckAdminLogin();
        $userinfo = session('user');
        $this->userId =$userinfo['userid'];
        $this->assign('uid',$this->userId);
	}
	
	public function index()
	{
		$LuckyModel = D('Bonus');
		$lucky_title = I('bonus_title',false);
		$p    = I('p',1);
        if($lucky_title){
            $parameter['bonus_title'] = $lucky_title;
            $this->assign('bonus_title',$lucky_title);
        }
        $count     = $LuckyModel->getLuckyCount($lucky_title,$this->userId);
		$Page      = $this->page($count,$parameter);
		$pageList      = $Page->weishow();
		$data_list  = $LuckyModel->getLuckylist($lucky_title,$this->userId,$p,$Page->firstRow,$Page->listRows);
		$logModel = D('Bonuslog');
		foreach ($data_list as $k=>$v){
		    $data_list[$k]['partakepeople'] = $logModel->getLuckyDrawCount(array("bonus_id"=>$v["id"]));
		    $data_list[$k]['prizepeople'] = $logModel->getLuckyDrawCount(array("bonus_id"=>$v["id"] , "is_lottery"=>1));
		}
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
		$lucky_id = I('bonus_id',0,'intval');
		$LuckyModel = D('Bonus');
		if (IS_POST){
			$data = array();
			$data['bonus_title'] = I('bonus_title');
			$data['bonus_rules'] = I('bonus_rules');
			$data['wining_remark'] = I('wining_remark');
			$data['award_remark'] = I('award_remark');
			$data['start_time'] = strtotime(I('start_time'));
			$data['end_time'] = strtotime(I('end_time'));
			$data['bonus_type']= 1;
			$data['ep_bonus_number'] = I('ep_bonus_number');
			$data['bonus_number'] = I('bonus_number');
			$data['background'] = I('picurl');
			$data['repeat_note'] = I('repeat_note');
			$data['end_topic'] = I('end_topic');
			$data['end_remark'] = I('end_remark');
			$data['involvement_num'] = 1000;
			$data['lottery_num'] = 1000;
			$data['is_show'] = 0;
			$data['created'] = time();
			$data['updated'] = time();
			$data['ip'] = time();
			$data['is_repeat'] = I('is_repeat');
			$data['uid'] = I('uid');
			$data['timelong'] = I('timelong');
			$data['bonussum'] = I('bonussum')*100;
			$data['bonusover'] = I('bonussum')*100;
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
            $luckyModel = D('Bonus');
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
            $luckyModel = D('Bonus');
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
            $luckyModel = D('Bonus');
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
            $luckyModel = D('Bonus');
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
	
	
	/**
	 * 修改抢红包活动状态
	 */
	public function bonusstart(){
	    $id = I('id',0,'intval');
		$is_show = I('is_show', 0,'intval');
		if($id){
            $luckyModel = D('Bonus');
            $result = $luckyModel->changebonus($id,array("is_show"=>$is_show , 'ip'=>time()));
            if($result){
                $data=array('status'=>1,'info'=>'修改成功');
            }else{
                $data=array('status'=>0,'info'=>'修改失败');
            }
        }else{
            $data=array('status'=>0,'info'=>'修改失败');
        }
        $this->ajaxReturn($data);
	}
	
	/**
	 * 统计信息
	 */
	public function tongji(){
		$BonusModel = D('Bonus');
		$bonuslist = $BonusModel->getdata();
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$BonusModel = D('Bonus');
		$bonuslist = $BonusModel->getdata();
		$BonusPrizerizeModel = D('Bonusprize');
		//$prizelist = $BonusPrizerizeModel->getdata();
		$BonusLogModel = D('Bonuslog');
		//$loglist = $BonusLogModel->getdata();
		$this->display();
	}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//End Class
}
