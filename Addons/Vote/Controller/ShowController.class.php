<?php
/**
 * 微平台互动的投票前端
 * 
 */
namespace Addons\Vote\Controller;
use Home\Controller\AddonsController;

class ShowController extends AddonsController{
    protected $voteid;
    public function __construct() {
		parent::__construct ();
		/**
		 * 图片多选投票测试 index.php?s=/addon/Vote/Show/show/voteid/54
		 * 文字多选投票测试 index.php?s=/addon/Vote/Show/show/voteid/56
		 * 文字单选投票测试 index.php?s=/addon/Vote/Show/show/voteid/51
		 * 添加积分方法 action_log('add_vote', 'member', $memberId, $memberId);
		 */
		$this->voteid = I('voteid');
		$this->assign("voteid",$this->voteid);
    }
        
    
    /*
     * 投票前端显示
    */
    public function show(){
        $voteid = $this->voteid;
        //$uid = $this->userid;
        $uid = session('user_auth.uid');
        $voteModel = D( 'Addons://Vote/Vote' );
        $vote_list = $voteModel->getVoteInfoById($voteid);
        if($vote_list['img_isshow'] == 1){ //显示投票缩略图
            $where['id'] = $vote_list['imgurl'];
            $imgurl = $this->getImageinfo($where);
            $vote_list['img_path'] = $imgurl[0]['path'];
            if($imgurl[0]['path']){
                $vote_list['img_path'] = __ROOT__.$imgurl[0]['path'];
            }
            if($imgurl[0]['url']){
                $vote_list['img_path'] = $imgurl[0]['url'];
            }
        }
        $vote_option = $voteModel->getVoteOptionById($voteid);
        foreach($vote_option as $k=>$v){
            $percent = $v['votenumber']/$vote_list['votnum'];
            $vote_option[$k]['percent'] = round(($percent)*100);
        }
        if($vote_list['type'] == 2){ //图片投票
            foreach($vote_option as $k=>$v){
                $where['id'] = $v['imgurl'];
                $imgurl = $this->getImageinfo($where);
                if($imgurl[0]['path']){
                    $vote_option[$k]['img_path'] = __ROOT__.$imgurl[0]['path'];
                }
                if($imgurl[0]['url']){
                    $vote_option[$k]['img_path'] = $imgurl[0]['url'];
                }
                
            }
        }
        
        //获取用户投票次数
        if($uid){
            $wheres['userid'] = $uid;
            $wheres['voteid'] = $voteid;
        }else{
            $wheres['userid'] = 0;
            $wheres['ip'] = get_client_ip();
        }
        $cast_count = $voteModel->getCastVoteCount($wheres);
        //获取投票参与人数
        $have_person = $voteModel->getPreson($voteid);
        $vote_style = $vote_list['vote_style'];
        $this->assign('link', ONETHINK_ADDON_PATH . _ADDONS.'/View/front/'.$vote_style.'/'._ADDONS);
        $this->assign("info",$vote_list);
        $this->assign("option",$vote_option);
        $this->assign("cast_count",$cast_count);
        $this->assign("have_person",$have_person);
        if($vote_style == 'green' || $vote_style == 'default'){
            if($vote_list['type'] == 2){
                $this->display(T ( 'Addons://Vote@front/'.$vote_style.'/Vote/img_show' ));
            }elseif ($vote_list['type'] == 1){
                $this->display(T ( 'Addons://Vote@front/'.$vote_style.'/Vote/words_show' ));
            }           
        }else{
            $this->display(T ( 'Addons://Vote@front/'.$vote_style.'/Vote/show' ));
        }
        
    }
    
    /**
     * 提交投票
     */
    public function castVote1(){
        $ret['status'] = 'fail';
        $voteid = $this->voteid;
        $memberId = session('user_auth.uid');
        $voteModel = D( 'Addons://Vote/Vote' );
        $vote_list = $voteModel->getVoteInfoById($voteid);
        if($vote_list['is_register'] == 1 && $memberId == ''){
            $url = $_SERVER['HTTP_REFERER'];
            $loginurl =  C('LOGINURL').urlencode($url);
            $ret['url'] = $loginurl;
            $ret['code'] = '001';
            $ret['msg'] = '您还未登录';
            $this->ajaxReturn($ret);
        }
        if(isset($memberId) && $memberId == ''){
            $memberId = 0;
        }
        $option = I('optionid');
        $option_array = explode(",", $option);
        
        // 检查ID是否合法
        if (empty ( $voteid ) || 0 == $voteid) {
            $ret['msg'] = '错误的投票ID';
            $this->ajaxReturn($ret);
        }
        $notic = '';
        //检查投票时间
        if ($notic = $this->_is_overtime ( $voteid )) {
            $ret['msg'] = $notic;
            $this->ajaxReturn($ret);
        }
        
        //检查每人每天最多投票次数
        
        $peverday_maxnum = $vote_list['peverday_maxnum'];
        if ($this->_is_join ( $voteid, $memberId, $peverday_maxnum,'peverday_maxnum' )) {
            $ret['msg'] = '您今天的投票次数已用尽';
            $this->ajaxReturn($ret);
        }
        $voteperson_maxnum = $vote_list['voteperson_maxnum'];
        if ($this->_is_join ( $voteid, $memberId, $voteperson_maxnum )) {
            $ret['msg'] = '您该投票次数已用尽';
            $this->ajaxReturn($ret);
        }
        if (empty ( $option )) {
            $ret['msg'] = '请先选择投票项';
            $this->ajaxReturn($ret);
        }
        
        $voteModel = D( 'Addons://Vote/Vote' );
        $data['userid'] = $memberId;
        $data['voteid'] = $voteid;
        $data['time'] = time();
        $data['ip'] = get_client_ip();
        if(count($option_array) > 1){
            foreach($option_array as $k=>$v){
                $data['optionid'] = $v;
                $result = $voteModel->castVote($data);
            }
        }else{
            $data['optionid'] = $option;
            $result = $voteModel->castVote($data);
        }
        if($result){
            $where['voteid'] = $voteid;
            $res = $voteModel->upVoteNum($where,count($option_array)); //更新投票主表数
            $wheres['id'] = array('in',$option);
            $voteModel->upOptionNum($wheres,$voteid); //更新选项投票选项表数
            $ret['status'] = 'success';
        }else {
            $ret['msg'] = '投票失败';
        }
        $this->ajaxReturn($ret);
    }
    
    public function castVote(){
        $ret['status'] = 'fail';
        $voteid = $this->voteid;
        $memberId = session('user_auth.uid');
        $voteModel = D( 'Addons://Vote/Vote' );
        $vote_list = $voteModel->getVoteInfoById($voteid);
        if($vote_list['is_register'] == 1 && $memberId == ''){
            $url = $_SERVER['HTTP_REFERER'];
            $loginurl =  C('LOGINURL').urlencode($url);
            $ret['url'] = $loginurl;
            $ret['code'] = '001';
            $ret['msg'] = '您还未登录';
            $this->ajaxReturn($ret);
        }
        if(isset($memberId) && $memberId == ''){
            $memberId = 0;
        }
        $option = I('optionid');
        $option_array = explode(",", $option);
        
        // 检查ID是否合法
        if (empty ( $voteid ) || 0 == $voteid) {
            $ret['msg'] = '错误的投票ID';
            $this->ajaxReturn($ret);
        }
        $notic = '';
        //检查投票时间
        if ($notic = $this->_is_overtime ( $voteid )) {
            $ret['msg'] = $notic;
            $this->ajaxReturn($ret);
        }
        
        //检查每人每天最多投票次数
        
        $peverday_maxnum = $vote_list['peverday_maxnum'];
        if ($this->_is_join ( $voteid, $memberId, $peverday_maxnum,'peverday_maxnum' )) {
            $ret['msg'] = '您今天的投票次数已用尽';
            $this->ajaxReturn($ret);
        }
        $voteperson_maxnum = $vote_list['voteperson_maxnum'];
        if ($this->_is_join ( $voteid, $memberId, $voteperson_maxnum )) {
            $ret['msg'] = '您该投票次数已用尽';
            $this->ajaxReturn($ret);
        }
        if (empty ( $option )) {
            $ret['msg'] = '请先选择投票项';
            $this->ajaxReturn($ret);
        }
        
        $voteModel = D( 'Addons://Vote/Vote' );
        $data['userid'] = $memberId;
        $data['voteid'] = $voteid;
        $data['time'] = time();
        $data['ip'] = get_client_ip();
        if(count($option_array) > 1){
            foreach($option_array as $k=>$v){
                $data['optionid'] = $v;
                $data1[$k]=$data;
            }
        }else{
            $data['optionid'] = $option;
            $data1=$data;
        }
        $queue['log'] = $data1;
        $where['voteid'] = $voteid;
        $data2['where'] = $where;
        $data2['count'] = count($option_array);
        $queue['vote'] = $data2;
        $wheres['id'] = array('in',$option);
        $data3['where'] = $wheres;
        $data3['count'] = 1;
        $data3['voteid'] = $voteid;
        $queue['option'] = $data3;
        
        $pos=sendToQueue('castVote', $queue);
        if($pos){
            $ret['status'] = 'success';
        }else{
            $ret['msg'] = '投票失败';
        }
        $this->ajaxReturn($ret);
    }
    
    
    
    
    
    public function result(){
        $voteid = $this->voteid;
        $voteModel = D( 'Addons://Vote/Vote' );
        $vote_list = $voteModel->getVoteInfoById($voteid);
        $vote_style = $vote_list['vote_style'];
        $this->assign('link', ONETHINK_ADDON_PATH . _ADDONS.'/View/front/'.$vote_style.'/'._ADDONS);
        $this->assign('voteid',$voteid);
        $this->display(T ( 'Addons://Vote@front/'.$vote_style.'/Vote/result' ));
    }
    /**
     * 投票结果页
     */
    public function voteResult(){
        $ret['status'] = 'fail';
        $voteid = I('voteid');
        if (empty ( $voteid ) || 0 == $voteid) {
            $ret['msg'] = '错误的投票ID';
            $this->ajaxReturn($ret);
        }
        $voteModel = D( 'Addons://Vote/Vote' );
        $where['voteid'] = $voteid;
        $option_list = $voteModel->getVoteOptionById($voteid);
        $dataOptionsLabel = array();
        foreach($option_list as $k=>$v){
            $dataOptionsLabel[$k] = $v['title'];
        }
        if($option_list){
            $ret['status'] = 'success';
            $ret['data']['option'] = $option_list;
            $ret['data']['option_title'] = $dataOptionsLabel;
        }
        //print_r($option_list);
        $this->ajaxReturn($ret);
    }
    

    private function _is_overtime($vote_id) {
        // 先看看投票期限过期与否
        //$the_vote = M ( "vote" )->where ( "id=$vote_id" )->find ();
        $the_vote = D('Addons://Vote/Vote')->getVoteInfoById($vote_id);
        $str = false;
        if(!empty($the_vote['starttime']) && $the_vote ['starttime'] > NOW_TIME){
            $str = '投票活动未开始';
        }
        if(!empty($the_vote['endtime']) && $the_vote ['endtime'] < NOW_TIME){
            $str = '投票活动已结束';            
        } 
        return $str;
    }
    
    private function _is_join($vote_id, $user_id = 0, $maxnum,$type = '') {
        $where['voteid'] = $vote_id;
        $where['userid'] = $user_id;
        if($user_id == 0){
            $where['ip'] = get_client_ip();
        }
        if($type == 'peverday_maxnum'){
            $cur_date = strtotime(date('Y-m-d'));
            $where['time'] = array('egt',$cur_date);
        }
        $where['optionid'] = array('neq','');
        $VoteModel = D('Addons://Vote/Vote');
        $count = $VoteModel->getCastVoteCount($where);
        //$count = M ( "vote_log" )->where ($where)->count ();//echo $count;
        
        if ($count >= $maxnum) {
            return true;
        }
        return false;
    }
}
