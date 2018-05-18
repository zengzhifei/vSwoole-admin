<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use User\Api\UserApi;

/**
 * 用户控制器
 * 包括用户中心，用户登录及注册
 */
class UserController extends HomeController {

	/* 用户中心首页 */
	public function index(){
		
	}

	/* 注册页面 */
	 public function register1($username = '', $password = '', $repassword = '', $email = '', $verify = ''){
        if(!C('USER_ALLOW_REGISTER')){
            $this->error('注册已关闭');
        }
		if(IS_POST){ //注册用户
			/* 检测验证码 */
			if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}

			/* 检测密码 */
			if($password != $repassword){
				$this->error('密码和重复密码不一致！');
			}			

			/* 调用注册接口注册用户 */
            $User = new UserApi;
			$uid = $User->register($username, $password, $email);
			if(0 < $uid){ //注册成功
				//TODO: 发送验证邮件
				$this->success('注册成功！',U('login'));
			} else { //注册失败，显示错误信息
				$this->error($this->showRegError($uid));
			}

		} else { //显示注册表单
			$this->display();
		}
	}
   public function register(){
        if(is_login()){
           $this->redirect('Index/index');
        }
        /* if(!C('USER_ALLOW_REGISTER')){
            $this->error('注册已关闭');
        } */
		if(IS_POST){ //注册用户
		    $username = I('post.username',false);
		    $password = I('post.password',false);
		    $email    = I('post.email',false);
		    $mobile   = I('post.mobile',false);
			/* 检测验证码 */
			/*if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}*/

			/* 检测密码 */
			/* if($password != $repassword){
				$this->error('密码和重复密码不一致！');
			}	 */		

			/* 调用注册接口注册用户 */
            $User = new UserApi;
			$uid = $User->register($username, $password, $email,$mobile);
			if(0 < $uid){ //注册成功
				//TODO: 发送验证邮件
				//$this->success('',U('login'));
			    $data=array('msg'=>'注册成功','status'=>'success');
			} else { //注册失败，显示错误信息
				//$this->error($this->showRegError($uid));
				$data = array('msg'=>$this->showRegError($uid));
			}
			$this->ajaxReturn($data);

		} else { //显示注册表单
		    $this->assign('title','注册');
			$this->display();
		}
   }
   public function login(){
        if(is_login()){
            $this->redirect('Index/index');
        }
        if(IS_POST){ //登录验证
			/* 检测验证码 */
			/*if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}*/

			/* 调用UC登录接口登录 */
            ///$callBackurl = I('post.from',false);
			$user = new UserApi;
			$uid = $user->login(I('post.username',false), I('post.password',false));
			if(0 < $uid){ //UC登录成功
				/* 登录用户 */
				$Member = D('Member');
				if($Member->login($uid)){ //登录用户
					//TODO:跳转到登录前页面
					//$this->success('登录成功！',U('Home/Index/index'));
					    $data = array('msg'=>'登录成功','status'=>'success');
					
				} else {
					//$this->error($Member->getError());
					$data = array('msg'=>$Member->getError());
				}

			} else { //登录失败
				switch($uid) {
					case -1: $data=array('msg'=>'用户不存在或被禁用！'); break; //系统级别禁用
					case -2: $data=array('msg'=>'密码错误！'); break;
					default: $data=array('msg'=>'未知错误！'); break; // 0-接口参数错误（调试阶段使用）
				}
				//$this->error($error);
			}
			$this->ajaxReturn($data);

		} else { //显示登录表单
		    $this->assign('title','登录');
			$this->display();
		}
   }
	/* 登录页面 */
	public function login1($username = '', $password = '', $verify = ''){
		if(IS_POST){ //登录验证
			/* 检测验证码 */
			if(!check_verify($verify)){
				$this->error('验证码输入错误！');
			}

			/* 调用UC登录接口登录 */
			$user = new UserApi;
			$uid = $user->login($username, $password);
			if(0 < $uid){ //UC登录成功
				/* 登录用户 */
				$Member = D('Member');
				if($Member->login($uid)){ //登录用户
					//TODO:跳转到登录前页面
					$this->success('登录成功！',U('Home/Index/index'));
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

		} else { //显示登录表单
			$this->display();
		}
	}

	/* 退出登录 */
	public function logout(){
		/*if(is_login()){
			D('Member')->logout();
			$this->success('退出成功！', U('User/login'));
		} else {
			$this->redirect('User/login');
		}*/
	    if(is_login()){
	        D('Member')->logout();
	        //$this->success('退出成功！', U('User/login'));
	        $data= array('msg'=>'注销成功','status'=>'success');
	    } else {
	       // $this->redirect('User/login');
	        $data = array('status'=>'success');
	    }
	    $this->ajaxReturn($data);
	}

	/* 验证码，用于登录和注册 */
	public function verify(){
		$verify = new \Think\Verify();
		$verify->entry(1);
	}

	/**
	 * 获取用户注册错误信息
	 * @param  integer $code 错误编码
	 * @return string        错误信息
	 */
	private function showRegError($code = 0){
		switch ($code) {
			case -1:  $error = '用户名长度必须在16个字符以内！'; break;
			case -2:  $error = '用户名被禁止注册！'; break;
			case -3:  $error = '用户名被占用！'; break;
			case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
			case -5:  $error = '邮箱格式不正确！'; break;
			case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
			case -7:  $error = '邮箱被禁止注册！'; break;
			case -8:  $error = '邮箱被占用！'; break;
			case -9:  $error = '手机格式不正确！'; break;
			case -10: $error = '手机被禁止注册！'; break;
			case -11: $error = '手机号被占用！'; break;
			default:  $error = '未知错误';
		}
		return $error;
	}


    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function profile(){
		if ( !is_login() ) {
			$this->redirect(U('User/login'));
		}
        if ( IS_POST ) {
            //获取参数
            $uid        =   is_login();
            $password   =   I('post.old');
            $repassword = I('post.repassword');
            $data['password'] = I('post.password');
            empty($password) && $this->ajaxReturn(array('msg'=>'请输入原密码','status'=>'fail'));
            empty($data['password']) && $this->ajaxReturn(array('msg'=>'请输入新密码','status'=>'fail'));
            empty($repassword) && $this->ajaxReturn(array('msg'=>'请输入确认密码','status'=>'fail'));

            if($data['password'] !== $repassword){
                $this->ajaxReturn(array('msg'=>'密码与确认密码不一致','status'=>'fail'));
            }

            $Api = new UserApi();
            $res = $Api->updateInfo($uid,$password,$data);
            if($res['status']){
                //$this->success('修改密码成功！');
                $data = array('msg'=>'修改密码成功！','status'=>'success');
            }else{
                $data = array('msg'=>$this->error($res['info']),'status'=>'fail');
            }
            $this->ajaxReturn($data);
        }else{
            $this->assign('title','个人设置');
            $this->display();
        }
    }
    
    
    //修改用户信息
    public function userProfile(){
        if ( !is_login() ) {
            $this->redirect(U('User/login'));
        }
        $Api = new UserApi();
        $res = $Api->info(is_login());
        if ( IS_POST ) {
            $data['username'] = I('username');
            $data['mobile']   = I('mobile');
            $data['email']    = I('email');
            $password = 'ssss';
            empty($data['username']) && $this->ajaxReturn(array('msg'=>'请输入用户名','status'=>'fail'));
            empty($data['mobile']) && $this->ajaxReturn(array('msg'=>'请输入手机号','status'=>'fail'));
            empty($data['email']) && $this->ajaxReturn(array('msg'=>'请输入邮箱','status'=>'fail'));
            if($res[1] == $data['username']) unset($data['username']);
            if($res[2] == $data['email']) unset($data['email']);
            if($res[3] == $data['mobile']) unset($data['mobile']);
            $Api = new UserApi();
            $res = $Api->updateInfo(is_login(),$password,$data,C('ISPASSWORD'));
            if($res['status']){
                //$this->success('修改密码成功！');
                if($res[1] != $data['username']){
                    $Member=D('Member');
                    $where['uid'] = is_login();
                    $param['nickname'] = $data['username'];
                    $Member->where($where)->save($param);
                }
                $data = array('msg'=>'修改成功！','status'=>'success');
            }else{
                $data = array('msg'=>'修改失败','status'=>'fail');
            }
            $this->ajaxReturn($data);
        }else{
            $this->assign('userinfo',$res);
            $this->assign('title','个人设置');
            $this->display();
        }
    }
    
    /**
     * 修改设置头像
     */
    public function setHead(){
        if ( !is_login() ) {
            $this->redirect(U('User/login'));
        }
        if(IS_POST){
            $x    = I('x1',false,'intval');
            $y    = I('y1',false,'intval');
            $width = I('w' ,false,'intval');
            $height= I('h' ,false,'intval');
            $userId=is_login();
            $result=$this->upload_head($userId,'Member_headeimg',$x,$y,$width, $height);
            if($result){
                $this->redirect('Index/index');
            }else{
                $this->redirect('User/setHead');
            }
        }else{
            $this->assign('user_id',is_login());
            $this->assign('title','设置头像');
            $this->display();
        }
       
    }

}
