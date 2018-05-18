<?php

namespace Admin\Controller;
use Admin\Controller\AdminController;
use Think\Page;

class ResearchController extends AdminController{
    public function _initialize(){
        //parent::_initialize();
        $this->CheckAdminLogin();
        $userinfo = session('user');
        $this->userId = $userinfo['userid'];
        $this->assign('menuname', "调查");
    }
    public function index(){
        $keyword = I('keyword',false);
        $type    = I('type',false,'intval');
        /*$from    = I('from',false);
        $to      = I('to',false);*/
        $p    = I('p',1,'intval');
        if($keyword){
            $parameter['keyword'] = $keyword;
            $this->assign('keyword',$keyword);
        }
        if($type){
            $parameter['type'] = $type;
            $this->assign('type',$type);
        }
        //dump($where);
        $Rese = D( 'Research' );
        $count     = $Rese->getReseListCount($keyword,$type,$this->userId);
        $Page      = $this->page($count,$parameter);
        $show      = $Page->weishow();
        $list      = $Rese->getReseList($keyword,$type,$this->userId,$p,$Page->firstRow,$Page->listRows);
        $this->assign("p",$p);
        $this->assign("totalpage",$Page->totalPages);
        $this->assign("page",$show);
        $this->assign('list',$list);
        $this->display('index');
    }
    
    public function addRese(){
        $this->assign("uid",$this->userId);
        $this->assign('template',$this->getTemplateByDir());
        $this->display('addRese');
    }
    
    public function endJump(){
        $type    = I('lucky_type',1,'intval');
        $p    = I('p',1,'intval');
        
        $where=array();
        $where['end_time'] = array('gt',time());
        $where['lucky_type'] = array('eq',$type);
        $where['uid'] = $this->userId;
        $parameter['lucky_type'] = $type;
        $this->assign('lucky_type',$type);
        C('PAGE_OFFSET',5);
        $Rese = D( 'Research' );
        $lucktype  = $Rese->getLuckyType();
        $this->assign('jumpinfo',$lucktype);
        $tableName = $lucktype[0]['code'];
        $order = 'updated DESC';
        $Model = M($tableName);
        $count     = $Model->where($where)->count();
        $Page      = $this->page($count,$parameter);
        $show      = $Page->weishow();
        $list      = $Model->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign("p",$p);
        $this->assign("totalpage",$Page->totalPages);
        $this->assign("page",$show);
        $this->assign('list',$list);
        $this->display("endJump");
    }
    
    public function dateilRese(){
        $id = I('id',false,'intval');
        $ReseModel = D( 'Research' );
        $TopicModel = D( 'Topic' );
        $reseinfo=$ReseModel->getReseInfoById($id);
        $huodonginfo = json_decode($reseinfo['endjump'],true);
        $topilist=$TopicModel->getTopic('*',$id);
        foreach($topilist as $key=>$value){
            $TopicInfo = $TopicModel->getTopicInfo($value['id']);
            $topilist[$key]['optionlist'] = $TopicInfo['optionlist'];
        }
        $where['id'] = array('eq',$reseinfo['imgurl']);
        $rimginfo = $this->getImageinfo($where);
        if(!empty($rimginfo[0]['path'])){
            $rimginfo[0]['path'] = C('BASE_URL').__ROOT__.$rimginfo[0]['path'];
        }else{
            $rimginfo[0]['path'] = $rimginfo[0]['url'];
        }
        $ABC= array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $this->assign('huodonginfo',$huodonginfo);
        $this->assign('ABC',$ABC);
        $this->assign('template',$this->getTemplateByDir());
        $this->assign('topiclist',$topilist);
        $this->assign('rimginfo',$rimginfo[0]);
        $this->assign('reseinfo',$reseinfo);
        $this->display('dateilRese');
    }
    
    public function editRese(){
        $id = I('id',false,'intval');
        $ReseModel = D( 'Research' );
        $reseinfo=$ReseModel->getReseInfoById($id);
        $where['id'] = array('eq',$reseinfo['imgurl']);
        $rimginfo = $this->getImageinfo($where);
        if(!empty($rimginfo[0]['path'])){
            $rimginfo[0]['path'] = C('BASE_URL').__ROOT__.$rimginfo[0]['path'];
        }else{
            $rimginfo[0]['path'] = $rimginfo[0]['url'];
        }
        $huodonginfo = json_decode($reseinfo['endjump'],true);
        $this->assign('huodonginfo',$huodonginfo);
        $this->assign('template',$this->getTemplateByDir());
        $this->assign('rimginfo',$rimginfo[0]);
        $this->assign('reseinfo',$reseinfo);
        $this->display('editRese');
    }
    
    public function saveRese(){
        $id = I ( 'id', 0, 'intval' );
        $data['uid'] = I ( 'uid' , false  );
        $data['keyword'] = I ( 'keyword' , false );
        $data['title'] = I( 'title' , false );
        $data['starttime'] = I( 'from' , false ,'strtotime' );
        $data['endtime'] = I( 'to' , false , 'strtotime' );
        $data['imgurl'] = I( 'pic_id' , false , 'intval' );
        $data['remark'] = I( 'remark' );
        $data['endremark'] = I( 'endremark' );
        $data['style'] = I( 'style' ,'');
        $data['is_register'] = I( 'is_register' ,'','intval');
        $data['source'] = I( 'source' );
        $huodong['id'] = I('huodongid',false,'intval');
        $huodong['title'] = I('huodongtitle');
        $huodong['url'] = addons_url('Lucky://Userlottery/lottery',array('luck_id'=>$huodong['id']));
        if($huodong['id']){
            $data['endjump'] = json_encode($huodong);
        }else{
            $data['endjump'] = '';
        }
        $ReseModel = D( 'Research' );
        if($id){
            $where['id'] = array( 'EQ' , $id);
            $result=$ReseModel->updateRese($where,$data);
            if($result){
                $data=array('status'=>1,'info'=>'编辑成功');
            }else{
                $data=array('status'=>-1,'info'=>'编辑失败');
            }
        }else{
            $data['creattime'] = time();
            $id = $ReseModel->addRese($data);
            if($id){
                $data=array('status'=>1,'info'=>'保存成功','id'=>$id);
            }else{
                $data=array('status'=>-1,'info'=>'保存失败');
            }
        }
        $this->ajaxReturn($data);
    }
    
    /*
     * 删除调研
    */
    public function deleteRese(){
        $id = I('id',false);
        if($id){
            $ReseModel = D( 'Research' );
            $result = $ReseModel->deleteRese($id);
            if($result){
                $data=array('status'=>1,'info'=>'删除成功');
            }else{
                $data=array('status'=>-1,'info'=>'删除失败');
            }
        }else{
            $data=array('status'=>-1,'info'=>'缺少调研ID');
        }
        $this->ajaxReturn($data);
    }
    
    
    /*
     * 获取调研下的题目列表
     * 
     */
    public function topicList(){
        $researchId = I('researchid',false,'intval');
        $p = I('p',1,'intval');
        if($researchId){
            $parameter['researchid'] = $researchId;
        }
        $order = 'id DESC';
        $topicModel = D( 'Topic' );
        $count     = $topicModel->getTopicListcount($researchId);
        $Page      = $this->page($count,$parameter);
        $show      = $Page->weishow();
        $list      = $topicModel->getTopicList($researchId,$p,$Page->firstRow,$Page->listRows);
        $this->assign("p",$p);
        $this->assign("totalpage",$Page->totalPages);
        $this->assign("page",$show);
        $this->assign('researchid',$researchId);
        $this->assign('list',$list);
        $this->display('topicList');
    }
    
    
    /*
     * 添加调研题目
     */
    public function addTopic(){
        $researchId = I('researchid',false,'intval');
        $this->assign('researchid',$researchId);
        $this->display('addTopic');
    }
    /*
     * 添加调研题目
    */
    public function editTopic(){
        $topicid = I('topicid',false,'intval');
        $TopiModel = D( 'Topic' );
        $topicinfo = $TopiModel->getTopicInfo($topicid);
        $topic = $topicinfo['topicinfo'];
        $optionlist = $topicinfo['optionlist'];
        $this->assign('topic',$topic);
        $this->assign('option',$optionlist);
        $this->display('editTopic');
    }
    
    public function saveTopic(){
        $data['researchid']     = I('researchid',false,'intval');
        $topicid       = I('topicid',false,'intval');
        $data['title']          = I('title',false);
        $data['answer_number'] = I('answer_number',false,'intval');
        $optiontitle = I('optiontitle');
        
        $TopicModel = D( 'Topic' );
        if($data['researchid']){
            if($topicid){
                $where['id'] = array('eq',$topicid);
                $data['uptime'] = time();
                $result =  $TopicModel->updateTopic($where,$data);
                $optionid = I('optionid');
                if($result){
                    foreach($optiontitle as $key=>$value){
                        $optionData[$key]['title'] = $value;
                        $optionData[$key]['topicid'] = $topicid;
                        $optionData[$key]['researchid'] = $data['researchid'];
                        $optionData[$key]['optionid'] = $optionid[$key];
                    }
                    $TopicModel->updateTopicoption($optionData);
                    $removeOptionid = I('removeOption',false);
                    if($removeOptionid){
                        $deleteOptionWhere['id'] = array('in',$removeOptionid);
                        M('topic_option')->where($deleteOptionWhere)->delete();
                    }
                    $data=array('status'=>1,'info'=>'题目编辑成功');
                }else{
                    $data=array('status'=>-1,'info'=>'题目编辑失败,请重新编辑');
                }
            }else{
                $topicid=$TopicModel ->addTopic($data);
                if($topicid){
                    foreach($optiontitle as $key=>$value){
                       if($value){
                           $optionData[$key-1]['title'] = $value;
                           $optionData[$key-1]['topicid'] = $topicid;
                           $optionData[$key-1]['researchid'] = $data['researchid'];
                       }
                    }
                    $result=$TopicModel->addTopicOption($optionData);
                    if($result){
                        $data=array('status'=>1,'info'=>'保存成功');
                    }else{
                        $data=array('status'=>-1,'info'=>'选项保存失败,请重新添加选项');
                    }
                }else{
                    $data=array('status'=>-1,'info'=>'题目添加失败');
                }
            }
        }else{
            $data=array('status'=>-1,'info'=>'缺少调研ID');
        }
        $this->ajaxReturn($data);
    }
    
    /*
     * 删除调研题目和题目的选项
    */
    public function deleteTopic(){
        $id = I('id',false);
        if($id){
            $topicModel = D( 'Topic' );
            $result = $topicModel->deleteTopic($id);
            if($result){
                $data=array('status'=>1,'info'=>'删除成功');
            }else{
                $data=array('status'=>-1,'info'=>'删除失败');
            }
        }else{
            $data=array('status'=>-1,'info'=>'缺少题目ID');
        }
        $this->ajaxReturn($data);
    }
    
    /*
     * 调查数据统计
     */
    public function chsetResearch(){
        $researchid = I('rid',false);
        //$researchid = 17;
        $topicid = I('topicid',false);
        //$topicid = 34;
        $ReserachModel = D( 'Research' );
        $ResearchInfo = $ReserachModel->getReseInfoById($researchid);
        $topicModel = D( 'Topic' );
        $toplist = $topicModel->getTopic('id,title,partake_number',$researchid);
        if($researchid && !$topicid){
            //统计调查的在有效期间每天的参与数
            $where['reserachid'] = intval($researchid);
            $chsetReserach=$ReserachModel->chsetResarch(intval($researchid));
            $ResearchInfo['starttime'] = intval($ResearchInfo['starttime']);
            $ResearchInfo['endtime'] = intval($ResearchInfo['endtime']);
            $i=0;
            while ($ResearchInfo['starttime']<=$ResearchInfo['endtime']){
                $chset[$i]['year'] = date('m/d',$ResearchInfo['starttime']);
                $chset[$i]['partake_number'] = intval(0);
                $ResearchInfo['starttime'] = strtotime('+1 day',$ResearchInfo['starttime']);
                $i++;
            }
            foreach($chset as $key=>$value){
                foreach($chsetReserach as $k=>$v){
                    if($v['year']==$value['year']){
                        $chset[$key]['partake_number'] = intval($v['partake_number']);
                    }
                }
            }
            $this->assign("research",json_encode($chset));
            $this->assign('rvalueField','partake_number');
            $this->assign('RcategoryField','year');
            $this->assign("divid",'chart_1');
            $this->assign("title",$ResearchInfo['title'].'---调研统计');
        }elseif($researchid && $topicid){
           //统计题目下的选项的参与数
           $topicinfo = $topicModel->getTopicInfo($topicid);
           foreach($topicinfo['optionlist'] as $key => $value){
               $optionset[$key]['option_title'] = $value['title'];
               $optionset[$key]['option_number'] = intval($value['partake_number']);
           }
           $this->assign("topicinfo",$topicinfo);
           $this->assign("divid",'chart_2');
           $this->assign("research",json_encode($optionset));
           $this->assign('rvalueField','option_number');
           $this->assign('RcategoryField','option_title');
           $this->assign("title",$ResearchInfo['title'].'--'.$topicinfo['topicinfo']['title'].'---调研统计');
        }
        $this->assign("researchinfo",$ResearchInfo);
        $this->assign("toplist",$toplist);
        $this->assign("rtitle",'参与数');
        $this->display("chsetResearch");
    }
    //class end
}
