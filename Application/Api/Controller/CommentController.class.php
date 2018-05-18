<?php
namespace Api\Controller;

/**
 * 评论前台接口
 * 仿搜狐畅言功能
 * Enter description here ...
 * @author Administrator
 *
 */
class CommentController extends ApiBaseController{


    /**
     * 登录方法
     * Enter description here ...
     */
    public function login(){
		$name= I ( 'param.name');
		if (! $this->check_verify(trim( I ( 'param.code')))) {
    		$r=0;
    		$msg="验证码错误";
    	}else{
    		$r=1;
    		$msg="登陆成功";
    	}
    	$ret = array('status' => $r,'msg'=>$msg,'name'=>$name);
		$result=json_encode($ret);
		$callback=$_GET['callback'];
		echo $callback."($result)";
		exit;
	}
	
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
	
	/**
	 * 评论查询接口
	 * Enter description here ...
	 */
    public function exportcommentapp(){
		$insert_data = array();
		$articleid=  I ( 'param.articleid');//文章id
	
		if(!$articleid){
			$res["status"]="fail";
			$res["msg"]="文章id输入有误";
			$result=json_encode($res);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
		
		$where["articleid"]=array("eq",$articleid);
		$page=  I ( 'param.pagenum', 1 ,intval);
		$perpage= I ( 'param.pagesize', 20 ,intval);
		$starttime= I ( 'param.starttime', false);
		$endtime= I ( 'param.endtime', false);

		if($starttime){
			$where["create_time >="]=strtotime($starttime);
		}
		if($endtime){
			$where["create_time <="]=strtotime($endtime);
		}

			$model = D("Comment");
			$data = $model -> getCommentList($where,$page,$perpage);
			$count=$model->counthe($where);
		
		 
		if($data){
			$res["status"]="success";
			$res["msg"]="获取成功";
			$res["total"]=$count;
			$res["totalpage"]=ceil($count/$perpage);
			$res["currentpage"]=$page;
			$res["commentlist"]=$data;
			$result=json_encode($res);
			//动态执行回调函数
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;

		}else{
			$res["status"]="fail";
			$res["msg"]="获取失败";
			$result=json_encode($res);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
	}
	
    //修改评论
	public function upcommentapp(){
		$id= I ( 'param.id'); //评论id
		$comment= I ( 'param.comment');//内容
		$model=M("hudong_comment");
		$set["comment"]=$comment;
		$where["id"]=array("eq",$id);
		$model->where($where)->save($set);
		echo "1";
		exit;
	}
	//删除评论
	public function delcommentapp(){
		$id= I ( 'param.id'); //评论id
		$model=D("Comment");
		$where["id"]=array("eq",$id);
		$model->delete($where);
		echo "1";
		exit;
	}
	//批量添加评论回复
	public function pladdcomment(){
		
		$insert_data = array();
		$commentid= I ( 'param.commentid'); //评论id
		$articleid= I ( 'param.articleid');//文章id	
		$title= I ( 'param.title');//文章标题	
		$type= I ( 'param.type');//评论用户类型（1：登陆用户 2：匿名用户）	
		$uid= I ( 'param.uid');//评论用户
		$uname= I ( 'param.uname');//评论用户名称
		$fid=  I ( 'param.fid', 0 ,intval); 
		$fname=  I ( 'param.fname', 0 ,intval);
		$comment= I ( 'param.comment');
		
		$model=D("Comment");
		foreach($commentid as $key=>$value){
			$insert_data['commentid']=$value;
			$insert_data['articleid']=$articleid[$key];
			$insert_data['title']=$title[$key];
			$insert_data['type']=$type;
			$insert_data['uid']=$uid;
			$insert_data['uname']=$uname;
			$insert_data['uimg']="http://127.0.0.1/dulihudong/Public/commentapi/css/imgs/img_default.jpg";
			$insert_data['fid']=$fid[$key];
			$insert_data['fname']=$fname[$key];
			$insert_data['status']=1;
			$insert_data['commenttype']=999999;
			$insert_data['comment']=$comment;
			$insert_data['create_time']=time();
			$model->add($insert_data);
			
		}
		echo "1";
		exit;	
	}
	/*
	 * 生成验证码图片
	*/
	public function imgCode ()
	{
	    $config =    array(    'fontSize'    =>    30,    // 验证码字体大小    
	    						'length'      =>    4,     // 验证码位数    
	    						'useNoise'    =>    false, // 关闭验证码杂点
	                        );
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
	
	/*
	 * 默认用户头像
	 */
	public function img($url){
		if($url=="defalut"){
			return "http://127.0.0.1/dulihudong/Public/commentapi/css/imgs/img_default.jpg";
		}else{
		    return $url;
		}
	}
	/**
	 * 评论添加接口
	 */
	public function addcommentapp(){ 

		$insert_data = array();
		$id=  I ( 'param.commentid', 0 ,intval); //评论id
		if(!is_numeric($id ) || $id<0){
			$ret = array('status' => 'fail','msg'=>'评论id不正确');
			$result=json_encode($ret);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
		$insert_data['commentid'] =$id;
		
		$id= I ( 'param.articleid');//文章id
		if(!$id){
			$ret = array('status' => 'fail','msg'=>'文章id不正确');
			$result=json_encode($ret);
			//动态执行回调函数
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
		$insert_data['articleid'] =$id;
		
		$title=  I ( 'param.title');//文章标题
		if(!isset($title)){
			$ret = array('status' => 'fail','msg'=>'文章标题必填');
			$result=json_encode($ret);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
		$insert_data['title'] = $title;
		
		$type=  I ( 'param.type'); //评论用户类型（1：登陆用户 2：匿名用户）
		if(!isset($type) || !in_array($type,array(1,2)) ){
			$ret = array('status' => 'fail','msg'=>'用户类型输入有误');
			$result=json_encode($ret);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
		$insert_data['type'] = $type;
		
		$uid=I ( 'param.uid', -1 ,intval);//评论用户

		if($uid=="-1"){
			$ret = array('status' => 'fail','msg'=>'uid必填');
			$result=json_encode($ret);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}

		$insert_data['uid'] = $uid;
		
		$uname=  I ( 'param.uname'); //评论用户名称

		if(!isset($uname)){
			$ret = array('status' => 'fail','msg'=>'uname必填');
			$result=json_encode($ret);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
		$insert_data['uname'] = $uname;
		
		$uimg= I ( 'param.uimg');//评论用户头像
		if($uimg=="defalut"){
			$uimg=$this->img($uimg);
		}
		$insert_data['uimg']=$uimg;
		$insert_data['fid'] = I ( 'param.fid', 0 ,intval);//被评论用户
		$insert_data['fname'] = I ( 'param.fname');//被评论用户名称
		
		$fimg= I ( 'param.fimg'); //被评论用户头像
		$insert_data['fimg']=$fimg;
		$commenttype=  I ( 'param.commenttype');//评论类型
		if(!isset($commenttype)){
			$ret = array('status' => 'fail','msg'=>'评论类型必填');
			$result=json_encode($ret);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
		$insert_data['commenttype'] = $commenttype;
		$comment=  I ( 'param.comment');//评论内容
		$insert_data['comment'] =$comment;
		if(!isset($comment)){
			$ret = array('status' => 'fail','msg'=>'评论内容必填');
			$result=json_encode($ret);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
		
		$status= I ( 'param.status', 0 ,intval);//评论状态
		$insert_data['status'] =$status;

		
		$insert_data['create_time'] 	= time();//评论时间
		$articleurl= I ( 'param.articleurl');
		$insert_data["url"]=$articleurl;
		$ip=$_SERVER["REMOTE_ADDR"];
		$json=file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);
		$arr=json_decode($json);
		$country= $arr->data->country;	//国家
		$area=$arr->data->area;	//区域
		$region=$arr->data->region;	//省份
		$city=$arr->data->city;	//城市
		$isp =$arr->data->isp;	//运营商
		$insert_data['ip']=$country.$area.$region.$city.$isp;
		$model = D("Comment");
		$insert = $model -> addcomment($insert_data);
		
		//返回类型 默认jsonp
		$callbacktype= I ( 'param.callbacktype', "jsonp" ,string);
	
		if($insert){
// 			if( $insert_data['type'] =="2"){
// 				$where["id"]=$insert;
// 				$set["uid"]=$insert;
// 				$set["uname"]="匿名用户".$insert;
// 				$model->update($set,$where);
	
// 			}
		
			$ret = array('status' => 'success','msg'=>'评论成功,请等待审核' );
			$result=json_encode($ret);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			if($callbacktype == "jsonp"){
			echo $callback."($result)";
			}else{
				echo $result;
			}
			exit;
		}else{
			$ret = array('status' => 'fail','msg'=>'评论失败');
			$result=json_encode($ret);
			//动态执行回调函数	
			$callback=$_GET['callback'];
			echo $callback."($result)";
			exit;
		}
	}
	//分页
	public function page($current,$total){
		for($i=1;$i<=$total;$i++){
			//<a href="javascript:void(0)" class="wrap-current-e">1</a><a pagenum="2" href="javascript:void(0)">2</a><em class="wrap-ellipsis-w wrap-ellipsis-b"><i>...</i></em><a pagenum="131" href="javascript:void(0)">131</a>
			if($total<=7){
				if($current == $i){
					$pagenum.='<a href="javascript:void(0)" page="'.$i.'" class="wrap-current-e">'.$i.'</a>';
				}else{
					$pagenum.='<a href="javascript:void(0)" page="'.$i.'">'.$i.'</a>';
				}
			}else{
				$tag="1";//使用固定位置 标记
				if($i==1){
					if($current == $i){
						$first='<a href="javascript:void(0)" page="'.$i.'" class="wrap-current-e">'.$i.'</a>';
					}else{
						$first='<a href="javascript:void(0)" page="'.$i.'" >'.$i.'</a>';
					}
				}
				if($i==$total){
					if($current == $total){
						$last='<a href="javascript:void(0)" page="'.$i.'" class="wrap-current-e">'.$i.'</a>';
					}else{
						$last='<a href="javascript:void(0)" page="'.$i.'" >'.$i.'</a>';
					}
				}
	
			}
		}
		if($tag=="1"){
			$pagenum=$first;
			//循环位置 2-6位置 填充数据
			//当当前页面小于等于4时 显示 123456.8
			//当页面大于4时 显示 1.345.8
					//当前页面大于等于页面最大数-3时 显示 1.678910
			 if($current<=4){
					for($i=2;$i<=6;$i++){
						
							if($i==6){
								$pagenum.='<em class="wrap-ellipsis-w wrap-ellipsis-b"><i>...</i></em>';
							}else{
								if($current == $i){
									$pagenum.='<a href="javascript:void(0)" page="'.$i.'" class="wrap-current-e">'.$i.'</a>';
								}else{
									$pagenum.='<a href="javascript:void(0)" page="'.$i.'">'.$i.'</a>';
								}
							}
					}
				}
				if($current>4){
					$pagenum.='<em class="wrap-ellipsis-w wrap-ellipsis-b"><i>...</i></em>';
					$pagenum.='<a href="javascript:void(0)" page="'.($current-1).'" >'.($current-1).'</a>';
					$pagenum.='<a href="javascript:void(0)" page="'.$current.'" class="wrap-current-e">'.$current.'</a>';
					$pagenum.='<a href="javascript:void(0)" page="'.($current+1).'">'.($current+1).'</a>';
					if($current < $total-3){
						$pagenum.='<em class="wrap-ellipsis-w wrap-ellipsis-b"><i>...</i></em>';
					}else{
						$tag2=1;//当前页面大于等于页面最大数-3时 显示 1.678910
					}
				}
			}
			if($tag2==1){
				$pagenum=$first;
				$pagenum.='<em class="wrap-ellipsis-w wrap-ellipsis-b"><i>...</i></em>';
				for($i=($total-4);$i<=$total;$i++){
					if($current==$i){
					$pagenum.='<a href="javascript:void(0)" page="'.$i.'" class="wrap-current-e" >'.$i.'</a>';
					}else{
					$pagenum.='<a href="javascript:void(0)" page="'.$i.'" >'.$i.'</a>';
					}
				}
			}else{
				$pagenum.=$last;
			}
			if(($current-1) <1){
				$prev=1;
			}else{
				$prev=$current-1;
			}
			if(($current+1)>$total){
				$next=$total;
			}else{
				$next=$current+1;
			}
		if($total>1){
		$page=<<<aa
		   <div class="reset-g section-page-w">
		    <span class="page-wrap-gw"><a id="nextPage" href="javascript:void(0)" page="{$prev}" class="wrap-next-w wrap-next-b">上一页</a></span>
		    <span class="page-wrap-w page-wrap-b">{$pagenum}</span>
		    <span class="page-wrap-gw"><a id="nextPage" href="javascript:void(0)" page="{$next}" class="wrap-next-w wrap-next-b">下一页</a></span>
		   </div>
		
aa;
		}else{
			$page="";
		}
		return $page;
		
	}
	public function commentlist($where,$page,$perpage,$order,$sort){

		$model = D("Comment");
		$data = $model -> getCommentList($where,$page,$perpage,$order,$sort);
		$count=$model->counthe($where);
		if($data){
			$res["total"]=$count;
			$res["totalpage"]=ceil($count/$perpage);
			$res["page"]=$page;
			$res["commentlist"]=$data;	
		}
		return $res;
	}
	//回复框html
	public function replyhtml(){
		$replyhtml= <<<EOT
		<div class="wrap-reply-gw">
		<div node-type="cbox-wrapper" class="reset-g section-cbox-w">
		<div class="clear-g cbox-block-w">
		<div class="block-head-w">
		<div class="head-img-w"></div>
		<!---->
		</div>
		<div class="block-post-w block-post-default-e">
								          <div class="post-wrap-w post-wrap-b">
										          <div class="wrap-area-w">
										          <div class="area-textarea-w" style="position:relative;zoom:1;z-index:9;">
										          <textarea name="" class="textarea-fw textarea-bf" class="saytext" placeholder="来说两句吧..."></textarea>
										          </div>
										          </div>
										          <div class="clear-g wrap-action-w wrap-action-b">
										          <div class="action-function-w action-function-b relative-z-w">
										          <ul class="clear-g">
										          		<li class="function-face-w"><a href="javascript:void(0)" class="effect-w" title="表情"><i class="face-b"></i></a></li>
										              <li class="function-uploadimg-w"> <a href="javascript:void(0)" class="effect-w" title="上传图片"><i class="uploadimg-b"></i></a>
										              <div class="uploadimg-file-w">
										              <input class="file-fw" id="img_upload" name="file" type="file" accept="image/*" />
										              		</div>
										              				<div class="img-btn-cover" style="width:40px;height:40px;margin-top:-40px;z-index:-1;position: relative;"></div> </li>
								              <!--<li class="function-at-w"><a href="javascript:void(0)" class="effect-w"><i class="at-b"></i></a></li>-->
										              		</ul>
										              		</div>
										              		<div class="clear-g action-issue-w" buttontype="2"  id="data-id" uid="data-uid" uname="data-uname" uimg="data-uimg">
										              		<div class="issue-btn-w">
										              				<a href="javascript:void(0)"><button class="btn-fw btn-bf btn-fw-main" >发布</button></a>
										              				</div>
										              						</div>
										              						</div>
										              						</div>
										              						</div>
										              						</div>
										              						</div>
									              						</div>
EOT;
		
		return $replyhtml;
	}
	public function userreply($data){
		if(empty($data)){
			
			$html='<div style="width:100%;height:20px;text-align: center;margin-top: 100px;">您还没有收到过回复</div>';
		}else{
			$model=M("hudong_comment");
			foreach($data as $key=>$value){
				$where["id"]=array("eq",$value["commentid"]);
				$comment=$model->where($where)->find();
				if($value["status"] == 0){
					$s="未审核";
				}else{
					$s="已审核";
				}
				$html.=<<<EOT
				<div class="area-get-dw area-get-bd">
		<div cmtid="608445811" class="clear-g block-cont-gw block-cont-bg">
                                        <div class="cont-head-gw">
                                                                                        <div class="head-img-gw">
                                                <a href="javascript:void(0)"><img height="42" width="42" alt="" onerror="SOHUCS.isImgErr(this)" src="{$value["uimg"]}"></a>
                                            </div>
                                            </div>
                                        <div class="cont-msg-gw">
                                            <div class="msg-wrap-gw">
                                                <div class="wrap-user-gw"><span class="user-name-gw">{$value["uname"]}</span></div>
                                                <div class="wrap-issue-gw">
                                                    <p class="issue-wrap-gw"><span class="wrap-word-bg">{$value["comment"]}</span></p>
                                                </div>
                                                <!-- picture show  Begin -->
                                                <!-- picture show  End -->
                                                <div class="wrap-reply-from-dw">
                                                    <p class="reply-dw">回复我的评论<span>{$comment->comment}</span></p>
                                                    <p class="from-dw">来自：<span><a target="_blank" href="{$value["url"]}">“…”</a></span></p>
                                                </div>
                                                <div class="clear-g wrap-action-gw">
                                                    <div class="action-click-gw">
                                                        <i class="gap-gw"></i>
                                                        <span class="click-ding-gw" id="{$value["id"]}" style="position:relative"><a href="javascript:void(0)"><i class="icon-gw icon-ding-bg"></i><em class="icon-name-bg">{$value["top"]}</em></a></span>
                                                                                                                <i class="gap-gw gap-bg"></i>
                                                        <span class="click-cai-gw" id="{$value["id"]}" style="position:relative"><a href="javascript:void(0)"><i class="icon-gw icon-cai-bg"></i><em class="icon-name-bg">{$value["down"]}</em></a></span>
                                                        <i class="gap-gw"></i>
                                                        <span class="click-reply-gw click-reply-eg" uid="{$value["uid"]}" uname="{$value["uname"]}"  uimg="{$value["uimg"]}"  id="{$value["id"]}"><a href="javascript:void(0)">回复</a></span>
                                                        <i class="gap-gw"></i>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
				</div>
EOT;
			}
		
		}
		
		return $html;
		
	}
	public function usercomment($data){
		if(empty($data)){
			$html='<div style="width:100%;height:20px;text-align: center;margin-top: 100px;">您还没有发出过评论</div>';
		}else{
			foreach($data as $key=>$value){
				if($value["status"] == 0){
					$s="未审核";
				}else{
					$s="已审核";
				}
				$html.=<<<EOT
			<div class="area-emit-dw area-emit-bd">
			<div class="wrap-issue-gw">
			<p class="issue-wrap-gw"><span class="wrap-word-bg">{$value["comment"]}</span></p>
			</div>
			<!-- picture show  Begin -->
			<!-- picture show  End -->
			<div class="msg-time-address-dw msg-time-address-bd">
			<span class="time-bd">{$s}</span>，<span class="time-bd">{$this->formattime($value["create_time"])}</span>，<span class="address-bd">来自：<a target="_blank" href="{$value["url"]}">"{$value["title"]}"</a></span>
			</div>
			</div>
EOT;
			}
		
		}
		
		return $html;
	}
	//个人评论中心
	public function userpage($user){
		$model=D("Comment");
		//发出的所有评论 
		$where["uname"]=array("eq",$user);
		$data=$model->where($where)->order("id  desc")->select();
		$commentcount=count($data);
		//收到的回复都为审核通过的
		$where1["fname"]=array("eq",$user);
		$where1["status"]=array("eq",1);
		$data1=$model->where($where1)->order("id  desc")->select();
		$replycount=count($data1);
		
		$html=<<<EOT
                <div class="wrapper-cont-dw wrapper-cont-bd">
                    <div class="clear-g cont-head-dw cont-head-bd">
                        <div class="clear-g head-box-dw">
                            <div class="box-pic-dw box-pic-bd">
                                <img height="78" width="78" id="userpageimg" onerror="SOHUCS.isImgErr(this)" src="{$this->img("defalut")}" alt="">
                            </div>
                            <div title="{$user}" class="box-msg-dw">
                                <strong class="msg-name-dw global-substring">{$user}</strong>
                                <!--<span class="msg-address-dw msg-address-bd"></span>-->
                            </div>
                        </div>
                        <div class="head-number-dw">
                            <div class="number-close-dw"><a href="javascript:void(0)"></a></div>
                            <div class="number-block-dw">
                                <ul class="clear-g">
                                    <li><strong class="block-sum-dw">{$commentcount}</strong><span class="block-word-dw">评论</span></li>
                                    <li class="gap-dw"></li>
                                    <li><strong class="block-sum-dw">{$replycount}</strong><span class="block-word-dw">回复</span></li>
                                    <li class="gap-dw"></li>
                                    <li><strong node-type="fav-count" class="block-sum-dw">0</strong><span class="block-word-dw">收藏</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="cont-tab-dw cont-tab-new cont-tab-bd">
                        <div class="tab-name-dw tab-name-bd">
                            <ul class="clear-g">
                                <li class="name-current-e"><strong>发出的评论</strong></li>
                                <li><strong>收到的回复</strong></li>
                                <li><strong>我的收藏</strong></li>
                            </ul>
                        </div>
                        <div class="tab-cont-wrap-dw">
                            <!-- 发出评论内容  Begin -->
                            <div class="wrap-area-dw wrap-area-a" style="display: block;">
                                {$this->usercomment($data)}
                            
                             </div>
                            <!-- 发出的评论 内容  End -->
                            <!-- 收到的回复 内容  Begin -->
                            <div class="wrap-area-dw wrap-area-b" style="display: none;">
                                {$this->userreply($data1)}
                               </div>
                            <!-- 收到的回复 内容  End -->
                            <!-- 我的收藏  Begin -->
                            <div class="wrap-area-dw wrap-area-c" style="display: none;">                            
                                	<div style="width:100%;height:20px;text-align: center;margin-top: 100px;">您还没有收藏过文章</div>
            </div>
                            <!-- 我的收藏  End   -->
                        </div>
                    </div>
                    <div class="cont-service-dw cont-service-bd">
                        <span class="service-cont-dw service-cont-bd"></span>
                    </div>
                    
                    <!-- 用户升级提示 Begin -->
                    <!-- 用户升级提示 End -->
                    
                    <!-- 等级说明  Begin -->
                                <div class="cont-level-text-w" node-type="level-text">
                <div class="text-head-w clear-g">
                    <h4 class="head-name-w">等级说明</h4>
                    <div class="head-link-w"><a href="javascript:void(0)" node-type="hide-level-text">&lt;&lt;返回我的评论</a></div>
                </div>
                <ul class="text-title-w clear-g">
                    <li class="col-1-w">等级</li>
                    <li class="col-2-w">头衔</li>
                    <li class="col-3-w">评论数</li>
                    <li class="col-4-w">特权</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">1</li>
                    <li class="col-2-w">潜水</li>
                    <li class="col-3-w">0</li>
                    <li class="col-4-w">
                        无</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">2</li>
                    <li class="col-2-w">冒泡</li>
                    <li class="col-3-w">2</li>
                    <li class="col-4-w">
                        无</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">3</li>
                    <li class="col-2-w">吐槽</li>
                    <li class="col-3-w">40</li>
                    <li class="col-4-w">
                        无</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">4</li>
                    <li class="col-2-w">活跃</li>
                    <li class="col-3-w">100</li>
                    <li class="col-4-w">
                        评论加粗</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">5</li>
                    <li class="col-2-w">话唠</li>
                    <li class="col-3-w">500</li>
                    <li class="col-4-w">
                        评论加粗</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">6</li>
                    <li class="col-2-w">畅言</li>
                    <li class="col-3-w">2000</li>
                    <li class="col-4-w">
                        评论加粗</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">7</li>
                    <li class="col-2-w">专家</li>
                    <li class="col-3-w">6000</li>
                    <li class="col-4-w">
                        评论加粗</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">8</li>
                    <li class="col-2-w">大师</li>
                    <li class="col-3-w">10000</li>
                    <li class="col-4-w">
                        炫彩评论 + 评论加粗</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">9</li>
                    <li class="col-2-w">传说</li>
                    <li class="col-3-w">15000</li>
                    <li class="col-4-w">
                        炫彩评论 + 评论加粗</li>
                </ul>
                                <ul class="text-kinds-w">
                    <li class="col-1-w">10</li>
                    <li class="col-2-w">神话</li>
                    <li class="col-3-w">30000</li>
                    <li class="col-4-w">
                        炫彩评论 + 评论加粗</li>
                </ul>
                </div>
        
                    <!-- 等级说明  End -->
                    
                    <!-- 收藏提示  Begin  -->
                    <div style="display: none;" class="cont-collect-gw" node-type="fav-prompt-wrapper">
                        <div class="collect-bg-gw"></div>
                        <div class="collect-btn-gw"><a href="javascript:;"></a></div>
                    </div>
                    <!-- 收藏提示  End    -->
                </div>

		
EOT;
		$ret = array('status' => 'success','msg'=>$html);
		$result=json_encode($ret);
		$callback=$_GET['callback'];
		echo $callback."($result)";
		exit;
		
	}
	//游客登陆框
	public function guestlogin(){
		$html=<<<EOT
			 <div style="display: none; z-index: 1999; outline: 0px none; height: auto; width: 400px; top: 100px; left: 260px;" id="guestlogin" class="sohucs-ui-dialog sohucs-ui-widget sohucs-ui-widget-content sohucs-ui-corner-all reset-g windows-define-dg visitor-login-wrapper-dw" tabindex="-1" role="dialog" aria-labelledby="sohucs-ui-dialog-title-sohu_dialog_visitorLogin">
   <div class="clear-g cont-title-dw cont-title-bd sohucs-ui-dialog-titlebar sohucs-ui-widget-header sohucs-ui-corner-all sohucs-ui-helper-clearfix">
    <span class="title-close-dw sohu-comment-windows-title-close sohucs-ui-dialog-titlebar-close sohucs-ui-corner-all" role="button"><a href="javascript:void(0)" class="sohucs-ui-icon sohucs-ui-icon-closethick"></a></span>
    <strong class="title-name-dw title-name-bd" id="sohucs-ui-dialog-title-sohu_dialog_visitorLogin">游客</strong>
   </div>
   <div style="min-height: 0px; width: auto; height: 203px;" id="sohu_dialog_visitorLogin" class="sohucs-ui-dialog-content sohucs-ui-widget-content" scrolltop="0" scrollleft="0">
    <div>
     <div class="clear-g cont-form-dw">
      <span class="form-name-dw form-name-bd">昵称</span>
      <div class="clear-g form-action-dw ">
       <input type="text" id="guestname" name="" value="" class="action-text-dfw action-text-bdf" />
      </div>
     </div>
     <div class="clear-g cont-verify-dw">
      <span class="verify-name-dw verify-name-bd">验证码</span>
      <div class="clear-g verify-action-dw">
       <input type="text" id="guestcode" name="" value="" class="verify_container action-text-dfw action-text-bdf" maxlength="4" size="4" />
       <span class="action-img-dw"><img height="25" width="100" id="imgcode" src="http://hudong.com/commentapi/imgcode" alt="" style="width:100px;" /></span>
       <span class="action-link-dw action-link-bd"><a data-rel="change" href="javascript:void(0)">换一换</a></span>
      </div>
     </div>
     <div class="cont-prompt-dw">
      <span class="prompt-word-bd">
       <!--不能超过20字符--></span>
     </div>
     <div style="padding-bottom:20px" class="cont-btn-dw">
      <a href="javascript:void(0)"><button data-rel="button" class="btn-dfw btn-bdf"></button></a>
     </div>
    </div>
   </div>
  </div>
	
		
EOT;
		return $html;
	}
	
	//嵌套回复框
	public function floor($data,$tar=0){
		global $index;
		$index=1;
		if($data["commentid"] ==0){
			$a="";
		}else{
		$model = M("hudong_comment");
		$where["id"]=array("eq",$data["commentid"]);
		$parentdata = $model->where($where)->select();

		$a .= <<<EOT
	
		<div class="build-floor-gw block-cont-hover-e">
				{$this->floor($parentdata[0],1)}
		<!--div class="build-floor-gw"-->
		<div floornum="1" cmtid="592913532" class="build-msg-gw borderbot">
				<div class="wrap-user-gw global-clear-spacing">
			      <span class="user-time-gw user-time-bg user-floor-gw">{$index}</span>
					      		<span class="user-name-gw"><a uid="214411996" title="不分春夏秋冬" commhref="javascript:void(0)" href="javascript:void(0)">{$parentdata[0]["uname"]}</a></span>
					      		<span class="user-address-gw">[<i>{$parentdata[0]["ip"]}</i>网友]</span>
					      		</div>
					      		<!--div class="wrap-hidden-gw wrap-hidden-bg"><a href="#">评论已被折叠，查看请点击。</a></div-->
					      		<div class="wrap-issue-gw">
					      				<p class="issue-wrap-gw"> <span class="wrap-word-bg ">{$parentdata[0]["comment"]}</span> </p>
					      				</div>
					      				<!-- picture show  Begin -->
					      				<!-- picture show  End -->
					      				<div style="visibility: hidden;" class="clear-g wrap-action-gw evt-active-wrapper" >
					      				<div class="action-click-gw">
					      				<i class="gap-gw"></i>
					      				<span class="click-ding-gw"  id="{$parentdata[0]["id"]}" style="postion:relative"><a class="evt-support" title="顶" href="javascript:void(0)"><i class="icon-gw icon-ding-bg" ></i><em class="icon-name-bg">{$parentdata[0]["top"]}</em></a></span>
					      				<i class="gap-gw"></i>
					      				<span class="click-cai-gw"  id="{$parentdata[0]["id"]}" style="postion:relative"><a class="evt-opposed" title="踩" href="javascript:void(0)"><i class="icon-gw icon-cai-bg"></i><em class="icon-name-bg">{$parentdata[0]["down"]}</em></a></span>
					      				<i class="gap-gw"></i>
					      				<span class="click-reply-gw click-reply-eg"  uid="{$parentdata[0]["uid"]}" uname="{$parentdata[0]["uname"]}"  uimg="{$parentdata[0]["uimg"]}"  id="{$parentdata[0]["id"]}"><a class="evt-reply" href="javascript:void(0)">回复</a></span>
					      						<i class="gap-gw"></i>
					      						<span class="click-share-gw click-reply-eg"><a class="evt-share" href="javascript:void(0)">分享</a></span>
					      						</div>
			      					<div class="action-from-gw action-from-bg"></div>
					      </div>
					      		<!-- reply area  Begin -->
					      			
					      		<!-- reply area  End -->
					      		</div>
					    <!--/div-->
					   </div>
					
		
EOT;
			$index++;
		}
	
		return $a;
	} 
	//格式化时间
	public function formattime($time){
		$now=time();
		$t=$now-$time;
		switch($t)
		{
			case $t<0.5*3600:
				 $name = '刚刚';
				break;
			case $t<1*3600:
				 $name = '小于1小时';
				break;
			default:
				$name = date("Y年m月d日 H:i",$time);
		}
		return $name;
	}
	//单条评论框html
	public function datalist($data){
		$datastr= <<<EOT
		<div cmtid="594456699" cmtnum="0" datatype="time" class="clear-g block-cont-gw block-cont-bg">
		<div class="cont-head-gw">
		<div class="head-img-gw">
		<a commhref="javascript:void(0)" href="javascript:void(0)"><img width="42" height="42" uid="214597564" alt="" onerror="SOHUCS.isImgErr(this)" src="{$this->img($data["uimg"])}" /></a>
		</div>
		</div>
		<div class="cont-msg-gw">
		<div class="msg-wrap-gw">
		<div class="wrap-user-gw global-clear-spacing">
		<span class="user-time-gw user-time-bg evt-time">{$this->formattime($data["create_time"])}</span>
		<span title="{$data["uname"]}" class="user-name-gw"><a uid="214597564" commhref="javascript:void(0)" href="javascript:void(0)">{$data["uname"]}</a></span>
		<!-- 管理员、铭牌图标 -->
		<!-- 管理员、铭牌图标 END -->
		<span class="user-address-gw">[<i>{$data["ip"]}</i>网友]</span>
      </div>
			<!--盖楼-->
			<div class="wrap-build-gw" >
EOT;

		$datastr.=$this->floor($data,0);
		$datastr.= <<<EOT
		  </div>
		   <!--盖楼end-->
				
		<div class="wrap-issue-gw">
		     <p class="issue-wrap-gw"><span class="wrap-word-bg ">{$data["comment"]}</span></p>
      </div>
		      <div class="clear-g wrap-action-gw">
		      <div class="action-click-gw" >
		      <i class="gap-gw"></i>
		        <span class="click-ding-gw" id="{$data["id"]}" style="position:relative"><a class="evt-support" title="顶" href="javascript:void(0)"><i class="icon-gw icon-ding-bg" ></i><em class="icon-name-bg">{$data["top"]}</em></a></span>
		        <i class="gap-gw"></i>
		        <span class="click-cai-gw" id="{$data["id"]}" style="position:relative"><a class="evt-opposed" title="踩" href="javascript:void(0)"><i class="icon-gw icon-cai-bg" ></i><em class="icon-name-bg">{$data["down"]}</em></a></span>
		        <i class="gap-gw"></i>
		        <span class="click-reply-gw click-reply-eg" uid="{$data["uid"]}" uname="{$data["uname"]}" uimg="{$data["uimg"]}"  id="{$data["id"]}" ><a class="evt-reply" href="javascript:void(0)">回复</a></span>
		        		<i class="gap-gw"></i>
		        		<span class="click-share-gw click-reply-eg"><a class="evt-share" href="javascript:void(0)">分享</a></span>
		        				</div>
       <div class="action-from-gw action-from-bg">
		       </div>
      </div>
 		<!-- 回复框 -->
		 		<!-- 回复框 -->
		 		</div>
		 		</div>
		   </div>
EOT;

		
		return $datastr;
	}
	
	//所有html
	public function commenthtml(){
		$p= I ( 'param.p', 1 ,intval);
		//默认一页显示5条
		$perpage= I ( 'param.perpage', 5 ,intval);
		$datawidth= I ( 'param.datawidth');
		$articleid= I ( 'param.articleid');
		$where["status"]=array("eq",1);
		$where["articleid"]=array("eq",$articleid);
		$data=$this->commentlist($where,$p,$perpage,"id","desc");
		
		$totalpage= I ( 'param.totalpage', -1 ,intval);
		if($totalpage == "-1"){
			//默认显示全部页数
			$totalpage=$data["totalpage"];
		}else{
			$totalpage=$data["totalpage"]>=$totalpage?$totalpage:$data["totalpage"];
		}
		if(empty($data["commentlist"])){
			$datalist= <<<EOT
			<!--没有评论时显示如下代码-->
			<div class="list-comment-empty-w">
			<div class="empty-prompt-w">
			<span class="prompt-null-w prompt-null-b">还没有评论，快来抢沙发吧！</span>
			</div>
			</div>
EOT;
		}else{
			foreach($data["commentlist"] as $key=>$value){
				$dataliststr.=$this->datalist($value);			
			}
			$datalist= <<<EOT
			<!--有评论时显示如下代码-->
			  <div class="list-block-gw list-newest-w list-newest-b"> 
			   <div class="block-title-gw"> 
			    <ul class="clear-g"> 
			     <li><strong class="title-name-gw title-name-bg">最新评论</strong></li> 
			    </ul> 
			   </div> 
				{$dataliststr}
			  </div> 			
EOT;
		}
	
		$msg= <<<EOT
		<div id="SOHUCS" style="width:{$datawidth};">
				<div id="SOHU_MAIN">
					<div class="sohu-comment-wrapper" id="SOHU-comment-main">
						<div id="article_info_sohu">
							<div class="reset-g clear-g section-title-w  section-title-logoutStyle">
								<div class="title-join-w">
									<div class="join-wrap-w join-wrap-b">
										<strong class="wrap-name-w wrap-name-b">评论</strong><span class="wrap-join-w wrap-join-b">(<em class="join-strong-gw join-strong-bg countjoin">0</em>人参与<i class="gap-b">，</i><em class="join-strong-gw join-strong-bg countcomment">0</em>条评论)</span>
									</div>
								</div>
								<div class="title-user-w" style="display:none">
									<!--登录后显示如下代码-->
		                            <div class="clear-g user-wrap-w user-wrap-b" ><span class="wrap-name-w wrap-name-b">似水柔情</span><span class="wrap-icon-w wrap-icon-b"></span>
		                                <div class="wrap-menu-dw wrap-menu-bd">
		                                    <div class="menu-box-dw menu-box-bd">
		                                        <a href="javascript:void(0)" id="userinfo"><i class="gap-dgw">我的畅言</i></a>
		                                        <!--<a class="menu-box-bd-gold" href="javascript:void(0)"><i class="gap-dgw">我的金币</i></a>-->
		                                        <a href="javascript:void(0)" class="menu-box-dw-quit"><i class="gap-dgw gap-bdg">退出</i></a>
		                                    </div>
		                                </div>
		                            </div>
		                            <div class="title-link-w" node-type="sohu-pact" style="display: none;">
										<a target="_blank" href="http://zt.pinglun.sohu.com/s2014/sljyhgy/index.shtml">搜狐“我来说两句”用户公约</a>
									</div>
								</div>
							</div>
						</div>
						<div id="login_sohu"></div>
						<div id="comment_sohu">
							<div class="reset-g section-cbox-w" node-type="cbox-wrapper">
								<div style="width:1px;height:1px;overflow:hidden;"><img style="visibility:hidden;width:1px;height:1px;" src="http://changyan.itc.cn/v2/asset/scs/imgs/vcode.jpg"></div>
								<div class="clear-g cbox-block-w">
									<div class="block-head-w">
										<div class="head-img-w"><a target="_self" href="javascript:void(0)" node-type="user-avatar"><img width="42" height="42" alt="" onerror="SOHUCS.isImgErr(this)" id="comment_uimg" src="{$this->img("defalut")}"></a></div>
										<!-- <div class="head-gold-w"><a href="javascript:void(0)">金币</a></div>
										-->
									</div>
									<div class="block-post-w block-post-default-e">
										<div class="post-wrap-w post-wrap-b">
											<div class="wrap-area-w">
												<div style="position:relative;zoom:1;z-index:9;" class="area-textarea-w">
													<textarea class="textarea-fw textarea-bf" placeholder="来说两句吧..." name="" id="saytext" name="saytext"></textarea>
												</div>
											</div>
											<div class="clear-g wrap-action-w wrap-action-b">
												<div class="action-function-w action-function-b relative-z-w">
													<ul class="clear-g">
														<li class="function-face-w"><a title="表情" class="effect-w" href="javascript:void(0)"><i class="face-b"></i></a></li>
														<li class="function-uploadimg-w">
															<a title="上传图片" class="effect-w" href="javascript:void(0)"><i class="uploadimg-b"></i></a>
															<div class="uploadimg-file-w">
																<input type="file" accept="image/*" name="file" id="img_upload" class="file-fw">
															</div>
															<div style="width:40px;height:40px;margin-top:-40px;z-index:-1;position: relative;"
															class="img-btn-cover"></div>
														</li>
														<!--<li class="function-at-w"><a href="javascript:void(0)" class="effect-w"><i class="at-b"></i></a></li>-->
													</ul>
												</div>
												<div class="clear-g action-issue-w" id="0" buttontype="1">
													<div class="issue-btn-w"><a href="javascript:void(0)"><button class="btn-fw btn-bf btn-fw-main">发布</button></a></div>
												</div>
											</div>
										</div>
										<div class="post-login-w" node-type="login-list">
											<ul class="clear-g">
												<li style="display:block">
													<div class="login-wrap-w login-wrap-b">
														<a alt="新浪微博" title="新浪微博" href="javascript:;" target="_self" data-key="sina">
															<span class="wrap-icon-w icon30-sina-b"></span><span class="wrap-name-w wrap-name-b">微博登录</span>
														</a>
													</div>
												</li>
												<li style="display:block">
													<div class="login-wrap-w login-wrap-b">
														<a alt="QQ" title="QQ" href="javascript:;" target="_self" data-key="qq">
															<span class="wrap-icon-w icon30-qq-b"></span><span class="wrap-name-w wrap-name-b">QQ登录</span>
														</a>
													</div>
												</li>
												<li>
													<div class="login-wrap-w login-wrap-b login-wrap-visitor-b">
														<a href="javascript:void(0)" target="_self" data-key="visitor">
															<span class="wrap-icon-w icon30-visitor-b"></span><span class="wrap-name-w wrap-name-b">游客</span>
														</a>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<div style="display: none;" class="cbox-prompt-w" node-type="prompt-no-privilege">
									<span class="prompt-empty-w prompt-empty-b">等级不够，发表评论升至指定级别才能获得该特权。详情请参见<a href="javascript:;" node-type="privilege-intro">等级说明</a>。</span>
								</div>
							</div>
						</div>
						<div id="list_sort_sohu">
						</div>
						<!--评论-->
						<div id="list_sohu" topicid="461090316">
									<div class="reset-g section-list-w">
										{$datalist}
									</div>
						</div>
						<!--评论-->
						<div id="page_sohu">
						{$this->page($p,$totalpage)}
						</div>
						<div id="more_list_sohu">
						</div>
					</div>
				</div>
			</div>
		{$this->guestlogin()}	
	<div id="user_page" class="reset-g windows-define-dg user-msg-wrapper-dw" style="top: 10px; left: 461.5px;"></div>
	<div class="bdsharebuttonbox" style="display:none">
   <a href="#" class="bds_more" data-cmd="more">分享到：</a>
   <a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone">QQ空间</a>
   <a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina">新浪微博</a>
   <a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq">腾讯微博</a>
   <a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren">人人网</a>
   <a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin">微信</a>
  </div> 
EOT;

		$replyhtml=$this->replyhtml();
		$countjoin=$this->countjoin($articleid);
		$countcomment=$this->countcomment($articleid);
		$imgurl=$this->img("defalut");
		$ret = array('status' => 'success','msg'=>$msg,'replyhtml'=>$replyhtml,"imgurl"=>$imgurl,"countjoin"=>$countjoin,"countcomment"=>$countcomment);
		$result=json_encode($ret);
		$callback=$_GET['callback'];
		echo $callback."($result)";
		exit;
	}
	//只返回评论部分 点击分页时
	public function commentlisthtml(){
		$p= I ( 'param.p', 1 ,intval);
		//默认一页显示5条
		$perpage= I ( 'param.perpage', 5 ,intval); 
		
		$articleid= I ( 'param.articleid'); 
		$where["status"]=array("eq",1);
		$where["articleid"]=array("eq",$articleid);
		$data=$this->commentlist($where,$p,$perpage,"id","desc");
		$totalpage=  I ( 'param.totalpage', -1 ,intval);
		if($totalpage == "-1"){
			//默认显示全部页数
			$totalpage=$data["totalpage"];
		}else{
			$totalpage=$data["totalpage"]>=$totalpage?$totalpage:$data["totalpage"];
		}
		
		if(empty($data["commentlist"])){
			$datalist="";
		}else{
			foreach($data["commentlist"] as $key=>$value){
				$dataliststr.=$this->datalist($value);
			}
			$datalist= <<<EOT
			<!--有评论时显示如下代码-->
			  <div class="list-block-gw list-newest-w list-newest-b">
			   <div class="block-title-gw">
			    <ul class="clear-g">
			     <li><strong class="title-name-gw title-name-bg">最新评论</strong></li>
			    </ul>
			   </div>
				{$dataliststr}
			  </div>
EOT;
		}
		$msg=<<<EOT
		<!--评论-->
	
		<div class="reset-g section-list-w">
		{$datalist}
		</div>

		<!--评论-->
EOT;
		
		$pagebar=$this->page($p,$totalpage);
		$countjoin=$this->countjoin($articleid);
		$countcomment=$this->countcomment($articleid);
		$ret = array('status' => 'success','msg'=>$msg,"pagebar"=>$pagebar,"countjoin"=>$countjoin,"countcomment"=>$countcomment);
		$result=json_encode($ret);
		$callback=$_GET['callback'];
		echo $callback."($result)";
		exit;
	}
	//参与人数
	public function countjoin($articleid){
		$model=M("hudong_comment");
		$where["articleid"]=array("eq",$articleid);
		$where["status"]=array("eq",1);
		//$select[]="sum(top) as a";
		//$select[]="sum(down) as b";
		$top=$model->where($where)->sum("top");
		$down=$model->where($where)->sum("down");
		return $top+$down;
	}
	//评论人数
	public function countcomment($articleid){
		$model=D("Comment");
		$where["articleid"]=array("eq",$articleid);
		$where["status"]=array("eq",1);
		return  $model->counthe($where);
	}
	//顶评论
    public function topcomment(){
    	$id=  I ( 'param.id');
    	$articleid= I ( 'param.articleid');
    	$model=M("hudong_comment");
    	//$data=$model->where(array("id"=>array("eq"=>$id)))->field("top")->find();
    	//$set=array("top"=>$data["top"]+1);
    	$where["id"]=array("eq",$id);
    	$model->where($where)->setInc("top");
    	$countcomment=$this->countcomment($articleid);
    	$countjoin=$this->countjoin($articleid);
    	$ret = array('status' => 'success',"countjoin"=>$countjoin,"countcomment"=>$countcomment);
    	$result=json_encode($ret);
    	$callback=$_GET['callback'];
    	echo $callback."($result)";
    	exit;
    }
    //踩评论
    public function downcomment(){
    	$id= I ( 'param.id');
    	$model=M("hudong_comment");
    	$articleid= I ( 'param.articleid');
    	//$data=$model->where(array("id"=>array("eq"=>$id)))->field("down")->find();
    	//$set=array("down"=>$data["down"]+1);
    	$where["id"]=array("eq",$id);
    	$model->where($where)->setInc("down");
    	$countcomment=$this->countcomment($articleid);
    	$countjoin=$this->countjoin($articleid);
    	$ret = array('status' => 'success',"countjoin"=>$countjoin,"countcomment"=>$countcomment);
    	$result=json_encode($ret);
    	$callback=$_GET['callback'];
    	echo $callback."($result)";
    	exit;
    }
    

































//End Class
}