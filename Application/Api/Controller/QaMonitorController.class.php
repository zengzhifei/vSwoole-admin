<?php
/**
 * Created by PhpStorm.
 * User: zengz
 * Date: 2018/1/18
 * Time: 10:00
 */

namespace Api\Controller;

class QaMonitorController extends ApiBaseController
{
    /**
     * 进程监控
     */
    public function processMonitor()
    {
        $process_list = M('qa_monitor_process')->where(array('monitor_status' => 1))->select();
        if ($process_list) {
            $data = array();
            $is_unusual = 1;
            foreach ($process_list as $key => $process) {
                $cmd = "ps -ef | grep '" . $process['project_name'] . "\>' | grep '" . $process['process_code'] . "\>' | grep -v grep | grep -v ' sleep\>' | wc -l";
                exec($cmd, $msg, $status);
                $data[$process['project_name']][$process['process_code']] = array(
                    'process_status' => $msg[0] == 0 ? 0 : 1,
                    'exec_status'    => $status == 0 ? 1 : 0,
                    'monitor_time'   => date('Y-m-d H:i:s', time())
                );
                unset($msg);
                $is_unusual = $is_unusual & $data[$process['project_name']][$process['process_code']]['process_status'];
            }
            $this->ajaxReturn(array('status' => 1, 'msg' => '成功', 'data' => $data, 'is_unusual' => $is_unusual), $this->format);
        } else {
            $this->ajaxReturn(array('status' => 0, 'msg' => '没有监控的进程'), $this->format);
        }
    }
}