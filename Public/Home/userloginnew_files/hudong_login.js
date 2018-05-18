var Url_domainname=location.href;
var Url_domainname1 = '';
var $=jQuery;
//登录框
$("#login").hover(function(){
$("#SI_Top_LoginLayer").show();
},function(){
$("#SI_Top_LoginLayer").hide();
});
$(".cur_move .layerbox_close").click(function(){
$("#SI_Top_LoginLayer").hide();
})
/*顶通更多*/
$("#topmore").hover(function(){
$(this).addClass("active");
},function(){
$(this).removeClass("active");
});
var shorturl = (Url_domainname.substr(0,Url_domainname.indexOf("/",7)));
var zhuceurl = "http://reg.cntv.cn/regist.html?from="+shorturl+"&backurl="+encodeURI(Url_domainname);
$("#SI_Top_LoginLayer .log_option .register_lnk").attr("href",zhuceurl);
var URL_zhuce = "http://reg.cntv.cn/regist/regist.jsp?from="+shorturl;

if(Url_domainname.indexOf("?")==-1){
	Url_domainname1 = Url_domainname;
}else{
	Url_domainname1 = Url_domainname.substr(0,Url_domainname.indexOf("?"));
}

var qq_url = "http://oauth.passport.cntv.cn/OAuthQzoneClient/OAuthQZoneClientServlet.do?method=login&cntv_callback="+encodeURI(Url_domainname1);
var rr_url = "http://oauth.passport.cntv.cn/OAuthRenRenClient/OAuthRenRenClientServlet.do?method=login&cntv_callback="+encodeURI(Url_domainname1);
var kx_url = "http://oauth.passport.cntv.cn/OAuthKaixinClient/connect/index.jsp?cntv_callback="+encodeURI(Url_domainname1);
var weixin_url = "http://oauth.passport.cntv.cn/OauthClientWeixin/OAuthWeixinClientServlet.do?method=login&cntv_callback="+encodeURI(Url_domainname1);
$("#qq_url").attr("href",qq_url);
$("#rr_url").attr("href",rr_url);
$("#kx_url").attr("href",kx_url);
$("#weixin_url").attr("href",weixin_url);

var sns_userid = "";
var userSeqId = "";
getCookie_main();
var sns_userid = getCookie1('userSeqId');
function getCookie_main() {
var userSeqId=getCookie1('userSeqId');
var flag = passport.isLoginedStatus();
if(flag){
	$.getJSON(
		'http://my.cntv.cn/intf/napi/api.php?client=cntv_top&method=user.getNickName&userid='+userSeqId+'&cb=?&format=jsonp',
		function(data){
			if(data.code == 0){
				var namecookie = data.content.nickname;
					if(namecookie.length>=6){
						namecookie = namecookie.substr(0,5)+"...";
					}else{
						namecookie = namecookie;
					}
					document.getElementById("track").style.display = "block";
					jQuery("#right").css("width", "auto");
					if(shorturl=="http://my.cntv.cn/"&&$.browser.msie && $.browser.version<=7){$(".up ul li").css("padding-right","6px");}
					document.getElementById('login').style.display = 'none';
					document.getElementById('logon2').style.display = 'block';
					$("#cookie_user_name2").attr("title",data.content.nickname);
					document.getElementById("cookie_user_name2").innerHTML = namecookie;
					document.getElementById("cookie_user_name2").href = "http://my.cntv.cn";
					document.getElementById("cookie_user_name2").target = "_blank";
					//document.getElementById("cookid").value = sns_userid;
					document.getElementById("nicknm").value = namecookie;
			}else{}
		}
		);
}else{
	//展示 “登录” 按钮
	document.getElementById('login').style.display = 'block';
	$('#SI_Top_LoginLayer .loginformlist table').eq(0).find('tr').eq(0).find('td').html('<input type="text" name="username" onfocus="if(this.value==this.defaultValue){this.value=\'\'}" onblur="if(this.value==\'\'){this.value=this.defaultValue}" value="帐号" id="username0102" class="styles" autocomplete="off" onkeypress="getOnkeyDown_login(event)"><input type="hidden" value="client_transaction" id="service" name="service"><input type="hidden" value="http://www.cntv.cn" id="from" name="from">')
	document.getElementById("passwd_view").style.display = "block";
	document.getElementById("password0102").value = "";
	document.getElementById("password0102").style.display = "none";
	document.getElementById('logon2').style.display = 'none';
	document.getElementById('track').style.display = 'none';
	$("#right").removeAttr("style");
	$("#right").addClass("jianrong");
	var Shorturl = location.href;
	//if(URL_zhuce=="http://reg.cntv.cn/regist/regist.jsp?from="+shorturl&&$.browser.msie && $.browser.version<=7){$(".up .tn-topmenulist").css("left","200px");}
	//if(Shorturl=="http://my.cntv.cn/"&&$.browser.msie && $.browser.version<=7){$(".up .tn-topmenulist").css("left","200px");}
}
}
document.getElementById("from").value = shorturl;
function handleResult (result){
		var msg = result.msg;//提示信息
		var errorCode = result.errorCode;//错误码，i18n展示用
		if(passport.usernameError==result.type){//如果是用户名有问题
			//在用户名的位置展示错误提示信息
			//alert(msg);
			if(errorCode == "-1"){
				alert("格式不正确，请使用邮箱，手机号码或名字");
			}else if(errorCode == "-2"){
				alert("请输入密码!");
			}else if(errorCode == "-4"){
				alert("账户不存在!");
			}else if(errorCode == "-11"){
				alert("不能用昵称登录，请使用邮箱、手机号或用户名");
			}else if(errorCode == "-36"){
				alert("帐户信息进行审查中...");
			}else if(errorCode == "-40"){
				alert("该帐号已被封，请联系客服!");
			}else if(errorCode == "104"){
				alert("此帐户没有注册!");
			}else if(errorCode == "105"){
				alert("密码错误，请重新输入!");
			}else if(errorCode == "106"){
				alert("您尚未激活，请去reg.cntv.cn激活!");
			}
		}else if(passport.passwordError==result.type){//如果是密码有问题
			//在密码的位置展示错误提示信息
			//alert(msg);
			if(errorCode == "-1"){
				alert("格式不正确，请使用邮箱，手机号码或名字");
			}else if(errorCode == "-2"){
				alert("请输入密码!");
			}else if(errorCode == "-4"){
				alert("账户不存在!");
			}else if(errorCode == "-11"){
				alert("不能用昵称登录，请使用邮箱、手机号或用户名");
			}else if(errorCode == "-36"){
				alert("帐户信息进行审查中...");
			}else if(errorCode == "-40"){
				alert("该帐号已被封，请联系客服!");
			}else if(errorCode == "104"){
				alert("此帐户没有注册!");
			}else if(errorCode == "105"){
				alert("密码错误，请重新输入!");
			}else if(errorCode == "106"){
				alert("您尚未激活，请去reg.cntv.cn激活!");
			}
		} else if(passport.success==result.type){//登录成功
			//处理用户id：result.usrid 或者 result.user_seq_id
			if ($("#check_user").is(":checked")) {
			setCookie('cntv_main_usr', $("#username0102").attr("value"));
			}else{
			}
			window.location.reload();
			sns_userid = result.user_seq_id;
			function loadjquery(m){
				var d=document.createElement("script");
				d.setAttribute("charset","utf-8");
				d.type="text/javascript";
				d.language="javascript";
				d.src=m;
				document.getElementsByTagName("body")[0].appendChild(d);
				if(d.readyState){
				d.onreadystatechange=function(){
					if(!this.readyState||this.readyState=="loaded"||this.readyState=="complete"){
						delete d;
					}
				}
				}else{
				d.onload=function(){
						delete d;
				}
				}
			}
			var m="http://my.cntv.cn/intf/napi/api.php?client=cntv_top&method=user.getNickName&userid="+result.user_seq_id+"&cb=callbackfun&format=jsonp";
			loadjquery(m);
		}
	}
function callbackfun(data){
	if(data.code == 0){
	var nickname = data.content.nickname;
		if(nickname.length>=6){
			nickname = nickname.substr(0,5)+"...";
		}else{
			nickname = nickname;
		}
		$("#cookie_user_name2").attr("title",data.content.nickname);
		document.getElementById('cookie_user_name2').innerHTML = nickname;
		document.getElementById("cookie_user_name2").href = "http://my.cntv.cn";
		document.getElementById("cookie_user_name2").target = "_blank";
		document.getElementById('login').style.display = 'none';
		document.getElementById('logon2').style.display = 'block';
		document.getElementById("track").style.display = "block";
		document.getElementById("wb").href = "http://t.cntv.cn/index.php?m=index";
		document.getElementById("bk").href = "http://blog.cntv.cn/spacecp.php?docp=me";
		$("#right").css("width", "auto");
		if(shorturl=="http://my.cntv.cn/"&&$.browser.msie && $.browser.version<=7){$(".up ul li").css("padding-right","6px");}
	}else{
		alert(data.error);
	}
}
function loginDemo(){
	document.getElementById("username0102").value = document.getElementById("username0102").value;
	document.getElementById("password0102").value = document.getElementById("password0102").value;
	var re = /[^\u4e00-\u9fa5]/;
	var flg = re.test(document.getElementById("username0102").value);
	if (document.getElementById("username0102").value == "" || document.getElementById("username0102").value == "帐号") {
		document.getElementById("username0102").focus();
		return false
	} else if (document.getElementById("password0102").value == "") {
		document.getElementById("password0102").style.display = "block";
		document.getElementById("password0102").focus();
		return false
	} else if (flg == false) {
		alert("帐号或密码错误");
		document.getElementById("username0102").value = "";
		document.getElementById("username0102").focus();
		return false;
	}
	var form = document.getElementById("loginForm");
	if ($("#check_user").attr('checked') == 'checked') {
	$("#check_user").attr("value", "checktrue");
	}else{
	$("#check_user").attr("value","");
	}
	passport.checkJsonpForm(form, handleResult);
	}
function afterLogout(){
	location.reload();
}
function logout_20111107(){
	var from = shorturl;
	passport.logout(from,afterLogout);
	if (getCookie1('cntv_main_usr') == "" || getCookie1('cntv_main_usr') == null) {
		$('#SI_Top_LoginLayer .loginformlist table').eq(0).find('tr').eq(0).find('td').html('<input type="text" name="username" onfocus="if(this.value==this.defaultValue){this.value=\'\'}" onblur="if(this.value==\'\'){this.value=this.defaultValue}" value="帐号" id="username0102" class="styles" autocomplete="off" onkeypress="getOnkeyDown_login(event)"><input type="hidden" value="client_transaction" id="service" name="service"><input type="hidden" value="http://www.cntv.cn" id="from" name="from">');
	} else {
		$("#username0102").attr("value", getCookie1('cntv_main_usr'));
		$("#username0102").attr("onblur", "").attr("onfocus", "");
		$("#check_user").attr('checked', true);
	}
	document.getElementById('login').style.display = 'block';
	document.getElementById("passwd_view").style.display = "block";
	document.getElementById("password0102").value = "";
	document.getElementById("password0102").style.display = "none";
	document.getElementById('logon2').style.display = 'none';
	document.getElementById('track').style.display = 'none';
	$("#right").removeAttr("style");
	$("#right").addClass("jianrong");
}
function getOnkeyDown_login(e){
var ev = e;
ev = ev || event;
if(ev.keyCode == 13){
loginDemo();
}
}
function show_pwd() {
    document.getElementById("passwd_view").style.display = "none";
    document.getElementById("password0102").style.display = "block";
    document.getElementById("password0102").focus()
}
function checkTime(i) {
    if (i < 10) {
        i = "0" + i
    }
    return i
}
var array = [{
    "id": "1",
    "img_title": "电脑",
    "className": "client01"
},
{
    "id": "2",
    "img_title": "手机",
    "className": "client02"
},
{
    "id": "3",
    "img_title": "平板",
    "className": "client03"
}];
function callback(json) {
    if (json.code === 0) {
        html = [];
        for (var i in json.list) {
            var time = json.list[i].position;
            var img_clienttype = json.list[i].clienttype;
            var className = "";
            var width = 0;
            var img_title = "";
            var title = "";
            if (json.list[i].title.length > 13) {
                title = json.list[i].title.substring(0, 13) + "..."
            } else {
                title = json.list[i].title
            }
            if (img_clienttype == 1) {
                className = array[0].className;
                img_title = array[0].img_title
            } else if (img_clienttype == 2) {
                className = array[1].className;
                img_title = array[1].img_title
            } else if (img_clienttype == 3) {
                className = array[2].className;
                img_title = array[2].img_title
            } else {
                className = array[0].className;
                img_title = array[0].img_title
            }
            if (time == -1) {
                fina = "已看完"
            } else {
                var hour = checkTime(parseInt(time / 60 / 60));
                var minutes = checkTime(parseInt(time / 60));
                var seconds = checkTime(time % 60);
                if (hour == 0 && minutes == 0 & seconds == 0) {
                    fina = "已看到&nbsp;00：00：00"
                } else {
                    fina = "已看到&nbsp;" + hour + "：" + minutes + "：" + seconds
                }
            }
            if(json.list[i].pageurl.length == 0){
				html.push('<dd><span class="client ' + className + '"></span><span class="info"><em><a id="'+json.list[i].vid+'" class="url_null" target="_blank" href="' + json.list[i].pageurl + '" title="' + json.list[i].title + '">' + title + '</a></em><i>' + fina + '</i></span></dd>');
			}else{
				html.push('<dd><span class="client ' + className + '"></span><span class="info"><em><a target="_blank" href="' + json.list[i].pageurl + '" title="' + json.list[i].title + '">' + title + '</a></em><i>' + fina + '</i></span></dd>');
			}
        }
        document.getElementById('gkjl').innerHTML = html.join("");
		var page_num = $("#track .url_null").length;
		for(var j=0;j<page_num;j++){
			var page_vid = $("#track .url_null").eq(j).attr("id");
			var url = 'http://api.cntv.cn/video/videoinfoByGuid?serviceId=cbox&guid='+page_vid+'&cb=?&t=jsonp';
			$.getJSON(url,function(data){
				var page_url = data.url;
				var new_vid = data.vid;
				$("#"+new_vid).attr("href",page_url);
			})
		}		
    } else if (json.code === -201) {
        document.getElementById('gkjl').innerHTML = '<dd><span class="client client01" style="display:none;"></span><span class="info"><em><a href="javascript:;" title="">没有任何视频观看记录</a></em><i style="display:none;"></i></span></dd>'
    }
    tc()
}
$(".track").hover(function() {
    $(".tracklist").css({
        "display": "block"
    });
    var o = document.createElement('script');
    o.src = "http://history.apps.cntv.cn/interface/jsonp/service.php?client=3&method=video.getUserVideoRecordList&cb=callback&data=" + encodeURIComponent('{"uid":' + sns_userid + '}') + "&" + Math.random();
    document.getElementsByTagName("HEAD")[0].appendChild(o)
},
function() {
    $(".tracklist").css({
        "display": "none"
    });
    delete o
});
function tc() {
    $(".tracklist .box .item_list dl dd").hover(function() {
        $(this).addClass("active")
    },
    function() {
        $(this).removeClass("active")
    })
}
function getCookie1(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg)) return unescape(arr[2]);
    else return null
}
function setCookie(name, value) {
    var Days = 14;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString()
}
function delCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval = getCookie1(name);
    if (cval != null) document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString()
}
function get_main_usr() {
    if (getCookie1('cntv_main_usr') == "" || getCookie1('cntv_main_usr') == null) {} else {
        $("#username0102").attr("value", getCookie1('cntv_main_usr'));
        $("#username0102").attr("onblur", "").attr("onfocus", "");
        $("#check_user").attr('checked', true);
    }
}
$(function() {
    get_main_usr()
});
$(function(){
	
	var str1_140106='<input class="styles" type="text" id = "username0102" name="username" value="帐号" onblur="if(this.value==\'\'){this.value=this.defaultValue;}" onfocus="if(this.value==this.defaultValue){this.value=\'\';}" autocomplete="off" onkeypress="getOnkeyDown_login(event)"><input type="hidden" name="service" id="service" value="client_transaction" /><input type="hidden" name="from" id="from" value="aaa" />';
	var str2_140106='<input type="text" class="ilogininp" maxlength="30" id="username" name="username" value="请输入邮箱/手机号" style="color:#999" onfocus="if(this.value==this.defaultValue){this.value=\'\'}" onblur="if(this.value==\'\'){this.value=this.defaultValue}" >';
	if (getCookie1('cntv_main_usr') == "" || getCookie1('cntv_main_usr') == null) {
		$("#SI_Top_LoginLayer .loginformlist table").eq(0).find("tr").eq(0).find("td").html(str1_140106);
		$("#check_user").attr('checked', false);	
	}else{
	$("#username0102").attr("value", getCookie1('cntv_main_usr'));
	$("#username0102").attr("onblur", "").attr("onfocus", "");
	$("#check_user").attr('checked', true);	
	}
	$("#frmLogin table tr").eq(0).find(".itd_con div").html(str2_140106);
});