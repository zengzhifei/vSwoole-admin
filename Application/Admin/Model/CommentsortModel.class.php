<?php

namespace Admin\Model;
use Think\Model;

/**
 * Comment模型
 */
class CommentsortModel extends Model{
    
    //定义主表
    protected  $tableName='comment_sort';
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
     * 获取所有的分类列表
     * $where 查询条件、默认为空   $field 查询字段、默认为*  $p 当前页  $offset偏移量
     */
    public function getsortlist($where = array() , $field = "*"  , $p , $offset){
        return $this->where($where)->page($p , $offset)->order('createtime desc')->field($field)->select();
    }
    
    /**
     * 添加一条新的分类
     */
    public function addsort($data){
        return   $this->add($data);
    }
    
    /**
     * 更新一条分类
     */
    public function updatesort($where , $data){
        return $this->where($where)->save($data); 
    }
    
    /**
     * 删除一条分类
     */
    public function delsort($where){
        if(!empty($where)){
            return $this->where($where)->delete();
        }
    }
    
    /**
     * 根据where条件获取分类相关信息
     */
    public function getsortinfo($sid){
        if($sid){
            return $this->where($sid)->find();
        }else{
            return false;
        }
    }
}
