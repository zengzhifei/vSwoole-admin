<?php

namespace Admin\Model;
use Think\Model;

/**
 * Research模型
 */
class ResearchModel extends Model{
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
    
    /*
     * 获取调研列表次数
     */
    public function getReseListCount($keyword,$type,$uid){
        if(C('IS_CACHE')){
            $Memcache = $this->Memcache;
            $cachename = 'ReseListCount_'.$uid.'_';
            if($keyword) $cachename.=$keyword.'_';
            if($type) $cachename.=$type;
            $count=$Memcache->getCache($cachename);
        }else{
            $count = false;
        }
        if(!$count){
            if($keyword){
                $where['keyword'] = array('LIKE','%'.$keyword.'%');
            }
            if($type){
                if($type == 1){
                    $where ['starttime'] = array ('gt',time());
                }
                if($type == 2){
                    $where['starttime'][] = array('lt',time());
                    $where ['endtime'] [] = array ('gt',time());
                }
                if($type == 3){
                    $where ['endtime'] = array ('lt',time());
                }
            }
            $where['uid'] = array('EQ',$uid);
            $count     = $this->where($where)->count();
            if(C('IS_CACHE')){
                $Memcache->setCache($cachename, $count);
            }
        }
        return $count;
    }
    
    /*
     * 获取调研列表
     */
    public function getReseList($keyword,$type,$uid,$p,$fistRow,$listRows){
        if(C('IS_CACHE')){
            $Memcache = $this->Memcache;
            $cachename = 'ReseachList_uid'.$uid.'_'.$p;
            if($keyword) $cachename .= '_'.$keyword;
            if($type) $cachename .='_'.$type;
            $list = $Memcache->getCache($cachename);
        }else{
            $list = false;
        }
        if(!$list){
            if($keyword){
                $where['keyword'] = array('LIKE','%'.$keyword.'%');
            }
            if($type){
                if($type == 1){
                    $where ['starttime'] = array ('gt',time());
                }
                if($type == 2){
                    $where['starttime'][] = array('lt',time());
                    $where ['endtime'] [] = array ('gt',time());
                }
                if($type == 3){
                    $where ['endtime'] = array ('lt',time());
                }
            }
            $order = 'creattime DESC';
            $where['uid'] = array('EQ',$uid);
            $list=$this->where($where)->order($order)->limit($fistRow.','.$listRows)->select();
            if(C('IS_CACHE')){
                $Memcache->setCache($cachename, $list);
            }
        }
        return $list;
    }
/*
     * 添加调研
     */
    public function addRese($data){
        $Memcache = $this->Memcache;
        $result=$this->add($data);
        if(C('IS_CACHE')){
            $Memcache->updateCache();
        }
        return $result;
    }
    
    /*
     * 根据投票id获取调研详情
    */
    public function getReseInfoById($id){
        if(C('IS_CACHE')){
            $Memcache = $this->Memcache;
            $cachename = "getReseInfoById_".$id;
            $info = $Memcache->getCache($cachename);
            if(!$info){
                $where['id'] = array('eq',$id);
                $info=$this->where($where)->find();
                $Memcache->setCache($cachename, $info);
            }
        }else{
            $where['id'] = array('eq',$id);
            $info=$this->where($where)->find();
        }
        return $info;
    }
    
    public function updateRese($where,$param){
        $Memcache = $this->Memcache;
        $result=$this->where($where)->save($param);
        if(C('IS_CACHE')){
            $Memcache->updateCache();
        }
        return $result;
    }
    
    /*
     * 删除调研
    */
    public function deleteRese($id){
        $where['id'] = array('in',$id);
        $result = $this->where($where)->delete();
        $topicModel = M('topic');
        $topicOptionModel = M('topic_option');
        if($result){
            $where1['researchid'] = array('in',$id);
            $resut1 = $topicModel->where($where1)->delete();
            $result2= $topicOptionModel->where($where1)->delete();
            if(C('IS_CACHE')){
                $this->Memcache->updateCache();
            }
            return true;
        }else{
            return false;
        }
    }
    
    //前端调研的相关操作
    
    //提交调研
    function castReseach($data){
        $Model = M('research_log');
        $result=$Model->add($data);
        if(C('IS_CACHE')){
            $this->Memcache->updateCache();
        }
        return $result;
    }
    
    
    //调查结束后调转活动类型
    public function getLuckyType(){
        $array = array(array('title'=>'大转盘','type'=>1,'code'=>'lucky'));
        return $array;
    }
    
    /*public function chsetResarch($researchid){
        $model = M('research_log');
        $count=$model ->where(array('researchid'=>$researchid))->field("FROM_UNIXTIME(time,'%m/%d') year,count('researchid') as partake_number")->group('year')->select();
        return $count;
    }*/
    
    public function chsetResarch($researchid){
        $model = M('interact_count');
        $count = $model ->where(array('resultid'=>$researchid))->field("FROM_UNIXTIME(time,'%m/%d') year,count as partake_number")->group('year')->select();
        return empty($count) ? false : $count;
    }
}
