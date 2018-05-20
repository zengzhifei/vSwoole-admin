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

class CrontabController extends AdminController
{
    /**
     * 管理页
     */
    public function index()
    {
        $curl = new Curl();
        $server_list = $curl->get(C('Crontab.Get_Servers'));
        if (($server_list = json_decode($server_list, true)) && $server_list['status'] == 1) {
            $this->assign('server_list', $server_list['data']);
        }
        $this->display();
    }

    /**
     * 计划任务页
     */
    public function task()
    {
        $curl = new Curl();
        $task_list = $curl->get(C('Crontab.Get_Task_List'));
        if (($task_list = json_decode($task_list, true)) && $task_list['status'] == 1) {
            foreach ($task_list['data'] as $task) {
                $_task_list[md5($task['task_group'])][] = $task;
            }
            $_task_list = array_reduce($_task_list ?? [], 'array_merge', array());
            $this->assign('task_list', $_task_list);
        }
        $this->display();
    }

    /**
     * 清理异常服务器
     */
    public function clearServers()
    {
        $curl = new Curl();
        $res = $curl->get(C('Crontab.Clear_Servers'));
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
        $res = $curl->get(C('Crontab.Reload_Server'), ['server_ip' => $server_ip]);
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
        $res = $curl->get(C('Crontab.ShutDown_Server'), ['server_ip' => $server_ip]);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }

    /**
     * 添加计划任务
     */
    public function addTask()
    {
        $task_id = I('task_id', null, 'trim');
        $task_cmd = I('task_cmd', null, 'trim');
        $task_url = I('task_url', null, 'trim');
        $task_time = I('task_time', null, 'trim');
        $task_process_num = I('task_process_num', 1, 'intval');
        $task_group = I('task_group', '');
        $task_name = I('task_name', '');

        if (!$task_cmd || !$task_url || !$task_time || $task_process_num < 1 || !$task_group || !$task_name) {
            $this->ajaxReturn(['status' => -1, 'msg' => '缺少必要参数']);
        }

        $curl = new Curl();
        $data = ['task_id' => $task_id, 'task_cmd' => $task_cmd, 'task_url' => $task_url, 'task_process_num' => $task_process_num, 'task_time' => $task_time, 'task_group' => $task_group, 'task_name' => $task_name];
        $res = $curl->post(C('Crontab.Add_Task'), $data);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }

    /**
     * 获取任务
     */
    public function getTask()
    {
        $task_id = I('task_id', null, 'trim');

        if (!$task_id) {
            $this->ajaxReturn(['status' => -1, 'msg' => '缺少必要参数']);
        }

        $curl = new Curl();
        $res = $curl->get(C('Crontab.Get_Task'), ['task_id' => $task_id]);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success', 'data' => $res['data']]);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }

    /**
     * 开启暂停任务
     */
    public function startStopTask()
    {
        $task_id = I('task_id', null, 'trim');
        $task_status = I('task_status', 0, 'intval');

        if (!$task_id) {
            $this->ajaxReturn(['status' => -1, 'msg' => '缺少必要参数']);
        }

        $curl = new Curl();
        if ($task_status == 1) {
            $res = $curl->get(C('Crontab.Start_Task'), ['task_id' => $task_id]);
        } else if ($task_status == 0) {
            $res = $curl->get(C('Crontab.Stop_Task'), ['task_id' => $task_id]);
        }
        if (isset($res) && ($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }

    /**
     * 删除任务
     */
    public function deleteTask()
    {
        $task_id = I('task_id', null, 'trim');

        if (!$task_id) {
            $this->ajaxReturn(['status' => -1, 'msg' => '缺少必要参数']);
        }

        $curl = new Curl();
        $res = $curl->get(C('Crontab.Delete_Task'), ['task_id' => $task_id]);
        if (($res = json_decode($res, true)) && $res['status'] == 1) {
            $this->ajaxReturn(['status' => 1, 'msg' => 'success']);
        } else {
            $this->ajaxReturn(['status' => 0, 'msg' => 'fail']);
        }
    }
}