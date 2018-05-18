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
use Think\Log;
use Think\Page;
use Think\Upload;
use Think\Image;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {

    //错误页面方法
//     Public function _empty(){
//         header("HTTP/1.0 404 Not Found");
//         $this->display('404:index');
//     }

    protected $userId = '';

    protected function _initialize(){
        
        //读取微平台左侧菜单数据，并赋给前端变量
        C('PAGE_OFFSET',5);
    }
    public function checkUserLogin(){
        $UID = is_login();
        if($UID){
            return $UID;
        }else{
            $this->redirect('User/login');
        }
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
        $Page->setConfig('prev', '<<上一页');
        $Page->setConfig('next', '下一页>>');
        $Page->rollPage=5;
        return $Page;
    }
    
    /*
     * 获取图片信息
    */
    public function getImageinfo($where){
        $imgModel = M('picture');
        return $imgModel->where($where)->select();
    }
	    /*
	     * 平台用户的单点登录验证即 租赁用户的登录验证
	     * 需要开启curl扩展
	     */
    /*public function CheckAdminLogin(){
        $user = session('admin_user');
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
                    session("admin_user",$userinfo);
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
    }*/
    
    
    
    /*
     * 上传头像
    * 用户头像尺寸  120*120  30*30   90*90
    */
    protected function upload_head($userId,$filename,$x,$y,$width,$height,$type='jpg')
    {
        if (!$_FILES[$filename]['tmp_name']) {
            $this->error('您没有选择图片');
        }
        $data=array();
        if(!C('HEADOPTIONS.IS_FTPUPLOAD')){
            $upload = new Upload();
            $upload->maxSize   =     3145728 ;
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath  =     C('HEADOPTIONS.UPLOAD_URL');
            $upload->savePath  =     ''; // 设置附件上传目录
            $upload->saveName  =     time().rand(1000, 9999);
            $info   =   $upload->uploadOne($_FILES[$filename]);
            $file_upload_url = C('HEADOPTIONS.UPLOAD_URL').$info['savepath'].$info['savename'];
            if($info){
                $image = new Image();
                $image->open($file_upload_url);
                $image->thumb(300,300,\Think\Image::IMAGE_THUMB_FIXED)->save($file_upload_url);
                if($x && $y && $width && $height){
                    $image->open($file_upload_url);
                    $file_crop_url = C('HEADOPTIONS.CROP_URL').date('Y-m-d').'_'.$info['savename'];
                    $image->crop($width, $height,$x, $y)->save($file_crop_url);
                    $image->open($file_crop_url);
                }else{
                    $image->open($file_upload_url);
                }
                //生成相应尺寸的头像
                $sizeData = C('HEADOPTIONS.HEAD_SIZS');
                foreach($sizeData as $key => $value){
                    $face =FaceUrl($userId,$value['w'].'x'.$value['h']);
                    self::forcemkdir($face);
                    $thumbinfo[$value['w']]=$image->thumb($value['w'],$value['h'],\Think\Image::IMAGE_THUMB_FIXED)->save(dirname($face).'/'.$userId.'.jpg');
                }
                if( $thumbinfo['300'] && $thumbinfo['120'] && $thumbinfo['90'] && $thumbinfo['30']){
                    return true;
                }else{
                    return false;
                }
            }
        }
    }
    
    public function forcemkdir($path)
    {
        if (! file_exists($path)) {
            self::forcemkdir(dirname($path));
            mkdir(dirname($path), 0777);
        }
    }
    
    
    
}
