/*
ÖØÔØÒ£¿ØÆ÷µÇÂ¼·½·¨
*/
function doLogin(){
check_fromliuyan();
}
function pwin_login_init(){
var localUrl = document.location.href;
var passportUrl="http://passport.cntv.cn/login.jsp?addons="+localUrl+"&errtype=0";
var tmp=window.open(passportUrl,"_self","");
}
function pwin_toolbar_logout(){
logout();
}