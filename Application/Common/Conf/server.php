<?php
// +----------------------------------------------------------------------+
// | VSwoole FrameWork                                                    |
// +----------------------------------------------------------------------+
// | Not Decline To Shoulder a Responsibility                             |
// +----------------------------------------------------------------------+
// | zengzhifei@outlook.com                                               |                  
// +----------------------------------------------------------------------+

return [
    //WebSocket
    'WebSocket' => [
        //获取归档号
        'Get_Ranges'        => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/getRanges',
        //获取配置
        'Get_Configs'       => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/getConfigs',
        //获取服务器IP
        'Get_Servers'       => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/getServerList',
        //清理服务器IP
        'Clear_Servers'     => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/clearServers',
        //获取服务器在线人数
        'Get_Server_Online' => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/getServerOnline',
        //重载服务器
        'Reload_Server'     => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/reload',
        //关闭服务器
        'ShutDown_Server'   => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/shutdown',
        //获取归档在线人数
        'Get_Range_Online'  => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/getRangeOnline',
        //消息推送
        'Push_Message'      => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/send',
        //关闭连接
        'Close_Connect'     => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/close',
        //设置配置
        'Set_Configs'       => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=WebSocket/config',
    ],
    //Crontab
    'Crontab'   => [
        //获取服务器IP
        'Get_Servers'     => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/getServerList',
        //重载服务器
        'Reload_Server'   => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/reload',
        //关闭服务器
        'ShutDown_Server' => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/shutdown',
        //清理服务器IP
        'Clear_Servers'   => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/clearServers',
        //添加任务
        'Add_Task'   => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/addTask',
        //获取任务列表
        'Get_Task_List'   => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/getTaskList',
        //获取任务
        'Get_Task'   => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/getTask',
        //开始任务
        'Start_Task'   => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/startTask',
        //暂停任务
        'Stop_Task'   => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/stopTask',
        //删除任务
        'Delete_Task'   => 'http://127.0.0.1/demo/vSwoole/public/client.php?s=Crontab/deleteTask',
    ]
];