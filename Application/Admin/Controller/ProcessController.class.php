<?php

namespace Admin\Controller;


class ProcessController extends AdminController {

    protected $stage_id;
    
    public function _initialize(){
        parent::_initialize();
        $stage_id = I("stage_id",false);
        if (!$stage_id) {
            $stageInfo = $this->getStartStage();
            $stage_id = $stageInfo ? $stageInfo['stage_id'] : false;
        }
        $this->stage_id = $stage_id;
        $this->assign('menuname', "主持人流程");
    }
    
    public function index(){
        $title = I('title',false);
        $p    = I('p',1,'intval');
        $from = I('from',false);
        $to   = I('to',false);
        if($title){
            $this->assign('title',$title);
            $parameter['title'] = $title;
        }
        if($from){
            $this->assign('from',$from);
            $parameter['from'] = $from;
        }
        if($to){
            $this->assign('to',$to);
            $parameter['to'] = $to;
        }
        $processModel = D('Process');
        $count     = $processModel->getProcessCount($this->stage_id,$title,$this->UID,$from,$to);
        $Page      = $this->page($count,$parameter);
        $show      = $Page->weishow();
        $list  = $processModel->getProcessList($this->stage_id,$title,$this->UID,$from,$to,$p,$Page->firstRow,$Page->listRows);
        $totalpage = $Page->totalPages;
        $this->assign('data',compact('list','p','totalpage'));
        $this->assign("page",$show);
        $this->display();
    }
    
   
    //添加
    public function add(){
        $this->assign('UID',$this->UID);
        $this->display();
    }
   
    
   //执行添加
   public function saveProcess(){
       $processModel = D('Process');
       
       $title = I('title');
       $content  = $_POST['content'];
       $created = $updated = time();
       
       $data['stage_id'] = $this->stage_id;
       $data['title'] = $title;
       $data['uid'] = $this->UID ? $this->UID : '';
       $data['content'] = $content;
       $data['created'] = $created;
       $data['updated'] = $updated;
       
       $result = $processModel->addProcess($data);
       if($result){
           $data=array('status'=>1,'info'=>'添加成功');
       }else{
           $data=array('status'=>-1,'info'=>'添加失败');
       }
       
       $this->ajaxReturn($data);
   }
   
   public function update(){
       $processId = I('processId',false);
       $where['id'] = array('EQ',$processId);
       $processModel = D('Process');
       $processInfo  = $processModel->getProcessById($where);
       $this->assign('processInfo',$processInfo);
       $this->display();
   }
    
    
   //执行修改
   public function updateProcess(){
       $processModel = D('Process');
       $processId = I('processId',0,'intval');
       $title = I('title');
       $content = $_POST['content'];
       
       if($processId){
           $data['updated']  = time();
           $data['title']  = $title;
           $data['content']  = $content;
           $where['id'] = array('EQ',$processId);
           $result = $processModel->saveProcess($where,$data);
           if($result){
               $data=array('status'=>1,'info'=>'更新成功');
           }else{
               $data=array('status'=>-1,'info'=>'更新失败');
           }
       }
       
     
       $this->ajaxReturn($data);
   }
   
   
   public function deleteProcess(){
       $processId = I('processId',0);
       if($processId){
           $processModel = D('Process');
           $where['id'] = array('in',$processId);
           $result=$processModel->deleteProcess($where);
           if($result){
               $data=array('status'=>1);
           }else{
               $data=array('status'=>-1);
           }
       }else{
           $data = array('status'=>-1);
       }
       $this->ajaxReturn($data);
   }
   
   
   
   /*
    *更改流程顺序 
    */
   public function updateProcessorder(){
       $processid = I('processid',false);
       $processorder = I('processorder',0,false);
       $where['id'] = array('EQ',$processid);
       $data['process_order']= $processorder;
       $data['updated']= time();
   
       $processModel = D('Process');
       $result = $processModel->saveProcess($where,$data);
       if($result){
           $data=array('status'=>1,'info'=>'添加成功');
       }else{
           $data=array('status'=>-1,'info'=>'添加失败');
       }
       $this->ajaxReturn($data);
   }
}
