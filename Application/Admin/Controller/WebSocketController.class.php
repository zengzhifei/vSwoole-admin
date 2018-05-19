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
        $curl = new Curl();
        $server_list = $curl->get(C('WebSocket.Get_Servers'));
        if (($server_list = json_decode($server_list, true)) && $server_list['status'] == 1) {
            $this->assign('server_list', $server_list['data']);
        }
        $this->display();
    }

    /**
     * 统计页
     */
    public function count()
    {
        $curl = new Curl();
        $ranges = $curl->get(C('WebSocket.Get_Ranges'));
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
        $ranges = $curl->get(C('WebSocket.Get_Ranges'));
        if (($ranges = json_decode($ranges, true)) && $ranges['status'] == 1) {
            foreach ($ranges['data'] as $key => $range) {
                $_ranges[$key]['range_id'] = $range;
                $_ranges[$key]['range_name'] = $range;
            }
            $this->assign('ranges', $_ranges ?? []);
        }
        $configs = $curl->get(C('WebSocket.Get_Configs'));
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
        $data = $curl->post(C('WebSocket.Get_Server_Online'));
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
     * 清理异常服务器
     */
    public function clearServers()
    {
        $curl = new Curl();
        $res = $curl->get(C('WebSocket.Clear_Servers'));
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }

    /**
     * 重载服务
     */
    public function reloadServer()
    {
        $server_ip = I('server_ip', null);
        $curl = new Curl();
        $res = $curl->get(C('WebSocket.Reload_Server'), ['server_ip' => $server_ip]);
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
        $res = $curl->get(C('WebSocket.ShutDown_Server'), ['server_ip' => $server_ip]);
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
            $res = $curl->get(C('WebSocket.Get_Range_Online'), ['range_id' => $range_id]);
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
            $res = $curl->post(C('WebSocket.Push_Message'), ['range_id' => $range_id, 'message' => $message]);
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
            $res = $curl->get(C('WebSocket.Close_Connect'), ['range_id' => $range_id, 'user_id' => $user_id]);
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
        $res = $curl->post(C('WebSocket.Set_Configs'), ['config' => ['ENABLE-CHECK-HOST' => $switch, 'CHECK-HOST' => $host]]);
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
        $res = $curl->post(C('WebSocket.Set_Configs'), ['config' => ['ENABLE-CHECK-IP' => $switch, 'CHECK-IP' => $ips]]);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }
}