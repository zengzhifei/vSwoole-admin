<?php
namespace Api\Controller;
/**
 * 积分相关接口
 */
class ScoreController extends ApiBaseController {
	
  /**
   * 增/减积分接口
   * @param string $action 行为标识(投票：add_vote;问卷：answer;奖品兑换：to_prize)
   * @param string $model 触发行为的模型名
   * @param int $record_id 触发行为的记录id
   * @param int $user_id 执行行为的用户id
   * @param array $score_info (string $score_type 积分类型  add:加积分；sub：减积分
   *                           string $column_id 栏目id
   *                           int    $score 积分流水；null默认读取配置分值) 
   */
    public function doScore(){
        $ret['status'] = 'fail';
        $action = I('action', '');
        $record_id = I('record_id', '' ,intval);
        $user_id = I('user_id', '', intval);
        $score_type = I('score_type', 'add');
        $column_id = I('column_id', '');
        $score = I('score', '');
        $model = I('model', '');
        if(!$action){
            $ret['msg'] = 'action参数错误';
            $this->ajaxReturn($ret,$this->format);
        }
        if(!$record_id){
            $ret['msg'] = 'record_id参数错误';
            $this->ajaxReturn($ret,$this->format);
        }
        if(!$user_id){
            $ret['msg'] = 'user_id参数错误';
            $this->ajaxReturn($ret,$this->format);
        }
        if(!$column_id){
            $ret['msg'] = 'column_id参数错误';
            $this->ajaxReturn($ret,$this->format);
        }
        $score_info = array('score_type' => $score_type, 'score' => $score, 'column_id' => $column_id);
        $result = action_log($action, 'vote', $record_id, $user_id, $score_info);
        if($result['status']){
            $ret['status'] = 'success';
        }else {
            $ret['msg'] = $result['msg'];
        }
        $this->ajaxReturn($ret,$this->format);
    }


}


