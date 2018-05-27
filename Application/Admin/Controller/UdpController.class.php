<?php
// +----------------------------------------------------------------------+
// | VSwoole FrameWork                                                    |
// +----------------------------------------------------------------------+
// | Not Decline To Shoulder a Responsibility                             |
// +----------------------------------------------------------------------+
// | zengzhifei@outlook.com                                               |                  
// +----------------------------------------------------------------------+

namespace Admin\Controller;


use Common\Controller\Curl;

class UdpController extends AdminController
{
    /**
     * 管理页
     */
    public function index()
    {
        $curl = new Curl();
        $server_list = $curl->get(C('Udp.Get_Servers'));
        if (($server_list = json_decode($server_list, true)) && $server_list['status'] == 1) {
            $this->assign('server_list', $server_list['data']);
        }
        $this->display();
    }

    /**
     * 清理异常服务器
     */
    public function clearServers()
    {
        $curl = new Curl();
        $res = $curl->get(C('Udp.Clear_Servers'));
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
        $res = $curl->get(C('Udp.Reload_Server'), ['server_ip' => $server_ip]);
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
        $res = $curl->get(C('Udp.ShutDown_Server'), ['server_ip' => $server_ip]);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }
}