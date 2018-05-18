var base_url="http://ting.cri.cn";
function addReply(com_id,to_uid,uname,comment_type,reply_id){
	var row_id = $("#row_id").val();
	var uid = $("#uid").val();
	if(reply_id){
		var comment = $("#reply_content"+com_id+"_"+reply_id);
	}else{
		var comment = $("#reply_content"+com_id);
	}
	if(comment.val() == ''){
		alert("内容不能为空");
		return false;
	}else if(comment.val().length > 140){
		alert("字数超过限制");
		return false;
	}
	var comments = "@" + uname + ":" + comment.val();
	$.post(base_url+"/index.php/Home/Comment/addComment",{row_id:row_id,comment_type:comment_type,uid:uid,comment:comments,commentid:com_id,touid:to_uid}, function(json){
		if(json.status == 1){
			$(".dialog_boxs").hide();
			alert("评论成功，请耐心等待审核！");
			comment.val('');
		}
	  },"json");
}

//列表中的评论的回复
function addReplyList(com_id,to_uid,uname,comment_type,row_id,comment_uid){
	
	var com_id = com_id;
	var to_uid = to_uid;
	var uname  = uname;
	var comment_type = comment_type;
	var row_id = row_id;
	var comment = $("#replaycontent_"+com_id);
	var uid =comment_uid;
	if(comment.val() == ''){
		alert("内容不能为空");
		return false;
	}else if(comment.val().length > 140){
		alert("字数超过限制");
		return false;
	}
	var comments = "@" + uname + ":" + comment.val();
	//alert(comment_type);return false;
	$.post(base_url+"/index.php/Home/Comment/addComment",{row_id:row_id,comment_type:comment_type,uid:uid,comment:comments,commentid:com_id,touid:to_uid}, function(json){
		if(json.status == 1){
			alert("评论成功，请耐心等待审核！");
			comment.val('');
			showcommentList(row_id,comment_type,'jixvhui_'+row_id);
		}
	  },"json");
}

/*
 * 删除评论
 */
function delComment(comment_id,uid,type){
	if(comment_id && uid){
		$.post(base_url+"/index.php/Home/Comment/delComment",{comment_uid:uid,comment_id:comment_id}, function(json){
			if(json.msg == 'succ'){
				if(type == 'co'){
					$("#com_box"+comment_id).fadeOut();
				}else if(type == 're'){
					$("#re_box"+comment_id).fadeOut();
				}else if(type == 'showlist'){
					$("#jixvhui_"+comment_id).fadeOut();
				}
			}
		  },"json");
	}
}


//添加收藏
function addCollect(id,source_id,collect_type){
   
	var source_id =source_id;
	var collect_type=collect_type;
	if(source_id =='' || collect_type == ''){
		alert('参数有误');
		return false;
	}else{
		///index.php/Home/Collect
		$.post(base_url+"/index.php/Home/Collect",{source_id:source_id,collect_type:collect_type}, function(json){
			if(json.status == 1){
				$('#collect_'+id).html('取消收藏');
			}
			if(json.status == 2){
				$('#collect_'+id).html('收藏');
			}
			if(json.status == 0){
				alert("没有登录");
			}
		  },"json");
	}
	
}

//转发 即发布一条动态
function zhuanfa(name,sound_id,sound_name,sound_img,sound_url,trend_type){
	
	//var uid =1;
	var trendcontent=$("[name="+name+"]").val();
	var id = $("[name="+name+"]").attr('rel');
	$.ajax({
		type:"GET",
		url:base_url+"/index.php/Home/Trend/index",
		data:{trend_type:trend_type,sound_id:sound_id,sound_url:sound_url,sound_name:sound_name,sound_img:sound_img,trends_content:trendcontent},
		dataType:"JSON",
		success:function(json){
			if(json.status =="succ"){
				alert(json.msg);
				$("[name="+name+"]").val('');
				$('#zhuanfa_'+id).hide();
				$('.mengban').hide();
			}
			if(json.status ==0){
				$("[name="+name+"]").val('');
				$('#zhuanfa_'+id).hide();
				$('.mengban').hide();
				alert("没有登录");
			}
			
		}
	});
}

$(function($) {
	//加关注 weiguanzhu 0 没关系  1对方已关注我
	//guanzhule  hxguanzhu
	$('.fensihuaguo').hover(function(){
			$(this).find('.conright').show();
			},function(){
			$(this).find('.conright').hide();	
	})
	$(".weiguanzhu").live("click",function(){
		var that=$(this);
		var type=$(this).attr("rel");
		var fid=$(this).attr("uid");
		if(type == 0){
			var rel=2;
			var text="已关注";
			var cname="guanzhule";
		}else if(type==1){
			var rel=3;
			var text="互相关注";
			var cname="hxguanzhu";
		}
		$.ajax({
	        type: "GET",
	        url: base_url+"/index.php/Home/Show/addattention",  /*注意后面的名字对应CS的方法名称 */
	        data:{"fid":fid},/* 注意参数的格式和名称 */
	        dataType: "json",
	        success: function (result){
	        	if(result.status==-1){
	        		if(!result.uid){
		        		alert("没有登录");
	        		}else{
	        			alert(result.message);
	        		}
	        		return;
	        	}
	        	if(result.status==1){
	        		that.attr("rel",rel);
	        		that.removeClass("weiguanzhu").addClass(cname);
	        	}
	        }
	      });		

		
	});
	$(".guanzhule").live("click",function(){
		var that=$(this);
		var fid=$(this).attr("uid");
		$.ajax({
	        type: "GET",
	        url: base_url+"/index.php/Home/Show/removecare",  /*注意后面的名字对应CS的方法名称 */
	        data:{"fid":fid},/* 注意参数的格式和名称 */
	        dataType: "json",
	        success: function (result){
	        	if(result.status==-1){
	        		alert(result.message);
	        		return;
	        	}
	        	if(result.status==1){
	        		that.attr("rel",0);
					that.removeClass("guanzhule").addClass("weiguanzhu");
	        	}
	        }
	      });	
		
	});
	$(".hxguanzhu").live("click",function(){
		var that=$(this);
		var fid=$(this).attr("uid");
		$.ajax({
	        type: "GET",
	        url: base_url+"/index.php/Home/Show/removecare",  /*注意后面的名字对应CS的方法名称 */
	        data:{"fid":fid},/* 注意参数的格式和名称 */
	        dataType: "json",
	        success: function (result){
	        	if(result.status==-1){
	        		alert(result.message);
	        		return;
	        	}
	        	if(result.status==1){
	        		that.attr("rel",1);
					that.removeClass("hxguanzhu").addClass("weiguanzhu");
	        	}
	        }
	      });	
		
	});
	$(".yichu").live("click",function(){
		var that=$(this);
		var fid=$(this).attr("uid");
		$.ajax({
	        type: "GET",
	        url: base_url+"/index.php/Home/Show/removefans",  /*注意后面的名字对应CS的方法名称 */
	        data:{"fid":fid},/* 注意参数的格式和名称 */
	        dataType: "json",
	        success: function (result){
	        	if(result.status==-1){
	        		alert(result.message);
	        		return;
	        	}
	        	if(result.status==1){
	        		$("#fensi_"+fid).remove();
	        	}
	        }
	      });	
		
	});
	
	//关闭表情弹窗
    $(".dialog_close").click(function(){
    	var box = $(this).parent().parent();
    	box.hide();
    });
  //加载表情弹窗
    $(".face").click(function(){
    	var box = $(this).next();
    	if(box.css('display') == 'none'){
    		box.find(".dialog_content").html("<ul class=\"face_list\"></ul>");
    		box.find(".arrow-t").attr('style','left: 5px;');
            $.get(base_url+"/index.php/Home/Show/getFace",'', function(html){
                box.find(".face_list").html(html);
            },"html");
            box.show();
    	}else{
    		box.hide();
    	}
    });
    
});	

function checkwordsnum(textarea_id,maxnum,display_id){
	$(function() {
	    $("#"+textarea_id).keyup(function() {
	        var len = $(this).val().length;
	        if (len > maxnum-1) {
	            $(this).val($(this).val().substring(0, maxnum));
	        }
	        var num = maxnum - len;
	        $("#"+display_id).html("<span>"+num+"</span>/"+maxnum);
	    });
	});
}


function add_face(content, ts) {
	if(ts == ''){
		$("#content").insertAtCaret(content);
	}else{
		$(".comment" + ts).insertAtCaret(content);
	}
    
}
function add_soundzhuanfa_face(content, ts) {
	$(".transmitcontent" + ts).insertAtCaret(content);
}
function add_soundpinglun_face(content, ts) {
	$(".duanyixie" + ts).insertAtCaret(content);
}
function add_soundhuifu_face(content, ts) {
	$("#huifu" + ts).insertAtCaret(content);
}
function add_trendzhuanfa_face(content, ts) {
	$("#trendzhuanfa" + ts).insertAtCaret(content);
}
function add_trendpinglun_face(content, ts) {
	$("#content_" + ts).insertAtCaret(content);
}
function add_trendhuifu_face(content, ts) {
	$("#replaycontent_" + ts).insertAtCaret(content);
}
function add_albumzhuanfa_face(content, ts) {
	$("#album_zhuanfa_textarea" + ts).insertAtCaret(content);
}
function add_albumpinglun_face(content, ts) {
	$("#album_pinlun_textarea" + ts).insertAtCaret(content);
}
function add_soundplayzhuanfa_face(content) {
	$("#mytxtdafdfasdf").insertAtCaret(content);
}
function add_centerindexzhuanfa_face(content, ts) {
	$("#zhuanfacenterindex" + ts).insertAtCaret(content);
}
function add_centerindexpinglun_face(content, ts) {
	$(".centerindex_pinglun" + ts).insertAtCaret(content);
}
function add_centersoundzhuanfa_face(content, ts) {
	$("#zhuanfacentersound" + ts).insertAtCaret(content);
}
function add_centersoundpinglun_face(content, ts) {
	$(".centersound_pinglun" + ts).insertAtCaret(content);
}
function add_centercollectzhuanfa_face(content, ts) {
	$("#zhuanfacentercollect" + ts).insertAtCaret(content);
}
function add_centercollectpinglun_face(content, ts) {
	$(".centercollect_pinglun" + ts).insertAtCaret(content);
}
function add_centerlistenedzhuanfa_face(content, ts) {
	$("#zhuanfacenterlistened" + ts).insertAtCaret(content);
}
function add_centerlistenedpinglun_face(content, ts) {
	$(".centerlistened_pinglun" + ts).insertAtCaret(content);
}
function add_centertopzhuanfa_face(content, ts) {
	$("#zhuanfacentertop" + ts).insertAtCaret(content);
}
function add_centertoppinglun_face(content, ts) {
	$(".centertop_pinglun" + ts).insertAtCaret(content);
}
//图片回显js代码
function showpic(file,img){
	var dFile = document.getElementById(file.id);
	var dImg = document.getElementById(img);
	var dInfo = document.getElementById('img');
	if(!dFile.value.match(/.jpg|.gif|.png|.bmp/i)){
   		alert('图片类型必须是: .jpg, .gif, .bmp or .png !');
   		return;
	}
	if(dFile.files){
		dImg.style.display='block';
  		dImg.src = window.URL.createObjectURL(dFile.files[0]);  
	}else{
		/*这步骤是用来在ie6,ie7中显示图片的*/
		var from=img.indexOf('g')+1;
		var to=img.length;
		var pic='pic'+img.substring(from,to);
		var newPreview = document.getElementById(pic);
		newPreview.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = dFile.value;
		dImg.style.display='none';
     	newPreview.style.width = "155px";
     	newPreview.style.height = "105px";
    }
}
//个人中心 转发的字数提示
$(function(){
	$(".wenben textarea").bind("keyup focus blur", function() {
		var limit = 0;
	    var text = "";
	    var comment = $(this).val();
	    var id = $(this).attr('rel');
	    if(comment.length > 0 || comment!='请输入转发内容'){
	    	if(comment.length<=140){
	    		len = 140 - comment.length;
	    		txt = len;
	    		$("#shuzi_"+id).text(txt);
	    		$("#shuzi_"+id).attr('style','');
	    		$("[name='zhuanfatijiao_"+id+"']").show();
	    	  }else{
	    		len = comment.length - 140;
	    		txt = "超出:" + len + '个字';
	    		$("#shuzi_"+id).attr('style','color:red');
	    		$("#shuzi_"+id).text(txt);
	    		$("[name='zhuanfatijiao_"+id+"']").hide();
	    	  }
	    	  
	      }
	});
});
$(function(){
	$("[name='txt_content']").bind("keyup focus blur", function() {
		var limit = 0;
	    var text = "";
	    var comment = $(this).val();
	    var id = $(this).attr('rel');
	    if(comment.length > 0){
	    	if(comment.length<=140){
	    		len = 140 - comment.length;
	    		txt = "还剩" + len + "个字";
	    		$("#plshuzi_"+id).text(txt);
	    		$("[name='huipingstijiao_"+id+"']").show();
	    	  }else{
	    		len = comment.length - 140;
	    		txt = "超出" + len + '个字';
	    		$("#plshuzi_"+id).text(txt);
	    		$("[name='huipingstijiao_"+id+"']").hide();
	    	  }
	    	  
	      }
	});
});

