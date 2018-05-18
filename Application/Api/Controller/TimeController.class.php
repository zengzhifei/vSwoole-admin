<?php

namespace Api\Controller;

class TimeController extends ApiBaseController
{

    
    /**
     * 当前最高分接口
     */
    public function getTimeLine(){
        //获取当前期id
        $stage_info = M("stage")->where(array("stage_status"=>1))->find();
        $stage_id = $stage_info["stage_id"];
        
        $group_info = M("group")->where(array("group_status"=>1,"stage_id"=>$stage_id))->select();
        $group_show = array();
        $qaMode = M("qa");
        $now_time = time();
        $format_now_time = date("Y-m-d H:i:s",$now_time);
        foreach($group_info as $k=>$v){
            $group_show[$k]["group_id"] = $v["id"];
            $group_show[$k]["group_title"] = $v["group_title"];
            $group_show[$k]["group_time"] = date("Y-m-d H:i:s",$v["group_start_time"])."-". date("Y-m-d H:i:s",$v["group_end_time"]);
            if($now_time >= $v["group_start_time"] &&  $now_time <= $v["group_end_time"]){
                $group_show[$k]["is_select"] = 1;
            }else{
                $group_show[$k]["is_select"] = 0;
            }
            $qa_info = $qaMode->where(array("group_id"=>$v["id"]))->field("id,group_id,qa_type_name,qa_subject,qa_start_time,qa_res_time,from_unixtime(qa_start_time) as start_time,from_unixtime(qa_end_time) as end_time,from_unixtime(qa_res_time) as res_time")->select();
            $group_show[$k]["qa"] = $qa_info;
        }
        //echo "<pre>";print_r($group_show);exit;
        $this->ajaxReturn(array('code' => 1, 'data' => $group_show,"timestamp"=>$now_time,"format_timestamp"=>$format_now_time), $this->format);
        
    }
    
}
