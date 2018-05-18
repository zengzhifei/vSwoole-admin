<?php
namespace Admin\Model;
use Think\Model;

/**
 * 抽奖参与情况模型
 */
class BonususerModel extends Model{
    
    //定义主表
    protected  $tableName='bonus_user';

    
    /**
     * 删除参与抽奖用户
     */
    public function deleteLuckyUser($uid){
        $where['uid'] = $uid;
        $result = $this->where($where)->delete();
        if($result){
            return false;
        }else{
            return false;
        }
    }
    
    /**
     * 根据活动ID和用户ID、获取用户参与这个活动的详细信息
     */
    public function getuserluckyinfo($uid , $luck_id){
        if($uid && $luck_id){
            return $this->where(array("uid"=>$uid , "bonus_id"=>$luck_id))->find();
        }else{
            return false;
        }
    }
    
    
    /**
     * 用户抽奖之后、新增或者修改一条用户抽奖数据
     */
    public function luckuserdata($data){
        if(empty($data))
            return false;
        $userdata = $this->where(array("bonus_id"=>$data["bonus_id"] , "uid"=>$data["uid"]))->find();
        if(!empty($userdata)){
            $data["bonus_num"] = $userdata["bonus_num"]+1;
            unset($data["created"]);
            return $this->where(array("bonus_id"=> $data["bonus_id"] , "uid"=>$data["uid"]))->save($data);
        }else{
            return $this->add($data);
        }
    }
    /**
	 * 根据用户id修改用户参与活动状态
	 */
	public function updateUserStatus($uid = FALSE,$del_flag = 0,$luck_id = 0){
	    if ($uid === FALSE)
	        return false;
	      return  $this->where(array("uid"=>$uid,"bonus_id"=>$luck_id))->save(array("del_flag" => $del_flag));
	}
    
}