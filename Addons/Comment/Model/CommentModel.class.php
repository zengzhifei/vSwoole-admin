<?php

namespace Addons\Comment\Model;
use Think\Model;

/**
 * Comment模型
 */
class CommentModel extends Model{
    
    //定义主表
    protected  $tableName='comment';
    
    public $model = array(
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
    );
    
    
    /**
     * 根据where条件，获取评论相关信息
     */

    public function getcommentinfo($where = array() , $field = "*", $order="commenttime asc", $p, $offset){
    	if (!$p) {
    		return $this->where($where)->field($field)->order($order)->select();
    	}else {
        	return $this->where($where)->field($field)->order($order)->page($p,$offset)->select();
    	}
    }
    
    /**
     * 根据where条件，删除评论
     */
    public function delcomment($where){
        if(!empty($where)){
            return $this->where($where)->delete();
        }
    }
    
    /**
     * 根据where条件,修改评论信息
     */
    public function updatecomment($where , $data){
        if(!empty($where) || !empty($data)){
            return $this->where($where)->save($data);
        }else{
            return false;
        }
    }
    
    /**
     * 新增一条评论
     */
    public function addcomment($data){
        return $this->data($data)->add();
    }
    
    /**
     * 根据租赁用户ID获取评论用户信息
     * @param unknown $uid
     * @return unknown
     */
    public function getids($uid){
    	if ($uid) {
    		$where[C('DB_PREFIX').'comment_sort.uid'] = $uid;
    	}	
    	$res = $this->join(C('DB_PREFIX').'comment_topic on '.C('DB_PREFIX').'comment_topic.tid = '.C('DB_PREFIX').'comment.topicid')
    				->join(C('DB_PREFIX').'comment_sort on '.C('DB_PREFIX').'comment_sort.sid ='.C('DB_PREFIX').'comment_topic.sid')
			    	->where($where)
			    	->field(C('DB_PREFIX')."comment.*")
			    	->group(C('DB_PREFIX')."comment.uid")
			    	->select();
    	return $res;
    }
    
    /**
     * 
     * @param unknown $commentid
     * @param unknown $is_top
     * @return unknown
     */
    public function commenttop($commentid,$is_top){
		$where["comment_id"]    = $commentid;
		$param['is_top'] = $is_top;
		$res = $this->where($where)->save($param);
		return $res;
    }
    
}
