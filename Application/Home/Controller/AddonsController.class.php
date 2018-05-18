<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;
use Think\Page;
use Think\Httpsqs;

/**
 * 扩展控制器
 * 用于调度各个扩展的URL访问需求
 */
class AddonsController extends Controller{

	public function _initialize(){
		/* 读取数据库中的配置 */
        $config = S('DB_CONFIG_DATA');
        if(!$config){
            $config = api('Config/lists');
            S('DB_CONFIG_DATA',$config);
        }
        C($config); //添加配置
		//读取微平台左侧菜单数据，并赋给前端变量
//         $sendto = C('LMENU');
//         $user_info = session("user");
//         $result = sendCurlRequest($sendto,array("id"=>"selectMenu","userId"=>$user_info['userid']));
//         $nav    = json_decode($result,true);
//         $this->assign('nav',$nav['data']);
        $this->assign("addon",I('_addons'));
	}

	protected $addons = null;

	public function execute($_addons = null, $_controller = null, $_action = null){
		if(C('URL_CASE_INSENSITIVE')){
			$_addons = ucfirst(parse_name($_addons, 1));
			$_controller = parse_name($_controller,1);
		}

	 	$TMPL_PARSE_STRING = C('TMPL_PARSE_STRING');
        $TMPL_PARSE_STRING['__ADDONROOT__'] = __ROOT__ . "/Addons/{$_addons}";
        C('TMPL_PARSE_STRING', $TMPL_PARSE_STRING);

        define ( 'ADDON_PUBLIC_PATH', __ROOT__ . '/Addons/' . $_addons . '/View/default/Public' );
        defined ( '_ADDONS' ) or define ( '_ADDONS', $_addons );
        defined ( '_CONTROLLER' ) or define ( '_CONTROLLER', $_controller );
        defined ( '_ACTION' ) or define ( '_ACTION', $_action );
        // js,css的版本
        if (APP_DEBUG) {
            defined ( 'SITE_VERSION' ) or define ( 'SITE_VERSION', time () );
        } else {
            defined ( 'SITE_VERSION' ) or define ( 'SITE_VERSION', C ( 'SYSTEM_UPDATRE_VERSION' ) );
        }
		if(!empty($_addons) && !empty($_controller) && !empty($_action)){
			$Addons = A("Addons://{$_addons}/{$_controller}")->$_action();
		} else {
			$this->error('没有指定插件名称，控制器或操作！');
		}
	}
	/**
	 * 重写模板显示 调用内置的模板引擎显示方法，
	 *
	 * @access protected
	 * @param string $templateFile
	 *        	指定要调用的模板文件
	 *        	默认为空 由系统自动定位模板文件
	 *        	支持格式: 空, index, UserCenter/index 和 完整的地址
	 * @param string $charset
	 *        	输出编码
	 * @param string $contentType
	 *        	输出类型
	 * @param string $content
	 *        	输出内容
	 * @param string $prefix
	 *        	模板缓存前缀
	 * @return void
	 */
	protected function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
	    $templateFile = $this->getAddonTemplate ( $templateFile );
	    $this->view->display ( $templateFile, $charset, $contentType, $content, $prefix );
	}
	function getAddonTemplate($templateFile = '') {
	    if (file_exists ( $templateFile )) {
	        return $templateFile;
	    }
	    // dump ( $templateFile );
	    $oldFile = $templateFile;
	    if (empty ( $templateFile )) {
	        $templateFile = T ( 'Addons://' . _ADDONS . '@' . _CONTROLLER . '/' . _ACTION );
	    } elseif (stripos ( $templateFile, '/Addons/' ) === false && stripos ( $templateFile, THINK_PATH ) === false) {
	        if (stripos ( $templateFile, '/' ) === false) { // 如index
	            $templateFile = T ( 'Addons://' . _ADDONS . '@' . _CONTROLLER . '/' . $templateFile );
	        } elseif (stripos ( $templateFile, '@' ) === false) { // // 如 UserCenter/index
	            $templateFile = T ( 'Addons://' . _ADDONS . '@' . $templateFile );
	        }
	    }
	
	    if (stripos ( $templateFile, '/Addons/' ) !== false && ! file_exists ( $templateFile )) {
	        $templateFile = ! empty ( $oldFile ) && stripos ( $oldFile, '/' ) === false ? $oldFile : _ACTION;
	    }
	    // dump ( $templateFile );//exit;
	    return $templateFile;
	}
	
	/*
	 * 获取图片信息
	 */
	public function getImageinfo($where){
	    if(C('IS_CACHE')){
	        import("Vendor.Memcache.Memch",'','.php');
	        $Memcache = new \Memch('imgVersion');
	        $cachename = 'imginfo_'.$where['id'];
	        $imginfo = $Memcache->getCache($cachename);
	        if(!$imginfo){
	            $imgModel = M('picture');
	            $imginfo=$imgModel->where($where)->select();
	            $Memcache->setCache($cachename, $imginfo);
	        }
	    }else{
	        $imgModel = M('picture');
	        $imginfo=$imgModel->where($where)->select();
	    }
	    
	    return $imginfo;
	}
	
	
	/**
	 * 分页输出
	 *
	 * @param type $total
	 *            信息总数
	 * @param type $parameter
	 *            配置，分页参数，用于拼接url查询条件
	 * @return type
	 */
	public  function page ($total, $parameter = array())
	{
	    $Page = new Page($total, C('PAGE_OFFSET'), $parameter);
	    $Page->rollPage=5;
	    return $Page;
	}
	
	// 获取应用模板信息
	protected  function getTemplateByDir($type = 'front') {
	    $dir = ONETHINK_ADDON_PATH . _ADDONS . '/View/' . $type ;
	
	    $dirObj = opendir ( $dir );
	    while ( $file = readdir ( $dirObj ) ) {
	        if ($file === '.' || $file == '..' || $file == '.svn' || is_file ( $dir . '/' . $file ))
	            continue;
	         
	        $res ['dirName'] = $res ['title'] = $file;
	
	        // 获取配置文件
	        if (file_exists ( $dir . '/' . $file .'/'._ADDONS. '/info.php' )) {
	            $info = require_once $dir . '/' . $file .'/'._ADDONS. '/info.php';
	            $res = array_merge ( $res, $info );
	        }
	        // 获取效果图
	        if (file_exists ( $dir . '/' . $file .'/'._ADDONS. '/info.php' )) {
	            $res ['icon'] = __ROOT__ . '/Addons/'._ADDONS.'/View/'.$type .'/'.$file.'/' . _ADDONS  . '/icon.png';
	        } else {
	            $res ['icon'] = '/'.__ROOT__ . 'Public/Home/interact/images/default.png';
	        }
	        $tempList [] = $res;
	        unset ( $res );
	        }
	        closedir ( $dir );
	        return $tempList;
	    }
	    
	    /*
	     * 平台用户的单点登录验证即 租赁用户的登录验证
	     * 需要开启curl扩展
	     */
	    public function CheckAdminLogin(){
	         $user = session('user');
	        if(empty($user)){
                $ticket = I('ticket',false);
	            $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	            if(!$ticket){
                    $getTicketUrl=C('SSO').$url;
                    if(strstr($url,'&ticket')){
                        //$getTicketUrl = rtrim($getTicketUrl,strstr($url,'&ticket'));
                        $getTicketUrl = explode('&ticket=', $getTicketUrl);
                        $getTicketUrl = $getTicketUrl[0];
                    }
	                header("Location:".$getTicketUrl);
	            }else{
	                $checkTicketUrl=C('SSOV').$ticket;
	                $curl=curl_init();
	                curl_setopt($curl, CURLOPT_URL, $checkTicketUrl);
	                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	                curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 25);
	                $result=curl_exec($curl);
	                curl_close ( $curl );
	                $userinfo=json_decode($result,true);
	                if(!empty($userinfo)){
	                    session("user",$userinfo);
	                    setcookie("PHPSESSID",session_id(),time()+1800,"/");
	                    return true;
	                }else{
                        $loginUrl = C('ADMIN_LOGIN_URL').$url;
                        if(strstr($url,'&ticket')){
                            //$loginUrl = trim($loginUrl,strstr($url,'&ticket'));
                            $loginUrl = explode('&ticket=', $loginUrl);
                            $loginUrl = $loginUrl[0];
                        }
	                    header("Location:".$loginUrl);
	                }
	            }
	        }else{
	            return true;
	        }
	    }
	    
	    
	    /*
	     * 前端会员用户的登录
	     * $userId  平台租赁用户的ID
	     */
	    public function checkUserLogin(){
	        if(is_login()){
	            return true;
	        }else{
	            $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	            $loginurl =  C('LOGINURL').urlencode($url);
	            header("Location:".$loginurl);
	        }
	    }
	    /*public function chekUserLogin($userId){
	        $memberId = cookie('memberId');
	        if(empty($memberId)){
	            $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."&userId=".$userId;
	            $loginurl =  C('LOGINURL').$url;
	            if(I('memberId')){
	               cookie('memberId',I('memberId'),60*60*24);
	               return true;
	            }else{
	                header("Location:".$loginurl);
	            }
	        }else{
	            return true;
	        }
	    }*/
	    
	    
	    
	   /*
	    * 导出csv文件
	    * $title = "语言,问题分类,问题描述,来源地址,电话,邮箱,qq,ip,浏览器,添加时间,状态,备注\n";
	    */
	    function export_csv($title,$filename,$data){
	        header("Content-type:text/csv;charset=GB2312");
	        header("Content-Disposition:attachment;filename=".$filename);
	        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	        header('Expires:0'); 
	        header('Pragma:public');
	        //$title = "语言,问题分类,问题描述,来源地址,电话,邮箱,qq,ip,浏览器,添加时间,状态,备注\n";
	        $titles = mb_convert_encoding($title,"GB2312","UTF-8");
	        //$titles=iconv('UTF-8','GB2312',$title);
	        exit($titles.$data);
	    }
}
