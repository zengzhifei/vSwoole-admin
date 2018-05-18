<?php
namespace Api\Model;
use Think\Model;


class BonusLogModel extends Model{

    public function _initialize(){
        parent::_initialize();
        if(C('IS_CACHE')){
            import("Vendor.Memcache.Memch",'','.php');
            $this->Memcache = new \Memch('voteVersion');
        }
    }
    
    public function addPrizeAccount($data){
        $result = $this->add($data);
        return $result;
    }
 
}
