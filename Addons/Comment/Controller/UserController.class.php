<?php

namespace Addons\Comment\Controller;
use Home\Controller\AddonsController;

/**
 * 前台评论控制器
 * 主要获取评论相关信息
 */
class UserController extends AddonsController {

	//根据话题ID显示评论详情
    public function commentdetail(){
        $tid = I("param.tid",8,intval);//接收话题ID,此处预留ID为8
        $topicModel = D('Addons://Comment/Commenttopic');
        $topicinfo = $topicModel->gettopicval(array("tid"=>$tid) , "topicname,logo_img,topicinfo,createtime,sid");
        $softModel = D('Addons://Comment/Commentsort');
        $uid = session('user_auth.uid');
        if(!$uid){
	        $this->checkUserLogin();
	    }
	    $uid = cookie('memberId');//获取前端用户ID
        $path = $this->getImageinfo(array("id"=>$topicinfo["logo_img"]));
        $topicinfo["topicimgpath"] = $path[0]["path"];
        $commentModel = D('Addons://Comment/Comment');
        $commentpraiseModel = D('Addons://Comment/Commentpraise');
        $commentlist = $commentModel->getcommentinfo(array("topicid"=>$tid , "status" => array("eq",1)) , "*");
        foreach ($commentlist as $k=>$v){
            if($v["to_comment_id"]){
                $parent_commentinfo = $commentModel->getcommentinfo(array("topicid"=>$tid , "comment_id" =>$v["to_comment_id"]) , "*" , 'is_top desc');
                $commentlist[$k]["parent_commentinfo"] = $parent_commentinfo[0];
            }
            $commentlist[$k]["praise"] = $commentpraiseModel->getpraisecount(array("comment_id"=>array('eq',$v["comment_id"])));
            $is_praise = $commentpraiseModel->getpraiseinfo(array("comment_id"=>array('eq',$v["comment_id"] ) , "uid"=>array("eq",$uid)));
            if(!empty($is_praise)){
                $commentlist[$k]["is_praise"] = 1;
            }
        }
    	$this->assign('tid',$tid);
        $this->assign("uid",$uid);//登陆用户ID
    	$this->assign('topicinfo',$topicinfo);
    	//var_dump($topicinfo);die;
    	$this->assign('commentlist',$commentlist);
    	$this->assign('count',count($commentlist));
    	//var_dump($commentlist);die;
        $this->display("comment/comment/commentdetail");
    }
    
    /**
     * 显示评论页面
     * Enter description here ...
     */
    public function  comment(){
        $to_uid = I("param.to_uid");
        $tid = I("param.tid");
        $topicModel = D('Addons://Comment/Commenttopic');
        $topicinfo = $topicModel->gettopicval(array("tid"=>$tid) , "topicname,logo_img,topicinfo,createtime,sid");
        $softModel = D('Addons://Comment/Commentsort');
        $uid = session('user_auth.uid');
        if(!$uid){
	        $this->checkUserLogin();
	    }
	    $uid =cookie('memberId');//获取前端用户ID
        $to_comment_id = I("param.to_comment_id");
    	$this->assign('uid',$uid);
    	$this->assign('to_uid',$to_uid);
    	$this->assign('tid',$tid);
    	$this->assign('to_comment_id',$to_comment_id);
        $this->display("comment/comment/comment");
    }
    
    
    /**
     * 敏感词验证
     */
    public function checkblackwords(){
        $content = I("param.content");
        $tid = I("param.tid");
        $topicModel = M('comment_topic');
        $usersetinfo = $topicModel->join(C('DB_PREFIX').'comment_sort on '.C('DB_PREFIX').'comment_topic.sid ='.C('DB_PREFIX').'comment_sort.sid')
                                  ->join(C('DB_PREFIX').'comment_set on '.C('DB_PREFIX').'comment_sort.uid = '.C('DB_PREFIX').'comment_set.uid')
                                  ->where(array(C('DB_PREFIX')."comment_topic.tid"=>$tid))
                                  ->field(C('DB_PREFIX')."comment_set.is_filter,".C('DB_PREFIX')."comment_set.is_self,".C('DB_PREFIX')."comment_set.check_set,".C('DB_PREFIX')."comment_set.filter_words")
                                  ->find();
        
        $ret  = array('status' => 'success');//初始化返回值
        if(!empty($usersetinfo)){
            if($usersetinfo["is_filter"]){//判断如果租赁用户没有开启敏感词验,默认通过
                $this->ajaxReturn(array('status' => 'success'));
            }
            if($usersetinfo["is_self"] && empty($usersetinfo["filter_words"])){//如果用户选择不需要使用系统敏感词库,并且没有设置自定义词汇,则通过
                $this->ajaxReturn(array('status' => 'success'));
            }
            if(!empty($usersetinfo["filter_words"])){//如果自定义了敏感词,先验证自定义敏感词
                $blackkeywords = explode(',',$usersetinfo["filter_words"]);
                $count = 0;
                for($i=0;$i<  count( $blackkeywords );$i++){
                    if(  substr_count($content , $blackkeywords[$i]) >0  ){
                        $count++;
                        break;
                    }
                }
                if($count>0){
                    $this->ajaxReturn(array('status' => 'fail'));
                }
            }
            if(!$usersetinfo["is_self"]){//验证敏感词库
                //系统敏感词缓存中有的话取缓存,没有的话查询之后写入缓存
                if(S("blackwords")){
                    $blackkeywords = S("blackwords");
                }else{
                    $blackkeywordModel = M("blackwords");
                    $blackkeywords = $blackkeywordModel->field("words")->select();
                    S("blackwords" , $blackkeywords);
                }
                foreach ($blackkeywords as $k=>$v){
                    if(  substr_count($content , $v["words"]) >0  ){
                        $count++;
                        break;
                    }
                }
                if($count>0){
                    $this->ajaxReturn(array('status' => 'fail'));
                }
            }
        }else{//如果该租赁用户没有设置留言管理,默认走系统词库验证
                if(S("blackwords")){
                    $blackkeywords = S("blackwords");
                }else{
                    $blackkeywordModel = M("blackwords");
                    $blackkeywords = $blackkeywordModel->field("words")->select();
                    S("blackwords" , $blackkeywords);
                }
                foreach ($blackkeywords as $k=>$v){
                    if(  substr_count($content , $v["words"]) >0  ){
                        $count++;
                        break;
                    }
                }
                if($count>0){
                    $this->ajaxReturn(array('status' => 'fail'));
                }
        }
        $this->ajaxReturn($ret);
    }
    
    /**
     * 添加评论
     */
    public function comment_do(){
        $data["topicid"] = I("param.tid");
        $topicModel = D('Addons://Comment/Commenttopic');
        $topicinfo = $topicModel->gettopicval(array("tid"=>$data["topicid"]) , "topicname,logo_img,topicinfo,createtime,sid");
        $sid = $topicinfo["sid"];//接收分类ID
	    $uid = session('user_auth.uid');//获取前端用户ID
        if(!$uid){
	        $this->checkUserLogin();
	    }
        $data["uid"] = $uid;
        $userinfo = json_decode(sendCurlRequest(C('GETUSERINFO') . $uid) , TRUE);
        $data["user_head"] = $userinfo["data"][0]["image"]  ? $userinfo["data"][0]["image"] :  "";
        $data["user_name"] = $userinfo["data"][0]["nickname"] ? $userinfo["data"][0]["nickname"] : "";
        $data["comment_content"] = I("param.form_article");
        $data["commenttime"] = time();
        $data["to_comment_id"] = I("param.to_comment_id");;
        $data["to_uid"] = I("param.to_uid");
        $usersetinfo = $topicModel->join(C('DB_PREFIX').'comment_sort on '.C('DB_PREFIX').'comment_topic.sid ='.C('DB_PREFIX').'comment_sort.sid')
                          ->join(C('DB_PREFIX').'comment_set on '.C('DB_PREFIX').'comment_sort.uid = '.C('DB_PREFIX').'comment_set.uid')
                          ->where(array(C('DB_PREFIX')."comment_topic.tid"=>$data["topicid"]))
                          ->field(C('DB_PREFIX')."comment_set.is_filter,".C('DB_PREFIX')."comment_set.is_self,".C('DB_PREFIX')."comment_set.check_set,".C('DB_PREFIX')."comment_set.filter_words")
                          ->find();
        if(empty($usersetinfo)){
            $data["status"] = 0;
        }else{
            $data["status"] = $usersetinfo["check_set"] ? 1 : 0;
        }
        $data["is_top"] = 0;
        $data["is_users"] = 0;
        $commentModel = D('Addons://Comment/Comment');
        $result = $commentModel->addcomment($data);
        if($result){
            echo "<script>javascript:history.go(-2)</script>";
        }else{
            echo "<script>javascript:history.go(-1)</script>";
        }
    }
    
    /**
     * 赞 + 取消赞
     */
    public function praise(){
        $uid = I("param.uid");
        $comment_id = I("param.commentid");
        if(!$uid || !$comment_id)
            $this->ajaxReturn(array('status' => 'fail' , "info" =>"参数错误"));
        $commentpraiseModel = D('Addons://Comment/Commentpraise');
        $ret  = array('status' => 'fail' , "info" =>"修改失败");
        $result = $commentpraiseModel->changepraise(array("uid"=>$uid , "comment_id"=>$comment_id));
        if($result){
            $ret['status'] = 'succ';
            $ret['info'] = '修改成功';
        }
        $this->ajaxReturn($ret);
    }
    
    /**
     * 删除评论
     */
    public function delcomment(){
        $comment_id = I("param.comment_id");//获取要删除的评论ID
        if(!$comment_id)
            $this->ajaxReturn(array('status' => 'fail' , "info" =>"参数错误"));
        $uid = I("param.userid");//获取要删除的评论ID的用户ID
        $commentModel = D('Addons://Comment/Comment');
        $ret  = array('status' => 'fail' , "info" =>"删除失败");
        $result = $commentModel->delcomment(array("uid"=>$uid , "comment_id"=>$comment_id));
        if($result){
            $ret['status'] = 'succ';
            $ret['info'] = '删除成功';
        }
        $this->ajaxReturn($ret);
    }

}