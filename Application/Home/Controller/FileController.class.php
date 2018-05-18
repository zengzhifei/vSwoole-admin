<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 文件控制器
 * 主要用于下载模型的文件上传和下载
 */

class FileController extends HomeController {
	/* 文件上传 */
	public function upload(){
		$return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
		$return['code'] = I("addons");
		/* 调用文件上传组件上传文件 */
		$File = D('File');
		$file_driver = C('DOWNLOAD_UPLOAD_DRIVER');
		$rootPath = './Addons/' . I('addons') . '/View/front/';
		$uploadinfo['rootPath'] = $rootPath;
		C('DOWNLOAD_UPLOAD.rootPath',$rootPath);
		$info = $File->upload(
			$_FILES,
			C('DOWNLOAD_UPLOAD'),
			C('DOWNLOAD_UPLOAD_DRIVER'),
			C("UPLOAD_{$file_driver}_CONFIG")
		);

		/* 记录附件信息 */
		if($info){
		    //上传成功后解压
		    if($info['name']['ext'] == 'zip'){
		        import('OT/PhpZip');
		        $archive  = new \PhpZip();
		        $zipfile   =  SITE_PATH.$info['name']['path']; //上传文件地址
		        $to_path = str_replace(".zip","",$info['name']['path']);
                $savepath  = SITE_PATH.$to_path; //解压地址
                $array     = $archive->GetZipInnerFilesInfo($zipfile); //压缩包信息
                $result = $archive->unZip($zipfile, $savepath);
                if($result){
                    unlink($zipfile);
                    $return['unzip'] = "解压成功！";
                }else{
                    $return['status'] = 0;
                    $return['info'] = "解压缩失败！";
                }
		    }
			$return['data'] = think_encrypt(json_encode($info['download']));
		} else {
			$return['status'] = 0;
			$return['info']   = $File->getError();
		}

		/* 返回JSON数据 */
		$this->ajaxReturn($return);
	}

	/* 下载文件 */
	public function download($id = null){
		if(empty($id) || !is_numeric($id)){
			$this->error('参数错误！');
		}

		$logic = D('Download', 'Logic');
		if(!$logic->download($id)){
			$this->error($logic->getError());
		}
		
	}
	
	
	
	/**
	 * 上传图片
	 * @author huajie <banhuajie@163.com>
	 */
	public function uploadPicture(){
	    //TODO: 用户登录检测
	    /* 返回标准数据 */
	    $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
	    /* 调用文件上传组件上传文件 */
	    $Picture = D('Picture');
	    $pic_driver = C('PICTURE_UPLOAD_DRIVER');
	    $uploadinfo = C('PICTURE_UPLOAD');
	    $subName = I('uid')."/".date('Y-m-d');
	    $uploadinfo['subName'] = $subName;
	    C('PICTURE_UPLOAD',$uploadinfo);
	    $info = $Picture->upload(
	            $_FILES,
	            C('PICTURE_UPLOAD'),
	            C('PICTURE_UPLOAD_DRIVER'),
	            C("UPLOAD_{$pic_driver}_CONFIG"),
	            I('uid')
	    ); //TODO:上传到远程服务器
	    /* 记录图片信息 */
	    if($info){
	        $return['status'] = 1;
	        $return = array_merge($info['download'], $return);
	    } else {
	        $return['status'] = 0;
	        $return['info']   = $Picture->getError();
	    }
	
	    /* 返回JSON数据 */
	    $this->ajaxReturn($return);
	}
	public function upload_file(){
	    $this->upload_file();
	}
}
