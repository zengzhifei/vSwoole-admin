<?php

namespace Addons\Bonus\Model;
use Think\Model;

/**
 * Bonus模型
 */
class BonusModel extends Model{
    public function __construct(){
        parent::__construct();
        if(C('IS_CACHE')){
            import("Vendor.Memcache.Memch",'','.php');
            $this->Memcache = new \Memch('voteVersion');
        }
    }
	protected $_auto = array (
		array('updated','time',self::MODEL_BOTH,'function'),
		array('created','time',self::MODEL_INSERT,'function'),
		array('ip','get_client_ip',self::MODEL_BOTH,'function'),
	);
	
	protected $_validate = array(
		array('lucky_title','1,50', '活动标题不能为空且少于50个字！', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
		array('lucky_rules','1,200', '活动说明不能为空且少于200个字！', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
		array('wining_remark','1,50', '中奖提示不能为空且少于50个字！', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
		array('award_remark','1,200', '领奖提示不能为空且少于200个字！', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
		array('start_time','require', '开始时间不能为空！'),
		array('end_time','_validate_compare_time', '开始时间不能为空！', self::MUST_VALIDATE , 'function'),
		array('end_time','1,200', '领奖提示不能为空且少于200个字！', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
		array('ep_lucky_number','number', '每人每天抽奖次数格式不符', self::VALUE_VALIDATE),
		array('lucky_number','number', '活动期间内没人总抽奖次数格式不符', self::VALUE_VALIDATE),
		array('end_topic','1,50', '活动结束公告主题不能为空且少于50个字！', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
		array('end_remark','1,200', '活动结束说明不能为空且少于200个字！', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
	);
	
	private function _validate_compare_time(){
		$start_time = I('start_time', '');
		$end_time = I('end_time', '');
		if ((strtotime($start_time) > strtotime($end_time)) || $end_time == ''){
			return false;
		}else{
			return true;
		}
	}
     /*
     * 获取抽奖列表
     */
    public function getLuckylist($lucky_title,$uid,$p,$firstRows,$listRows){
        if(C('IS_CACHE')){
            $cacheKey = 'LuckyList_uid'.$uid.'_'.$p.'_';
            if($lucky_title) $cacheKey .= $lucky_title;
            $list = $this->Memcache->getCache($cacheKey);
            if(!$list){
                $list = array();
            }
        }else{
            $list = array();
        }
        if(empty($list)){
            $where=array();
            $parameter=array();
            if($lucky_title){
                $where['lucky_title'] = array('LIKE','%'.$lucky_title.'%');
            }
            
            $order = 'id DESC';
            $luckyModel = M("lucky");
            $where['uid'] = array('EQ',$uid);
            $list      = $luckyModel->where($where)->order($order)->limit($firstRows.','.$listRows)->select();
            if(C('IS_CACHE')){
                $this->Memcache->setCache($cacheKey,$list);
            }
        }
        return $list;
    }
    
     public function getLuckyCount($lucky_title,$uid){
        if(C('IS_CACHE')){
            $Memcache = $this->Memcache;
            $cachekey = 'LuckyCount_uid'.$uid.'_';
            if($lucky_title) $cacheKey .= $lucky_title;
            $count = $Memcache->getCache($cacheKey);
            if(!$count){
                $count= false;
            }
        }else{
            $count = false;
        }
        if(!$count){
            if($lucky_title){
                $where['lucky_title'] = array('LIKE','%'.$lucky_title.'%');
            }
            
            $luckyModel = M("lucky");
            $where['uid'] = array('EQ',$uid);
            $count     = $luckyModel->where($where)->count();
            if(C('IS_CACHE')){
                $Memcache->setCache($cacheKey,$count);
            }
        }
        return $count;
    }
	/**
	 * 设置数据
	 * @param unknown $data
	 * @param number $lucky_id
	 */
	public function setter($data, $lucky_id = 0){
	    $Memcache= $this->Memcache;
		if (!$this->create($data)){
			return false;
		}else{
			if ($lucky_id === 0){
				$ret = $this->add();
			}else{
				$ret = $this->save();
			}
		}
	     if($ret){
			if(C('IS_CACHE')){
                $Memcache->updateCache();
            }
            return $ret;
		}else{
            return false;
        }
		//return $ret;
	}
	
	/**
	 * 获取数据
	 * @param number $lucky_id
	 */
	public function getter($lucky_id = 0, $first_row = 0, $list_rows = 10, $order = 'id DESC'){
	    $Memcache= $this->Memcache;
		if ($lucky_id === 0){
			$result = $this->order($order)->limit($first_row, $list_rows)->select();
    		if($result){
                if(C('IS_CACHE')){
                    $Memcache->updateCache();
                }
                return $result;
            }else{
                return false;
            }
		}else{
			$result = $this->where(array('id' => $lucky_id))->find();
		    if($result){
                if(C('IS_CACHE')){
                    $Memcache->updateCache();
                }
                return $result;
            }else{
                return false;
            }
		}
	}
	
     /**
     * 删除抽奖
     */
    public function delete($id){
        $luckywhere['id'] = $id;
        $lucky_Model = M('lucky');
        $result= $lucky_Model->where($luckywhere)->delete();
        if($result){
            return true;
        }else{
            return false;
        }
    }
  	/**
     * 批量删除抽奖
     */
    public function deleteDraw($id){
        $luckywhere['id'] = array('in',$id);
        $lucky_Model = M('lucky');
        $result = $lucky_Model->where($luckywhere)->delete();
        if($result){
            return true;
        }else{
            return false;
        }
    }
	/**
	 * 根据活动id修改活动开始时间
	 */
	public function updateStarttime($id = 0,$start_time = 0){
	    if ($id === 0)
	        return false;
	      return  $this->where(array("id"=>$id))->save(array("start_time" => $start_time));
	}
	/**
	 * 根据活动id修改活动结束时间
	 */
	public function updateEndtime($id = 0,$end_time = 0){
	    if ($id === 0)
	        return false;
	      return  $this->where(array("id"=>$id))->save(array("end_time" => $end_time));
	}
	/**
     * 根据活动id获取活动详情
     */
    public function getLuckyInfoById($lucky_id){
        $where['id'] = array('eq',$lucky_id);
        return $this->where($where)->find();
    }
    
    /**
     * 根据where人条件、返回数据
     */
    public function getisshowbonus(){
        return $this->where(array("is_show"=>1))->find();
    }
    
    /**
     * 从红包余额中减去刚刚抽中的金额
     */
    /*public function bonusover($bonusid , $bonusover){
    	$this->startTrans();//开启事务
    	$bonusshengxia = $this->lock(true)->where(array("id"=>$bonusid))->sum("bonusover");
    	$this->where(array("id"=>$bonusid))->setDec('bonusover',$bonusover);
    	if(  ($bonusshengxia - $bonusover) < 0){
    		$this->where(array("id"=>$bonusid))->setInc('bonusover',$bonusover);
    		$result = $bonusshengxia - $bonusover;
    		$this->commit();//事务提交
    		return $result;
    	}else{
    		$result = $bonusshengxia - $bonusover;
    		$this->commit();//事务提交
    		return $result;
    	}
    }*/
    
	public function bonusover($bonusid , $sumprize , $min , $max){
    	$this->startTrans();//开启事务
    	$bonusinfo = $this->lock(true)->where(array("id"=>$bonusid))->find();
    	$bonusover = $this->randmoney($bonusinfo["bonusover"] , $sumprize ,  $min , $max);//生成红包金额
		$this->where(array("id"=>$bonusid))->setDec('bonusover',$bonusover);
    	if(  ($bonusinfo["bonusover"] - $bonusover) < 0){
    		$this->where(array("id"=>$bonusid))->setInc('bonusover',$bonusover);
    		$result = $bonusinfo["bonusover"] - $bonusover;
    		$this->commit();//事务提交
    		return array($result,$bonusover);
    	}else{
    		$result = $bonusinfo["bonusover"] - $bonusover;
    		$this->commit();//事务提交
    		return array($result,$bonusover);
    	}
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
    
    
    
    
    
    
    
    
    
    
    
    
//End Class
}
