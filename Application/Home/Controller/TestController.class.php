<?php


namespace Home\Controller;
use Think\Controller;

class TestController extends Controller {

	//系统首页
    public function index(){       
        $this->assign('uid',132654);         
        $this->display();
    }
    
    public function test(){
        var_dump(APP_DEBUG);
        $result = del_dir(CONFIG_CACHE_PATH);var_dump($result);exit;//删除数据缓存目录
        $score_info = array('score_type'=>'sub','score'=>'1','column_id'=>'AB');
        $aa = action_log('to_prize', 'vote', 1,10,$score_info);var_dump($aa);exit;//减积分
        $aa = action_log('add_research', 'vote', 1, 10,$score_info);var_dump($aa);exit;//加积分
        $this->display();
    }
    
}