<?php
namespace Addons\Bonus\Model;
use Think\Model;

/**
 * 中奖情况模型
 */
class BonuslogModel extends Model{
		    //定义主表
    protected  $tableName='bonus_log';
	
    
    public function _initialize(){
        parent::_initialize();
        if(C('BONUS_IS_CACHE')){
            import("Vendor.Memcache.Memch",'','.php');
            $this->Memcache = new \Memch('bonusVersion');
        }
    }
	/**
     * 获取抽奖次数
     */
    public function getLuckyDrawCount($where){
        $count = $this->where($where)->count();
        return $count;
    }
 	/**
     * 删除中奖用户
     */
    public function deleteWinner($uid){
        $where['uid'] = $uid;
        $result = $this->where($where)->delete();
        if($result){
            return false;
        }else{
            return false;
        }
    }
	/**
	 * 根据用户id修改派奖状态
	 */
	public function updatPrize($uid = FALSE,$award_flag = 0,$luck_id = 0){
	    if ($uid === FALSE)
	        return false;
	      return  $this->where(array("uid"=>$uid,"luck_id"=>$luck_id))->save(array("award_flag" => $award_flag));
	}
    
    /**
     * 修改中奖信息:tel、award_flag
     */
    public function updateluckyinfo($where , $data){
        $result = $this->where($where)->count();
        if($result){
             return $this->where($where)->save($data);
        }else{
            return false;
        }
    }
    
    
    /**
     * 用户抽奖后 新增一条log数据
     */
    public function addlog($data){
        if (empty($data))
            return false;
        else
            return $this->add($data);
    }
    
    /**
     * 根据用户ID和活动ID、返回一条已经中奖的信息
     */
    public  function getlotteryinfo($uid , $luck_id){
        if(!$uid || !$luck_id)
            return false;
        if(C('BONUS_IS_CACHE')){
            $Memcache = $this->Memcache;
            $cacheKey = $uid.'_'.$luck_id;
            $flag = $Memcache->getCache($cacheKey);
            if(!$flag){
                $data = $this->where(array("uid"=>$uid , "bonus_id"=>$luck_id , "is_lottery"=>1))->find();
                $this->Memcache->setCache($cacheKey,$data);
                return $data;
            }else{
                return $flag;
            }
        }else{
            return $this->where(array("uid"=>$uid , "bonus_id"=>$luck_id , "is_lottery"=>1))->find();
        }
    }
    
    /**
     * 根据活动ID计算出当前已经发出的红包总额
     */
    public function givemoneysum($bonusid){
        return $this->where(array("bonus_id"=>$bonusid))->sum("bonus_money");
    }
    
    
}