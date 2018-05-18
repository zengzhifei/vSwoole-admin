<?php

namespace Admin\Controller;
use Think\Page;

class LuckyController extends AdminController{

    public function _initialize(){
        $this->CheckAdminLogin();
        $userinfo = session('user');
        $this->userId = $userinfo['userid'];
	}
	
	public function index()
	{
		$LuckyModel = D('Lucky');
		
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
		$LuckyModel = D('Lucky');
		if (IS_POST){
			$data = array();
			$data['lucky_title'] = I('lucky_title');
			$data['lucky_rules'] = I('lucky_rules');
			$data['wining_remark'] = I('wining_remark');
			$data['award_remark'] = I('award_remark');
			$data['ep_lucky_number'] = I('ep_lucky_number');
			$data['lucky_number'] = I('lucky_number');
			$data['background'] = I('picurl');
			$data['repeat_note'] = I('repeat_note');
			$data['end_topic'] = I('end_topic');
			$data['end_remark'] = I('end_remark');
			$data['is_repeat'] = I('is_repeat');
			$data['uid'] = $this->userId;
			$dateRangePicker = I('dateRangePicker', false);
            if ($dateRangePicker){
                list($stime, $etime) = explode('-', $dateRangePicker);
                $data['start_time'] = strtotime($stime);
                $data['end_time'] = strtotime($etime);
            }
				
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
				$data['dateRangePicker'] = date("Y/m/d H:i",$data['start_time']).' - '.date("Y/m/d H:i",$data['end_time']);
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
            $luckyModel = D( 'Lucky' );
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
            $luckyModel = D( 'Lucky' );
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
	
	public function changeStatus(){
	    $state = I('state');
	    if($state == 0){
	        $data['is_show'] = 1;
	    }elseif ($state == 1){
	        $data['is_show'] = 0;
	    }
	    $id = I('id',0,'intval');
	    if($id){
	        $luckyModel = D( 'Lucky' );
	        $where['id'] = $id;
	        //$result = $luckyModel->setter($data,$id);
	        $result = $luckyModel->changeLuckyStatus($where,$data);
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
	 * 抽奖参与者列表
	 */
	public function userList(){
	    $luck_id = I('lucky_id',0,'intval');
	
	    $luckyUserModel = D('LuckyUser');
	    $luckyLogModel = D('LuckyLog');
	    $luckyPrizeModel = D('LuckyPrize');
	    $where = array();
	    $parameter=array();
	    $where['luck_id'] = $luck_id;
	    $parameter['lucky_id'] = $luck_id;
	    //$parameter[''] = "m/Home";
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
	        $luckyUserModel = D( 'LuckyUser' );
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
	        $luckyUserModel = D( 'LuckyUser');
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
	
	/**
	 * 奖项管理
	 */
	public function prizeModify()
	{
	    $lucky_id = I('lucky_id', 0, 'int');
	    $LuckyPrizeModel = D('LuckyPrize');
	    if ($lucky_id <= 0){
	        $this->error("非法访问！");
	    }
	    $this->assign('lucky_id', $lucky_id);
	    if (IS_POST){
	        unset($_POST['lucky_id']);
	        if ($_POST){
	            if ($_POST['id']){
	                $prizes_tmp = $LuckyPrizeModel->getter($lucky_id, 0, 1000);
	                if ($prizes_tmp){
	                    $ids = array();
	                    foreach ($prizes_tmp as $_v){
	                        $ids[] = $_v['id'];
	                    }
	                    $diff_ids = array_diff($ids, $_POST['id']);
	                    if ($diff_ids){
	                        $diff_ids = $diff_ids ? array_filter($diff_ids) : array();
	                        $LuckyPrizeModel->delete(implode(',', $diff_ids));
	                    }
	                }
	            }
	            $data = array();
	            foreach ($_POST as $_key => $_value){
	                foreach ($_value as $_k => $_v){
	                    $data[$_k][$_key] = $_v;
	                    $data[$_k]['sort'] = $_k+1;
	                    $data[$_k]['luck_id'] = $lucky_id;
	                }
	            }
	            foreach ($data as $_key => $_value){//修改数据库后补救操作:totalnum字段为设置的总数、num字段为目前剩余的数量
	                $data[$_key]["totalnum"] = $_value["num"];
	            }
	            foreach ($data as $_key => $_value){
	                if (!$_value['name']){
	                    continue;
	                }
	                if ($_value['id']){
	                    $LuckyPrizeModel->setter($_value, $_value['id']);
	                }else{
	                    $LuckyPrizeModel->setter($_value);
	                }
	            }
	        }
	        $data = array('status'=>1,'info'=>'提交成功');
	        $this->ajaxReturn($data);
	        //$this->success('提交成功！', addons_url("Lucky://Lucky/index"));
	        //exit;
	    }
	    $prizes = $LuckyPrizeModel->getter($lucky_id, 0, 1000);
	    $this->assign('prizes', $prizes);
	    $this->display();
	}
	
	/**
	 * 中奖列表
	 */
	public function luckyLog(){
	    $luck_id = I('lucky_id',0,'intval');
	    $id = I('id',0,'intval');
	    $p    = I('p',1);
	    $luckyLogModel = D('LuckyLog');
	    $luckyPrizeModel = D('LuckyPrize');
	    $where = array();
	    $parameter=array();
	    $where['luck_id'] = $luck_id;
	    $where['is_lottery'] = 1;
	    $parameter['lucky_id'] = $luck_id;
	    //$parameter[''] = "m/Home";
	    $order = "luck_id DESC";
	    $count     = $luckyLogModel->where($where)->count();
	    $Page      = $this->page($count,$parameter);
        $show      = $Page->weishow();
	    $select_tab = $luckyPrizeModel->getprizeinfo($luck_id);
	    $data_list      = $luckyLogModel->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
	    foreach ($data_list as $k => $v){
	        $prizename = $luckyPrizeModel->getPrizeName($v['lottery_id']);
	        if ($prizename){
	            $data_list[$k]['name'] = $prizename['title'] . '-' . $prizename['name'];
	        }
	    }
	    $this->assign('luck_id', $luck_id);
	    $this->assign('list', $data_list);
	    $this->assign('select_tab', $select_tab);
	    $this->assign("p",$p);
	    $this->assign("totalpage",$Page->totalPages);
	    $this->assign("page",$show);
	    $this->display();
	}
	/**
	 * 删除中奖用户
	 */
	public function deleteLuckyWinner(){
	    $uid = I('uid',false);
	    if($uid){
	        $luckyLogModel = D( 'LuckyLog');
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
	    $award_flag = I('award_flag',0,'intval');
	    $id = I('id','intval');
	    $luckyLogModel = D( 'LuckyLog');
	    $where['id'] = $id;
	    $data['award_flag'] = $award_flag;
	    $result = $luckyLogModel->updateluckyinfo($where,$data);
	    if($result){
	        $data=array('status'=>1,'info'=>'发奖成功');
	    }else{
	        $data=array('status'=>-1,'info'=>'发奖失败');
	    }
	    
	    $this->ajaxReturn($data);
	
	}
	
	/**
	 * 奖品列表
	 */
	public function luckyPrize()
	{
	    $luck_id = I('lucky_id',0,'intval');
	    $p    = I('p',1);
	    $prizeModel = D('LuckyPrize');
	    $where = array();
	    $parameter=array();
	    $where['luck_id'] = $luck_id;
	    $parameter['luck_id'] = $luck_id;
	    $count     = $prizeModel->where($where)->count();
	    $Page      = $this->page($count,$parameter);
	
	    $pageList      = $Page->weishow();
	
	    $data_list      = $prizeModel->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
	    foreach ($data_list as $k => $v){
	        $data_list[$k]['remain_num'] = $v['num'] - $v['lottery_num'];
	    }
	    $this->assign('luck_id', $luck_id);
	    $this->assign("p",$p);
	    $this->assign("totalpage",$Page->totalPages);
	    $this->assign('page', $pageList);
	    $this->assign('list', $data_list);
	    $this->display();
	}
	
	/**
	 * 中奖统计
	 */
	public function statisticsprize()
	{
	    $luck_id = I('lucky_id',0,'intval');
	    $p    = I('p',1);
	    $prizeModel = D('Addons://Lucky/LuckyPrize');
	    $luckyUserModel = D('Addons://Lucky/LuckyUser');
	    $where = array();
	    $parameter=array();
	    $where['luck_id'] = $luck_id;
	    $parameter['luck_id'] = $luck_id;
	    $count     = $prizeModel->where($where)->count();
	    $sum     = $luckyUserModel->where($where)->count();//参与人数
	    $Page      = $this->page($count,$parameter);
	
	    $pageList      = $Page->weishow();
	
	    $data_list      = $prizeModel->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
	    foreach ($data_list as $k => $v){
	        $data_list[$k]['proportion'] = $v['lottery_num']/$sum*100;
	    }
	    $this->assign('luck_id', $luck_id);
	    $this->assign("p",$p);
	    $this->assign("totalpage",$Page->totalPages);
	    $this->assign('sum', $sum);
	    $this->assign('page', $pageList);
	    $this->assign('list', $data_list);
	    $this->display();
	}
	
	/*
	 * 导出中奖数据
	*/
	public function exportLucky(){
	    $luck_id = I('lucky_id',false);
	    if($luck_id){
	        $p    = I('p',1);
	        $luckyLogModel = D('LuckyLog');
	        $luckyPrizeModel = D('LuckyPrize');
	        $where = array();
	        $parameter=array();
	        $where['luck_id'] = $luck_id;
	        $where['is_lottery'] = 1;
	        $parameter['lucky_id'] = $luck_id;
	        $order = "luck_id DESC";
	        $count     = $luckyLogModel->where($where)->count();
	        $Page      = $this->page($count,$parameter);
	        $show      = $Page->weishow();
	        $select_tab = $luckyPrizeModel->getprizeinfo($luck_id);
	        $data_list      = $luckyLogModel->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
	        $luck_info = M("Lucky")->where("id = $luck_id")->find();
	        foreach ($data_list as $k => $v){
	            $prizename = $luckyPrizeModel->getPrizeName($v['lottery_id']);
	            if ($prizename){
	                $data_list[$k]['name'] = $prizename['title'] . '-' . $prizename['name'];
	            }
	            if($v["award_flag"] == 0){
	                $is_give = "未发";
	            }else{
	                $is_give = "已发";
	            }
	            $str .= $v['id'].",".$v['uname'].",".$data_list[$k]['name'].",".$v['prize_code'].",".$is_give."\n";
	        }
	        
	    }else{
	        $str = "暂无数据";
	    }
	    
	    $data = mb_convert_encoding($str,"gb2312","UTF-8");
	    $title = "编号, 昵称, 奖项, 中奖码, 是否发放\n";
	    $filename = $luck_info["lucky_title"]."_".$p."页_".date('Ymd',$luck_info['created']).".csv";
	    $this->export_csv($title,$filename,$data);
	}

}
