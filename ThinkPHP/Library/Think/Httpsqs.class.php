<?php
namespace Think;
/**
 * Httpsqs队列控制模块
 *
 */

class Httpsqs
{
    /**
     * 将文本信息放入一个队列
     *
     * @return bool
     */
    public static function put($host, $port, $charset='utf-8', $name, $data)
    {
        $result = self::httpPost($host, $port, "/?charset=".$charset."&name=".$name."&opt=put", $data);
        return $result;
    }

    /**
     * 从一个队列中取出文本信息
     *
     * @return string | false
     */
    public static function get($host, $port, $charset='utf-8', $name)
    {
        $result = self::httpGet($host, $port, "/?charset=".$charset."&name=".$name."&opt=get");
        if ($result["data"] == "HTTPSQS_ERROR" || $result["data"] == false) {
            return false;
        }
        return $result["data"];
    }

    /**
     * 从一个队列中取出文本信息和当前队列读取点Pos
     *
     * @return string | false array("pos" => 7, "data" => "text message")
     */
    public static function gets($host, $port, $charset='utf-8', $name)
    {
        $result = self::httpGet($host, $port, "/?charset=".$charset."&name=".$name."&opt=get");
        if ($result["data"] == "HTTPSQS_ERROR" || $result["data"] == false) {
            return false;
        }
        return $result;
    }

    /**
     * 查看队列状态（普通方式）
     *
     * @return string
     */
    public static function status($host, $port, $charset='utf-8', $name)
    {
        $result = self::httpGet($host, $port, "/?charset=".$charset."&name=".$name."&opt=status");
        if ($result["data"] == "HTTPSQS_ERROR" || $result["data"] == false) {
            return false;
        }
        return $result["data"];
    }

    /**
     * 查看队列状态（JSON方式）
     *
     * @return string json
     */
    public static function view($host, $port, $charset='utf-8', $name, $pos)
    {
        $result = self::httpGet($host, $port, "/?charset=".$charset."&name=".$name."&opt=view&pos=".$pos);
        if ($result["data"] == "HTTPSQS_ERROR" || $result["data"] == false) {
            return false;
        }
        return $result["data"];
    }

    /**
     * 更改指定队列的最大队列数量
     *
     * @return bool
     */
    public static function maxqueue($host, $port, $charset='utf-8', $name, $num)
    {
        $result = self::httpGet($host, $port, "/?charset=".$charset."&name=".$name."&opt=maxqueue&num=".$num);
        if ($result["data"] == "HTTPSQS_MAXQUEUE_OK") {
            return true;
        }
        return false;
    }

    private static function httpGet($host, $port, $query)
    {
        $fp = fsockopen($host, $port, $errno, $errstr, 1);
        if (!$fp) {
            return false;
        }
        $out = "GET ${query} HTTP/1.1\r\n";
        $out .= "Host: ${host}\r\n";
        $out .= "Connection: close\r\n";
        $out .= "\r\n";
        fwrite($fp, $out);
        $line = trim(fgets($fp));
        $pos_value = "";
        list($proto, $rcode, $result) = explode(" ", $line);
        $len = -1;
        while (($line = trim(fgets($fp))) != "") {
            if (strstr($line, "Content-Length:")) {
                list($cl, $len) = explode(" ", $line);
            }
            if (strstr($line, "Pos:")) {
                list($pos_key, $pos_value) = explode(" ", $line);
            }
        }
        if ($len < 0){
            return false;
        }
        $body = @fread($fp, $len);
        fclose($fp);
        $result_array["pos"] = (int)$pos_value;
        $result_array["data"] = $body;
        return $result_array;
     }

     private static function httpPost($host, $port, $query, $body)
     {
         $fp = fsockopen($host, $port, $errno, $errstr, 1);
         if (!$fp) {
             return false;
         }
         $out = "POST ${query} HTTP/1.1\r\n";
         $out .= "Host: ${host}\r\n";
         $out .= "Content-Length: " . strlen($body) . "\r\n";
         $out .= "Connection: close\r\n";
         $out .= "\r\n";
         $out .= $body;
         fwrite($fp, $out);
         $line = trim(fgets($fp));
         $pos_value = "";
         list($proto, $rcode, $result) = explode(" ", $line);
         $len = -1;
         while (($line = trim(fgets($fp))) != "") {
             if (strstr($line, "Content-Length:")) {
                 list($cl, $len) = explode(" ", $line);
             }
             if (strstr($line, "Pos:")) {
                 list($pos_key, $pos_value) = explode(" ", $line);
             }
         }
         fclose($fp);
         return ($len < 0) ? false : (int)$pos_value;
     }
 }