<?php
return array(
    /* 数据库配置 */
    'DB_TYPE'          => 'mysql', // 数据库类型
    'DB_HOST'          => '192.168.31.186', // 服务器地址
    'DB_NAME'          => 'vswoole', // 正式数据库名
    'DB_USER'          => 'root', // 用户名
    'DB_PWD'           => 'Passw0rd',  // 密码
    'DB_PORT'          => '3306', // 端口
    'DB_PREFIX'        => 'wei_', // 数据库表前缀
    'REDIS_HOST'       => '127.0.0.1', //redis服务器ip，多台用逗号隔开；读写分离开启时，第一台负责写，其它[随机]负责读；
    'REDIS_PORT'       => '6379',//端口号
    'REDIS_TIMEOUT'    => '0',//超时时间
    'REDIS_PERSISTENT' => true,//是否长连接 false=短连接
    'REDIS_AUTH'       => '',//AUTH认证密码
);
