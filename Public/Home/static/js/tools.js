/**初始化边导航选中栏目方法*/
/*var urlMap = new Map();
urlMap.put("/ui-lib/weixin/wxwall/wxwallAdd.jsp", '/ui-lib/weixin/wxwall/wallList.jsp');
urlMap.put("/ui-lib/wxwall/selectByPrimaryKeyWxwall", '/ui-lib/weixin/wxwall/wallList.jsp');
urlMap.put("/ui-lib/weixin/wxwall/wallSupervise.jsp", '/ui-lib/weixin/wxwall/wallList.jsp');
urlMap.put("/ui-lib/weixin/waccountFansGroupIndex.jsp", '/ui-lib/weixin/waccountFansIndex.jsp');
urlMap.put("/ui-lib/material/graphic/graphicMaterialAdd.jsp", '/ui-lib/material/graphic/graphicMaterialIndex.jsp');
urlMap.put("/ui-lib/material/graphic/graphicMaterialUpdate.jsp", '/ui-lib/material/graphic/graphicMaterialIndex.jsp');
urlMap.put("/ui-lib/system/log/loginLogIndex.jsp", '/ui-lib/system/log/operateLogIndex.jsp'); 
function initSlidBar() { 
	var selfHref = location.pathname;     
	if(urlMap.get(selfHref) != null) {
		selfHref = urlMap.get(selfHref);
	}
	$('.sub-menu').each(function() {
		$(this).children('li').each(function() {
			var href = $(this).find('a').attr('href');
			if(selfHref == href) {
				$(this).addClass('active');
				$(this).parent().parent().addClass('active');
			}  
		});
	});
}*/

/**
 * confirm方法
 */
(function($){
	
	$.confirm = function(params){
		var buttonHTML = '';
		$.each(params.buttons,function(name,obj){
			
			// Generating the markup for the buttons:
			
			buttonHTML += '\r\n<a href="#" class="btn '+obj['class']+'">'+name+'</a>';
			
			if(!obj.action){
				obj.action = function(){
					return false;
				};
			}
		});
		
		var color = "";
		var icon = "";
		if (params.level == "success") {
			color = "green";
			icon = "glyphicon glyphicon-ok-sign";
		} else if (params.level == "warning") {
			color = "yellow";
			icon = "glyphicon glyphicon-question-sign";
		} else if (params.level == "danger") {
			color = "red";
			icon = "glyphicon glyphicon-exclamation-sign";
		} else {
			color = "blue-madison";
			icon = "glyphicon glyphicon-info-sign";
		}  
		
		var markup = "";
		var content = "";
		if($('#confirmOverlay').length){
			// A confirm is already shown on the page:
			markup = [
			    '<div class="portlet solid ', color, '"  id="confirmBox">',
				'<div class="portlet-title">',
				'<div class="caption"><i class="', icon, '"></i>', params.title, '</div>',  //2015.7.8注释
				'</div>',
				'<div class="portlet-body">',
				//'<div id="confirmBox" class="alert alert-block alert-', params.level ,' ">',
				//'<h4 class="alert-heading text-center">', params.title, '</h4>',
				'<p  class="message">',params.message,'</p>',
				'<div align="center">',buttonHTML,'\r\n</div>',
				'</div></div>'
			].join('');
			content = $(markup).replaceAll('#confirmBox');
		} else {
			markup = [
			    '<div class="portlet solid ', color, '"  id="confirmBox">',
				'<div class="portlet-title">', 
				'<div class="caption"><i class="', icon, '"></i>', params.title, '</div>', 
				'</div>',
				'<div class="portlet-body">',
				//'<div id="confirmBox" class="alert alert-block alert-', params.level ,' ">',
				//'<h4 class="alert-heading text-center">', params.title, '</h4>',
				'<p class="message">',params.message,'</p>',
				'<div align="center">',buttonHTML,'\r\n</div>',
				'</div></div><div id="confirmOverlay"></div>'
			].join('');
			content = $(markup).hide().appendTo('body');
			var width = $(content.get(0)).css("width");
			var height = $(content.get(0)).css("height");
			width = width.replace("px","") / 2 + "px";
			height = height.replace("px","") / 2 + "px";
			
			content.fadeIn();
			$(content.get(0)).css("margin","-" + height + " 0 0 -" + width);
		}
		
		
		
		
		var buttons = $('#confirmBox .btn'),
			i = 0;

		$.each(params.buttons,function(name,obj){ 
			buttons.eq(i++).click(function(){
				
				// Calling the action attribute when a
				// click occurs, and hiding the confirm.
				$.confirm.stopClick(this);
				if(!obj.action()) {
					$.confirm.hide();
				}
				return false;
			});
		});
	};
	
	$.confirm.hide = function(){
		$('#confirmBox').fadeOut(function(){
			$(this).remove();
		});
		$('#confirmOverlay').fadeOut(function(){
			$(this).remove();
		});
	};
	
	$.confirm.stopClick = function(curObj) {
		$('#confirmOverlay .alert').addClass('alert-waiting');
		$.each($('#confirmOverlay .btn'), function(name, obj) {
			$(obj).replaceWith("<a class='btn grey' href='#'>" + $(obj).html() + "</a>");
			$(obj).click(
				function() {return false;}
			);
		});
	};
})(jQuery);


/**
 * 弹出窗口方法
 */


(function($){

	$.flowWindow = function(params){
		//创建浮窗实例
		var newWindowInst = new $.flowWindow.windowInst(params);
		//显示浮窗
		var cont = newWindowInst.show();
		//将新的浮窗对象放入浮窗堆栈
  		$.flowWindow.wIArray.push(newWindowInst);
  		
  		return cont;
	};
	
	//定义浮窗实例
	$.flowWindow.windowInst = function(params) {
		//根据参数确定浮窗大小
		this.windowSize = "";
		if(params.size) {
			if (params.size == "50per") {//50%
				this.windowSize = "size50per";
			} else if (params.size == "90per") {//90%
				this.windowSize = "size90per";
			} else if (params.size == "80per") {//80%*40%
				this.windowSize = "size80per";
			} else if (params.size == "500p") {//500pixel
				this.windowSize = "size500p";
			} else {
				this.windowSize = "size900p";//默认900pixel
			}
		}
		
		//
		if (!params.title) {
			params.title = "请设定标题";
		}
		
		//根据参数确定浮窗的高和宽
		var style = "";
		
		if(this.windowSize == "") {
			var height = params.height;
			var width = params.width;
			var top = (100-height)/2-5;   
			var left = (100-width)/2; 
			style = "style=\"width: "+width+"%;height:"+height+"%;top: "+top+"%;left: "+left+"%;\"";
		} 
		
		//浮窗框架html代码
		if ("blank" == (params.mode)) {
			this.markup = [
					  		'<div class="flowWindow portlet light ' + this.windowSize + '" '+style+'>',
					  		'<div class="portlet-title">',
					  		'<div class="actions">',
					  		'<a class="btn btn-sm glyphicon glyphicon-resize-full resize" href="javascript:;"></a>',
							'<a class="btn btn-sm glyphicon glyphicon-remove remove" href="javascript:;"></a>',
							'</div>',
				  		    '</div>', 
				  		    '<div class="portlet-body flowWindow-content"></div>',
				  		    '</div>', 
				  			'<div class="flowWindowOverlay"></div>'      
					  		].join('');
		} else {//default
			this.markup = [
			  		'<div class="flowWindow portlet light ' + this.windowSize + '" '+style+'>',
			  		'<div class="portlet-title"><div class="caption"><i class="fa fa-reorder"></i><span class="caption-subject theme-font-color bold">' + params.title + '</span></div>',
			  		'<div class="actions">',
			  		'<a class="btn btn-sm glyphicon glyphicon-resize-full resize" href="javascript:;"></a>',
			  		'<a class="btn btn-sm glyphicon glyphicon-remove remove" href="javascript:;"></a>',
					'</div>',
		  		    '</div>', 
		  		    '<div class="portlet-body flowWindow-content"></div>',
		  		    '</div>', 
		  			'<div class="flowWindowOverlay"></div>'      
			  		].join('');
		}
  		
		//新的浮窗插入到页面后对应的jquery对象，方便之后的操作
		this.content = null;
		
		//显示新浮窗
		this.show = function() {
			//载入浮窗内容页面
			$.refreshWindow.open("正在加载内容，请稍后……");
			if (params.src) {
				$.ajax({
					url : params.src,
					type : "post",
					data : params.data,
					async : false,
					success : function (curInst) {
						return function(data) {
							try {
								//curInst.markup = curInst.markup.replace('{#body}', data);
								curInst.content = $(curInst.markup).hide().appendTo('body');
								curInst.resizef();
								curInst.content.find(".flowWindow-content").append($(data));
								//计算新浮窗层所需的z-index并赋值
								$.flowWindow.zIndex += 10;
								curInst.content.eq(1).css('z-index', $.flowWindow.zIndex);
								$.flowWindow.zIndex += 10;
								curInst.content.eq(0).css('z-index', $.flowWindow.zIndex);
								//淡入
								$.refreshWindow.close();
								curInst.content.fadeIn();
								$(window).resize(function(inst){
										return function(){
											inst.resizef();
										}
									}(curInst)
								);
								//$(data).appendTo(curInst.content.find('.flowWindow-content'));
							} catch(e){}
							//赋予浮窗右上角关闭按钮功能
							
						};
					}(this)
				});
			} else {
				this.content = $(this.markup).hide().appendTo('body');
				this.resizef();
				//计算新浮窗层所需的z-index并赋值
				$.flowWindow.zIndex += 10;
				this.content.eq(1).css('z-index', $.flowWindow.zIndex);
				$.flowWindow.zIndex += 10;
				this.content.eq(0).css('z-index', $.flowWindow.zIndex);
				//淡入
				$.refreshWindow.close();
				this.content.fadeIn();
			}
			this.content.find('.actions .remove').click(
					function () {
						$.flowWindow.cancel();
						return false;
					}
				);
			this.content.find('.actions .resize').click(
					function(inst) {
						return function () {
							inst.full();
						}
					} (this)
				);
			return this.content.find('.portlet-body');
		};
  		
		//初始化浮窗操作成功关闭回调方法
  		if (params.successAction) {
  			this.successAction = params.successAction;
  		} else {
  			this.successAction = null;
  		}
  		
  		//初始化浮窗取消操作关闭回调方法
  		if (params.cancelAction) {
  			this.cancelAction = params.cancelAction;
  		} else {
  			this.cancelAction = null;
  		}
  		
  		//初始化浮窗取消操作出错回调方法
  		if (params.errorAction) {
  			this.errorAction = params.errorAction;
  		} else {
  			this.errorAction = null;
  		}
  		
  		//浮窗操作成功关闭方法
  		this.success = function (params) {
  			if (this.successAction) {
  				this.successAction(params);
  			}
  			this.hide();
  		};
  		
  		//浮窗取消操作关闭方法
  		this.cancel = function(params) {
  			if (this.cancelAction) {
  				this.cancelAction(params);
  			}
  			this.hide();
  		};
  		
  		//浮窗取消操作出错方法
  		this.error = function(params) {
  			if (this.errorAction) {
  				this.errorAction(params);
  			}
  			this.hide();
  		};
		
  		//浮窗隐藏操作，内容使用不对外暴露
  		this.hide = function(curInst) {
  			return function() {
  				curInst.content.eq(0).fadeOut(function(){
  					$(this).remove();
  				});
  				curInst.content.eq(1).fadeOut(function(){
	  				$(this).remove();
	  			});
	  		};
  		}(this);
  		
  		//浮层最大化操作
  		this.full = function() {
  			if (this.windowSize != "") {
  				this.content.eq(0).removeClass(this.windowSize).addClass("full");
  			} else {
  				this.content.eq(0).css({"height":"","width":"","top":"","left":""}).addClass("full");
  			}
  			
  			this.content.find(".actions .resize").removeClass("glyphicon-resize-full").addClass("glyphicon-resize-small");
  			this.resizef();
  			this.content.find(".actions .resize").unbind("click");
  			this.content.find(".actions .resize").click(
				function(inst) {
					return function () {
						inst.small();
					}
				} (this)	
  			);
  		}
  		
  		//浮层回复初始状态操作
  		this.small = function() {
  			if (this.windowSize == "") {
  				var height = params.height;
  				var width = params.width;
  				var top = (100-height)/2-5;   
  				var left = (100-width)/2; 
  				this.content.eq(0).removeClass("full").css({"height":height + "%","width":width + "%","top":top + "%","left":left + "%"});
  			} else {
  				this.content.eq(0).removeClass("full").addClass(this.windowSize);
  			}
  			this.content.find(".actions .resize").removeClass("glyphicon-resize-small").addClass("glyphicon-resize-full");
  			this.resizef();
  			this.content.find(".actions .resize").unbind("click");
  			this.content.find(".actions .resize").click(
				function(inst) {
					return function () {
						inst.full();
					}
				} (this)	
  			);
  		}
  		
  		this.resizef = function() {
  			var heightpx = this.content.css("height");
  			var height = heightpx.replace("px", "");
  			this.content.find(".flowWindow-content").css("height", (height * 1 - 80) + "px");
  		}
	}
	//浮窗当前zIndex，每个浮窗会在之前浮窗的数值基础山加10，保证新的浮窗会遮盖原有浮窗
	$.flowWindow.zIndex = 10000;
	//浮窗堆栈，依照创建顺序存储浮窗实例，堆栈顶端的浮窗实例为当前操作的对象
	$.flowWindow.wIArray = new Array();
	//在浮窗中进行操作并且成功后对应的浮窗关闭方法
	$.flowWindow.success = function (params) {
		$.flowWindow.wIArray.pop().success(params);
	};
	//在浮窗中进行操作并且取消后对应的浮窗关闭方法
	$.flowWindow.cancel = function (params) {
		$.flowWindow.wIArray.pop().cancel(params);
	};
	//在浮窗中进行操作并且出错后对应的浮窗关闭方法
	$.flowWindow.error = function (params) {
		$.flowWindow.wIArray.pop().error(params);
	};
	
})(jQuery);


(function($){
	$.refreshWindow = function() {
		return false;
	};
	$.refreshWindow.open = function(title, obj, options) {
		var defaultOptions = {
			message:"<h4><i class='fa fa-spin fa-refresh'></i>&nbsp;&nbsp;正在载入内容，请稍后……</h4>",
			css: {
				padding:		'0px',
		        textAlign:      'center',
		        color:          '#555555',
		        height:	        '40px',
		        border:         '0px',
		        backgroundColor:'#e5e5e5',
		        cursor:         'wait'
		    },
		    overlayCSS:  {
		        opacity:         0.4,
		    },
		    fadeIn: 0
		};
		if (!options) {
			options = {};
		}
		options = $.extend(true, defaultOptions, options);
		if (title) {
			options.message = "<h4><i class='fa fa-spin fa-refresh'></i>&nbsp;&nbsp;" + title + "</h4>";
		}
		if (obj) {
			$(obj).block(options);
		} else {
			$.blockUI(options);
		}
	};
	$.refreshWindow.close = function(obj) {
		if (obj) {
			$(obj).unblock();
		} else {
			$.unblockUI();
		}
	};
})(jQuery);

function confirmMsg(msg) { 
    Metronic.alert({
        container: "", // alerts parent container(by default placed after the page breadcrumbs)
        place: "prepend", // append or prepend in container 
        type: "info",  // alert's type
        message: msg,  // alert's message
        close: false, // make alert closable
        reset: true, // close all previouse alerts first
        focus: false, // auto scroll to the alert after shown
        closeInSeconds: 2, // auto close after defined seconds
		width:"col-md-offset-3 col-md-3",
		fixed:"fixed",
        icon: "" // put icon before the message
    });
}

//数据格式化
function getContent(content){
	if(content==null||content=="null"||content==undefined){
		content = "";
	}
	return content;
}

String.prototype.nullToStr = function(){
    return this == 'null' ? '' : this;
}