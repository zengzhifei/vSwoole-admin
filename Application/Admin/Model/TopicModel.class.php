<?php

namespace Admin\Model;
use Think\Model;

/**
 * Research模型
 */
class TopicModel extends Model{
    /*public $model = array(
        'title'=>'',//新增[title]、编辑[title]、删除[title]的提示
        'template_add'=>'',//自定义新增模板自定义html edit.html 会读取插件根目录的模板
        'template_edit'=>'',//自定义编辑模板html
        'search_key'=>'',// 搜索的字段名，默认是title
        'extend'=>1,
    );

    public $_fields = array(
        'id'=>array(
            'name'=>'id',//字段名
            'title'=>'ID',//显示标题
            'type'=>'num',//字段类型
            'remark'=>'',// 备注，相当于配置里的tip
            'is_show'=>3,// 1-始终显示 2-新增显示 3-编辑显示 0-不显示
            'value'=>0,//默认值
        ),
        'title'=>array(
            'name'=>'title',
            'title'=>'书名',
            'type'=>'string',
            'remark'=>'',
            'is_show'=>1,
            'value'=>0,
            'is_must'=>1,
        ),
    );*/
   public function _initialize(){
       parent::_initialize();
       if(C('IS_CACHE')){
           import("Vendor.Memcache.Memch",'','.php');
           $this->Memcache = new \Memch('researchVersion');
       }
   }
   
   
   public function getTopicListcount($researchId){
       if(C('IS_CACHE')){
           $Memcache  = $this->Memcache; 
           $cachename = "topiclistcount_".$researchId;
           $count = $Memcache->getCache($cachename);
           if(!$count){
               $where['researchid'] = array('EQ',$researchId);
               $count     = $this->where($where)->count();
               $Memcache->setCache($cachename, $count);
           }
       }else{
           $where['researchid'] = array('EQ',$researchId);
           $count     = $this->where($where)->count();
       }
       
       return $count;
   }
   
   public function getTopicList($researchId,$p,$fistRow,$listRows){
       if(C('IS_CACHE')){
           $Memcache = $this->Memcache;
           $cachename = "Toplist_".$researchId.'_'.$p;
           $list=$Memcache->getCache($cachename);
           if(!$list){
               $where['researchid'] = array('EQ',$researchId);
               $order = 'id DESC';
               $list      = $this->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
               $Memcache->setCache($cachename, $list);
           }
       }else{
           $where['researchid'] = array('EQ',$researchId);
           $order = 'id DESC';
           $list      = $this->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
       }
      
       return $list;
   }
   
   
   public function getTopic($field='*',$reseachid){
       $where['researchid'] = array('eq',$reseachid);
       return $this->field($field)->where($where)->order("id DESC")->select();
   }
   public function addTopic($data){
        $topicModel = M('topic');
        if(C('IS_CACHE')){
            $this->Memcache->updateCache();
        }
        return $topicModel->add($data);
    }
    
    public function updateTopic($where,$data){
        $topicModel = M('topic');
        if(C('IS_CACHE')){
            $this->Memcache->updateCache();
        }
        return $topicModel->where($where)->save($data);
    }
    
    public function addTopicOption($data){
        $topicoptionModel = M('topic_option');
        return $topicoptionModel->addAll($data);
    }
    
    /*
     * 删除投票
    */
    public function deleteTopic($id){
        $where['id'] = array('in',$id);
        $topicoptionModel = M('topic_option');
        $result = $this->where($where)->delete();
        if($result){
               $where1['topicid'] = array('in',$id);
               $result1=$topicoptionModel->where($where1)->delete();
               if($result1){
                   if(C('IS_CACHE')){
                       $this->Memcache->updateCache();
                   }
                   return true;
               }else{
                   return false;
               }
        }else{
            return false;
        }
    }
    
    
    public function getTopicInfo($id){
        $topicModel = M('topic');
        $topicoptionModel = M('topic_option');
        $topicwhere['id'] = array('eq',$id);
        $topicinfo = $topicModel->where($topicwhere)->find();
        $toptionwhere['topicid'] = array('eq',$id);
        $topicoptioninfo = $topicoptionModel->where($toptionwhere)->select();
        $Topicinfo['topicinfo'] = $topicinfo;
        $Topicinfo['optionlist'] = $topicoptioninfo;
        return $Topicinfo;
    }
    
    
    
    public function updateTopicoption($data){
        $topicoptionModel = M('topic_option');
        foreach($data as $key=>$value){
            if(!empty($value['optionid'])){
                $where['id'] = array('eq',$value['optionid']);
                $param['title'] = $value['title'];
                $param['researchid'] = $value['researchid'];
                $param['topicid'] = $value['topicid'];
                $topicoptionModel->where($where)->save($param);
            }else{
                $param['title'] = $value['title'];
                $param['researchid'] = $value['researchid'];
                $param['topicid'] = $value['topicid'];
                $topicoptionModel->add($param);
            }
        }
    }
    
    
    
    //前端调研的相关操作
    
    //更新投票的参与
    public function updateTopicNumber($where,$num){
        $result = $this->where($where)->setInc('partake_number',$num);
        return $result;
    }
    
    
    //更新选项的参与数
    public function updateOptionNumber($where){
        $result =  M("topic_option")->where($where)->setInc('partake_number');
        return $result;
    }
}
