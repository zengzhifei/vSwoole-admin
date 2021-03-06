<?php
namespace Addons\Lucky\Controller;
use Home\Controller\AddonsController;

class PrizeController extends AddonsController
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
     * 奖品列表
     */
    public function index()
	{
	    $luck_id = I('lucky_id',0,'intval');
	    $p    = I('p',1);
		$prizeModel = D('Addons://Lucky/LuckyPrize');
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
     * 奖项管理
     */
    public function modify()
	{
	    $lucky_id = I('lucky_id', 0, 'int');
		$LuckyPrizeModel = D('Addons://Lucky/LuckyPrize');
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
		$this->display("modify");
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
}