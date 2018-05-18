<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if (version_compare(PHP_VERSION, '5.3.0', '<')) die('require PHP > 5.3.0 !');
header("content-type:text/html;charset=utf-8");
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__FILE__));
define('MODE_NAME', 'Cli');//必须是cli，采用CLI运行模式运行
define('THINK_PATH', ROOT_PATH . '/ThinkPHP/');
define('APP_NAME', 'cli');
define('APP_PATH', ROOT_PATH . '/Application/');//echo THINK_PATH;exit;
define('APP_DEBUG', false);
define('APP_MODE', 'api');
/**
 * 缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define('RUNTIME_PATH', ROOT_PATH . '/Runtime/');
define('SITE_PATH', dirname(__FILE__));
require(THINK_PATH . "ThinkPHP.php");


// 亲^_^ 后面不需要任何代码了 就是如此简单