//写cookies
function setCookie(name,value,time)
{
    var Days = time;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

//读取cookies
function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
 
    if(arr=document.cookie.match(reg))
 
        return unescape(arr[2]);
    else
        return null;
}

//删除cookies
function delCookie(name)
{
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval=getCookie(name);
    if(cval!=null)
        document.cookie= name + "="+cval+";expires="+exp.toGMTString();
} 
var loadfile = {
    css: function(path){
		if(!path || path.length === 0){
			throw new Error('css引用失败!');
		}
		var head = document.getElementsByTagName('head')[0] || document.head || document.documentElement ;
        var link = document.createElement('link');
        link.href = path;
        link.rel = 'stylesheet';
        link.type = 'text/css';
        head.appendChild(link);
    },
    js: function(path){
		if(!path || path.length === 0){
			throw new Error('js引用失败!');
		}
		var head = document.getElementsByTagName('head')[0] || document.head || document.documentElement;
        var script = document.createElement('script');
        script.src = path;
        script.type = 'text/javascript';
        head.appendChild(script);
    }
}
loadfile.css("http://"+dataurl+"/Public/commentapi/css/changyan2-floatCbox.css");
loadfile.css("http://"+dataurl+"/Public/commentapi/css/changyan2-floatCbox-frame.css");
loadfile.css("http://"+dataurl+"/Public/commentapi/css/changyan2.css");
loadfile.css("http://"+dataurl+"/Public/commentapi/css/default.css");


var uid="";//用户id
var uname="";//用户名
var uimg="";
var user_type=""; //用户类型 登陆用户1 匿名用户2

//setCookie("comment_uid","1");
//setCookie("comment_uname","abc");
//setCookie("comment_uimg","http://hudong.com/images/1.jpg");
//setCookie("comment_usertype","1");
//游客登陆保存cookie
function comment_login(uid,uname,uimg,utype,time){
	setCookie("comment_uid",uid,time); 
	setCookie("comment_uname",uname,time); 
	setCookie("comment_uimg",uimg,time); 
	setCookie("comment_usertype",utype,time); //游客登陆 用户id 都为0
}
//判断用户是否登陆
function login_user(){
	uid=getCookie("comment_uid");
    uname=getCookie("comment_uname");
	uimg=encodeURIComponent(encodeURIComponent(getCookie("comment_uimg")));
	user_type=getCookie("comment_usertype");
	if(uid !="" && uid != null){	
		return true;
	}else{
		alert("请先登陆");
		return false;
	}
	
}

function changeloginstatus(){
	uid=getCookie("comment_uid");
    uname=getCookie("comment_uname");                                                                        
	uimg=getCookie("comment_uimg");
	user_type=getCookie("comment_usertype");
	//如果uid不为null 则已登陆
	if(uid != null){
		$("#guestlogin").hide();//登陆窗口隐藏
		$(".sohucs-ui-widget-overlay").css("display","none");//遮挡层关闭
		
		$(".title-user-w").show();
		$(".title-user-w .user-wrap-w span.wrap-name-b").html(uname);
		
		$(".post-login-w ul.clear-g").hide();
		if(uimg !="defalut"){
			$("#comment_uimg").attr("src",uimg);
		}
	}
}

//游客登出
function logout(){
	delCookie("comment_uid");
	delCookie("comment_uname");
	delCookie("comment_uimg");
	delCookie("comment_usertype");
	
	$(".title-user-w").hide();
	$(".title-user-w .user-wrap-w span.wrap-name-b").html("");
	
	$(".post-login-w ul.clear-g").show();
	
	$("#comment_uimg").attr("src",imgurl);
	
	$("#user_page").html();
	  if(logout_f && typeof(logout_f) == "function"){
                logout_f();
        }
}

var replyhtml="";//回复框字符串
var imgurl="";//默认头像
var	url  ='http://'+dataurl+'/index.php/Api/Comment/commenthtml/p/1';
//url+='/perpage/'+perpage;
//url+='/totalpage/'+totalpage;
//url+='/datawidth/'+encodeURIComponent(datawidth);
//url+='/articleid/'+articleid;
url+='/perpage/5';
url+='/totalpage/-1';
url+='/datawidth/500';
url+='/articleid/1';
//点击分页 获取内容
function getcomment(page){
	var	url  ='http://'+dataurl+'/index.php/Api/Comment/commentlisthtml/p/'+page;
	//url+='/perpage/'+perpage;
	//url+='/totalpage/'+totalpage;
	//url+='/articleid/'+articleid;
	url+='/perpage/5';
	url+='/totalpage/-1';
	url+='/articleid/1';
	//获取页面内容
	$.ajax({ 
		type : "get", 
		async:false, 
		url :url,
		dataType : "jsonp", 
		success : function(json){ 
			document.getElementById("list_sohu").innerHTML=json.msg;
			document.getElementById("page_sohu").innerHTML=json.pagebar;
		},
		error:function(){ 
			alert("页面超时!请刷新！");
		} 
	}); 
}
//查看个人评论信息
function userpage(username){
	if(username ==""){
		alert("用户参数有误");
		return false;
	}
	uimg=getCookie("comment_uimg");
	var	url  ='http://'+dataurl+'/index.php/Api/Comment/userpage/user/'+username;
	//获取页面内容
	$.ajax({ 
		type : "get", 
		async:false, 
		url :url,
		dataType : "jsonp", 
		success : function(json){ 
			document.getElementById("user_page").innerHTML=json.msg;
			if(uimg !="defalut"){
				$("#userpageimg").attr("src",uimg);
			}
		},
		error:function(){ 
			alert("页面超时!请刷新！");
		} 
	}); 
}
//查看结果
function replace_em(str){
	//alert(str);
	str = str.replace(/\</g,'&lt;');
	str = str.replace(/\>/g,'&gt;');
	str = str.replace(/\n/g,'<br/>');
	str = str.replace(/\[em_([0-9]*)\]/g,'<img src="http://'+dataurl+'/Public/commentapi//qq/arclist/$1.gif" border="0" />');
	return str;
}
$(document).ready(function(){
	//获取页面内容
	$.ajax({ 
		type : "get", 
		async:false, 
		url :url,
		dataType : "jsonp", 
		success : function(json){
			document.getElementById("pinglun_content").innerHTML=json.msg;
			window._bd_share_config={
					"common":{"bdSnsKey":{},"bdText":title,"bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},
					"share":{"bdSize":16}
					};
			with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];

			$(".countjoin").html(json.countjoin);
			$(".countcomment").html(json.countcomment);
			var h=parseInt($("#SOHUCS").css("height"))+10;
			$(".sohucs-ui-widget-overlay").css("width",$("body").css("width"));
			$(".sohucs-ui-widget-overlay").css("height",h+"px");
			$(".sohucs-ui-widget-overlay").css("background-color","black");
			$(".sohucs-ui-widget-overlay").css("display","none");
			changeloginstatus();
			imgurl=json.imgurl;
			replyhtml=json.replyhtml;
			
			$('li.function-face-w').qqFace({
				id : 'facebox', 
				assign:'saytext', 
				path:'http://'+dataurl+'/Public/commentapi/qq/arclist/'	//表情存放的路径
			});
			
			
			//分享
			$("span.click-share-gw").delegate("a","click",function(event){
				 var left = parseInt($(this).offset().left) - 340,
	             top = parseInt($(this).offset().top) -30;
				$(".bdsharebuttonbox").css({
			             'position': 'absolute',
			             'z-index': '1',
			             'font-size':'12px',
			             'color': '#C30',
			            'left': left + 'px',
			             'top': top + 'px'
			             });
				$(".bdsharebuttonbox").show();
				event.stopPropagation();
			})
			
		},
		error:function(){ 
			alert("页面超时!请刷新！");
		} 
	}); 


	//分页
	$("#page_sohu a").live("click",function(){
		var p=$(this).attr("page");
		getcomment(p);	
	})

	$(".build-msg-gw").live("mouseover",function(){
		$(this).find(".evt-active-wrapper").css("visibility","visible");	
	})
	$(".build-msg-gw").live("mouseout",function(){
		$(this).find(".evt-active-wrapper").css("visibility","hidden");	
	})
	
	//游客登陆框
	$(".login-wrap-visitor-b").live("click",function(){
		$(".sohucs-ui-widget-overlay").css("display","block");
		$("#guestlogin").show();
		$("#imgcode").attr("src","http://"+dataurl+"/index.php/Api/Comment/imgcode?"+Math.random());	
		
	})
	//关闭
	$(".sohu-comment-windows-title-close").live("click",function(){
		$(".sohucs-ui-widget-overlay").css("display","none");
		$("#guestlogin").hide();
		
	})
	//点击更换验证码
	$(".action-link-bd").live("click",function(){
		$("#imgcode").attr("src","http://"+dataurl+"/index.php/Api/Comment/imgcode?"+Math.random());	
	})
	//个人中心
	$("#userinfo").live("click",function(){
		var username=$(this).parent().parent().parent().find("span.wrap-name-b").html();
		userpage(username);
	})
	//个人中心 关闭
	$(".number-close-dw").live("click",function(){
		$("#user_page").html("");	
	})
	//个人中心 切换
	$("div.tab-name-bd ul li").live("click",function(i){
		var arr=[];
		arr[0]="a";
		arr[1]="b";
		arr[2]="c";
		var div=".wrap-area-"+arr[$(this).index()];
		$(this).siblings().removeClass("name-current-e");
		$(this).addClass("name-current-e");
		$(".wrap-area-dw").hide();
		$(div).show();
	})
	//游客登陆按钮
	$(".btn-dfw").live("click",function(){
		var name=$("#guestname").val();
		var code=$("#guestcode").val();
		var url  ='http://'+dataurl+'/index.php/Api/Comment/login/name/'+name+'/code/'+code;
		//获取页面内容
		$.ajax({ 
			type : "get", 
			async:false, 
			url :url,
			dataType : "jsonp", 
			success : function(json){ 
				if(json.status == 1){
					//游客登陆保存cookie
					var visitor_id=0;
					var visitor_name=json.name;
					var visitor_uimg="defalut";
					comment_login(visitor_id,visitor_name,visitor_uimg,"2",1*24*3600);
					changeloginstatus();
				}else{
					alert(json.msg);
				}
				
			},
			error:function(){ 
				alert("页面超时!请刷新！");
			} 
		}); 
		
	})
	//游客登出
	$(".wrap-icon-b").live("click",function(){
		$(".wrap-menu-dw").show();
	})
	$(".gap-bdg").live("click",function(){
		logout();
	})

	//发布
	$(".action-issue-w").live("click",function(){
		if(!login_user()){
			return false;
		}
	
		var that=$(this);

		if(that.attr("disabled")=="disabled"){
				alert("正在处理数据，请勿重复提交");	
				return false;
		}
		that.attr("disabled","disabled");

		var buttontype=$(this).attr("buttontype");//1：新发布 2：回复
		var comment= replace_em($(this).parent().parent().find(".textarea-fw").val());
		// var comment=$(this).parent().parent().find(".textarea-fw").val();
		articleurl=document.location.href;
		 var url1  ='http://'+dataurl+'/index.php/Api/Comment/addcommentapp';
		 url1+='/articleurl/'+articleurl;
		 url1+='/commenttype/'+commenttype;
		 url1+='/articleid/'+articleid;
		 url1+='/title/'+title;		 
		 url1+='/uid/'+uid;
		 url1+='/uname/'+uname;
		 url1+='/uimg/'+uimg;
		 url1+='/type/'+user_type;
		 //回复评论
		 if(buttontype ==2){
			 url1+='/commentid/'+$(this).attr("id"); 
			 url1+='/fid/'+$(this).attr("uid"); 
			 url1+='/fname/'+$(this).attr("uname"); 
			 url1+='/fimg/'+$(this).attr("uimg");
		 }	
		 url1+='/comment/'+comment;
		 $.ajax({ 
				type : "get", 
				async:false, 
				url :url1,
				dataType : "jsonp", 
				success : function(json){
					alert(json.msg);
					that.parent().parent().find(".textarea-fw").val("");
					that.removeAttr("disabled");
					
				},
				error:function(){ 
					alert("页面超时!请刷新！");
				} 
			}); 	
		})	
		
	//回复
	$(".click-reply-gw").live("click",function(){
		if(!login_user()){
			return false;
		}
		if($(this).parent().parent().parent().find(".wrap-reply-gw").length==0){
			var reg1=new RegExp("data-id","g"); //创建正则RegExp对象 
			var newstr=replyhtml.replace(reg1,$(this).attr("id"));  
			var reg2=new RegExp("data-uid","g"); //创建正则RegExp对象 
			 newstr=newstr.replace(reg2,$(this).attr("uid"));  
			var reg3=new RegExp("data-uname","g"); //创建正则RegExp对象 
			 newstr=newstr.replace(reg3,$(this).attr("uname"));  
			 var reg4=new RegExp("data-uimg","g"); //创建正则RegExp对象 
			 newstr=newstr.replace(reg4,$(this).attr("uimg"));  
			$(this).parent().parent().after(newstr);
		}else{
			$(this).parent().parent().parent().find(".wrap-reply-gw").remove();
		}
	
	})
		
		//顶
		$(".click-ding-gw").live("click",function(){
		
			  var left = parseInt($(this).offset().left) + 10,
	             top = parseInt($(this).offset().top) - 10,
	             id=$(this).attr("id"),
	             obj = $(this);
				//alert(document.cookie);
				if(getCookie("commentid_"+id) == 1){
					
					return false;
				}
				setCookie("commentid_"+id,"1",60); 	 
				left=5;
				top=0;
		         $(this).append('<div class="zhans"><b>+1<\/b></\div>');
		         $('.zhans').css({
		             'position': 'absolute',
		             'z-index': '999',
		             'color': '#C30',
		             'font-size':'12px',
		             'left': left + 'px',
		             'top': top + 'px'
		         }).animate({
		             top: top - 20,
		             'font-size':'20px'
		           //  left: left + 10
		         }, 'slow', function () {
		             $(this).fadeIn('fast').remove();
		             $.ajax({ 
			 				type : "get", 
			 				async:false, 
			 				url :'http://'+dataurl+'/index.php/Api/Comment/topcomment/id/'+id+'/articleid/'+articleid,
			 				dataType : "jsonp", 
			 				success : function(json){
			 					if(json.status == "success"){
			 					  var Num = parseInt(obj.find('.icon-name-bg').text())?parseInt(obj.find('.icon-name-bg').text()):0;
			 		             Num++;
			 		             obj.find('.icon-name-bg').text(Num);
			 		             
			 		        	$(".countjoin").html(json.countjoin);
			 					$(".countcomment").html(json.countcomment);
			 					 obj.next().next().find("a i").css("background-position","-100px -25px"); 
			 					 obj.next().next().find("a i").live("mouseover",function(){
			 			        	 $(this).css("background-position","-100px -25px"); 
			 			         })
			 					   obj.find("a i").css("background-position","-100px 0"); 
				 				   obj.find("a i").live("mouseover",function(){
				 			        	 $(this).css("background-position","-100px 0"); 
				 			         })
			 					}
			 				},
			 				error:function(){ 
			 					alert("页面超时!请刷新！");
			 				} 
			 			}); 	

		         });
		      
		         return false;
			
		})
		//踩
		$(".click-cai-gw").live("click",function(){
			
			  var left = parseInt($(this).offset().left) + 10,
	             top = parseInt($(this).offset().top) - 10,
	             id=$(this).attr("id"),
	             obj = $(this);
			  //alert(document.cookie);
			  if(getCookie("commentid_"+id) == 1){
				
					return false;
				}
			    left=5;
				top=0;
				setCookie("commentid_"+id,"1",60); 	 
		         $(this).append('<div class="zhans"><b>-1<\/b></\div>');
		         $('.zhans').css({
		             'position': 'absolute',
		             'z-index': '999',
		             'font-size':'12px',
		             'color': '#C30',
		            'left': left + 'px',
		             'top': top + 'px'
		         }).animate({
		             top: top - 20,
		             'font-size':'20px'
		           //  left: left + 10
		         }, 'slow', function () {
		             $(this).fadeIn('fast').remove(); 
		    		 $.ajax({ 
		 				type : "get", 
		 				async:false, 
		 				url :'http://'+dataurl+'/index.php/Api/Comment/downcomment/id/'+id+'/articleid/'+articleid,
		 				dataType : "jsonp", 
		 				success : function(json){
		 					if(json.status == "success"){
		 					  var Num = parseInt(obj.find('.icon-name-bg').text())?parseInt(obj.find('.icon-name-bg').text()):0;
		 		             Num++;
		 		             obj.find('.icon-name-bg').text(Num);
		 		             
		 		        	$(".countjoin").html(json.countjoin);
		 					$(".countcomment").html(json.countcomment);
		 					obj.prev().prev().find("a i").css("background-position","-100px 0"); 
		 					obj.prev().prev().find("a i").live("mouseover",function(){
		 			        	 $(this).css("background-position","-100px 0"); 
		 			         })
		 					  obj.find("a i").css("background-position","-100px -25px"); 
			 				   obj.find("a i").live("mouseover",function(){
			 			        	 $(this).css("background-position","-100px -25px"); 
			 			         })
			 			         
		 					}
		 				},
		 				error:function(){ 
		 					alert("页面超时!请刷新！");
		 				} 
		 			}); 	

	
		         });
		         return false;
			
		})
		
		$(document).live("click",function(){
		
			$(".bdsharebuttonbox").hide();
		})
		
})
