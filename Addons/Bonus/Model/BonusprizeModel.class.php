<?php
namespace Addons\Bonus\Model;
use Think\Model;

/**
 * 奖品列表模型
 */
class BonusprizeModel extends Model{
	
	    //定义主表
    protected  $tableName='bonus_prize';
	/**
	 * 获取奖品列表数据
	 * @param number $lucky_id
	 */
	public function getter($lucky_id = 0, $first_row = 0, $list_rows = 10, $order = 'sort ASC'){
		return $this->where(array('luck_id' => $lucky_id))->order($order)->limit($first_row, $list_rows)->select();
	}
	/**
	 * 添加奖品列表数据
	 * @param unknown $data
	 * @param number $lucky_id
	 */
	public function setter($data, $id = 0){
		if (!$this->create($data)){
			return false;
		}else{
			if ($id === 0){
				$ret = $this->add();
			}else{
				$ret = $this->save();
			}
		}
		return $ret;
	}
	
	/**
	 * 根据抽奖活动ID、获取该活动下各个奖项信息
	 */
	public function getprizeinfo($luck_id = 0){
	    if ($luck_id === 0)
	        return false;
	    return $this->where(array("bonus_id"=>$luck_id , "is_show" => 1))->order("sort ASC")->select();
	}
	
	/**
	 * 根据活动ID和奖项title,获取一条奖项信息
	 */
	public function getprizeonce($where = array()){
	    if (empty($where))
	        return false;
	    return $this->where($where)->find();
	}
	
	/**
	 * 根据where条件、所中奖项的库存数量减去1个
	 */
	public function delprizenum($where){
	    if (empty($where))
	        return false;
	    $this->where($where)->setDec('num');
	    //return $this->where($where)->sum("num");
	    
	    $prizeover = $this->where($where)->sum("num");
	    if($prizeover<0){
	    	$this->where($where)->setInc('num');
	    	return $prizeover;
	    }else{
	    	return $prizeover;
	    }
	}
	/**
	 * 根据抽奖活动ID、奖品ID获取该活动下的奖品名
	 */
	public function getPrizeName($id = 0){
	    if ($id === 0)
	        return false;
	    return $this->getById($id);
	}
	
	/**
	 * 查询某个红包活动下还有多少库存奖品
	 */
	public function getsumprize($bonusid){
	    return $this->where(array("bonus_id"=>$bonusid))->sum('num');
	}
}