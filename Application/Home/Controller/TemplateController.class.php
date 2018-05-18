<?php


namespace Home\Controller;

use OT\File;

class TemplateController extends HomeController {
    //protected $app = array(array('code'=>'Vote','name'=>'微投票模版'),array('code'=>'Research','name'=>'微调研模版'),array('code'=>'Comment','name'=>'微评论模版'),array('code'=>'Draw','name'=>'微抽奖模版'));
    protected $app = array(array('code'=>'Vote','name'=>'微投票模版'),array('code'=>'Research','name'=>'微调研模版'));  
    protected $spath = '';
    
    protected function _initialize(){
        parent::_initialize();
        $this->CheckAdminLogin();
        $userinfo = session('admin_user');
        $this->userId = $userinfo['userid'];
        $sendto = C('LMENU');
        $result = sendCurlRequest($sendto,array("id"=>"selectMenu","userId"=>$this->userId));
        $nav    = json_decode($result,true);
        $this->assign('nav',$nav['data']);
        $this->spath = I("spath");
        $this->assign("spath",$this->spath);
        $this->assign("app",$this->app);
        $this->assign("addon",I('_addons'),'');
    }

    
    function index($spath = '', $stype = 'template',$uid='',$addons='Vote',$root='') {
        $enocdeflag = I('encodeflag', 0, 'intval');
        switch ($stype) {
            case 'picture':
                $base_path = '/uploads/Picture/'.$uid;
                break;
            case 'template':
                //$base_path = '/Addons/' . $addons . '/View/default/'.$addons.'/';
                $base_path = '/Addons/' . $addons . '/View/front';
                break;
            case 'ad':
                $base_path = '/uploads/abc1';
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
    
     // echo $path;
        $path_array = explode('/', $path);
        //var_dump($path_array);
        if($path_array[5] == ''){
            $root = 1;
        }
        $dir = new \Common\Lib\Dir('.'. $path);
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
                if (in_array($ext, array('css','js','php'))) {
                    $list[$i]['isUpdate'] = 1; //不可修改
                }
            }else {
                //为了兼容URL_MODEL(1、2)
                if (in_array(C('URL_MODEL'), array(1,2,3))) {
                    $url = U('Template/index', array('stype' => $stype,'uid'=>$uid,'addons'=>$addons, 'encodeflag' => 1 ,'spath'=>base64_encode(rtrim($path,'/') . '/'. $list[$i]['filename'])));
                }else {
                    $url = U('Template/index', array('stype' => $stype,'uid'=>$uid,'addons'=>$addons, 'spath'=> rtrim($path,'/') . '/'. $list[$i]['filename']));
                }
    
            }
            $list[$i]['url'] = $url;
            $list[$i]['bas_url'] = base64_encode(rtrim($path,'/') . '/'. $list[$i]['filename']);
            $list[$i]['size'] = get_byte($list[$i]['size']);
            $list[$i]['root'] = $root;
        }
        //p($list);
        $parentpath = substr($path, 0, strrpos($path, '/'));
        //为了兼容URL_MODEL(1、2)
        if (in_array(C('URL_MODEL'), array(1,2,3))) {
            $purl = U('Template/index', array('spath'=> base64_encode($parentpath),'encodeflag' => 1, 'stype' => $stype,'uid'=>$uid,'addons'=>$addons));
        }else {
            $purl = U('Template/index', array('spath'=> $parentpath, 'stype' => $stype,'uid'=>$uid,'addons'=>$addons));
        }

        $this->assign('purl', $purl);
        $this->assign('vlist', $list);//echo "<pre>";print_r($list);exit;
        $this->assign('stype', $stype);
        $this->assign('type', '浏览文件');
        $this->assign('spath',base64_encode($spath));
        $this->assign("addons",$addons);
        $this->assign("path",base64_encode($path));
        $this->display();
    
    }
    /*
     * 修改模版
     */
    public function edit_file(){
        $spath = I('spath');
        $filepath = SITE_PATH.base64_decode($this->spath);
        $is_write = I('is_write');
        if (file_exists($filepath)) {
            $data = new_html_special_chars(file_get_contents($filepath));
        }else{
            $data = "文件不存在！";
        }
        $this->assign('spath',$spath);
        $this->assign('data',$data);
        $this->assign('type', '浏览文件');
        $this->assign('is_write',$is_write);
        $this->display();
    }
    
    public function doEdit(){
        $ret['status'] = 'fail';
        $filepath = SITE_PATH.base64_decode($this->spath);
        $is_write = I('is_write');
        $code = stripslashes($_POST['code']);
        if ($is_write == 1) {
            $filename = basename($filepath);
            $data = array(
                    'fileid' => base64_decode($this->spath),
                    'userid' => $this->userId,
                    'username' => '',
                    'template' => new_addslashes(file_get_contents($filepath)),
                    'creat_at' => time()
            );
            $result = M('template_bak')->add($data);
            file_put_contents($filepath,htmlspecialchars_decode($code));
            $ret['status'] = "success";
            $ret['msg'] = "修改成功";
        } else{
            $ret['msg'] = "没有写入权限！";
        }
        $this->ajaxReturn($ret);
    }
    
    /**
     * 模版修改历史
     */
    public function templateLog(){
        $where['fileid'] = array("eq",base64_decode($this->spath));
        $log_list = M("template_bak")->where($where)->order("creat_at desc")->limit('50')->select();
        $this->assign("log_list",$log_list);
        $this->display();
    }
    
    /**
     * 删除模版修改记录
     */
    public function delTemplateLog(){
        $ret['status'] = 'fail';
        $id = I("id");
        $result = M("template_bak")->where("id = {$id}")->delete();
        if($result){
            $ret['status'] = "success";
            $ret['msg'] = "删除成功";
        }else{
            $ret['msg'] = "删除失败";
        }
        $this->ajaxReturn($ret);
    }
    /**
     * 还原历史记录
     */
    public function restore() {
        $ret['status'] = 'fail';
        $id = I("id");
        $filepath = SITE_PATH.base64_decode($this->spath);
        $data = M("template_bak")->where("id = {$id}")->find();
        if ($data) {
            if (!is_writable($filepath)) {
                $ret['msg'] = "文件没有写权限！";
            }
            if (@file_put_contents($filepath,stripslashes($data['template']))) {
                $ret['status'] = "success";
                $ret['msg'] = "还原成功！";
            } else {
                $ret['msg'] = "操作失败！";
            }
            	
        } else {
            $ret['msg'] = "没有历史记录！";
        }
        $this->ajaxReturn($ret);
    }
    /**
     * 查看历史记录
     */
    public function show(){
        $id = I("id");
        $info = M("template_bak")->where("id = {$id}")->find();
        $data = new_html_special_chars(stripslashes($info['template']));
        $this->assign('data',$data);
        $this->display();
    }
    /**
     * 导出模版
     */
    public function export(){
        $bas_url = I("bas_url");
        $filename = I("filename");
        $filepath = SITE_PATH.base64_decode($bas_url);
        import('OT/PhpZip');
        $archive  = new \PhpZip();
        $result = $archive->ZipAndDownload($filepath,$filename.'_'.date("YmdHis", time()));
    }
    
    /**
     * 删除模版文件夹及下面的文件
     */
    public function delTemplate(){
        $ret['status'] = "fail";
        $bas_url = I("bas_url");
        $filename = I("filename");
        $filepath = base64_decode($bas_url);
        $file = new File();
        $result = $file->del_dir('.'. $filepath);
        if($result){
            $ret['status'] = "success";
            $ret['msg'] = "删除成功";
        }else{
            $ret['msg'] = "删除失败";
        }
        $this->ajaxReturn($ret);
    }
    


}