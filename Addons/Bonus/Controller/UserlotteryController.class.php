<?php

namespace Addons\Bonus\Controller;
use Home\Controller\AddonsController;
use Think\Log;
use Think\Page;

class UserlotteryController extends AddonsController
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * 抽奖概率程序
	 * @param $data  各个奖项概率信息
	 */
	function getReward($data,$total=100){
	    if(empty($data))
	        return false;
	    $win = array();
	    $wininfo = array();
	    foreach ($data as $k=>$v){
	        if($v["num"]){//只对有库存的奖品进行抽奖
	            $win[] = floor(($v["chance"]*$total)/100);
	            $wininfo[$k]["total"] = floor(($v["chance"]*$total)/100);
	            $wininfo[$k]["title"] = $v["title"];
	        }
	    }
	    $other = $total-array_sum($win);
	    $return = array();
	    foreach ($wininfo as $k=>$v){
	        for($i = 0 ; $i < $v["total"] ; $i++){
	            $return[] = $v["title"];
	        }
	    }
	    for ($n=0;$n<$other;$n++){
            $return[] = false;
        }
        shuffle($return);
	    return  array_search($return[array_rand($return)], array("0","一等奖","二等奖","三等奖","四等奖","五等奖","六等奖"));
    }
    
    /**
     * 抽奖验证方法
     * @param  uid用户ID luck_id活动
     * 1开始时间
     * 2结束时间
     * 3每天抽奖次数
     * 4活动最多抽奖次数
     * 5是否已经中奖
     */
    public function checklucky($userid , $luck_id){
        $LuckyModel = D('Addons://Lucky/Lucky');
	    $luckyinfo = $LuckyModel->getter($luck_id);
        if( time() < $luckyinfo["start_time"]){//判断抽奖时间是否符合活动时间
            $data['error'] ='starttimeerror';
            $data['info'] = "活动暂未开始" ;
        	$data['success'] =0 ;
        	$data['prizetype'] =0;
        	return $data;exit();
        }
        if(time() > $luckyinfo["end_time"]    ){//判断抽奖时间是否符合活动时间
            $data['error'] ='endtimeerror';
            $data['info'] = $luckyinfo["end_remark"] ;
        	$data['success'] =0 ;
        	$data['prizetype'] =0;
        	return $data;exit();
        }
        if($luckyinfo["ep_lucky_number"]){//判断是否有每日抽奖次数限制、如果有的话查询是否达到限制
    	    $logModel = D('Addons://Lucky/LuckyLog');
    	    $userlotterycount = $logModel->getLuckyDrawCount(array("luck_id"=>$luck_id , "uid"=>$userid , "created_date"=>array("egt"=>strtotime("today")) , "created_date"=>array("egt"=>strtotime("today")+86400)));
    	    if($userlotterycount >= $luckyinfo["ep_lucky_number"]){
    	        $data['error'] ='invalid';
                $data['info'] = "您今日抽奖次数已达到上限";
            	$data['success'] =0 ;
            	$data['prizetype'] =0;
        	    return $data;exit();
    	    }
        }
        if($luckyinfo["lucky_number"]){//判断是否有活动总抽奖次数限制、如果有的话查询是否达到总抽奖次数
            $userModel = D('Addons://Lucky/LuckyUser');
    	    $userlotterysum = $userModel->getuserluckyinfo(array( "uid"=>$userid ,"luck_id"=>$luck_id ));
    	    if($userlotterysum["lucky_num"] >= $luckyinfo["lucky_number"]){
    	        $data['error'] ='sumplus';
                $data['info'] = "该活动您的总抽奖次数已达到上限";
            	$data['success'] =0 ;
            	$data['prizetype'] =0;
        	    return $data;exit();
    	    }
        }
        $userModel = D('Addons://Lucky/LuckyUser');
        $userlotterysum = $userModel->getuserluckyinfo($userid ,$luck_id );
        if($userlotterysum["lottery_num"]){
            $this->redirect("lotteryshow" , array("userid"=>$userid , "luck_id"=>$luck_id));
            $data['error'] ='getsn';
            $data['info'] = "你已经中奖,请勿重复抽奖";
        	$data['success'] =0 ;
        	$data['prizetype'] =0;
        	return $data;exit();
        }
        return false;
    }
	
	
	/**
	 * 前端调用抽奖方法
	 * @param  luck_id 活动ID
	 * @param  userid  用户ID
	 */
	public function lottery(){
	    $luck_id = I("param.luck_id");//获取抽奖活动ID
    	$LuckyModel = D('Addons://Lucky/Lucky');
	    $prizeModel = D('Addons://Lucky/LuckyPrize');
	    $luckyinfo = $LuckyModel->getter($luck_id);
	    $userid = session('user_auth.uid');//获取前端用户ID
        if(!$userid){
	        $this->checkUserLogin();
	    }
	    $prizeinfo = $prizeModel->getprizeinfo($luck_id);
	    foreach ($prizeinfo as $k=>$v){
	        $sumprize += $v["chance"];
	    }
	    if(IS_POST){
	        $data = $this->checklucky($userid, $luck_id);//验证是否有抽奖资格
	        if($data){
                $this->ajaxReturn($data);exit();
	        }
    	    $luckyresult = $this->getReward($prizeinfo);
    	    //抽奖之后对结果进行操作
    	    //抽中奖项:加入log表一条数据、更新或者加入user表一条数据、减去一个所中奖品库存数量
    	    //未抽中奖项:加入log表一条数据、更新或者加入user表一条数据
    	    $logModel = D('Addons://Lucky/LuckyLog');//抽奖后写入log表
    	    $userModel = D('Addons://Lucky/LuckyUser');//抽奖后写入user表
    	    if($luckyresult){//当抽中奖项的时候、查询所中奖项ID、减去库存
    	        $prizekey = array("0","一等奖","二等奖","三等奖","四等奖","五等奖","六等奖");
    	        $prizeid = $prizeModel->getprizeonce(array("luck_id" =>$luck_id , "title" => $prizekey[$luckyresult]));//获取所中奖项信息
    	    }
    	    $userdata["luck_id"] = $luck_id;
    	    $userdata["uid"] = $userid;
	        $userinfo = json_decode(sendCurlRequest(C('GETUSERINFO') . $userid) , TRUE);
    	    $userdata["uheadimg"] = $userinfo["data"][0]["image"]  ? $userinfo["data"][0]["image"] :  "";
    	    $userdata["uname"] = $userinfo["data"][0]["nickname"] ? $userinfo["data"][0]["nickname"] : "";
    	    $userdata["uaccount"] = $userinfo["data"][0]["memberName"];
    	    $userdata["lucky_num"] = 1;
    	    $userdata["lottery_num"] = $prizekey[$luckyresult] ? 1 : 0;
    	    $userdata["del_flag"] = 0;
    	    $userdata["created"] = time();
    	    $userdata["updated"] = time();
    	    
    	    
    	    $logdata["luck_id"] = $luck_id;
    	    $logdata["uid"] = $userid;
    	    $logdata["uheadimg"] = $userinfo["data"][0]["image"]  ? $userinfo["data"][0]["image"] :  "";
    	    $logdata["uname"] = $userinfo["data"][0]["nickname"] ? $userinfo["data"][0]["nickname"] : "";
    	    $logdata["uaccount"] = $userinfo["data"][0]["memberName"];
    	    $logdata["is_lottery"] = $prizekey[$luckyresult] ? 1 : 0;
    	    $logdata["lottery_id"] = $prizeid["id"] ? $prizeid["id"] : 0;
    	    $logdata["del_flag"] = 0;
    	    $logdata["tel"] = 0;
    	    $logdata["award_flag"] = 0;
    	    $logdata["created_date"] = time();
    	    $logdata["created"] = time();
    	    $logdata["updated"] = time();
    	    
    	    if($luckyresult){
    	        $prizeModel->startTrans();
    	        $userModel->startTrans();
    	        $logModel->startTrans();
    	        $prizeshiwu = $prizeModel->delprizenum(array("luck_id" =>$luck_id , "title" => $prizekey[$luckyresult]));//减去奖项库存
    	        $usershiwu = $userModel->luckuserdata($userdata);//更新或者加入user表一条数据
    	        $logshiwu = $logModel->addlog($logdata);//加入log表一条数据
    	        if($prizeshiwu && $usershiwu && $logshiwu){
        	        $prizeModel->commit();
        	        $userModel->commit();
        	        $logModel->commit();
    	            $data['error'] ='null'; 
        	        $data['success'] =  $luckyresult ? 1 : 0 ;
        	        $data['prizetype'] =  $luckyresult;
        	        $this->ajaxReturn($data);
    	        }else{
        	        $prizeModel->rollback();
        	        $userModel->rollback();
        	        $logModel->rollback();
    	            $data['error'] ='undefined'; 
        	        $data['success'] = 0 ;
        	        $data['prizetype'] = 0;
        	        $this->ajaxReturn($data);
    	        }
    	    }else{
    	        $userModel->startTrans();
    	        $logModel->startTrans();
    	        $usershiwu = $userModel->luckuserdata($userdata);//更新或者加入user表一条数据
    	        $logshiwu = $logModel->addlog($logdata);//加入log表一条数据
    	        if( $usershiwu && $logshiwu){
        	        $userModel->commit();
        	        $logModel->commit();
    	            $data['error'] ='null'; 
        	        $data['success'] =  $luckyresult ? 1 : 0 ;
        	        $data['prizetype'] =  $luckyresult;
        	        $this->ajaxReturn($data);
    	        }else{
        	        $userModel->rollback();
        	        $logModel->rollback();
    	            $data['error'] ='undefined'; 
        	        $data['success'] = 0 ;
        	        $data['prizetype'] = 0;
        	        $this->ajaxReturn($data);
    	        }
    	    }
	    }else{
	        $data = $this->checklucky($userid, $luck_id);//验证是否有抽奖资格
	        if($data)
	            $this->assign("checklucky" , $data["info"]);
	        else
	            $this->assign("checklucky" , false);
	        $this->assign('link', ONETHINK_ADDON_PATH . _ADDONS.'/View/lottery/lottery');
	        $this->assign("luckyinfo" , $luckyinfo);
	        $this->assign("prizeinfo" , $prizeinfo);
	        $this->assign("sumprize" , $sumprize);
	        $this->assign("luck_id" , $luck_id);
	        $templet = $luckyinfo ? "lottery" : "";
	        $this->display("lottery/".$templet."/lottery");
	    }
	}
	
	/**
	 * 用户中奖后、保存用户中奖手机号
	 */
	public function addluckytel(){
	    $luck_id = I("param.luck_id" , 1);//获取抽奖活动ID
	    $userid = cookie('memberId');//获取前端用户ID
	    $tel = I("param.tel");//获取提交过来的手机号码
	    $tel_reg = "/^[1][0-9]{10}$/";
	    preg_match_all("/^[1][0-9]{10}$/" , $tel , $telresult);
	    if( empty($telresult)){
	        $ret  = array('status' => false , "error" =>"参数错误");
	        $this->ajaxReturn($ret);
	    }
	    $logModel = D('Addons://Lucky/LuckyLog');
	    $addresult = $logModel->updateluckyinfo( array("luck_id" =>$luck_id  , "uid" => $userid , "is_lottery"=>  1 ) , array("tel" =>$tel , "updated"=>time() ) );
	    if($addresult){
	        $ret  = array('status' => true , "userid"=>$userid , "luck_id"=>$luck_id);
	    }else{
	        $ret  = array('status' => false , "error" =>"提交失败");
	    }
	    $this->ajaxReturn($ret);
	}
	
	/**
	 * 已经中奖跳转至中奖页面
	 */
	public function lotteryshow(){
	    $luck_id = I("param.luck_id");//获取抽奖活动ID
	    $logModel = D('Addons://Lucky/LuckyLog');
	    $LuckyModel = D('Addons://Lucky/Lucky');
	    $prizeModel = D('Addons://Lucky/LuckyPrize');
	    $luckyinfo  = $LuckyModel->getter($luck_id);//查询该活动详情
		$userid = session('user_auth.uid');//获取前端用户ID
        if(!$userid){
	        $this->checkUserLogin();
	    }
	    $lotteryinfo = $logModel->getlotteryinfo($userid , $luck_id);//查询用户该活动中奖的一条记录
	    $lotterycount = $logModel->getLuckyDrawCount(array("luck_id"=>$luck_id , "uid" => $userid));//查询用户该活动总共的抽奖次数
	    $prizeinfo = $prizeModel->getprizeinfo($luck_id);//查询该活动奖项详情
	    foreach ($prizeinfo as $k=>$v){
	        if($v["id"] == $lotteryinfo["lottery_id"]){
	            $this->assign("luckytitle" , $v["title"]);
	            $this->assign("luckyname" , $v["name"]);
	        }
	    }
	    $this->assign('link', ONETHINK_ADDON_PATH . _ADDONS.'/View/lottery/lottery');
	    $this->assign("luckyinfo" , $luckyinfo);
	    $this->assign("lotteryinfo" , $lotteryinfo);
	    $this->assign("lotterycount" , $lotterycount);
	    $this->assign("luck_id" , $luck_id);
	    $this->assign("prizeinfo" , $prizeinfo);
	    $this->display("lottery/lottery/lotteryshow");
	}
	
    /**
     * 抢红包的验证方法
     */
	public function checkbonus(){
	    $openId = I("param.userinfo",false);//获取用户信息
	    $bonusid = I("param.bonusid",false);//获取红包活动ID
	    if(!$openId){
	    	Log::write('bonus:'."openID为：".$openId[0]."的，不是场内观众",'WARN','',C('LOG_PATH').'feichangneilog'.date('y_m_d').'.log');
	        $data['info'] = "活动仅限于场内观众" ;
        	$data['success'] =0 ;
        	$this->ajaxReturn($data);
	    }
	    //$a = $openId;
	    //$openId = array($a);
		if(!$bonusid){
			Log::write('bonus:'."openID为：".$openId[0]."的，无活动ID",'WARN','',C('LOG_PATH').'wuIDlog'.date('y_m_d').'.log');
	        $data['info'] = "本轮活动已经结束" ;
        	$data['success'] =0 ;
        	$this->ajaxReturn($data);
	    }
	    $BonusModel = D('Addons://Bonus/Bonus');
	    $bonusinfo = $BonusModel->getter($bonusid);
		if(!$bonusinfo["is_show"]){//查询抢红包活动是否开始
			Log::write('bonus:'."openID为：".$openId[0]."的，活动暂未开始",'WARN','',C('LOG_PATH').'weikaishilog'.date('y_m_d').'.log');
            $data['info'] = "活动未开始,敬请期待" ;
        	$data['success'] =0 ;
        	$this->ajaxReturn($data);
        }
	    if( $bonusinfo["ip"] + $bonusinfo["timelong"] <  time() ){//查询是否在时效范围内
	    	Log::write('bonus:'."openID为：".$openId[0]."的，活动已经结束",'WARN','',C('LOG_PATH').'yijieshulog'.date('y_m_d').'.log');
            $data['info'] = "本轮活动已经结束" ;
        	$data['success'] =0 ;
        	$this->ajaxReturn($data);
        }
	    
	    $logModel = D('Addons://Bonus/Bonuslog');
	    $userlottery = $logModel->getlotteryinfo($openId[0] , $bonusid);
	    if($userlottery){//查询是否抢过红包
	        $data['info'] = "本轮已中奖" ;
        	$data['success'] =0 ;
        	$this->ajaxReturn($data);
	    }
        
        $prizeModel = D('Addons://Bonus/Bonusprize');
        $prizeinfo = $prizeModel->getprizeinfo($bonusid);
        foreach($prizeinfo as $k=>$v){
            if($v["num"] <= 0){
                unset($prizeinfo[$k]);
            }
        }
        if(!$prizeinfo){
        	Log::write('bonus:'."openID为：".$openId[0]."的，刚请求发现没有库存了",'WARN','',C('LOG_PATH').'NO1log'.date('y_m_d').'.log');
        	$data['info'] = "本轮红包已发完" ;
        	$data['success'] =0 ;
        	$this->ajaxReturn($data);
        }
        $randkey = array_rand($prizeinfo,1);
        $prizeflag = $prizeModel->delprizenum(array("id" =>$prizeinfo[$randkey]["id"]));//减去奖项库存,并返回操作后的库存值
	    if( $prizeflag < 0 ){//查询是否还有库存
	        //以下判断为三个奖项以内适用
		    $prizeinfo = $prizeModel->getprizeinfo($bonusid);
	        foreach($prizeinfo as $k=>$v){
	            if($v["num"] <= 0){
	                unset($prizeinfo[$k]);
	            }
	        }
	        if(!$prizeinfo){
		    	Log::write('bonus:'. "目前库存为".$prizeflag+1,'WARN','',C('LOG_PATH').'kucunbonuslog'.date('y_m_d').'.log');
		    	Log::write('bonus:'."openID为：".$openId[0]."的，没有库存了，第二步",'WARN','',C('LOG_PATH').'NO2log'.date('y_m_d').'.log');
	            $data['info'] = "本轮红包已发完" ;
	        	$data['success'] =0 ;
	        	$this->ajaxReturn($data);
	        }
	        $randkey = array_rand($prizeinfo,1);
        	$prizeflag = $prizeModel->delprizenum(array("id" =>$prizeinfo[$randkey]["id"]));//减去奖项库存,并返回操作后的库存值
		    if( $prizeflag < 0 ){//查询是否还有库存
			    $prizeinfo = $prizeModel->getprizeinfo($bonusid);
		        foreach($prizeinfo as $k=>$v){
		            if($v["num"] <= 0){
		                unset($prizeinfo[$k]);
		            }
		        }
		        if(!$prizeinfo){
			    	Log::write('bonus:'. "目前库存为".$prizeflag+1,'WARN','',C('LOG_PATH').'kucunbonuslog'.date('y_m_d').'.log');
			    	Log::write('bonus:'."openID为：".$openId[0]."的，没有库存了，第二步",'WARN','',C('LOG_PATH').'NO2log'.date('y_m_d').'.log');
		            $data['info'] = "本轮红包已发完" ;
		        	$data['success'] =0 ;
		        	$this->ajaxReturn($data);
		        }
		        $randkey = array_rand($prizeinfo,1);
        		$prizeflag = $prizeModel->delprizenum(array("id" =>$prizeinfo[$randkey]["id"]));//减去奖项库存,并返回操作后的库存值
        		if( $prizeflag < 0 ){//查询是否还有库存
			    	Log::write('bonus:'. "目前库存为".$prizeflag+1,'WARN','',C('LOG_PATH').'kucunbonuslog'.date('y_m_d').'.log');
			    	Log::write('bonus:'."openID为：".$openId[0]."的，没有库存了，第二步",'WARN','',C('LOG_PATH').'NO2log'.date('y_m_d').'.log');
		            $data['info'] = "本轮红包已发完" ;
		        	$data['success'] =0 ;
		        	$this->ajaxReturn($data);
        		}
	        }
        }
        $sumprize  = $prizeModel->getsumprize($bonusid);//查询还有多少库存
        $sumprize = $sumprize+1;
        //$givemoney = $logModel->givemoneysum($bonusid);//已经发出去的钱数
        $maxmoney = $bonusinfo["bonusover"];//目前剩余的钱数
        //$randkey = rand(0,count($prizeinfo)-1);//$prizeinfo[$randkey] 随机取出该活动的一条奖品来
        $moneyrand = $this->randmoney($maxmoney , $sumprize ,  $prizeinfo[$randkey]['min'] , $prizeinfo[$randkey]['max']);//生成红包金额
        //$bonusoverflag = $BonusModel->bonusover($bonusid , $moneyrand);//红包剩余钱数减去刚刚抽中的金额,并返回目前剩余金额
        $bonusoverflag = $BonusModel->bonusover($bonusid , $sumprize ,  $prizeinfo[$randkey]['min'] , $prizeinfo[$randkey]['max']);//红包剩余钱数减去刚刚抽中的金额,并返回目前剩余金额
        Log::write('bonus:'."余额1--:".$maxmoney."余额1**".$bonusoverflag[0]."红包钱：".$bonusoverflag[1],'WARN','',C('LOG_PATH').'yuebonuslog'.date('y_m_d').'.log');
        if($bonusoverflag[0] + $bonusoverflag[1] < $bonusoverflag[1]){
        	Log::write('bonus:'."openID为：".$openId[0]."的，没有余额了,余额为:".$bonusoverflag[0] . "随机抽中的红包为：".$bonusoverflag[1],'WARN','',C('LOG_PATH').'NO33log'.date('y_m_d').'.log');
        	$data['info'] = "本轮红包已发完" ;
        	$data['success'] =0 ;
        	$this->ajaxReturn($data);
        }
        
        Log::write('bonus:'. "红包金额".$bonusoverflag[1]."目前余额".$bonusoverflag[0]."剩余红包数".$sumprize."最小值".$prizeinfo[$randkey]['min']."最大值". $prizeinfo[$randkey]['max'],'WARN','',C('LOG_PATH').'testbonuslog'.date('y_m_d').'.log');
        
        $bonusgive['openId'] = $openId[0];
        $bonusgive['amount'] = $bonusoverflag[1];
        $httpstr = http(C('BONUS_URL'), $bonusgive, 'GET', array("Content-type: text/html; charset=utf-8"));
		Log::write('givebonus:'."向".$bonusgive['openId']."发放".$bonusgive['amount']."分钱",'WARN','',C('LOG_PATH').'givebonuslog'.date('y_m_d').'.log');
		
		
        $logdata["bonus_id"] = $bonusid;
        $logdata["uid"] = $openId[0];
        $logdata["uheadimg"] = $openId[1] ? $openId[1] : "  " ;
        $logdata["uname"] = $openId[2] ? $openId[2] :  "  ";
        $logdata["uaccount"] = 'aaa';
        $logdata["is_lottery"] = 1;
        $logdata["lottery_id"] = $prizeinfo[$randkey]['id'];
        $logdata["del_flag"] = 0;
        $logdata["tel"] = '13111111111';
        if($httpstr == 'success'){
            $logdata["award_flag"] = 1;//是否发奖
        }else{
            $logdata["award_flag"] = 0;//是否发奖
        }
        $logdata["created_date"] = time();
        $logdata["created"] = time();
        $logdata["updated"] = time();
        //$logdata["action"] = 'add_bonus';
        $logdata["bonus_money"] = $bonusoverflag[1];
        $bonuslog = $logdata;
        $bonuslog["action"] = 'add_bonus';
        $pos = sendToQueue('bonus', $bonuslog);
        Log::write('bonus:'.$pos,'WARN','',C('LOG_PATH').'bonuslog'.date('y_m_d').'.log');
        if($pos){
            //$prizeflag = $prizeModel->delprizenum(array("id" =>$prizeinfo[$randkey]["id"]));//减去奖项库存
            $data['success'] =  1;
	        $data['info'] = "恭喜抢到红包" ;
	        $data['number'] = ($bonusoverflag[1]/100)."元" ;
	        $this->ajaxReturn($data);
        }else{
            $logflag = $logModel->addlog($logdata);//log表记录
            //$prizeflag = $prizeModel->delprizenum(array("id" =>$prizeinfo[$randkey]["id"]));//减去奖项库存
	        $data['success'] =  1;
	        $data['info'] = "恭喜抢到红包" ;
	        $data['number'] = ($bonusoverflag[1]/100)."元" ;
	        $this->ajaxReturn($data);
        }
        
//        $userdata["bonus_id"] = $bonusid;
//        $userdata["uid"] = $openId;
//        $userdata["uheadimg"] = 'aaa';
//        $userdata["uname"] = 'aaa';
//        $userdata["uaccount"] = "aaa";
//        $userdata["bonus_num"] = 1;
//        $userdata["lottery_num"] = 1;
//        $userdata["del_flag"] = 0;
//        $userdata["created"] = time();
//        $userdata["updated"] = time();
        
        //$userModel = D('Addons://Bonus/Bonususer');
        
        /*
        //事务开启
        $prizeModel->startTrans();
        $logModel->startTrans();
        //$userModel->startTrans();
        
        $prizeflag = $prizeModel->delprizenum(array("id" =>$prizeinfo[$randkey]["id"]));//减去奖项库存
        $logflag = $logModel->addlog($logdata);//log表记录
        //$userflag = $userModel->luckuserdata($userdata);//更新或者加入user表一条数据
        
        if( $prizeflag && $logflag && $userflag){
            $prizeModel->commit();
	        //$userModel->commit();
	        $logModel->commit();
	        $data['success'] =  1;
	        $data['info'] = "恭喜抢到红包" ;
	        $data['number'] = ($moneyrand/100)."元" ;
	        $this->ajaxReturn($data);
        }else{
	        $prizeModel->rollback();
	        //$userModel->rollback();
	        $logModel->rollback();
            $data['info'] ='很遗憾没有抢到'; 
	        $data['success'] = 0 ;
	        $this->ajaxReturn($data);
        }*/
	}
	
	/**
	 * 递归生成金额
	 */
	public function  randmoney($maxmoney , $sumprize , $min , $max){
	    if($min != $max){
    	    if( floor($maxmoney/$sumprize) > $max){
    	        return $max;
    	    }else{
    	        $max = floor($maxmoney/$sumprize);
    	    }
	    }
	    $money = rand( $min , $max);
	    if( $maxmoney >= $money){//判断随机生成的金额是否大于余额,若超出余额则重新生成
	        return $money;
	    }else{
	        $this->randmoney($maxmoney , $sumprize , $min , $max);
	    }
	}



    /**
     * 前端调用抢红包的方法
     */
    public function qiangbonus(){
        $BonusModel = D('Addons://Bonus/Bonus');
        $bonusid = $BonusModel->getisshowbonus();
        $openId = I("openId");
        $user_status = I("status",0);
        //根据openId获取用户信息
        $this->assign("openId",$openId);
        $this->assign("user_status",$user_status);
        $this->assign("bonusid",$bonusid["id"]);
	    $this->assign('link', ONETHINK_ADDON_PATH . _ADDONS.'/View/default/show/');
	    $this->display ( T ( 'Addons://Bonus@show/index' ) );
	}











}