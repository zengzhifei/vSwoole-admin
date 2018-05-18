<?php
/**
 * 短信发送
 * User: zengz
 * Date: 2018/2/2
 * Time: 10:06
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class SmsController extends Controller
{
    const APP_ID = 1400066356;
    const APP_KEY = "487e5a881c2623c824921853b2db094c";
    const TEMPLETE_ID = 83274;
    const NATION_CODE = 86;

    const CACHE_TYPE = 'File';
    const CACHE_SEND_PREFIX = 'sms_send_';
    const CACHE_SEND_TIME = 600;
    protected $cache = null;

    public function __construct()
    {
        vendor('Sms.SmsSenderUtil');
        vendor('Sms.SmsMultiSender');

        $this->cache = S(array('type' => self::CACHE_TYPE, 'prefix' => self::CACHE_SEND_PREFIX, 'expire' => self::CACHE_SEND_TIME));
    }

    //发送短信
    public function send($phones = [], $errorMsg = [], $sign = '')
    {
        try {
            $ip = get_client_ip();
            if (!$this->cache->$ip) {
                if (!empty($phones) && !empty($errorMsg)) {
                    $sms = new \Qcloud\Sms\SmsMultiSender(self::APP_ID, self::APP_KEY);
                    $res = $sms->sendWithParam(self::NATION_CODE, $phones, self::TEMPLETE_ID, $errorMsg, $sign);
                    $res = json_decode($res, true);
                    if ($res['result'] == 0) {
                        $this->cache->$ip = 1;
                    }

                    return $res;
                }
            }

            return false;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    //获取短信发送数量
    public function getSmsCount()
    {
        $random = randCode(10, 0);
        $time = time();
        $url = 'https://yun.tim.qq.com/v5/tlssmssvr/pullsendstatus?sdkappid=' . self::APP_ID . '&random=' . $random;
        $signStr = 'appkey=' . self::APP_KEY . '&random=' . $random . '&time=' . $time;
        $sign = hash('sha256', $signStr);
        $begin_date = date('Ym') . '0100' + 0;
        $end_date = date('Ymd') . '00' + 100;
        $data = array(
            'sig'        => $sign,
            'time'       => $time,
            'begin_date' => $begin_date,
            'end_date'   => $end_date
        );
        $res = http($url, json_encode($data), 'POST', array("Content-type: application/json; charset=utf-8"));
        $res = json_decode($res, true);

        return $res;
    }

}