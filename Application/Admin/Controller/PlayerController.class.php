<?php


namespace Admin\Controller;


class PlayerController extends AdminController
{
    protected $stage_id;
    
    public function _initialize(){
        parent::_initialize();
        $stage_id = I("stage_id",false);
        if (!$stage_id) {
            $stageInfo = $this->getStartStage();
            $stage_id = $stageInfo ? $stageInfo['stage_id'] : false;
        }
        $this->stage_id = $stage_id;
        
        
        if($this->stage_id == false){
            $this->error('请先开启期数！', U('Stage/index'));
        }
        $type    = I('type',0);
        if($type ==0){
            $this->assign('menuname', "百人团列表");
        }elseif ($type == 1){
            $this->assign('menuname', "选手列表");
        }elseif ($type == 6 || $type == 2){
            $this->assign('menuname', "72人榜单");
        }
        
    }

    public function index()
    {
        $number = I("number",false);
        $name = I('name',false);
        $type    = I('type',0);
        $is_vip = I("is_vip",-1);
        $p    = I('p',1,'intval');
        if($number){
            $this->assign('number',$number);
            $parameter['player_id'] = array('IN',$number);
            $where['player_id'] = array('IN',$number);
        }
        if($name){
            $this->assign('name',$name);
            $parameter['name'] = $name;
            $where['name'] = array("like","%".$name."%");
        }
        if(isset($type)){
            $this->assign('type',$type);
            $parameter['type'] = $type;
            $where['type'] = $type;
        }
        if(isset($is_vip) && $is_vip!=-1){
            $parameter['is_vip'] = $is_vip;
            $where['is_vip'] = $is_vip;
        }
        $this->assign('is_vip',$is_vip);
        $where["stage_id"] = $this->stage_id;
        $where["is_del"] = 0;
        $count = M('player')->where($where)->count();
        $Page = $this->page($count,$parameter);
        $pageList = $Page->weishow();
        //$order = "right_num desc,duration asc";
		$order = "number+0 desc";
        $playList = M("player")->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->field('*')->select();


        $this->assign("_list",$playList);
        $this->assign("p",$p);
        $this->assign("totalpage",$Page->totalPages);
        $this->assign('page', $pageList);
        $this->assign('head_img_url', C('HEAD_IMG_URL'));
        $this->display();
    }
    
    /**
     * 虚拟榜单
     * 
     */
    public function showList(){
        $type = I("type");
        
        $wheress["stage_id"] = $this->stage_id;
        $wheress["group_status"] = 1;
        $groupinfo = M("group")->where($wheress)->field("*")->find();
        $group_id = $groupinfo["is_false"];//获取当前开启的分组id
        if($groupinfo["is_false"] == 0){
            $list = array();
        }else{
            $where["stage_id"] = $this->stage_id;
            $where['type'] = 0;
            $where["is_del"] = 0;
            $order = "sort asc";
            $play_list = M("player")->where($where)->order($order)->field("number")->limit(10)->select();
            $play_id_str = '';
            foreach ($play_list as $k => $v) {
                $play_id_str .= $v['number'] . ',';
            }
            $play_id_str = rtrim($play_id_str, ',');
            $wheres["user_id"] = array('in',$play_id_str);
            $groupinfo = M("group")->where(array("stage_id"=>$this->stage_id,"group_status"=>1))->field("id")->find();
            $group_id = $groupinfo["id"];//获取当前开启的分组id
            $wheres["group_id"] = $group_id;
            $orders = "field(user_id,$play_id_str)";
            $list = M("qa_group_count")->where($wheres)->order($orders)->field("user_id as number,user_name as name,user_right_count as right_num,user_score as duration")->select();
            
        }

        $this->assign('type', $type);
        $this->assign('_list', $list);
        $this->display();
    }
    
    
    /**
     * 本轮真实榜单
     *
     */
    public function trueList(){
        $type = I("type");
        $p    = I('p',1,'intval');
        $number = I("number",false);
        $name = I('name',false);
        if($number){
            $this->assign('number',$number);
            $parameter['number'] = $number;
            $wheres['player_id'] = $number;
        }
        if($name){
            $this->assign('name',$name);
            $parameter['name'] = $name;
            $wheres['user_name'] = array("like","%".$name."%");
        }
        
        $where["stage_id"] = $this->stage_id;
        $where["group_status"] = 1;
        $groupinfo = M("group")->where($where)->field("id")->find();
        $group_id = $groupinfo["id"];//获取当前开启的分组id
        
        $wheres["group_id"] = $group_id;
		$wheres["user_type"] = 0;
        $count = M('qa_group_count')->where($wheres)->count();
        $Page = $this->page($count,$parameter);
        $pageList = $Page->weishow();
        $field = "user_id as number,user_name as name,user_right_count as right_num,user_score as duration";
        //$order = "user_right_count desc,user_score asc";
		$order = "user_score desc";
        $list = M("qa_group_count")->where($wheres)->order($order)->field($field)->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign('type', $type);
        $this->assign('_list', $list);
        $this->assign("p",$p);
        $this->assign("totalpage",$Page->totalPages);
        $this->assign('page', $pageList);
        $this->display();
    }
    public function showList_bak(){
        $type = I("type");
        $where["stage_id"] = $this->stage_id;
        $where['type'] = 0;
        $order = "right_num desc,duration asc";
        $list = M("player")->where($where)->order($order)->limit(6)->select();
        $vip = M("player")->where(array("stage_id"=>$this->stage_id,"is_vip"=>1,"type"=>0))->order($order)->limit(2)->select();
        $i = 0;
        $vip_in_num = 0;
        foreach($list as $k=>$v){
            if($v['is_vip'] == 1){
               $i++;
               if($i ==1){
                   $vip_in_num = $k;
               } 
            }
        }
        
        $data = array_merge($list,$vip);
        
        if($i == 0){  //前5没有vip,把vip替换到4 5名
            array_splice($list,3,2,$vip);
            $data = $list;
        }elseif ($i == 1){ //前五名中有一个vip
            if($vip_in_num == 4){ //vip在第五名，删除第四名，向前补位
                array_splice($list,3,1);//删除第四名
                unset($vip[0]);
                $data = array_merge($list,$vip);
            }else{ //vip大于第五名， 直接替换第五名非vip
                array_pop($list);
                unset($vip[0]);
                $data = array_merge($list,$vip);
            }
            
        }elseif ($i == 2){
            $data = $list;
        }
        //echo "<pre>";print_r($list);exit;
        $this->assign('type', $type);
        $this->assign('_list', $data);
        $this->display();
    }

    /**
     * 修改选手排序
     */
    public function changeSort(){
        $id = I("id");
        $sort = I("sort");
        $where["id"] = $id;
        $data["sort"] = $sort;
        $data["update_time"] = time();
        $result = M("player")->where($where)->save($data);
        if($result) {
            $this->ajaxReturn(array('code'=>1,'message'=>'修改成功'));
        } else {
            $this->ajaxReturn(array('code'=>-2,'message'=>'修改失败'));
        }
    }

    /**
     * 修改选手姓名
     */
    public function updateName(){
        $id = I("id");
        $changeName = I("changeName");
        $changeValue = I("changeValue");
        $where["id"] = $id;
        $data[$changeName] = $changeValue;
        $data["update_time"] = time();
        $result = M("player")->where($where)->save($data);
        if($result) {
            $this->ajaxReturn(array('code'=>1,'message'=>'修改成功'));
        } else {
            $this->ajaxReturn(array('code'=>-2,'message'=>'修改失败'));
        }
    }


    /**
     * 写入选手信息
     */
    public function writePlay()
    {
        $fileName = I('fileName',false,'trim');
        $file = SITE_PATH.$fileName;
        $type = I("type");

        if(!$fileName || !file_exists($file)) {
            $this->ajaxReturn(array('code'=>-1,'message'=>'缺少参数'));
        }
        if(!isset($type)) {
            $this->ajaxReturn(array('code'=>-1,'message'=>'缺少类型'));
        }

        $list = file_get_contents($file);
        $list = explode("\r\n",$list);
        $data = array();
        foreach ($list as $key=>$value) {
            $info = explode(" ", $value);
            $data[$key]["number"] = $info[0];
            $data[$key]["name"] = $info[1];
            $data[$key]["player_id"] = $info[2];
            $data[$key]["stage_id"] = $this->stage_id;
            $data[$key]["type"] = $type;
        }

        //删除已有数据
        //M('player')->where(array("stage_id"=>$this->stage_id))->delete();
        //M('player')->where(array("stage_id"=>$this->stage_id))->save(array("is_del"=>1,"update_time"=>time()));
        //写入数据
        $res = M('player')->addAll($data);
        if($res) {
            $this->ajaxReturn(array('code'=>1,'message'=>'写入成功'));
        } else {
            $this->ajaxReturn(array('code'=>-2,'message'=>'写入失败'));
        }
    }

    /**
     * 删除选手信息
     */
    public function deletePlayer()
    {
        $fileName = I('fileName',false,'trim');
        $file = SITE_PATH.$fileName;
		$type = I("type",false);
        //删除源文件
		if(file_exists($file)) {
			@unlink($file);
		}
		
		if(!$type) {
		    $this->ajaxReturn(array('code'=>-1,'message'=>'缺少类型'));
		}
		

       
        //删除库数据
        //$res = M('player')->where(array("stage_id"=>$this->stage_id,"type"=>$type))->delete();
        $res = M('player')->where(array("stage_id"=>$this->stage_id,"type"=>$type))->save(array("is_del"=>1,"update_time"=>time()));
        if($res) {
            $this->ajaxReturn(array('code'=>1,'message'=>'删除成功','data'=>$file));
        } else {
            $this->ajaxReturn(array('code'=>-2,'message'=>'删除失败'));
        }
    }

    /**
     * 设置/取消VIP
     */
    public function changeStatus()
    {
        $id = I("id",false);
        $status = I("status",false);
        $type = I("type");
        $where['id'] =   $id;
        if($type == "vip"){
            $data['is_vip'] = $status;
        }elseif ($type == "start"){
            $data['is_start'] = $status;
//             $is_start = M("player")->where(array("is_start"=>1,"type"=>1))->count();
//             if($is_start > 0 && $status == 1){
//                 $this->ajaxReturn(array('code'=>-2,'message'=>'请先关闭其它选手'));
//             }
        }
        
        $data['update_time'] = time();
        $result = M("player")->where($where)->save($data);
        if($result){
            $this->ajaxReturn(array('code'=>1,'message'=>'设置成功'));
        }else {
            $this->ajaxReturn(array('code'=>-2,'message'=>'设置失败'));
        }
    }
    
    /**
     * 监控list
     *
     */
    public function monitor(){
        C("PAGE_OFFSET",50);
        $this->assign('menuname', "监控查看");
        $p    = I('p',1,'intval');
        $type = I("type");
        $where["stage_id"] = $this->stage_id;
        $where["is_del"] = 0;
        $order = "heart_time asc";
        $count = M('player')->where($where)->count();
        $Page = $this->page($count,$parameter);
        $pageList = $Page->weishow();
        
        $playList = M("player")->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->field('*')->select();
        foreach($playList as $k=>$v){
            $check_time = time() - $v["heart_time"];
            //echo $check_time;echo "<br>";
            $playList[$k]["check_time"] = $check_time;
            if($check_time > 20){
                $playList[$k]["is_notice"] = 1;
            }else{
                $playList[$k]["is_notice"] = 0;
            }
        }
        //echo "<pre>";print_r($playList);exit;
        
        $this->assign("_list",$playList);
        $this->assign("p",$p);
        $this->assign("totalpage",$Page->totalPages);
        $this->assign('page', $pageList);
        $this->assign('type', $type);
        $this->assign("all_count",$count);
        $this->display();
    }

    /**
     * 重置选手排序
     */
    public function resetSort(){
        $where["stage_id"] = $this->stage_id;
        $data['sort'] = 99999;
        $result = M("player")->where($where)->save($data);
        if($result) {
            $this->ajaxReturn(array('code'=>1,'message'=>'重置成功'));
        } else {
            $this->ajaxReturn(array('code'=>-2,'message'=>'重置失败'));
        }
    }

}
