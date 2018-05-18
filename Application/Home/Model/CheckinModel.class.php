<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;

/**
 * 签到模型
 */
class CheckinModel extends Model{
    
    public function _initialize(){
        parent::_initialize();
    }
    
    public function checkin($uid,$userinfo){
        $timestamp = time();
        if(!$uid) 
            return -1;
        if(!$userinfo){
            $r=$this->addCheckinfUser($uid);
            $userinfo = $this->getCheckinfUserInfo($uid);
        }
        $lastck = strtotime(date('Y-m-d', $userinfo['checkin_time']));
        $today = strtotime('today');
        if ($today == $lastck)
            return - 2;
        $result = false;
        $res = $this->addCheckinLog($uid, $timestamp);
        if($res){
            $result = $this->updateCheckinfUser($userinfo,$timestamp);
            if ($today - $lastck == 86400) {
                $days = $userinfo['checkin_days'] + 1;
            } else {
                $days = 1;
            }
            if ($result) {
                $result = array(
                        'total' => $userinfo['checkin_total'] + 1,
                        'days' => $days
                );
            }
        }
        return $result;
    }
    
    //新增签到日志
    public function addCheckinLog($uid,$timestamp){
        $model = M('checkin_log');
        $data['uid'] = $uid;
        $data['checkin_date'] = strtotime(date('Y-m-d', $timestamp));
        $data['checkin_time'] = $timestamp;
        $result = $model->add($data);
        return $result;
    }
    
    //首次签到添加到签到用户表
    public function addCheckinfUser($uid){
        $data['uid'] = $uid;
        $data['checkin_days'] = 0;
        $data['checkin_total'] = 0;
        $data['checkin_max'] = 0;
        $data['checkin_time'] = 0;
        $result = $this->add($data);
        return $result;
    }
    
    public function updateCheckinfUser($userinfo,$timestamp){
        $lastck = strtotime(date('Y-m-d', $userinfo['checkin_time']));
        $today = strtotime('today');
        if ($today - $lastck == 86400) {
            $days = $userinfo['checkin_days'] + 1;
        } else {
            $days = 1;
        }
        $params = array(
                'checkin_total' => $userinfo['checkin_total']+1,
                'checkin_days'  => $days,
                'checkin_time'  => $timestamp
        );
        if ($days > $userinfo['checkin_max'])
            $params['checkin_max'] = $days;
        $where['uid'] = array('eq',$userinfo['uid']);
        $result = $this->where($where)->save($params);
        return $result;
    }
    
    
    //取出签到用户的信息
    public function getCheckinfUserInfo($uid){
        $where['uid'] = array('eq',$uid);
        $result = $this->where($where)->field('uid,checkin_days,checkin_total,checkin_max,checkin_time')->find();
        if($result)
            $result['ischeckined'] = $this->isChecked($result);
        return $result;
    }
    
    
    /**
     * 判断是否签到
     *
     * @param unknown $userinfo
     * @return boolean
     */
    function isChecked($userinfo = array())
    {
        $uid = $userinfo['uid'];
        if (! $uid)
            return false;
        $lastck = strtotime(date('Y-m-d', $userinfo['checkin_time']));
        $today = strtotime('today');
        return $today == $lastck ? true : false;
    }
    
    
    //获取用户签到日志
    function getUserCheckLog($uid, $timestamp){
        $uid = intval($uid);
        if (! $uid)
            return false;
        $timestamp = intval($timestamp) ? intval($timestamp) : time();
        $checkinLogModel = M('checkin_log');
        $year = date('Y', $timestamp);
        $month = date('n', $timestamp);
        $start_time = mktime(0, 0, 0, $month, 1, $year);
        $end_time = mktime(0, 0, 0, $month + 1, 1, $year);
        $where['uid'] = array('eq',$uid);
        $where['checkin_time'] = array(array('EGT',$start_time),array('LT',$end_time));
        $result = $checkinLogModel->where($where)->select();
        $ckeddata = array();
        
        foreach($result as $row){
            $date = date('j',$row['checkin_time']);
            $ckeddata[$date] = $row['checkin_time'];
        }
        
        return $ckeddata;
    }
    
    
    //签到的日历显示和签到记录
    function makecalendar($data=array(),$timestamp){
        $timestamp = intval($timestamp) ? intval($timestamp) : time();
        $prev_year = mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)-1);
        $prev_month = mktime(0,0,0,date('n',$timestamp)-1,1,date('Y',$timestamp));
        $next_year = mktime(0,0,0,date('n',$timestamp),1,date('Y',$timestamp)+1);
        $next_month = mktime(0,0,0,date('n',$timestamp)+1,1,date('Y',$timestamp));
        $prefs = array(
                'template' => '
{table_open}<table class="sign_calendar" border="0" cellpadding="0" cellspacing="0">{/table_open}
    
{heading_row_start}<div class="fz">{/heading_row_start}
{heading_previous_dub_cell}<a href="javascript:void(0);" class="shuang"  onclick="get_calendar('.$prev_year.');return false;"></a>{/heading_previous_dub_cell}
{heading_previous_cell}<a href="javascript:void(0);" class="dan"  onclick="get_calendar('.$prev_month.');return false;"></a>{/heading_previous_cell}
{heading_title_cell}<a  style="cursor:default; text-decoration:none">{heading}</a>{/heading_title_cell}
{heading_next_cell}<a href="javascript:void(0);" class="dan2"  onclick="get_calendar('.$next_month.');return false;"></a>{/heading_next_cell}
{heading_next_dub_cell}<a href="javascript:void(0);" class="shuang2"  onclick="get_calendar('.$next_year.');return false;"></a>{/heading_next_dub_cell}
{heading_row_end}</div>{/heading_row_end}
    
{week_row_start}<table cellpadding="0" cellspacing="0" width="174"><tr>{/week_row_start}
{week_day_cell}<td  width="24">{week_day}</td>{/week_day_cell}
{week_weekend_cell}<td class="sun"  width="24">{week_day}</td>{/week_weekend_cell}
{week_row_end}</tr></table>{/week_row_end}
    
{cal_row_start}<table cellpadding="0" cellspacing="0" width="174" style="border-top:none;"><tr>{/cal_row_start}
{cal_cell_start}<td  width="24">{/cal_cell_start}
{cal_cell_content}<div class="cur" title="已签到">{day}</div>{/cal_cell_content}
{cal_cell_content_today}<div class="cur2">{day}</div>{/cal_cell_content_today}
{cal_cell_no_content}{day}{/cal_cell_no_content}
{cal_cell_no_content_today}<div class="cur">{day}</div>{/cal_cell_no_content_today}
{cal_cell_blank}&nbsp;{/cal_cell_blank}
{cal_cell_end}</td>{/cal_cell_end}
{cal_row_end}</tr>{/cal_row_end}
    
{table_close}</tr></table>{/table_close}
		',
                'month_type'=>'short',
                'start_day'=>'monday',
                'show_next_prev'  => TRUE,
        );
    
        //$this->calendar = new calendar($prefs);
        import("Vendor.Calendar.Calendar",'','.php');
        $CalendarModel = new \Calendar($prefs);
        $cal = $CalendarModel->generate(date('Y',$timestamp),date('n',$timestamp),$data);
        return $cal;
    }
}
