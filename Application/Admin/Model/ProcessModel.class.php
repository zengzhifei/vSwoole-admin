<?php

namespace Admin\Model;
use Think\Model;

class ProcessModel extends Model {
    
    protected $tableName = 'process';
    
    
    public function getProcessList($stage_id,$title,$uid,$from,$to,$p,$firstRows,$listRows){
        if($stage_id){
            $where['stage_id'] = array('EQ',$stage_id);
        }
        if($title){
            $where['title'] = array('LIKE','%'.$title.'%');
        }
        if($from){
            $where['created'] = array(array('gt',strtotime(date('Y/m/d H:i:s',strtotime($from)))));
        }
        if($to){
            $to = strtotime(date('Y/m/d H:i:s',strtotime($to)));
            $where['created'] = array(array('lt',$to));
        }
        $where['uid'] = array('EQ',$uid);
        $order = 'process_order ASC,id ASC';
        $list      = $this->where($where)->order($order)->limit($firstRows.','.$listRows)->select();
        return $list;
    }
    
    public function getProcessCount($stage_id,$title,$uid,$from,$to){
        if($stage_id){
            $where['stage_id'] = array('EQ',$stage_id);
        }
        if($title){
            $where['title'] = array('LIKE','%'.$title.'%');
        }
        if($from){
            $where['created'] = array(array('gt',strtotime(date('Y/m/d H:i:s',strtotime($from)))));
        }
        if($to){
            $where['created'] = array(array('lt',strtotime(date('Y/m/d H:i:s',strtotime($to)))));
        }
        $where['uid'] = array('EQ',$uid);
        $count = $this->where($where)->count('id');
        return $count;
    }
    
    
    public function addProcess($data){
        $result = $this->add($data);
        return $result;
    }

    
    public function getProcessById($where){
        $result = $this->where($where)->find();
        return $result;
    }
    
    
    
    public function saveProcess($where,$data){
        $result = $this->where($where)->save($data);
        if($result === false){
            return false;
        }
        return true;
    }
    
    public function deleteProcess($where){
        $result=$this->where($where)->delete();
        return $result;
    }
    
}
