<?php
namespace Api\Controller;
/**
 * 应用相关接口
 */
class AppController extends ApiBaseController {
	
  
  /**
   * 同步应用接口
   */
  public function importApp(){
      $ret['status'] = 'fail';
      $name = I('app_name');
      $type = I('app_type');
      $table = I('table_name');
      if(!$name){
          $ret['msg'] = 'app_name参数错误';
          $this->ajaxReturn($ret,$this->format);
      }
      if(!$type){
          $ret['msg'] = 'app_type参数错误';
          $this->ajaxReturn($ret,$this->format);
      }
      if(!$table){
          $ret['msg'] = 'table_name参数错误';
          $this->ajaxReturn($ret,$this->format);
      }
      $data['name'] = $name;
      $data['type'] = $type;
      $data['table'] = $table;
      $data['ctime'] = time();
      $result = M("app")->add($data);
      if($result){
          $ret['status'] = 'success';
      }else{
          $ret['msg'] = '添加失败';
      }
      $this->ajaxReturn($ret,$this->format);
      
  }
  /**
   * 获取用户所有应用url
   * app_type:  1-抽奖  2-评论  3-投票  4-调查
   * 
   */
  public function getUserAppInfo(){
      $ret['status'] = 'fail';
      $user_id = I('user_id');
      $type = I('app_type',1);
      if(!$user_id){
          $ret['msg'] = 'user_id参数错误';
          $this->ajaxReturn($ret,$this->format);
      }
      if(!$type){
          $ret['msg'] = 'app_type参数错误';
          $this->ajaxReturn($ret,$this->format);
      }
      $web_url = C("FRONT_URL");
      $where['uid'] = $user_id;
      $model = D("App");
      $data = array();
      if($type == 1){
          $info = $model->getDrawInfo($where);
          foreach($info as $k=>$v){
              $data[$k]['title'] = $v['lucky_title'];
              $data[$k]['url'] = $web_url.'/index.php?s=/addon/Lucky/userlottery/lottery/luck_id/'.$v['id'].'.html';
          }
      }elseif ($type == 2){
          $info = $model->getCommentInfo($where);
          foreach($info as $k=>$v){
              $data[$k]['title'] = $v['topicname'];
              $data[$k]['url'] = $web_url.'/index.php?s=/addon/Comment/User/commentdetail/tid/'.$v['tid'].'.html';
          }
      }elseif ($type == 3){
          $info = $model->getVoteInfo($where);
          foreach($info as $k=>$v){
              $data[$k]['title'] = $v['title'];
              $data[$k]['url'] = $web_url.'/index.php?s=/addon/Vote/Show/show/voteid/'.$v['id'].'.html';
          }
      }elseif ($type == 4){
          $info = $model->getResearchInfo($where);
          foreach($info as $k=>$v){
              $data[$k]['title'] = $v['title'];
              $data[$k]['url'] = $web_url.'/index.php?s=/addon/Research/show/index/rid/'.$v['id'].'.html';
          }
      }

      if($info){
          $ret['status'] = 'success';
          $ret['data'] = $data;
      }else {
          $ret['msg'] = '数据为空';
      }
      $this->ajaxReturn($ret,$this->format);
  }
  


}


