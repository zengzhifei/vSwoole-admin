<?php

namespace Admin\Controller;


use Common\Controller\Curl;

class WebSocketController extends AdminController
{
    /**
     * 管理页
     */
    public function index()
    {
        $this->display();
    }

    /**
     * 统计页
     */
    public function count()
    {
        $curl = new Curl();
        $ranges = $curl->get('http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/getRanges');
        if (($ranges = json_decode($ranges, true)) && $ranges['status'] == 1) {
            $this->assign('ranges', $ranges['data']);
        }
        $this->display();
    }

    /**
     * 配置页
     */
    public function config()
    {
        $curl = new Curl();
        $ranges = $curl->get('http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/getRanges');
        if (($ranges = json_decode($ranges, true)) && $ranges['status'] == 1) {
            foreach ($ranges['data'] as $key => $range) {
                $_ranges[$key]['range_id'] = $range;
                $_ranges[$key]['range_name'] = $range;
            }
            $this->assign('ranges', $_ranges ?? []);
        }
        $configs = $curl->get('http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/getConfigs');
        if (($configs = json_decode($configs, true)) && $configs['status'] == 1) {
            $this->assign('configs', $configs['data'] ?? []);
        }
        $this->display();
    }

    /**
     * 日志页
     */
    public function log()
    {
        $this->display();
    }

    /**
     * 获取服务器列表
     */
    public function getServers()
    {
        $curl = new Curl();
        $data = $curl->post('http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/getServerOnline', [], 'POST');
        if (($data = json_decode($data, true)) && $data['status'] == 1) {
            $servers = [];
            foreach ($data['data'] as $ip => $count) {
                $servers[] = ['server_ip' => $ip, 'server_online' => $count];
            }
            $this->ajaxReturn(['status' => 1, 'msg' => 'success', 'data' => $servers]);
        }
        $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
    }

    /**
     * 重载服务
     */
    public function reloadServer()
    {
        $server_ip = I('server_ip', null);
        $curl = new Curl();
        $res = $curl->get('http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/reload', ['server_ip' => $server_ip]);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }

    /**
     * 关闭服务
     */
    public function shutdownServer()
    {
        $server_ip = I('server_ip', null);
        $curl = new Curl();
        $res = $curl->get('http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/shutdown', ['server_ip' => $server_ip]);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }

    /**
     * 获取栏目在线人数
     */
    public function getRangeOnline()
    {
        $range_id = I('range_id', null);
        if ($range_id) {
            $curl = new Curl();
            $res = $curl->get('http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/getRangeOnline', ['range_id' => $range_id]);
            if (($res = json_decode($res, true)) && $res['status'] == 1) {
                $this->ajaxReturn(['status' => 1, 'msg' => 'success', 'data' => $res['data']]);
            } else {
                $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
            }
        } else {
            $this->ajaxReturn(['status' => -1, 'msg' => '缺少参数：range_id']);
        }
    }

    /**
     * 推送消息
     */
    public function sendMessage()
    {
        $range_id = I('range_id', null);
        $message = I('message', '', 'json_filter');
        if ($range_id && $message) {
            $curl = new Curl();
            $res = $curl->post("http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/send", ['range_id' => $range_id, 'message' => $message]);
            if (($res = json_decode($res, true)) && $res['status'] == 1) {
                $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
            } else {
                $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
            }
        } else {
            $this->ajaxReturn(['status' => -1, 'msg' => '缺少参数']);
        }
    }

    /**
     * 关闭用户连接
     */
    public function closeUser()
    {
        $range_id = I('range_id', null);
        $user_id = I('user_id', null);
        if ($range_id && $user_id) {
            $curl = new Curl();
            $res = $curl->get("http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/close", ['range_id' => $range_id, 'user_id' => $user_id]);
            if (($res = json_decode($res, true)) && $res['status'] == 1) {
                $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
            } else {
                $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
            }
        } else {
            $this->ajaxReturn(['status' => -1, 'msg' => '缺少参数']);
        }
    }

    /**
     * 设置域名验证
     */
    public function checkHost()
    {
        $host = I('host', '');
        $switch = $host ? I('switch', false) : false;
        $curl = new Curl();
        $res = $curl->post("http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/config", ['config' => ['ENABLE-CHECK-HOST' => $switch, 'CHECK-HOST' => $host]]);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }

    /**
     * 设置域名验证
     */
    public function checkIp()
    {
        $ips = trim(I('ip', ''), ',');
        $switch = I('switch', false);
        $curl = new Curl();
        $res = $curl->post("http://10.4.0.101/demo/vSwoole/public/client.php?s=WebSocket/config", ['config' => ['ENABLE-CHECK-IP' => $switch, 'CHECK-IP' => $ips]]);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }
}