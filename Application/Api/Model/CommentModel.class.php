<?php
namespace Api\Model;
use Think\Model;

/**
 * 评论前台接口模型
 * 仿搜狐畅言
 * Enter description here ...
 * @author Administrator
 *
 */
class CommentModel extends Model{
    //定义主表
    protected  $tableName='hudong_comment';
    
    
    
/**
     * 获取评论列表
     */
    public function getCommentList ($where = array(), $page = 1, $perpage = 20, $order = 'id', $sort = 'asc',$order1="commenttype",$sort1="asc")
    {
        $page = (int) $page < 1 ? 1 : (int) $page;
        $perpage = (int) $perpage < 1 ? 10 : (int) $perpage;
        $offset = ($page - 1) * $perpage;
        $reply_list = $this->where($where)->order($order."  ".$sort." ",$order1." ".$sort1)->limit($perpage, $offset)->select();
        foreach($reply_list as $key=>$value){
        	$reply_list[$key]["ctime"]=date("Y-m-d H:i:s",$value["create_time"]);  	
        }
        return $reply_list;
    }
   
    /**
     * 计算分页的总条数
     */
    public function counthe ($where = array())
    {
        $count = $this->where($where)->count();
        return $count;
    }
    
    /**
     * 审核调查评论
     */
    public function checkcomment($cid,$status){
    	
        $check_ret=$this->where(array('id'=>array("eq"=>$cid)))->save(array('status'=>$status));
        
        if($check_ret){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 添加调查
     */
    public function addcomment($data){
        $insert = $this->add($data);
     
        if($insert){
            return $insert;
        }else{
            return false;
        }
    }
























//End Class
}