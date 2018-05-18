<?php
namespace Addons\Comment\Model;
use Think\Model;
/**
 * 
 * @author LY
 * 评论话题模型
 */
class CommenttopicModel extends Model{

	protected $tableName = 'comment_topic';
	
	/**
	 * 获取话题列表
	 * @param string $order  分页
	 * @param int    $p      页码
	 * @param int    $offset 页尺寸
	 */
	public function gettopiclist($sid,$order,$p,$offset){
		if ($sid) {
			$where['sid'] = $sid;
		}
		$list  = $this->where($where)->order($order)->page($p,$offset)->select();
		$count = $this->where($where)->count();
		$data = array('list'=>$list,'total'=>$count);
		return $data;
	}
	
	/**
	 * 根据话题ID获取话题基本信息
	 * @param int $tid 话题ID
	 * @return Ambigous <\Think\mixed, boolean, NULL, multitype:, unknown, mixed, string, object>
	 */
	public function gettopicinfo($tid){
		$topicinfo = $this->find($tid);
		return $topicinfo;
	}
	
	/**
	 * 添加/修改 话题
	 * @param unknown $topicname 话题名称
	 * @param unknown $topicinfo 话题简介
	 * @param unknown $logo_img  话题图片ID
	 * @param unknown $topicsort 话题所属分类ID
	 * @param unknown $tid       话题ID
	 * @return Ambigous <boolean, unknown, \Think\mixed, string>
	 */
	public function addtopic($topicname, $topicinfo, $logo_img, $topicsort, $tid){
    		$data['sid']       = $topicsort;
    		$data['topicname'] = $topicname;
    		$data['topicinfo'] = $topicinfo;
    		$data['logo_img']  = $logo_img;
    		$where['tid'] = $tid;
		if ($tid) {
			$data['updatetime'] = time();
			$res = $this->where($where)->save($data);
		}else {
			$data['createtime'] = time();
			$data['updatetime'] = time();
			$res = $this->add($data);
		}
		return $res;
	}
	
	/**
	 * 设置/取消   话题置顶
	 * @param int $tid    话题ID
	 * @param int $is_top 置顶值
	 */
	public function settop($tid,$is_top){
		$where["tid"]    = $tid;
		$param['is_top'] = $is_top;
		$res = $this->where($where)->save($param);
		return $res;
	}
	
	/**
	 * 删除话题
	 * @param int $tid 话题ID
	 * @return unknown
	 */
	public function deltopic($tid){
		$where['tid']    = $tid;
		$res = $this->where($where)->delete();
		return $res;
	}
	
	/**
	 * 查询某个话题信息
	 */
	public function gettopicval($where = array() , $field = "*"){
	    return $this->where($where)->field($field)->find();
	}
	
	public function getsortbytid($tid){
		$where['wei_comment_topic.tid'] = $tid;
		return $this->field('wei_comment_sort.sortname,wei_comment_sort.sid')->join('LEFT JOIN wei_comment_sort on wei_comment_sort.sid=wei_comment_topic.sid')->where($where)->select();
	}
	
	/**
	 * 根据where条件、获取一组信息
	 */
	public  function gettopic($where = array() , $field = "*"){
	    return $this->where($where)->field($field)->select();
	}
}