<?php
namespace Api\Model;
use Think\Model;
//use Vendor\Memcache;

/**
 * Vote模型
 */
class VoteModel extends Model{
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
            $this->Memcache = new \Memch('voteVersion');
        }
    }
    
    /*
     * 获取投票列表
     */
    public function getVotelist($keyword,$type,$option_type,$uid,$p,$firstRows,$listRows){
        if(C('IS_CACHE')){
            $cacheKey = 'VoteList_uid'.$uid.'_'.$p.'_';
            if($keyword) $cacheKey .= $keyword;
            if($type) $cacheKey .='_'.$type;
            if($option_type) $cacheKey .='_'.$option_type;
            $list = $this->Memcache->getCache($cacheKey);
            if(!$list){
                $list = array();
            }
        }else{
            $list = array();
        }
        if(empty($list)){
            $where=array();
            $parameter=array();
            if($keyword){
                $where['keyword'] = array('LIKE','%'.$keyword.'%');
            }
            if($type){
                $where['type'] = array('EQ',$type);
            }
            if($option_type){
                $where['option_type'] = array('EQ',$option_type);
            }
            $order = 'creattime DESC';
            $voteModel = M("vote");
            $where['uid'] = array('EQ',$uid);
            $list      = $voteModel->where($where)->order($order)->limit($firstRows.','.$listRows)->select();
            if(C('IS_CACHE')){
                $this->Memcache->setCache($cacheKey,$list);
            }
        }
        return $list;
    }
    
    public function getVoteCount($keyword,$type,$option_type,$uid){
        if(C('IS_CACHE')){
            $Memcache = $this->Memcache;
            $cachekey = 'VoteCount_uid'.$uid.'_';
            if($keyword) $cacheKey .= $keyword;
            if($type) $cacheKey .='_'.$type;
            if($option_type) $cacheKey .='_'.$option_type;
            $count = $Memcache->getCache($cacheKey);
            if(!$count){
                $count= false;
            }
        }else{
            $count = false;
        }
        if(!$count){
            if($keyword){
                $where['keyword'] = array('LIKE','%'.$keyword.'%');
            }
            if($type){
                $where['type'] = array('EQ',$type);
            }
            if($option_type){
                $where['option_type'] = array('EQ',$option_type);
            }
            $voteModel = M("vote");
            $where['uid'] = array('EQ',$uid);
            $count     = $voteModel->where($where)->count();
            if(C('IS_CACHE')){
                $Memcache->setCache($cacheKey,$count);
            }
        }
        return $count;
    }
    
    /*
     * 添加投票
     */
    public function addVote($data){
        $Memcache= $this->Memcache;
        $result=$this->add($data);
        if($result){
            if(C('IS_CACHE')){
                $Memcache->updateCache();
            }
            return $result;
        }else{
            return false;
        }
    }
    
    /*
     * 修改投票
     */
    public function updateVote($where,$parem){
        $Memcache= $this->Memcache;
        $result = $this->where($where)->save($parem);
        if($result){
            if(C('IS_CACHE')){
                $Memcache->updateCache();
            }
            return $result;
        }else{
            return false;
        }
    }
    
    /*
     * 批量添加投票选项
     */
    public function addVoteoption($data){
        $optionModel = M('vote_option');
        return $optionModel->addAll($data);
    }
    
    /*
     * 修改投票选项模型
     */
    public function updateVoteoption($data){
        $optionModel =M('vote_option');
        //dump($data);exit;
        foreach($data as $key=>$value){
            //if(empty($value)) continue;
            if($value['id'] !=null){
                $param=array();
                $where=array();
                $where['id'] = array('eq',$value['id']);
                $param['vote_id'] = intval($value['vote_id']);
                $param['title']   = $value['title'];
                $param['order']   = intval($value['order']);
                $param['init_votnum'] = intval($value['init_votnum']);
                if(!empty($value['imgurl'])) $param['imgurl'] = intval($value['imgurl']);
                if(!empty($value['img_jumpurl'])) $param['img_jumpurl'] = $value['img_jumpurl'];
                $optionModel->where($where)->save($param);
            }else{
                $optiondata=array();
                $optiondata['vote_id'] = intval($value['vote_id']);
                $optiondata['title']   = $value['title'];
                $optiondata['order']   = intval($value['order']);
                $optiondata['init_votnum'] = intval($value['init_votnum']);
                if(!empty($value['imgurl'])) $optiondata['imgurl'] = intval($value['imgurl']);
                if(!empty($value['img_jumpurl'])) $optiondata['img_jumpurl'] = $value['img_jumpurl'];
                $optionModel->add($optiondata);
            }
        }
    }
    /*
     * 根据投票id获取投票详情
     */
    public function getVoteInfoById($voteid){
        if(C('IS_CACHE')){
            $cachename = "VoteInfo_".$voteid;
            $voteinfoByid = $this->Memcache->getCache($cachename);
            if(!$voteinfoByid){
                $where['id'] = array('eq',$voteid);
                $model = M('vote');
                $voteinfoByid=$model->where($where)->find();
                $this->Memcache->setCache($cachename, $voteinfoByid);
            }
        }else{
            $where['id'] = array('eq',$voteid);
            $voteinfoByid=$this->where($where)->find();
        }
        return $voteinfoByid;
    }
    
    /*
     * 根据投票id获取投票选项
    */
    public function getVoteOptionById($voteid){
        if(C('IS_CACHE')){
            $cachename = "VoteOption_".$voteid;
            $voteOption = $this->Memcache->getCache($cachename);
            if(!$voteOption){
                $where['vote_id'] = array('eq',$voteid);
                $optionModel =M('vote_option');
                $voteOption=$optionModel->where($where)->select();
                $this->Memcache->setCache($cachename, $voteOption);
            }
        }else{
            $where['vote_id'] = array('eq',$voteid);
            $optionModel =M('vote_option');
            $voteOption=$optionModel->where($where)->select();
        }
        
        return $voteOption;
    }
    
    /*
     * 复制投票模型
     */
    public function copyVote($voteid){
        $voteinfo = $this->getVoteInfoById($voteid);
        $option   = $this->getVoteOptionById($voteid);
        unset($voteinfo['id']);
        $vote_id = $this->addVote($voteinfo);
        if($vote_id){
            foreach($option as $key=>$vlue){
                unset($option[$key]['id']);
                $option[$key]['vote_id'] = $vote_id;
                if(empty($value['imgurl'])) unset($option[$key]['imgurl']);
                if(empty($value['img_jumpurl'])) unset($option[$key]['img_jumpurl']);
                if(empty($value['votenumber'])) unset($option[$key]['votenumber']);
            }
            $re = $this->addVoteoption($option);
            if($re){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    /*
     * 删除投票
     */
    public function deleteVote($voteid){
        $votewhere['id'] = array('in',$voteid);
        $result = $this->where($votewhere)->delete();
        if($result){
            $optionwhere['vote_id'] = array('in',$voteid);
            $optionModel = M('vote_option');
            $resutl1= $optionModel->where($optionwhere)->delete();
            if(C('IS_CACHE')){
                $this->Memcache->updateCache();
            }
            if($resutl1){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    /*
     * 将图片的网络图片存入数据库 返回图片表的ID
     */
    public function addImageUrl($url,$uid){
        $pictureModel = M('picture');
        $data['url'] = $url;
        $data['uid'] = $uid;
        $data['md5'] = md5_file($url);
        $data['sha1'] = sha1_file($url);
        $data['create_time'] = time();
        $data['status'] = 1;
        return $pictureModel->add($data);
    }
    
    /*
     * 后台统计投票的参与人数
     */
    function chsetVote($voteid){
        if(C('IS_CACHE')){
            $cachename = "chsetVote_".$voteid;
            $list = $this->Memcache->getCache($cachename);
            if(!$list){
                $model = M('vote_log');
                $where['voteid'] = array('eq',$voteid);
                $list=$model->where($where)->group('userid')->field('id')->select();
                $this->Memcache->setCache($cachename, $list);
            }
        }else{
            $model = M('vote_log');
            $where['voteid'] = array('eq',$voteid);
            $list=$model->where($where)->group('userid')->field('id')->select();
        }
        
        return count($list);
    }
    
    function chsetOption($optionid){
        if(C('IS_CACHE')){
            $cachename = "chsetOption_".$optionid;
            $list = $this->Memcache->getCache($cachename);
            if(!$list){
                $model = M('vote_log');
                $where['optionid'] = array('eq',$optionid);
                $list=$model->where($where)->group('userid')->field('id')->select();
                $this->Memcache->setCache($cachename, $list);
            }
        }else{
            $model = M('vote_log');
            $where['optionid'] = array('eq',$optionid);
            $list=$model->where($where)->group('userid')->field('id')->select();
        }
        
        return count($list);
    }
    
    
    
    
    /**
     * 获取投票次数
     */
    public function getCastVoteCount($where){
        if(C('IS_CACHE')){
            if($where['userid']){
                $cachename = 'Votecount_'.$where['userid'].'_'; 
                $cachename .= $where['voteid']; 
            }else{
                $cachename = 'Votecount_'.$where['userid'].'_'; 
                $cachename .= $where['ip'];
            }
            $count = $this->Memcache->getCache($cachename);
            if(!$count){
                $model = M('vote_log');
                $count = $model->where($where)->count();
                if($count){
                    $this->Memcache->setCache($cachename, $count);
                }
            }
        }else{
            $model = M('vote_log');
            $count = $model->where($where)->count();
        }
       
        return $count;
    }
    
    /*
     * 获取投票人数
     * 
     */
    function getPreson($voteid){
        if(C('IS_CACHE')){
            $cachename = 'getPreson_'.$voteid;
            $have_person = $this->Memcache->getCache($cachename);
            if(!$have_person){
                $have_person = M("vote_log")->where("voteid = {$voteid}")->group("userid")->count('distinct(userid)');
                $this->Memcache->setCache($cachename, $have_person);
            }
        }else{
            $have_person = M("vote_log")->where("voteid = {$voteid}")->group("userid")->count('distinct(userid)');
        }
        return $have_person;
    }
    /**
     * 用户提交投票
     */
    public function castVote($data){
        $model = M('vote_log');
        $result = $model->add($data);
        if($result){
            action_log('add_vote', 'member', $data['userid'], $data['userid']);
        }
        if($result && C('IS_CACHE')){
            $cachename = 'Votecount_'.$data['userid'].'_'.$data['voteid'];
            $this->Memcache->delCache($cachename);
            $cachename = 'getPreson_'.$data['voteid'];
            $this->Memcache->delCache($cachename);
            $cachename = 'Votecount_0'.'_'.$data['ip'];
            $this->Memcache->delCache($cachename);
        }
        return $result;
    }
    
    /**
     * 更新投票数
     */
    public function upVoteNum($where,$num){
        $mode = M('vote');
        $result =  $mode->where($where)->setInc('votnum',$num);
        if(C('IS_CACHE')){
            $cachename = "VoteInfo_".$where['voteid'];
            $this->Memcache->delCache($cachename);
            $cachename = "chsetVote_".$where['voteid'];
            $this->Memcache->delCache($cachename);
        }
        return $result;
    }
    
    public function upOptionNum($where,$voteid){
        $result =  M("vote_option")->where($where)->setInc('votenumber');
        if(C('IS_CACHE')){
            $cachename = "VoteOption_".$voteid;
            $this->Memcache->delCache($cachename);
            $cachename = "chsetOption_".$where['id'];
            $this->Memcache->delCache($cachename);
        }
        return $result;
    }
}
