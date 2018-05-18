<?php

namespace Addons\Research\Model;
use Think\Model;

/**
 * Research模型
 */
class InteractCountModel extends Model{  
    public function saveInteractCount($where,$data){
        $model = M('interact_count');
        $Countinfo = $model->where($where)->find();
        if($Countinfo){
            return $model->where($where)->setInc('count');
        }else{
            $data['count'] = intval(1);
            return $model->add($data);
        }
    }
}
