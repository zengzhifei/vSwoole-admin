<?php

namespace Addons\Research\Controller;
use Home\Controller\AddonsController;
use Think\Page;

class ShowController extends AddonsController{
    
    //调查前端的展示页
    public function index(){
        $id = I('rid',false);
        //if($id){
            $ResearchModel = D( 'Addons://Research/Research' );
            $resinfo=$ResearchModel->getReseInfoById($id);
            $style=$resinfo['style'];
    //         dump($rimginfo);
            $this->assign("resinfo",$resinfo);
        //}else{
           // $style='ColorV1';
           // $this->assign('status','404');
           // $this->assign("message",'您的访问方式不正确，请确认后继续进行调查活动！！！！');
        //}
        $this->assign('id',$id);
        $this->assign("link",ONETHINK_ADDON_PATH . _ADDONS.'/View/front/'.$style.'/'._ADDONS);
        $this->display(T( 'Addons://Research@front/'.$style.'/Research/index' ));
    }
    
    //不用了
    public function addUser(){
        $id = I('rid');
        $ResearchModel = D( 'Addons://Research/Research' );
        $resinfo=$ResearchModel->getReseInfoById($id);
         $style=$resinfo['style'];
        $this->assign("resinfo",$resinfo);
        $this->assign("link",ONETHINK_ADDON_PATH . _ADDONS.'/View/front/'.$style.'/'._ADDONS);
        $this->display(T ( 'Addons://Research@front/'.$style.'/Research/userinfo' ));
    }
    
    //调查前端题目页
    public function topic(){
        $id = I('rid');
        $ResearchModel = D( 'Addons://Research/Research' );
        $topiclist=$ResearchModel->getTopic('*',$id);
        $resinfo=$ResearchModel->getReseInfoById($id);
        if($resinfo['is_register'] == 1){
            $this->checkUserLogin();
        }
         $style=$resinfo['style'];
        $topinfo=array();
        foreach($topiclist as $key=>$value){
            $topinfo = $ResearchModel->getTopicInfo($value['id']);
            $topiclist[$key]['optionlist'] = $topinfo['optionlist'];
        }
        //print_r($topiclist);
        $this->assign("reseachid",$id);
        $this->assign("topicNumber",count($topiclist));
        $this->assign("topiclist",$topiclist);
        $this->assign("link",ONETHINK_ADDON_PATH . _ADDONS.'/View/front/'.$style.'/'._ADDONS);
        $this->display(T ( 'Addons://Research@front/'.$style.'/Research/topic' ));
    }
    
    //提交调查
    public function addTopic(){
        $researchid = I('researchid');
        $topicid = I('topicid','');
        $optionid= I('optionid','');
        $userid = session('user_auth.uid');
        $ResearchModel = D( 'Addons://Research/Research' );
        $resinfo=$ResearchModel->getReseInfoById($id);
        if($resinfo['is_register'] == 1 && $userid == ''){
            $url = $_SERVER['HTTP_REFERER']."&userId=".$resinfo['uid'];
            $loginurl =  C('LOGINURL').urlencode($url);
            $ret['url'] = $loginurl;
            $ret['code'] = '001';
            $ret['msg'] = '您还未登录';
            $this->ajaxReturn($ret);
        }
        $topic_array = explode(',',$topicid);
        if(empty($topic_array)){
            $ret['msg'] = '请选择题目';
            $this->ajaxReturn($ret);
        }
        $option_array = explode(',',$optionid);
        if(empty($option_array)){
            $ret['msg'] = '请选择题目选项';
            $this->ajaxReturn($ret);
        }
        if(isset($userid) && $userid == ''){
            $userid = 0;
        }
        $data['userid'] = $userid;
        $data['researchid']    = $researchid;
        $data['time'] = time();
        $data['ip'] = get_client_ip();
        $option_id ='';
        foreach($option_array as $key => $value){
            $topic_option = explode('_',$value);
            $data['topicid'] = $topic_option[0];
            $data['optionid']= $topic_option[1];
            $option_id .=  $topic_option[1].',';
            $result = $ResearchModel->castReseach($data);
        }
        $countwhere['resultid'] = array('eq',$researchid);
        $countwhere['time']     = array('eq',strtotime(date('Y-m-d')));
        $countwhere['type']     = array('eq',intval(1));
        $countdata['resultid'] = $researchid;
        $countdata['time']     = strtotime(date('Y-m-d'));
        $countdata['type'] = intval(1);
        $rest = $ResearchModel->saveInteractCount($countwhere,$countdata);
        if($rest){
            $where['id'] = array('in',$topicid);
            $res = $ResearchModel->updateTopicNumber($where,1);
            $where1['id'] = array('in',trim($option_id,','));
            $re = $ResearchModel->updateOptionNumber($where1);
            $ret['status'] = 'success';
        }else{
            $ret['msg'] = '请选择题目';
        }
        $this->ajaxReturn($ret);
    }
    
    //提交调查
    public function addTopic1(){
        $researchid = I('researchid');
        $topicid = I('topicid','');
        $optionid= I('optionid','');
        $userid = session('user_auth.uid');
        $ResearchModel = D( 'Addons://Research/Research' );
        $resinfo=$ResearchModel->getReseInfoById($id);
        if($resinfo['is_register'] == 1 && $userid == ''){
            $url = $_SERVER['HTTP_REFERER'];
            $loginurl =  C('LOGINURL').urlencode($url);
            $ret['url'] = $loginurl;
            $ret['code'] = '001';
            $ret['msg'] = '您还未登录';
            $this->ajaxReturn($ret);
        }
        $topic_array = explode(',',$topicid);
        if(empty($topic_array)){
            $ret['msg'] = '请选择题目';
            $this->ajaxReturn($ret);
        }
        $option_array = explode(',',$optionid);
        if(empty($option_array)){
            $ret['msg'] = '请选择题目选项';
            $this->ajaxReturn($ret);
        }
        if(isset($userid) && $userid == ''){
            $userid = 0;
        }
        $data['userid'] = $userid;
        $data['researchid']    = $researchid;
        $data['time'] = time();
        $data['ip'] = get_client_ip();
        $option_id ='';
        foreach($option_array as $key => $value){
            $topic_option = explode('_',$value);
            $data['topicid'] = $topic_option[0];
            $data['optionid']= $topic_option[1];
            $option_id .=  $topic_option[1].',';
            $result = $ResearchModel->castReseach($data);
        }
        $countwhere['resultid'] = array('eq',$researchid);
        $countwhere['time']     = array('eq',strtotime(date('Y-m-d')));
        $countwhere['type']     = array('eq',intval(1));
        $countdata['resultid'] = $researchid;
        $countdata['time']     = strtotime(date('Y-m-d'));
        $countdata['type'] = intval(1);
        $InteractModel = D( 'Addons://Research/InteractCount' );
        if($rest){
            $where['id'] = array('in',$topicid);
            $res = $ResearchModel->updateTopicNumber($where,1);
            $where1['id'] = array('in',trim($option_id,','));
            $re = $ResearchModel->updateOptionNumber($where1);
            $ret['status'] = 'success';
        }else{
            $ret['msg'] = '请选择题目';
        }
        $this->ajaxReturn($ret);
    }
    
    //调查结束页
    public function end(){
        $id = I('rid');
        $ResearchModel = D( 'Addons://Research/Research' );
        $resinfo=$ResearchModel->getReseInfoById($id);
        $huodonginfo = json_decode($resinfo['endjump'],true);
        $style=$resinfo['style'];
        if(!empty($huodonginfo)){
            $this->assign('huodonginfo',$huodonginfo);
        }
        $this->assign("resinfo",$resinfo);
        $this->assign("link",ONETHINK_ADDON_PATH . _ADDONS.'/View/front/'.$style.'/'._ADDONS);
        $this->display(T ( 'Addons://Research@front/'.$style.'/Research/end' ));
    }
}
