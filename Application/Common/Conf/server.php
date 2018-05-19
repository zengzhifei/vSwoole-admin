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
        'Get_Ranges'        => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/getRanges',
        //获取配置
        'Get_Configs'       => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/getConfigs',
        //获取服务器IP
        'Get_Servers'       => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/getServerList',
        //清理服务器IP
        'Clear_Servers'       => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/clearServers',
        //获取服务器在线人数
        'Get_Server_Online' => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/getServerOnline',
        //重载服务器
        'Reload_Server'     => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/reload',
        //关闭服务器
        'ShutDown_Server'   => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/shutdown',
        //获取归档在线人数
        'Get_Range_Online'  => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/getRangeOnline',
        //消息推送
        'Push_Message'      => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/send',
        //关闭连接
        'Close_Connect'     => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/close',
        //设置配置
        'Set_Configs'       => 'http://192.168.31.100/demo/vSwoole/public/client.php?s=WebSocket/config',
    ]
];