<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 前台公共库文件
 * 主要定义前台公共函数库
 */

/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1){
	$verify = new \Think\Verify();
	return $verify->check($code, $id);
}

/**
 * 获取列表总行数
 * @param  string  $category 分类ID
 * @param  integer $status   数据状态
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_list_count($category, $status = 1){
    static $count;
    if(!isset($count[$category])){
        $count[$category] = D('Document')->listCount($category, $status);
    }
    return $count[$category];
}

/**
 * 获取段落总数
 * @param  string $id 文档ID
 * @return integer    段落总数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_part_count($id){
    static $count;
    if(!isset($count[$id])){
        $count[$id] = D('Document')->partCount($id);
    }
    return $count[$id];
}

/**
 * 获取导航URL
 * @param  string $url 导航URL
 * @return string      解析或的url
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_nav_url($url){
    switch ($url) {
        case 'http://' === substr($url, 0, 7):
        case '#' === substr($url, 0, 1):
            break;        
        default:
            $url = U($url);
            break;
    }
    return $url;
}
/**
 * CURL请求
 * @return mixed
 */
function sendCurlRequest($sendTo, $data, $send_type = 'get', $header = '') {
	//初始化CURL
	$ch = curl_init();
	//请求地址
	if ($send_type == 'get' && empty($data) == false) {
		$sendTo .= '?';
		foreach ($data as $k => $v) {
			$sendTo .= $k . '=' . $v . '&';
		}
		$sendTo = rtrim($sendTo, '&');
	}
	curl_setopt($ch, CURLOPT_URL, $sendTo);
	if ($header != '') {
		//设置本次请求的header信息
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header );
	}
	if (strtolower($send_type) == 'post') {
		//设置post提交
		curl_setopt($ch, CURLOPT_POST, true);
	}
	//设置请求链接超时时间
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
	//把结果返回，而非直接输出
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//提交post数据
	if (strtolower($send_type) == 'post') {
		//设置post提交
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}

	//执行CURL请求
	$curl_result = curl_exec($ch);
	//关闭CURL请求
	curl_close($ch);
	return $curl_result;
}

//截取中文内容
function znsubstr($str,$start,$len){
	$tmpstr="";
	$strlen=$start+$len;
	for($i=0;$i<$strlen;$i++){
		if(ord(substr($str,$i,1))>127){
			$tmpstr.=substr($str,$i,3);
			$i+=2;
		}else{
			$tmpstr.=substr($str,$i,1);
		}
	}
	return $tmpstr;
}



/**
 * 计算用户头像地址 上传头像
 * @param int $userId 数字id
 * @param string $snap 缩图类型(300*300、120*120、90*90、30*30)
 */
function FaceUrl($userId, $snap = '120x120'){
    $dir1 = $userId % 999;
    $dir2 = intval($userId / 7) % 999;
    return $userhead = C("HEADOPTIONS.THUMB_URL").$snap.'/'.$dir1.'/'.$dir2.'/'.$userId.'.jpg' ;
}
/**
 * 计算用户头像地址 前台用
 * @param int $userId 数字id
 * @param string $snap 缩图类型(300*300、150*150、90*90、50*50 32*32)
 */
function getFaceUrl($userId, $size='120'){
    $snap = $size.'x'.$size;
    $dir1 = $userId % 999;
    $dir2 = intval($userId / 7) % 999;
    $userhead = C("HEADOPTIONS.THUMB_URL").$snap.'/'.$dir1.'/'.$dir2.'/'.$userId.'.jpg' ;
    if(file_exists($userhead)){
        return __ROOT__.trim($userhead,'.');
    }else{
        return __ROOT__.C("HEADOPTIONS.DEFAULT_URL")."youxiang_2_".$size.".jpg";
    }
}