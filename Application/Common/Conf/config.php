<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /* 模块相关配置 */
    'AUTOLOAD_NAMESPACE' => array('Addons' => ONETHINK_ADDON_PATH), //扩展模块列表
    'DEFAULT_MODULE'     => 'Home',
    //'MODULE_DENY_LIST'   => array('Common','User','Admin','Install'),
    'MODULE_DENY_LIST'   => array('Common', 'User'),
    'MODULE_ALLOW_LIST'  => array('Home','Admin','Api'),

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => 'P2;4$`vLk?@RGrUomfg"/a6h|,:nsb_AiJ<B^yEc', //默认数据加密KEY

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000, //最大缓存用户数
    'USER_ADMINISTRATOR' => 1, //管理员用户ID

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 3, //URL模式
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => 'htmlspecialchars', //全局过滤函数

    //项目根目录之前的地址 如果是域名访问 则配置域名即可 如果是IP访问 则配置到项目的入口文件之前的的目录
    'BASE_URL'=> 'http://localhost',
    'FRONT_URL' => 'http://10.3.1.180/weipingtai',
    //是否启用缓存 memcache
    'IS_CACHE' => false, //true 启用     false 不启用
    'BONUS_IS_CACHE' => true, //true 启用     false 不启用
    'CACHE_API' =>'memcache', // value is 'file' or 'memcache'
    'CACHEDEBUG'=>true,  //true 使用memcache缓存 false 不使用
    'MEMCACHE_HOST'=>'10.110.86.207',
    'MEMCACHE_PORT'=>'12000',
    'MEMCACHE_EXPIRE'=>3600, //缓存时间3600

	'LOAD_EXT_CONFIG' => 'db,redis,url', // 加载扩展配置文件
);
