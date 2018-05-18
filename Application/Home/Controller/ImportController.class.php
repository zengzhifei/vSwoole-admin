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
 * 文件上传控制器
 * 主要用于管理员上传文件
 */

class ImportController extends HomeController {
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


}
