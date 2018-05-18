<?php
namespace Admin\Controller;
use User\Api\UserApi as UserApi;

/**
 * 后台评论控制器
 */
class CommentController extends AdminController {
    
    public function _initialize(){
        //parent::_initialize();
        $this->CheckAdminLogin();
        $userinfo = session('user');
        $this->userId = $userinfo['userid'];
        if(C('IS_CACHE')){
            import("Vendor.Memcache.Memch",'','.php');
            $this->Memcache = new \Memch('CommentVersion');
        }
    }
    

    	
    /**
     * 评论首页
     * 这个方法展示评论首页分类列表
     */
    public function index(){
        $page = I ( 'param.p', 1 ,intval);
        $offset=C('PAGE_OFFSET');
        $where = array ();//where预留
        $where['uid'] = array('eq',$this->userId);
        $parameter = array();
        $field = "sid,uid,sortname,createtime,sort_imgid";
        $SortModel = D ('Commentsort' );
        if(C('IS_CACHE')){
            $sortlistcacheKey = 'sortlist_uid'.$this->userId.'_'.$page;//分类列表缓存键名
            $sortlistcountcacheKey = 'sortlistcount_uid'.$this->userId;//分类总数缓存键名
            $SortList = $this->Memcache->getCache($sortlistcacheKey);//获取分类列表缓存数据
            $count = $this->Memcache->getCache($sortlistcountcacheKey);//获取分类总数缓存数据
            if(!$SortList){
                $SortList = $SortModel->getsortlist ($where , $field , $page , $offset);
                $this->Memcache->setCache($sortlistcacheKey,$SortList);
            }
            if(!$count){
                $count     = $SortModel->where($where)->count();
                $this->Memcache->setCache($sortlistcountcacheKey,$count);
            }
        }else{
            $SortList = $SortModel->getsortlist ($where , $field , $page , $offset);
            $this->Memcache->setCache($sortlistcacheKey,$SortList);
            $count     = $SortModel->where($where)->count();
            $this->Memcache->setCache($sortlistcountcacheKey,$count);
        }
        foreach ($SortList as $k=>$v){
            $path = $this->getImageinfo(array("id"=>$v["sort_imgid"]));
            $SortList[$k]["sortimgpath"] = $path[0]["path"];
        }
        $Page      = $this->page($count,$parameter);
        $show      = $Page->weishow();
        
        $this->assign("p",$page);
        $this->assign("totalpage",$Page->totalPages);
        $this->assign("page",$show);
    	$this->assign('title',"分类列表");//页面名称
    	$this->assign('sortlist',$SortList);//分类列表
        $this->assign("uid",$this->userId);//登陆用户ID
        $this->assign("menuname","评论");//默认选中子导航
        $this->display("index");
    }
    
    /**
     * 创建/修改评论分类
     * 这个方法用于创建/修改评论分类
     */
    public function sortoption(){
        if(I ( 'param.sid')){
            $SortModel = D ('Commentsort' );
            $where["sid"] = I ( 'param.sid');
            $sortinfo = $SortModel->getsortinfo($where);
            if(!empty($sortinfo)){
                $sortimgid = M("picture")->where(array("id"=>$sortinfo["sort_imgid"]))->find();
                $sortimgid ? $sortinfo["path"]= $sortimgid["path"]: $sortinfo["path"]="";
            }
            $this->assign("sortinfo",$sortinfo);//分类信息
        }
        $SortModel = D ('Commentsort' );
        $this->assign('title',"添加/修改分类");//页面名称
        $this->assign("uid",$this->userId);//登陆用户ID
        $this->assign("menuname","评论");//默认选中子导航
        $this->display("addsort");
    }
    public function addsortdo(){
        $data["uid"] = $this->userId;
        $data["sortname"] = I("sortname");
        $data["sort_imgid"] = I("pic_id");
        $SortModel = D ('Commentsort' );
        if(I("sid")){
            $data["updatetime"] = time();
            $add_status = $SortModel->updatesort(array("sid"=>I("sid")),$data);
        }else{
            $data["createtime"] = time();
            $data["updatetime"] = time();
            $add_status = $SortModel->addsort($data);
        }
        if(C('IS_CACHE')){
            $this->Memcache->updateCache();//更新缓存
        }
        if ($add_status){
            $this->ajaxReturn(array('status' => 1 , "info" =>"操作成功"));
        }else{
            $this->ajaxReturn(array('status' => 0 , "info" =>"操作失败"));
        }
    }
    
    /**
     * 删除评论分类
     */
    public function delsort(){
        if(I("param.sid")){
            $ret  = array('status' => 'fail' , "info" =>"删除失败");
    	    $where['sid'] = array('eq',I("param.sid"));
    	    $SortModel = D ('Commentsort' );
    	    $result = $SortModel->delsort($where);
    	    if($result){
    	        $ret['status'] = 'succ';
    	        $ret['info'] = '删除 成功';
        	    if(C('IS_CACHE')){
                    $this->Memcache->updateCache();//更新缓存
                }
    	    }
    	    $this->ajaxReturn($ret);
        }else{
            $this->ajaxReturn(array('status' => 'fail' , "info" =>"参数错误"));
        }
    }
    /**
     * 评论接口
     */
    public function commentapi(){
        $commentapicode = file_get_contents("./commentapi.txt");
        $this->ajaxReturn(array('commentapicode' => html_entity_decode($commentapicode)));
    }
    
    /**
     * 加载话题列表
     */
    public function topiclist(){
    	$p = I('p',1,intval);
    	$sid = I('sid',0,intval);
    	$offset = C('PAGE_OFFSET');  
    	$parameter['sid'] = $sid;       //分页参数
    	$order = "is_top DESC,updatetime DESC";
    	$commentModel = D('Commenttopic');
    	$topiclist = $commentModel->gettopiclist($sid,$order,$p,$offset);
    	foreach ($topiclist['list'] as $k => $v){
    		$sortimgid = M("picture")->find($topiclist['list'][$k]['logo_img']);
    		$topiclist['list'][$k]["path"]= $sortimgid["path"];
    		$topiclist['list'][$k]["info"]= U('Comment/topicinfo',array('tid'=>$topiclist['list'][$k]['tid'],'sid'=>$topiclist['list'][$k]['sid']));
    	}
    	$total = $topiclist['total'];
    	//分页
//     	$where['sid'] = array('eq',$sid);
//     	$count     = $commentModel->where($where)->count();
    	$Page      = $this->page($total,$parameter);
    	$show      = $Page->weishow();
    	
    	$this->assign("p",$p);
    	$this->assign("totalpage",$Page->totalPages);
    	$this->assign("page",$show);
    	$this->assign('total',$total);
    	$this->assign('title','话题列表');
    	$this->assign('topiclist',$topiclist['list']);
        $this->assign("menuname","评论");//默认选中子导航
    	$this->display('topic');
    }
    
    /**
     * 查看话题
     */
    public function topicinfo(){
        $sid = I("param.sid");//接收分类ID
        $tid = I("param.tid");//接收话题ID
        $topicModel = D('Commenttopic');
        $topicinfo = $topicModel->gettopicval(array("tid"=>$tid) , "topicname,logo_img,topicinfo,createtime");
        $path = $this->getImageinfo(array("id"=>$topicinfo["logo_img"]));
        $topicinfo["topicimgpath"] = $path[0]["path"];
        $commentModel = D('Comment');
        $commentpraiseModel = D('Commentpraise');
        $commentlist = $commentModel->getcommentinfo(array("topicid"=>$tid) , "*");
        foreach ($commentlist as $k=>$v){
            if($v["to_comment_id"]){
                $parent_commentinfo = $commentModel->getcommentinfo(array("topicid"=>$tid , "comment_id" =>$v["to_comment_id"]) , "*");
                $commentlist[$k]["parent_commentinfo"] = $parent_commentinfo[0];
            }
            $commentlist[$k]["praise"] = $commentpraiseModel->getpraisecount(array("comment_id"=>array('eq',$v["comment_id"])));
        }
    	$this->assign('title','话题评论内容');
    	$this->assign('tid',$tid);
    	$this->assign('sid',$sid);
        $this->assign("uid",$this->userId);//登陆用户ID
    	$this->assign('topicinfo',$topicinfo);
    	//var_dump($topicinfo);die;
    	$this->assign('commentlist',$commentlist);
    	$this->assign('count',count($commentlist));
        $this->assign("menuname","评论");//默认选中子导航
    	//var_dump($commentlist);die;
    	$this->display();
    }
    
    /**
     * 添加/修改   话题
     */
    public function addtopic(){
    	$commentModel = D('Commenttopic');
    	if (IS_POST) {
    		$tid       = I('tid',0,intval);
    		$topicname = I('topicname',false,trim);
    		$topicinfo = I('topicinfo',false,trim);
    		$logo_img  = I('pic_id',0,intval);
    		$topicsort = I('sid',0,intval);
    		if (!$topicname || !$topicinfo || !$logo_img || !$topicsort) {
    			$this->error('参数不完整,请填写完整');
    		}
    		$msg = empty($tid) ? '话题添加成功' : '话题修改成功';
    		$res = $commentModel->addtopic($topicname, $topicinfo, $logo_img, $topicsort, $tid);
    		if ($res) {
    		    if(C('IS_CACHE')){
                    $this->Memcache->updateCache();//更新缓存
                }
                $this->ajaxReturn(array('status' => 1 , "info" =>"操作成功"));
    		}else {
                $this->ajaxReturn(array('status' => 0 , "info" =>"操作失败"));
    		}
    	}else {
    		$uid   = $this->userId;   //uid
    		$tid   = I('tid',0,intval);
    		$title = empty($tid) ? '添加话题' : '修改话题';
    		$topicinfo = $commentModel->gettopicinfo($tid);
    		if ($topicinfo) {
    			$sortimgid = M("picture")->find($topicinfo['logo_img']);
    			$topicinfo["path"]= $sortimgid["path"];
    		}
    		$SortModel = D ('Commentsort');
    		$fields = array('sid','sortname');
    		$where['uid'] = $uid;
    		$sortinfo = $SortModel->getsortlist($where,$fields);
    		$this->assign('title',$title);
    		$this->assign('sortlist',$sortinfo);
    		$this->assign('topicinfo',$topicinfo);
    		$this->assign("uid",$uid);
            $this->assign("menuname","评论");//默认选中子导航
    		$this->display();
    	}
    }
    
    /**
     * 修改话题置顶信息
     */
    public function settop(){
    	if (!IS_AJAX) {
    		$data = array('status'=>-1,'msg'=>'请求非法');
    	}else {
    		$tid    = I('tid',0,intval);
    		$is_top = I('is_top',0,intval);
    		$it     = array(0,1);  //置顶取值范围
    		if (!$tid || !in_array($is_top, $it)) {
    			$data = array('status'=>-1,'msg'=>'参数非法');
    		}else{
    			$commentModel = D('Commenttopic');
    			$res          = $commentModel->settop($tid,$is_top);
    			if ($res && $is_top == 0){
        			if(C('IS_CACHE')){
                        $this->Memcache->updateCache();//更新缓存
                    }
    				$data = array('status'=>1,'msg'=>'置顶取消成功');
	    		}elseif ($res && $is_top == 1){
	    		    if(C('IS_CACHE')){
                        $this->Memcache->updateCache();//更新缓存
                    }
	    			$data = array('status'=>2,'msg'=>'置顶成功');
	    		}else {
	    			$data = array('status'=>-1,'msg'=>'操作失败');
	    		}
    		}
    	}
    	$this->ajaxReturn($data);
    }
    
    /**
     * 删除话题
     */
    public function deltopic(){
    	if (!IS_AJAX) {
    		$data = array('status'=>-1,'msg'=>'请求非法');
    	}else {
    		$tid = I('tid',0,intval);
    		if (!$tid) {
    			$data = array('status'=>-1,'msg'=>'参数非法');
    		}else{
    			$commentModel = D('Commenttopic');
    			$res          = $commentModel->deltopic($tid);
    			if ($res){
    			    if(C('IS_CACHE')){
                        $this->Memcache->updateCache();//更新缓存
                    }
    				$data = array('status'=>1,'msg'=>'删除成功');
	    		}else {
	    			$data = array('status'=>-1,'msg'=>'删除失败');
	    		}
    		}
    	}
    	$this->ajaxReturn($data);
    }
    
    
    
    /**
     * 删除评论
     */
    public function delcomment(){
        if(I("param.comment_id" , false ,intval)){
            $ret  = array('status' => 'fail' , "info" =>"删除失败");
    	    $where['comment_id'] = array('eq',I("param.comment_id" , false , intval));
    	    $where['to_comment_id'] = array('eq',I("param.comment_id" , false , intval));
    	    $where['_logic'] = 'OR';
    	    $commentModel = D ('Comment' );
    	    $result = $commentModel->delcomment($where);
    	    if($result){
    	        if(C('IS_CACHE')){
                    $this->Memcache->updateCache();//更新缓存
                }
    	        $ret['status'] = 'succ';
    	        $ret['info'] = '删除 成功';
    	    }
    	    $this->ajaxReturn($ret);
        }else{
            $this->ajaxReturn(array('status' => 'fail' , "info" =>"参数错误"));
        }
    }
    
    /**
     * 修改审核评论状态
     */
    public function changestatus(){
        if( I("param.comment_id")<=0 ||  !in_array(I("param.status"),array(0,1)))
            $this->ajaxReturn(array('status' => 'fail' , "info" =>"修改失败"));
        $commentModel = D ('Comment' );
        $where["comment_id"] = array('eq',I("param.comment_id"));
        $data["status"] = I("param.status");
        $ret  = array('status' => 'fail' , "info" =>"修改失败");
        $result = $commentModel->updatecomment($where , $data);
        if($result){
            if(C('IS_CACHE')){
                $this->Memcache->updateCache();//更新缓存
            }
	        $ret['status'] = 'succ';
	        $ret['info'] = '修改成功';
	    }
	    $this->ajaxReturn($ret);
    }
    
    /**
     * 后台管理回复用户
     */
    public function adminanswer(){
        $data["topicid"] = I("param.topicid");
        $data["uid"] = I("param.uid");
        $data["to_comment_id"] = I("param.to_comment_id");
        $data["to_uid"] = I("param.to_uid");
        $data["user_head"] = "123123";//预留
        $data["user_name"] = "123123";//预留
        $data["comment_content"] = I("param.comment_content");
        $data["commenttime"] = time();
        $data["status"] = 1;
        $data["is_top"] = 2;
        $data["is_users"] = 1;
        //var_dump($data);die;
        $commentModel = D ('Comment');
        $resule = $commentModel->addcomment($data);
        if ($resule){
            $this->redirect("topicinfo" , array( 'tid'=>I("param.topicid") , 'sid' => I("param.sid") ) );
        }else{
        	$this->error("回复失败", addons_url('Comment://Comment/topicinfo', array('sid' => I("param.sid"), 'tid'=>I("param.tid"))));
        }
    }
    
    /**
     * 统计信息页二级联动
     */
    public function topicoption(){
        $sortid = I("param.sid");
    	$topicModel = D('Commenttopic');
        $topicdata = $topicModel->gettopic(array("sid"=>array("eq" , $sortid)) , "tid,topicname");//获取该租赁用户下所有的话题
        if($topicdata){
	        $this->ajaxReturn(array("status" => "succ" , "data"=>$topicdata));
        }else{
	        $this->ajaxReturn(array("status" => "fail" , "info"=>"该分类下无数据"));
        }
    }
    
    /**
     * 统计信息
     */
    public  function counttable(){
        $uid = $this->userId;
        //此注释段为逐次查询方式,先取出租赁用户下的分类、再查出分类下的话题、最后查出话题下的所有评论数
        $SortModel = D ('Commentsort');
        $sortdata = $SortModel->getsortlist(array("uid"=>$uid));//获取该租赁用户下所有的分类
        $sortid = array_column($sortdata, 'sid');
        $sortModel = M('comment_sort');
        if(IS_POST){
            if(I( 'param.starttime' , false ,'strtotime' ) && I( 'param.endtime' , false ,'strtotime' )){
                $this->assign("starttime",I( 'param.starttime' , false ));
                $this->assign("endtime",I( 'param.endtime' , false ));
                $where[C('DB_PREFIX')."comment.commenttime"] = array("between",array( I( 'param.starttime' , false ,'strtotime' ),I( 'param.endtime' , false ,'strtotime' )));
            }
            if(I( 'param.sort' , false )){
    	        $topicModel = D('Commenttopic');
                $topicdata = $topicModel->gettopic(array("sid"=>array("eq" , I( 'param.sort' , false ) )) , "tid,topicname");//获取选中的分类下所有的话题
                $this->assign("topicdata",$topicdata);
                $this->assign("sortid",I( 'param.sort' , false , "intval" ));
                $where[C('DB_PREFIX')."comment_sort.sid"]= array("eq",I( 'param.sort' , false ));
            }
            if(I( 'param.topic' , false )){
                $this->assign("topicid",I( 'param.topic' , false, "intval" ));
                $where[C('DB_PREFIX')."comment_topic.tid"]= array("eq",I( 'param.topic' , false ));
            }
            if(I( 'param.starttime' , false ,'strtotime' ) && I( 'param.endtime' , false ,'strtotime' )){
                $j=0;
                $starttime = I( 'param.starttime' , false ,'strtotime' );
                $endtime = I( 'param.endtime' , false ,'strtotime' );
                while($starttime  <=  $endtime){
                    $date[$j]['time'] = date('m/d',$starttime);
                    $date[$j]['count'] = intval(0);
                    $starttime = strtotime('+1 day',$starttime);
                    $j++;
                }
            }else{
                for($i=1 ; $i<=30;$i++){
                    $date[$i-1]["time"] = date('m/d',strtotime("-".$i." day"));
                    $date[$i-1]["count"] = 0;
                }
            }
        }else{
            for($i=1 ; $i<=30;$i++){
                $date[$i-1]["time"] = date('m/d',strtotime("-".$i." day"));
                $date[$i-1]["count"] = 0;
            }
            //没有检索条件、默认显示最近一个月内的数据
            $where[C('DB_PREFIX')."comment.commenttime"] = array("between",array(strtotime("-1 month"),time()));
        }
        //查询该租赁用户下所有的评论
        $commentinfo =  $sortModel->join(C('DB_PREFIX').'comment_topic on '.C('DB_PREFIX').'comment_sort.sid ='.C('DB_PREFIX').'comment_topic.sid')
                                  ->join(C('DB_PREFIX').'comment on '.C('DB_PREFIX').'comment_topic.tid = '.C('DB_PREFIX').'comment.topicid')
                                  ->where(array(  C('DB_PREFIX')."comment_sort.uid"=>$uid , C('DB_PREFIX')."comment.is_users"=>array("eq",0)   , $where))
                                  ->field("FROM_UNIXTIME(".C('DB_PREFIX')."comment.commenttime,'%m/%d') time,count('".C('DB_PREFIX')."comment.comment_id') as count")
                                  ->group('time')
                                  ->select();
                                  //dump($commentinfo);die;
        foreach ($date as $k=>$v){
            foreach ($commentinfo as $k1=>$v1){
                if($v["time"] == $v1["time"]){
                    $date[$k] = $v1;
                }
            }
        }
        $this->assign("sortdata",$sortdata);
        $this->assign("rtitle",'评论数');
        $this->assign('rvalueField','count');
        $this->assign('RcategoryField','time');
        $this->assign("research",json_encode($date));
    	$this->assign("title","统计信息");
        $this->assign("menuname","评论");//默认选中子导航
        $this->display("counttable");
    }
    
    /**
     * 导出评论统计信息
     */
    public function exportcomment(){
        $uid = $this->userId;
            if(I( 'param.starttime' , false ) && I( 'param.endtime' , false  )){
                $this->assign("starttime",I( 'param.starttime' , false ));
                $this->assign("endtime",I( 'param.endtime' , false ));
                $where[C('DB_PREFIX')."comment.commenttime"] = array("between",array( I( 'param.starttime' , false  ),I( 'param.endtime' , false )));
            }
            if(I( 'param.sort' , false )){
    	        $topicModel = D('Commenttopic');
                $topicdata = $topicModel->gettopic(array("sid"=>array("eq" , I( 'param.sort' , false ) )) , "tid,topicname");//获取选中的分类下所有的话题
                $this->assign("topicdata",$topicdata);
                $this->assign("sortid",I( 'param.sort' , false , "intval" ));
                $where[C('DB_PREFIX')."comment_sort.sid"]= array("eq",I( 'param.sort' , false ));
            }
            if(I( 'param.topic' , false )){
                $this->assign("topicid",I( 'param.topic' , false, "intval" ));
                $where[C('DB_PREFIX')."comment_topic.tid"]= array("eq",I( 'param.topic' , false ));
            }
            if(I( 'param.starttime' , false ,'strtotime' ) && I( 'param.endtime' , false ,'strtotime' )){
                $j=0;
                $starttime = I( 'param.starttime' , false ,'strtotime' );
                $endtime = I( 'param.endtime' , false ,'strtotime' );
                while($starttime  <=  $endtime){
                    $date[$j]['time'] = date('m/d',$starttime);
                    $date[$j]['count'] = intval(0);
                    $starttime = strtotime('+1 day',$starttime);
                    $j++;
                }
            }else{
                for($i=1 ; $i<=30;$i++){
                    $date[$i-1]["time"] = date('m/d',strtotime("-".$i." day"));
                    $date[$i-1]["count"] = 0;
                }
            }
            //查询该租赁用户下所有的评论
            $sortModel = M('comment_sort');
            $where = $where ? array(  C('DB_PREFIX')."comment_sort.uid"=>$uid , C('DB_PREFIX')."comment.is_users"=>array("eq",0)   , $where) : array(  C('DB_PREFIX')."comment_sort.uid"=>$uid , C('DB_PREFIX')."comment.is_users"=>array("eq",0));
            $commentinfo =  $sortModel->join(C('DB_PREFIX').'comment_topic on '.C('DB_PREFIX').'comment_sort.sid ='.C('DB_PREFIX').'comment_topic.sid')
                                      ->join(C('DB_PREFIX').'comment on '.C('DB_PREFIX').'comment_topic.tid = '.C('DB_PREFIX').'comment.topicid')
                                      ->where($where)
                                      ->field("FROM_UNIXTIME(".C('DB_PREFIX')."comment.commenttime,'%m/%d') time,count('".C('DB_PREFIX')."comment.comment_id') as count")
                                      ->group('time')
                                      ->select();
                                      //dump($commentinfo);die;
            foreach ($date as $k=>$v){
                foreach ($commentinfo as $k1=>$v1){
                    if($v["time"] == $v1["time"]){
                        $date[$k] = $v1;
                    }
                }
            }
            foreach ($date as $k=>$v){
                $str.=$v["time"].",".$v["count"]."\n";
            }
        $data = mb_convert_encoding($str,"gb2312","UTF-8");
        $title="日期,评论数\n";
        $filename="评论统计.csv";
        $this->export_csv($title,$filename,$data);
    }
    
    /**
     * 评论管理
     */
    public function commentsettings(){
    	$uid   = $this->userId;   //uid
    	if (!$uid) {
    		$this->redirect('index');
    	}
    	$where['uid'] = $uid;
    	$commentsetModel = D('CommentSet');
    	$field = '*';
    	$commentset = $commentsetModel->getcommentsetinfo($field, $where);
        $this->assign("menuname","评论");//默认选中子导航
    	//接收数据，判断数据库中是否存在，进行更新或者新增操作
    	if (IS_POST) {
    		$is_filter    = I('is_filter',false,trim);
    		$is_self      = I('is_self',0,intval);
    		$filter_words = I('filter_words',false,trim);
    		$check_set    = I('check_set',false,trim);
    		if (!$is_filter) {
    			$is_filter = 1;
    		}else {
    			$is_filter = 0;
    		}
    		if (!$check_set) {
    			$check_set = 1;
    		}else {
    			$check_set = 0;
    		}
    		$data = array(
    			'is_filter'    => $is_filter,
    			'is_self'      => $is_self,
    			'filter_words' => $filter_words,
    			'check_set'    => $check_set
    		);
    		if ($commentset) {
    			$is_save = 1; //修改标识
    		}
    		$res = $commentsetModel->savecommentset($data, $uid, $is_save);
    		if ($res) {
        		if(C('IS_CACHE')){
                    $this->Memcache->updateCache();//更新缓存
                }
    			$this->redirect('commentsettings');
    		}
    	}else {	
	    	if (!$commentset) {
	    		$commentset = array(
	    			'uid'       => $uid,
	    			'is_filter' => 0,
	    			'is_self'   => 0,
	    			'check_set' => 0
	    		);
	    	}
	    	$this->assign('commentset',$commentset);
	    	$this->assign("title","留言设置");
	    	$this->assign('uid',$uid);
	    	$this->display('commentsetting');
    	}
    }
    
    /**
     * 用户管理
     */
    public function user(){
        $uid = $this->userId;
    	$p = I('p',1,intval);
    	$offset = C('PAGE_OFFSET'); 
    	$commentModel = D('Comment');
    	$userinfo = $commentModel->getids($uid);
    	$userids = array_slice($userinfo, ($p-1)*$offset,$offset);
    	foreach ($userids as $k => $v){
    		$where['uid'] = $v['uid'];
    		$order = 'commenttime desc';
    		$commentlist  = $commentModel->getcommentinfo($where,"comment_content",$order);
    		$userids[$k]['total'] = count($commentlist);
    		$userids[$k]['lastcomment'] = $commentlist[0]['comment_content'];
    	}
    	$parameter = array();
    	$total     = count($userinfo);
    	$Page      = $this->page($total,$parameter);
    	$show      = $Page->weishow();
    	
    	$this->assign("p",$p);
    	$this->assign("totalpage",$Page->totalPages);
    	$this->assign("page",$show);
    	$this->assign('total',$total);
    	$this->assign('userinfo',$userids);
        $this->assign("title" , "用户管理");
        $this->assign("menuname","评论");//默认选中子导航
        $this->display("user");
    }
    
    /**
     * 用户的评论
     */
    public function usercomments(){
    	$p = I('p',1,intval);
    	$offset = C('PAGE_OFFSET'); 
    	$uid = I('uid',false);
    	if (!uid) {
    		$this->error('用户信息非法');
    	}
    	$commentModel = D('Comment');
    	$where['uid'] = $uid;
    	$order = 'commenttime desc';
    	$commentlist  = $commentModel->getcommentinfo($where,"*",$order,$p,$offset);
    	$total = $commentModel->where($where)->count();
    	$commenttopicModel = D('Commenttopic');
    	if ($total > 0) {
	    	foreach ($commentlist as $k => $v){
	    		$sortinfo = $commenttopicModel->getsortbytid($commentlist[$k]['topicid']);
	    		$commentlist[$k]['sort'] = $sortinfo[0]['sortname'];
	    		$commentlist[$k]['sid']  = $sortinfo[0]['sid'];
	    	}
    	}
    	$parameter['uid'] = $uid;
    	$Page      = $this->page($total,$parameter);
    	$show      = $Page->weishow();
    	
    	$this->assign("p",$p);
    	$this->assign("totalpage",$Page->totalPages);
    	$this->assign("page",$show);
    	$this->assign('uid',$uid);
    	$this->assign('img',$commentlist[0][user_head]);
    	$this->assign('username',$commentlist[0]['user_name']);
    	$this->assign('commentlist',$commentlist);
    	$this->assign('total',$total);
    	$this->assign('title','用户评论记录');
        $this->assign("menuname","评论");//默认选中子导航
    	$this->display('usercomments');
    }
    
    /**
     * 设置评论置顶
     */
    public function commenttop(){
    	if (!IS_AJAX) {
    		$data = array('status'=>-1,'msg'=>'请求非法');
    	}else {
    		$comment_id = I('comment_id',0,intval);
    		$is_top = I('is_top',0,intval);
    		$it     = array(0,1);  //置顶取值范围
    		if (!$comment_id || !in_array($is_top, $it)) {
    			$data = array('status'=>-1,'msg'=>'参数非法');
    		}else{
    			$commentModel = D('Comment');
    			$res          = $commentModel->commenttop($comment_id,$is_top);
    			if ($res && $is_top == 0){
    				$data = array('status'=>1,'msg'=>'置顶取消成功');
	    		}elseif ($res && $is_top == 1){
	    			$data = array('status'=>2,'msg'=>'置顶成功');
	    		}else {
	    			$data = array('status'=>-1,'msg'=>'操作失败');
	    		}
    		}
    	}
    	$this->ajaxReturn($data);
    }
    
    
    


























//End Class
}