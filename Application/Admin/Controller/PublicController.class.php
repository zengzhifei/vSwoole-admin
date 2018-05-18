<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;

/**
 * 后台首页控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class PublicController extends \Think\Controller {

    /**
     * 后台用户登录
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function login($username = null, $password = null, $verify = null){
        if(IS_POST){
            /* 检测验证码 TODO: */
            if(!check_verify($verify)){
                $this->error('验证码输入错误！');
            }

            /* 调用UC登录接口登录 */
            $User = new UserApi;
            $uid = $User->login($username, $password);
            if(0 < $uid){ //UC登录成功
                /* 登录用户 */
                $Member = D('Member');
                if($Member->login($uid)){ //登录用户
                    //TODO:跳转到登录前页面
                    $this->success('登录成功！', U('WebSocket/index'));
                } else {
                    $this->error($Member->getError());
                }

            } else { //登录失败
                switch($uid) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
        } else {
            if(is_login()){
                $this->redirect('WebSocket/index');
            }else{
                /* 读取数据库中的配置 */
                $config	=	S('DB_CONFIG_DATA');
                if(!$config){
                    $config	=	D('Config')->lists();
                    S('DB_CONFIG_DATA',$config);
                }
                C($config); //添加配置
                
                $this->display();
            }
        }
    }

    /* 退出登录 */
    public function logout(){
        if(is_login()){
            D('Member')->logout();
            session('[destroy]');
            $this->success('退出成功！', U('login'));
        } else {
            $this->redirect('login');
        }
    }

    public function verify(){
        $verify = new \Think\Verify(array("useCurve"=>false,"useNoise"=>true,"length"=>4));
        $verify->entry(1);
    }
    
    //文件/夹管理
    function browseFile($spath = '', $stype = 'file',$uid='',$op='') {
        $base_path = '/Uploads/Picture/'.$uid;
        $enocdeflag = I('encodeflag', 0, 'intval');
        switch ($stype) {
            case 'picture':
                $base_path = '/Uploads/Picture/'.$uid;
                break;
            case 'file':
                $base_path = '/Uploads/file1';
                break;
            case 'ad':
                $base_path = '/Uploads/abc1';
                break;
            default:
                exit('参数错误');
                break;
        }
    
        if ($enocdeflag) {
            $spath = base64_decode($spath);
        }
    
        $spath = str_replace('.', '', $spath);
        if (strpos($spath, $base_path) === 0) {
            $spath = substr($spath,strlen($base_path));
        }
    
        $path = $base_path . '/'. $spath;
        $path = str_replace('//', '/', $path);
    
    
        $dir = new \Common\Lib\Dir('.'. $path);//加上.
        $list = $dir->toArray();
        for ($i=0; $i < count($list); $i++) {
            	
            $list[$i]['isImg'] = 0;
            if ($list[$i]['isFile']) {
                $url =  __ROOT__.rtrim($path,'/') . '/'. $list[$i]['filename'];
                $ext = explode('.', $list[$i]['filename']);
                $ext = end($ext);
                if (in_array($ext, array('jpg','png','gif'))) {
                    $list[$i]['isImg'] = 1;
                }
            }else {
                //为了兼容URL_MODEL(1、2)
                if (in_array(C('URL_MODEL'), array(1,2,3))) {
                    if($op){
                        $url = U('Public/browseFile', array('stype' => $stype,'uid'=>$uid,'op'=>$op, 'encodeflag' => 1 ,'spath'=>base64_encode(rtrim($path,'/') . '/'. $list[$i]['filename'])));
                    }else{
                        $url = U('Public/browseFile', array('stype' => $stype,'uid'=>$uid, 'encodeflag' => 1 ,'spath'=>base64_encode(rtrim($path,'/') . '/'. $list[$i]['filename'])));
                    }
                    	
                }else {
                    if($op){
                        $url = U('Public/browseFile', array('stype' => $stype,'uid'=>$uid,'op'=>$op, 'spath'=> rtrim($path,'/') . '/'. $list[$i]['filename']));
                    }else{
                        $url = U('Public/browseFile', array('stype' => $stype,'uid'=>$uid, 'spath'=> rtrim($path,'/') . '/'. $list[$i]['filename']));
                    }
                    	
                }
    
            }
            $list[$i]['url'] = $url;
            $list[$i]['size'] = get_byte($list[$i]['size']);
        }
        //p($list);
        $parentpath = substr($path, 0, strrpos($path, '/'));
        //为了兼容URL_MODEL(1、2)
        if (in_array(C('URL_MODEL'), array(1,2,3))) {
            if($op){
                $purl = U('Public/browseFile', array('spath'=> base64_encode($parentpath),'encodeflag' => 1, 'stype' => $stype,'uid'=>$uid,'op'=>$op));
            }else{
                $purl = U('Public/browseFile', array('spath'=> base64_encode($parentpath),'encodeflag' => 1, 'stype' => $stype,'uid'=>$uid));
            }
            	
        }else {
            if($op){
                $purl = U('Public/browseFile', array('spath'=> $parentpath, 'stype' => $stype,'uid'=>$uid,'op'=>$op));
            }else{
                $purl = U('Public/browseFile', array('spath'=> $parentpath, 'stype' => $stype,'uid'=>$uid));
            }
            	
        }
    
        $this->assign('purl', $purl);
        $this->assign('vlist', $list);
        $this->assign('stype', $stype);
        $this->assign('type', '浏览文件');
        $this->assign('op',$op);
        $this->display();
    
    }
    
    
    
    //文件/夹管理 ifram
    function iframBrowseFile($spath = '', $stype = 'file',$uid='',$op='') {
        $base_path = '/Uploads/Picture/'.$uid;
        $enocdeflag = I('encodeflag', 0, 'intval');
        switch ($stype) {
            case 'picture':
                $base_path = '/Uploads/Picture/'.$uid;
                break;
            case 'file':
                $base_path = '/Uploads/file1';
                break;
            case 'ad':
                $base_path = '/Uploads/abc1';
                break;
            default:
                exit('参数错误');
                break;
        }
    
        if ($enocdeflag) {
            $spath = base64_decode($spath);
        }
    
        $spath = str_replace('.', '', $spath);
        if (strpos($spath, $base_path) === 0) {
            $spath = substr($spath,strlen($base_path));
        }
    
        $path = $base_path . '/'. $spath;
        $path = str_replace('//', '/', $path);
    
    
        $dir = new \Common\Lib\Dir('.'. $path);//加上.
        $list = $dir->toArray();
        for ($i=0; $i < count($list); $i++) {
    
            $list[$i]['isImg'] = 0;
            if ($list[$i]['isFile']) {
                $url =  __ROOT__.rtrim($path,'/') . '/'. $list[$i]['filename'];
                $ext = explode('.', $list[$i]['filename']);
                $ext = end($ext);
                if (in_array($ext, array('jpg','png','gif'))) {
                    $list[$i]['isImg'] = 1;
                }
            }else {
                //为了兼容URL_MODEL(1、2)
                if (in_array(C('URL_MODEL'), array(1,2,3))) {
                    if($op){
                        $url = U('Public/iframBrowseFile', array('stype' => $stype,'uid'=>$uid,'op'=>$op, 'encodeflag' => 1 ,'spath'=>base64_encode(rtrim($path,'/') . '/'. $list[$i]['filename'])));
                    }else{
                        $url = U('Public/iframBrowseFile', array('stype' => $stype,'uid'=>$uid, 'encodeflag' => 1 ,'spath'=>base64_encode(rtrim($path,'/') . '/'. $list[$i]['filename'])));
                    }
    
                }else {
                    if($op){
                        $url = U('Public/iframBrowseFile', array('stype' => $stype,'uid'=>$uid,'op'=>$op, 'spath'=> rtrim($path,'/') . '/'. $list[$i]['filename']));
                    }else{
                        $url = U('Public/iframBrowseFile', array('stype' => $stype,'uid'=>$uid, 'spath'=> rtrim($path,'/') . '/'. $list[$i]['filename']));
                    }
    
                }
    
            }
            $list[$i]['url'] = $url;
            $list[$i]['size'] = get_byte($list[$i]['size']);
        }
        //p($list);
        $parentpath = substr($path, 0, strrpos($path, '/'));
        //为了兼容URL_MODEL(1、2)
        if (in_array(C('URL_MODEL'), array(1,2,3))) {
            if($op){
                $purl = U('Public/iframBrowseFile', array('spath'=> base64_encode($parentpath),'encodeflag' => 1, 'stype' => $stype,'uid'=>$uid,'op'=>$op));
            }else{
                $purl = U('Public/iframBrowseFile', array('spath'=> base64_encode($parentpath),'encodeflag' => 1, 'stype' => $stype,'uid'=>$uid));
            }
    
        }else {
            if($op){
                $purl = U('Public/iframBrowseFile', array('spath'=> $parentpath, 'stype' => $stype,'uid'=>$uid,'op'=>$op));
            }else{
                $purl = U('Public/iframBrowseFile', array('spath'=> $parentpath, 'stype' => $stype,'uid'=>$uid));
            }
    
        }
    
        $this->assign('purl', $purl);
        $this->assign('vlist', $list);
        $this->assign('stype', $stype);
        $this->assign('type', '浏览文件');
        $this->assign('op',$op);
        $this->display();
    
    }
    
    public function getImgId(){
        $ret  = array('status' => 'fail');
        $img = substr(trim(I("post.img")),strrpos(trim(I("post.img")) , "/Uploads"));
        $where['path'] = array('eq',$img);
        $imginfo = M("picture")->where($where)->find();
        if($imginfo){
            $ret['status'] = 'succ';
            $ret['id'] = $imginfo['id'];
        }
        $this->ajaxReturn($ret);
    }

}
