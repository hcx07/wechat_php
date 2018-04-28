<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/27
 * Time: 16:24
 */

namespace backend\helpers;

use Yii;
use yii\web\Response;

class Helper
{
    /**
     * @param array $data
     * @param string $msg
     * @param int $code
     */
    public static function response($data = [], $msg = "success", $code = 200)
    {
        header("Access-Control-Allow-Origin:*");
        header("content-type:application/json");
        $error = "";
        if (empty($code)) {
            $code = 200;
        } elseif ($code !== 200) {
            $isInsideError = preg_match('/sql/', strtolower($msg));  //sql
            if ($isInsideError || $code == 555) {
                $error = $msg;
                $code = 555;
                $msg = "程序出错，请稍后重试...";
            }
        }
        if (empty($data)) {
            $data = [];
        }
        $response = [
            "code" => $code,
            "time" => time(),
            "error" => $error,
            "msg" => $msg,
            "data" => $data
        ];
        exit(json_encode($response));
    }


    /**
     * @param array|Object $data
     * @param string $msg
     * @param int $code
     */
    public static function responseO($data = [], $msg = "success", $code = 200)
    {
        header("Access-Control-Allow-Origin:*");
        header("content-type:application/json");
        $error = "";
        if (empty($code)) {
            $code = 200;
        } elseif ($code !== 200) {
            $isInsideError = preg_match('/sql/', strtolower($msg));  //sql
            if ($isInsideError || $code == 555) {
                $error = $msg;
                $code = 555;
                $msg = "程序出错，请稍后重试...";
            }
        }
        if (empty($data)) {
            $data = new \stdClass();
        }
        $response = [
            "code" => $code,
            "time" => time(),
            "error" => $error,
            "msg" => $msg,
            "data" => $data
        ];
        exit(json_encode($response));
    }

    /**
     * @param \Exception $error
     */
    public static function responseError(\Exception $error)
    {
        header("Access-Control-Allow-Origin:*");
        header("content-type:application/json");
        $code = $error->getCode();
        $msg = $error->getMessage();
        Yii::error(print_r($error, 1), __METHOD__);
        if (empty($code)) {
            $code = 501;
        }
        $response = [
            "code" => $code,
            "time" => time(),
            "error" => $msg,
            "msg" => $msg,
            "data" => new \stdClass()
        ];
        exit(json_encode($response));
    }

    /**
     *  认证失败返回
     */
    public static function responseAuthFail()
    {
        header("Access-Control-Allow-Origin:*");
        header("content-type:application/json");
        $response = [
            "code" => 401,
            "time" => time(),
            "error" => "auth fail",
            "msg" => "认证失败",
            "data" => new \stdClass()
        ];
        exit(json_encode($response));
    }

    /**
     * 纯返回数据
     * @param $response
     */
    public static function responsePure($response)
    {
        header("Access-Control-Allow-Origin:*");
        header("content-type:application/json");

        exit(json_encode($response));
    }

    /**
     * 返回HTTP
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return array|string
     */
    public static function responseHttp($data = [], $msg = "", $code = 200)
    {
        header("Content-Type:application/json");
        http_response_code($code);
        $response = Yii::$app->response;
        $response->setStatusCode($code);
        $response->format = Response::FORMAT_JSON;
        $response->headers->set("Content-Type", "application/json");
        if (!empty($msg)) {
            return ($msg);
        }
        return $data;
    }

    /**
     * 返回格式化表格数据
     * @param $data
     * @param $total
     */
    public static function formatRes(&$data, $total)
    {
        $draw = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : 0;
        $result = [
            "draw" => intval($draw),
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data
        ];
        $data = $result;
    }

    /**
     * 验证手机号码
     * @param string $mobile
     * @return bool
     */
    public static function isMobile($mobile = "")
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^1[\d]{10}$#', $mobile) ? true : false;
    }

    /**
     * 验证是否是身份证号
     * @param $id
     * @return bool
     */
    public static function isIdCardNo($id)
    {
        if (strlen($id) != 18) {
            return false;
        }
//        $set = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
//        $ver = array('1','0','x','9','8','7','6','5','4','3','2');
//        $arr = str_split($id);
//        $sum = 0;
//        for ($i = 0; $i < 17; $i++)
//        {
//            if (!is_numeric($arr[$i]))
//            {
//                return false;
//            }
//            $sum += $arr[$i] * $set[$i];
//        }
//        $mod = $sum % 11;
//        if (strcasecmp($ver[$mod],$arr[17]) != 0)
//        {
//            return false;
//        }
        return true;
    }

    /**
     *  根据时间戳获取简单的时间描述
     * @param $timestamp
     * @return bool|string
     */
    public static function getSimpleTime($timestamp)
    {
        $timestamp |= 0;
        $rtime = date("m-d H:i", $timestamp);
        $htime = date("H:i", $timestamp);
        $time = time() - $timestamp;
        $year = date("Y", $timestamp);
        $now_year = date("Y");
        if ($time < 60) {
            $str = '刚刚';
        } elseif ($time < 60 * 60) {
            $min = floor($time / 60);
            $str = $min . '分钟前';
        } elseif ($time < 60 * 60 * 24) {
            $h = floor($time / (60 * 60));
            $str = $h . '小时前';
        } elseif ($time < 60 * 60 * 24 * 3) {
            $d = floor($time / (60 * 60 * 24));
            if ($d == 1)
                $str = '昨天 ' . $htime;
            else
                $str = '前天 ' . $htime;
        } elseif ($now_year > $year) {
            $str = date("Y-m-d", $timestamp);
        } else {
            $str = $rtime;
        }
        return $str;
    }

    /**
     * 生成订单号
     * @return string
     */
    public static function build_order_no()
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $msectime . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    /**
     * @param $array
     * @return array
     * 提交订单时 去重
     */
    public static function remove_duplicate($array)
    {
        $result = array();
        foreach ($array as $key => $value) {
            $has = false;
            foreach ($result as $val) {
                if ($val['coupon_id'] == $value['coupon_id']) {
                    $has = true;
                    break;
                }
            }
            if (!$has)
                $result[] = $value;
        }
        return $result;
    }

    /**
     * POST
     * @param $url
     * @param array $data
     * @return mixed
     */
    public static function post($url, $data = [])
    {
        $curl = curl_init($url);
        $param = http_build_query($data);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
        curl_setopt($curl, CURLOPT_POST, true); // post传输数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);// post传输数据
        $responseText = curl_exec($curl);

        curl_close($curl);

        return $responseText;
    }

    /**
     * 获取数组中的某一列
     * @param type $arr 数组
     * @param type $key_name 列名
     * @return type  返回那一列的数组
     */
    public static function get_arr_column($arr, $key_name)
    {
        $arr2 = array();
        foreach ($arr as $key => $val) {
            $arr2[] = $val[$key_name];
        }
        return $arr2;
    }


    /**
     *   实现中文字串截取无乱码的方法
     */
    public static function getSubstr($string, $start, $length)
    {
        if (mb_strlen($string, 'utf-8') > $length) {
            $str = mb_substr($string, $start, $length, 'utf-8');
            return $str . '...';
        } else {
            return $string;
        }
    }

    /**
     * 过滤emoji
     * @param $str
     * @return mixed
     */
    public static function filterEmoji($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);

        return $str;
    }

    /**
     * @param int $time
     * @param string $test
     * @return string
     * 例如 得到1小时前
     */
    public static function put_time($time = 0, $test = '')
    {
        if (empty($time)) {
            return $test;
        }
        $time = substr($time, 0, 10);
        $ttime = time() - $time;
        if ($ttime <= 0 || $ttime < 60) {
            return '刚刚';
        }
        if ($ttime > 60 && $ttime < 120) {
            return '1分钟前';
        }

        $i = floor($ttime / 60);                            //分
        $h = floor($ttime / 60 / 60);                       //时
        $d = floor($ttime / 86400);                         //天
        $m = floor($ttime / 2592000);                       //月
        $y = floor($ttime / 60 / 60 / 24 / 365);            //年
        if ($i < 30) {
            return $i . '分钟前';
        }
        if ($i > 30 && $i < 60) {
            return '1小时内';
        }
        if ($h >= 1 && $h < 24) {
            return $h . '小时前';
        }
        if ($d >= 1 && $d < 30) {
            return $d . '天前';
        }
        if ($m >= 1 && $m < 12) {
            return $m . '个月前';
        }
        if ($y) {
            return $y . '年前';
        }
        return "";
    }

    public static function html($string,$sublen=0)
    {
        $string = strip_tags($string);
        $string = preg_replace('/\n/is', '', $string);
        $string = preg_replace('/ |　/is', '', $string);
        $string = preg_replace('/&nbsp;/is', '', $string);

        preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);
        if(count($t_string[0]) - 0 > $sublen) $string = join('', array_slice($t_string[0], 0, $sublen))."…";
        else $string = join('', array_slice($t_string[0], 0, $sublen));
        return $string;
    }
}