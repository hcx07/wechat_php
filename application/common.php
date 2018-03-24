<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * @param $status
 * @param $msg
 * @param null $data
 * 返回数据
 */
function get_op_put($status = 200, $msg = '', $data) {
    header('Content-type: application/json');
    if(!isset($data)){
        $data1 = array();
        $data = (object)$data1;
    }
    $array = array(
        "status" => $status,
        "msg" => $msg,
        "data" => $data
    );
    exit(json_encode($array));
}

/**
 * @param $mobile
 * @return bool
 * 判断是否是正确手机号
 */
function is_mobile($mobile){
    if(preg_match('/^1[34578]{1}\d{9}$/',$mobile)){
        return true;
    }else{
        return false;
    }
}

/**
 * @param $password
 * @return string
 * md5加密干扰
 */
function encrypt($password){
    return md5('$D#Z%G&' . $password);
}

/**
 * @param $password
 * @return bool
 * 判断用户端密码格式
 */
function userPasswordAuth($password){
    if(preg_match('/^(?![0-9]*$)(?![a-zA-Z]*$)[a-zA-Z0-9]{6,12}$/',$password)){
        return true;
    }else{
        return false;
    }
}

/**
 * @param string $id
 * @return string
 * 生成订单号
 */
function generate_order_sn($id=''){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8) . $id;
}


/**
 * @param int $type
 * @return mixed
 * 获取用户端id
 */
function get_ip($type = 0)
{
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) return $ip[$type];
    if ($_SERVER['HTTP_X_REAL_IP']) {//nginx 代理模式下，获取客户端真实IP
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {//客户端的ip
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {//浏览当前页面的用户计算机的网关
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos) unset($arr[$pos]);
        $ip = trim($arr[0]);
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];//浏览当前页面的用户计算机的ip地址
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


/**
 * 过滤敏感词
 * @param $str
 * @return mixed
 */
function filterWord($str){
    $words = S('filter_word');
    if(empty($words)){
        $sensitive = M('sensitive_word')->getField('word',true);
        if(!empty($sensitive)){
            foreach($sensitive as &$item){
                $item = str_replace(['[',']'],['\[','\]'],$item);
            }
            $words = implode("|",$sensitive);
            S('filter_word',$words);
        }
    }
    if(empty($words)){
        return $str;
    }
    $res = preg_replace("/{$words}/ie",'str_repeat("*",mb_strlen("$0","utf8"))',$str);
    return $res;
}

/**
 * @param $data
 * @return string
 * 加密
 */
function encryption($data){
    $private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC7Z3C3hAIBrjpodv0M2bTjKcVI3eI6ljGnUpV0Db9kQhdEJ8ktv
baa9mDuSP3c/kAFh02Fnreb9caiuV5fRpWOQ0f5zDL60jtrJ+75nI+hIxstuNrjTi
DcLXeoWKI9rnq8AkInNf/GMgOS9RecudPXelYD9/vpxf9nli9LzzEVEwIDAQABAoG
BAJpJu18ba5t+mc/Pxt6Bjo9HoIkxREP/y7l6IFl/yAb+8rDGILdr7Z7/ISaNKZR8
LrFeh9Bur7PTUUo/WxcNwaoHABLIwa/7Cvw3pZEN2UDZsnGu051Qpb9bagBaqcd9F
mDTmRP8JGO+XjAmuCbcSXA3lXkYuxnpIXloxZ5SOvfhAkEA+ACT3i9+0aa3f5oYMw
yhh8dYxTtQwc6NNHcwlqYKTJJlBds1xYppKoKqYsvEidDASkz/Z3xW+8r6NSwq1r8
nBwJBAMFylagTbDpMllelU6VljNSII6sLLfE3HMTrJ/gjtB5V5KaI4Oc+HiQE2oEP
+qGdkpSc5P4seSr6jMvsHL0wMpUCQQCe1g/ef+DjebmQ2iqhl3dlNQHf4GuKlTXO4
n+WHOX/wMs/AvTffhR5C5MBD6zi73YYoFP7/aDgR1IU+CK/w1HFAkA+H0P8I7Cf0D
R/lPIVrVTac5WwufhY/C/a9QFy6FRRYZf5+v7ug74+JujchXshJ28JFpFbJoEK0kc
gvYRFJRM5AkAoVU6NkkKs85t2z7BiWMBaXF3el65Mi5xGPpudvTHh90P4r+VAn2R5
gcA6ZSxvBRvpdYwK6ENHxc3ygd0GxU8l
-----END RSA PRIVATE KEY-----';
    $pi_key =  openssl_pkey_get_private($private_key);
    $encrypted = "";
    openssl_private_encrypt(time() .$data,$encrypted,$pi_key);
    $encrypted = base64_encode($encrypted);
    return $encrypted;
}

/**
 * @param $encrypted
 * @return string
 * 解密
 */
function decryption($encrypted){
    $private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC7Z3C3hAIBrjpodv0M2bTjKcVI3eI6ljGnUpV0Db9kQhdEJ8ktv
baa9mDuSP3c/kAFh02Fnreb9caiuV5fRpWOQ0f5zDL60jtrJ+75nI+hIxstuNrjTi
DcLXeoWKI9rnq8AkInNf/GMgOS9RecudPXelYD9/vpxf9nli9LzzEVEwIDAQABAoG
BAJpJu18ba5t+mc/Pxt6Bjo9HoIkxREP/y7l6IFl/yAb+8rDGILdr7Z7/ISaNKZR8
LrFeh9Bur7PTUUo/WxcNwaoHABLIwa/7Cvw3pZEN2UDZsnGu051Qpb9bagBaqcd9F
mDTmRP8JGO+XjAmuCbcSXA3lXkYuxnpIXloxZ5SOvfhAkEA+ACT3i9+0aa3f5oYMw
yhh8dYxTtQwc6NNHcwlqYKTJJlBds1xYppKoKqYsvEidDASkz/Z3xW+8r6NSwq1r8
nBwJBAMFylagTbDpMllelU6VljNSII6sLLfE3HMTrJ/gjtB5V5KaI4Oc+HiQE2oEP
+qGdkpSc5P4seSr6jMvsHL0wMpUCQQCe1g/ef+DjebmQ2iqhl3dlNQHf4GuKlTXO4
n+WHOX/wMs/AvTffhR5C5MBD6zi73YYoFP7/aDgR1IU+CK/w1HFAkA+H0P8I7Cf0D
R/lPIVrVTac5WwufhY/C/a9QFy6FRRYZf5+v7ug74+JujchXshJ28JFpFbJoEK0kc
gvYRFJRM5AkAoVU6NkkKs85t2z7BiWMBaXF3el65Mi5xGPpudvTHh90P4r+VAn2R5
gcA6ZSxvBRvpdYwK6ENHxc3ygd0GxU8l
-----END RSA PRIVATE KEY-----';
    $pi_key =  openssl_pkey_get_private($private_key);
    $decrypted =  '';
    openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密
    return substr($decrypted,10);
}

/**
 * 发送post请求
 * @param $url
 * @param string $post
 * @param int $timeout
 * @return mixed|void
 */
function http_post( $url, $post = '', $timeout = 5 ){
    if( empty( $url ) ){
        return;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    if( $post != '' && !empty( $post ) ){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($post)));
    }
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


/**
 * Class UnionPay
 * 银联
 */
class UnionPay{

    const merId = "898520148160287";         //商户号
    static $config = '';

    public function __construct()
    {
        vendor("unionPay.sdk.acp_service");
        self::$config = \SDKConfig::getSDKConfig();
    }

    /**
     * 代付交易，付款给用户
     * @param string $orderNo  商户订单流水号
     * @param string $accNo 银行卡号
     * @param string $certifId 身份证号
     * @param string $customerNm 持卡人姓名
     * @param int $txnAmt 交易额，单位分
     * @param string $txnTime date('YmdHis')
     * @return string
     * @throws Exception
     */
    public function payment($orderNo,$accNo,$certifId,$customerNm,$txnAmt,$txnTime){
        $customerInfo = [
            "certifTp" => "01",
            'certifId' => trim($certifId),
            'customerNm' => trim($customerNm),
        ];
        $params = [
            'version' => '5.0.0',		      //版本号
            'encoding' => 'utf-8',		      //编码方式
            'signMethod' => '01',		      //签名方法
            'txnType' => '12',		          //交易类型
            'txnSubType' => '00',		      //交易子类
            'bizType' => '000401',		      //业务类型
            'accessType' => '0',		      //接入类型
            'channelType' => '08',		      //渠道类型
            'currencyCode' => '156',          //交易币种，境内商户勿改
            'backUrl' => SDK_BACK_NOTIFY_URL_PAYMENT, //后台通知地址
            'encryptCertId' => \AcpService::getEncryptCertId(), //验签证书序列号

            //TODO 以下信息需要填写
            'merId' => self::merId,		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
            'orderId' => $orderNo,	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
            'txnTime' => $txnTime,	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
            'txnAmt' => strval($txnAmt),	//交易金额，单位分，此处默认取demo演示页面传递的参数
            'accNo' =>  \AcpService::encryptData($accNo),     //卡号，新规范请按此方式填写
//            'accNo' => $accNo,
            'customerInfo' => \AcpService::getCustomerInfoWithEncrypt($customerInfo), //持卡人身份信息，新规范请按此方式填写
        ];
        \AcpService::sign($params);
        $url = SDK_BACK_TRANS_URL;
        $result = \AcpService::post($params,$url);
//        var_dump($params,$result);
        if(count($result)<=0){
            throw new \Exception("与银联服务器连接失败",502);
        }
        if(!\AcpService::validate($result)){
            throw new \Exception("应答报文验证失败",502);
        }
        if($result["respCode"] == "00"){
            return \AcpService::decryptData($result['accNo']);                           //返回银行卡号
        }elseif(in_array($result['respCode'],["03","04","05","01","12","34","60"])){
            throw new \Exception("处理超时，请稍后查询。",502);
        }else{
            throw new \Exception($result['respMsg']);
        }
    }

    /**
     * 银联支付订单
     * @param string $orderNo
     * @param int $txnAmt
     * @param string $txnTime
     * @param url $callback
     * @return mixed tn
     * @throws Exception
     */
    public function payOrder($orderNo, $txnAmt, $txnTime,$callback){
        $params = [
            'version' => self::$config->version,  //版本号
            'encoding' => 'utf-8',				  //编码方式
            'txnType' => '01',				      //交易类型
            'txnSubType' => '01',				  //交易子类
            'bizType' => '000201',				  //业务类型
            'frontUrl' =>  self::$config->frontUrl,  //前台通知地址
            'backUrl' => $callback,	  //后台通知地址
            'signMethod' => '01',	              //签名方法
            'channelType' => '08',	              //渠道类型，07-PC，08-手机
            'accessType' => '0',		          //接入类型
            'currencyCode' => '156',	          //交易币种，境内商户固定156

            //TODO 以下信息需要填写
            'merId' => self::merId,		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
            'orderId' => $orderNo,	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
            'txnTime' => $txnTime,	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
            'txnAmt' => $txnAmt
        ];
        \AcpService::sign($params);
        $url = 'https://gateway.95516.com/jiaofei/api/appTransReq.do';
        $result = \AcpService::post($params,$url);
//        var_dump($result,$params);
        if(count($result)<=0){
            throw new \Exception("与银联服务器连接失败",502);
        }
        if(!\AcpService::validate($result)){
            throw new \Exception("应答报文验证失败",502);
        }
//        var_dump($result);
        if($result["respCode"] == "00"){
            return $result['tn'];                           //返回银行受理订单号
        }else{
            throw new \Exception($result['respMsg']);
        }
    }

    /**
     * 退款
     * @param $order_no
     * @param $queryId
     * @param $txnAmt
     * @param $callback
     * @return bool
     * @throws Exception
     */
    public function refund($order_no, $queryId, $txnAmt,$callback){
        $params = [
            'version' => self::$config->version,  //版本号
            'encoding' => 'utf-8',		      //编码方式
            'signMethod' => '01',		      //签名方法
            'txnType' => '04',		          //交易类型
            'txnSubType' => '00',		      //交易子类
            'bizType' => '000201',		      //业务类型
            'accessType' => '0',		      //接入类型
            'channelType' => '07',		      //渠道类型
            'backUrl' => $callback, //后台通知地址

            //TODO 以下信息需要填写
            'orderId' => $order_no,	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
            'merId' => self::merId,	        //商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
            'origQryId' => $queryId, //原消费的queryId，可以从查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
            'txnTime' => date('YmdHis', time()),	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
            'txnAmt' => $txnAmt,       //交易金额，退货总金额需要小于等于原消费
        ];
        \AcpService::sign($params);
//        var_dump($params);
        $url = self::$config->backTransUrl;
        $result = \AcpService::post($params,$url);
        if(count($result)<=0){
            throw new \Exception("与银联服务器连接失败",502);
        }
        if(!\AcpService::validate($result)){
            throw new \Exception("应答报文验证失败",502);
        }
        if($result["respCode"] == "00"){
            return true;
        }else{
            throw new \Exception($result['respMsg']);
        }
    }

    /**
     * 交易查询
     * @param $orderNo
     * @param $txnTime
     * @return string
     * @throws Exception
     */
    public function queryOrder($orderNo, $txnTime){
        $params = [
            'version' => self::$config->version,  //版本号
            'encoding' => 'utf-8',		  //编码方式
            'signMethod' => '01',		  //签名方法
            'txnType' => '00',		      //交易类型
            'txnSubType' => '00',		  //交易子类
            'bizType' => '000000',		  //业务类型
            'accessType' => '0',		  //接入类型
            'channelType' => '07',		  //渠道类型

            //TODO 以下信息需要填写
            'merId' => self::merId,	    //商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
            'orderId' => $orderNo,	//请修改被查询的交易的订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数
            'txnTime' => $txnTime,
        ];
        AcpService::sign($params);
        $url = self::$config->singleQueryUrl;

        $result = AcpService::post ( $params, $url);
        if(count($result)<=0){
            throw new \Exception("与银联服务器连接失败",502);
        }
        if(!AcpService::validate($result)){
            throw new \Exception("应答报文验证失败",502);
        }
        if($result['respCode'] == '00'){
            if($result['origRespCode'] == '00'){
                return $result;
            }elseif(in_array($result['origRespCode'],["03","04","05","01","12","34","60"])){
                throw new \Exception("交易处理中，请稍后查询",502);
            }else{
                throw new \Exception("交易失败：".$result['origRespMsg'],502);
            }
        }elseif(in_array($result['respCode'],["03","04","05"])){
            throw new \Exception("处理超时，请稍后查询",502);
        }else{
            throw new \Exception("失败：".$result['origRespMsg'],502);
        }
    }
}

/**
 * Class AliPay
 * 支付宝支付
 */
class aliPay {
    static $NOTIFY_URL;
    static $REFUND_URL;
    private $aliPayApi;

    public function __construct(){
        vendor("alipay.aliPayApi");
        $this->aliPayApi = new AliPayApi();
    }

    /**
     * 验证支付宝支付回调消息是否合法
     * @param $data
     * @return bool
     */
    public function verifyCallBack($data){
        if(empty($data)) {
            return false;
        }
        else {
            //生成签名结果
            $isSign = $this->aliPayApi->getSignVeryfy($data, $data["sign"]);
            //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
            $responseTxt = 'false';
            if (!empty($data["notify_id"])){
                $responseTxt = $this->aliPayApi->getResponse($data["notify_id"]);
            }
            //验证
            //$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
            //isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            if (preg_match("/true$/i",$responseTxt) && $isSign) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * 获取带签名的请求体
     * @param string $order_no   订单号
     * @param float $money       交易金额 单位：元
     * @param string $notify_url 服务器异步通知页面路径
     * @return string
     */
    public function getRequestParam($order_no,$content,$money, $notify_url,$PARTNER,$SELLER_ID,$PRIVATE_KEY_PATH){
        $request = [
            "partner"=>$PARTNER,
            "seller_id"=>$SELLER_ID,
            "out_trade_no"=> $order_no,
            "subject" => $content,
            "body" => $content,
            "total_fee" => $money,
            "notify_url" => $notify_url,
            "service" => "mobile.securitypay.pay",
            "payment_type" => "1",
            "_input_charset" => "utf-8",
            "it_b_pay" => "30m",
        ];
        $request_str = $this->aliPayApi->getRequestStr(($request));
        /**
         * 这个地方改rsaSign($request_str,$PRIVATE_KEY_PATH) 改aliPayApi.php  public function rsaSign($data)  $priKey = file_get_contents(PRIVATE_KEY_PATH); 为public function rsaSign($data,$PRIVATE_KEY_PATH)  $priKey = $PRIVATE_KEY_PATH;
         */
        $sign = $this->aliPayApi->rsaSign($request_str,$PRIVATE_KEY_PATH);

        $request['sign'] = urlencode($sign);
        $request['sign_type'] = "RSA";
        $result = $this->aliPayApi->getRequestStr($request);
        return $result;
    }

    /**
     * 支付宝退款
     * @param string $batch_no 退款批次号
     * @param $trade_no
     * @param $money
     * @param $notify_url
     * @return 支付宝退款URL
     */
    public function refund($batch_no,$trade_no, $money, $notify_url){
        $result = $this->aliPayApi->refund($batch_no, $trade_no, $money, $notify_url);
        return $result;
    }

}

/**
 * Class WxPay
 * 微信支付
 *
 */
class WxPay{
    static $NOTIFY_URL;         //  退款回调地址
    static $TRADE_STATE = [
        "SUCCESS" => "支付成功",
        "REFUND" => "转入退款",
        "NOTPAY" => "未支付",
        "CLOSED" => "已关闭",
        "REVOKED" => "已撤销（刷卡支付）",
        "USERPAYING" => "用户支付中",
        "PAYERROR" => "支付失败"
    ];

    public function __construct()
    {
        vendor("wxpay.lib.WxPay#Api");
        self::$NOTIFY_URL =  url('/Admin/CallBack/wxPayRefund');
    }

    /**
     * 微信下单
     * @param string $order_no 商户订单号
     * @param string $txnTime 交易时间 date("YmdHis")
     * @param int $txnAmt 交易金额 单位为分
     * @return array 成功时返回
     * @throws Exception
     * @throws WxPayException
     */
    public function payOrder($order_no, $txnTime, $txnAmt, $callback,$APPID,$MCHID,$KEY){
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($order_no);
        $input->SetAttach("");
        $input->SetOut_trade_no($order_no);
        $input->SetTotal_fee($txnAmt);
        $input->SetTime_start($txnTime);
        $input->SetTime_expire(date("YmdHis", strtotime($txnTime) + 600));
        $input->SetNotify_url($callback);
        $input->SetTrade_type("APP");

        $result = \WxPayApi::unifiedOrder($input,6,$APPID,$MCHID,$KEY);
        if($result['return_code']!="SUCCESS"){
            throw new \Exception($result['return_msg']);
        }
        if($result['result_code']!="SUCCESS"){
            throw new \Exception($result['err_code_des']);
        }

        return $result;
    }

    /**
     * 获取APP端的请求参数
     * @param $prepayId
     * @return array
     */
    public function getAppRequest($prepayId,$APPID,$MCHID,$KEY){
        $input = new \WxPayRequest();
        $input->setPrepayid($prepayId);
        $result = \WxPayApi::getSignRequest($input,$APPID,$MCHID,$KEY);
        return $result;
    }

    /**
     * @param $transaction_id   微信订单号
     * @param $out_refund_no  退款单号
     * @param $total_money  订单金额 单位为分
     * @param $money  退款金额 单位为分
     * @return 成功时返回，其他抛异常
     */
    public function refund($transaction_id,$out_refund_no ,$total_money,$money){
        $input = new \WxPayRefund();
        $input->SetTransaction_id($transaction_id);
        $input->SetTotal_fee($total_money|0);
        $input->SetRefund_fee($money|0);
        $input->SetOut_refund_no($out_refund_no);
        $input->SetOp_user_id(WxPayConfig::MCHID);
        $result = \WxPayApi::refund($input);
        if($result['result_code'] == 'SUCCESS'){
            return true;
        }
        throw new \Exception($result['err_code_des']);
    }

    /**
     * 微信订单查询
     * @param string $order_no 商户订单号
     * @param string $transaction_id 微信订单号
     * @return array 成功时返回
     * @throws Exception
     * @throws WxPayException
     */
    public function orderQuery($order_no="", $transaction_id=""){
        $input = new \WxPayOrderQuery();
        if(!empty($order_no)){
            $input->SetOut_trade_no($order_no);
        }elseif(!empty($transaction_id)){
            $input->SetTransaction_id($transaction_id);
        }else{
            throw new \Exception("商户订单号或微信订单号必须！");
        }
        $response = \WxPayApi::orderQuery($input);
        $result = [];
        if($response['return_code']!='SUCCESS'){
            if(!empty($response['return_msg'])){
                $result['msg'] = $response['return_msg'];
            }else{
                $result['msg'] = "查询失败，请稍后再试";
            }
        }elseif($response['result_code']!='SUCCESS'){
            $result['msg'] = !empty($response['err_code_des'])?$response['err_code_des']:"请稍后再试";
        }else{
            $result['msg'] = self::$TRADE_STATE[$response['trade_state']];
        }

        return $result;
    }

    public function notify($callback,$msg){
        \WxPayApi::notify($callback,$msg);
    }
}

/**
 * Class WxPay
 * 微信公众号支付
 *
 */
class WxPayG{
    static $NOTIFY_URL;         //  退款回调地址
    static $TRADE_STATE = [
        "SUCCESS" => "支付成功",
        "REFUND" => "转入退款",
        "NOTPAY" => "未支付",
        "CLOSED" => "已关闭",
        "REVOKED" => "已撤销（刷卡支付）",
        "USERPAYING" => "用户支付中",
        "PAYERROR" => "支付失败"
    ];

    public function __construct()
    {
        vendor("wxpayG.lib.WxPay#Api");
        self::$NOTIFY_URL = SITE .'/Admin/CallBack/wxPayRefund.html';
    }

    /**
     * 微信下单
     * @param string $order_no 商户订单号
     * @param string $txnTime 交易时间 date("YmdHis")
     * @param int $txnAmt 交易金额 单位为分
     * @return array 成功时返回
     * @throws Exception
     * @throws WxPayException
     */
    public function payOrder($order_no, $txnTime, $txnAmt, $callback){
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($order_no);
        $input->SetAttach("");
        $input->SetOut_trade_no($order_no);
        $input->SetTotal_fee($txnAmt);
        $input->SetTime_start($txnTime);
        $input->SetTime_expire(date("YmdHis", strtotime($txnTime) + 600));
        $input->SetNotify_url($callback);
        $input->SetTrade_type("APP");

        $result = \WxPayApi::unifiedOrder($input);
        if($result['return_code']!="SUCCESS"){
            throw new \Exception($result['return_msg']);
        }
        if($result['result_code']!="SUCCESS"){
            throw new \Exception($result['err_code_des']);
        }

        return $result;
    }

    /**
     * 获取APP端的请求参数
     * @param $prepayId
     * @return array
     */
    public function getAppRequest($prepayId){
        $input = new \WxPayRequest();
        $input->setPrepayid($prepayId);
        $result = \WxPayApi::getSignRequest($input);
        return $result;
    }

    /**
     * @param $transaction_id   微信订单号
     * @param $out_refund_no  退款单号
     * @param $total_money  订单金额 单位为分
     * @param $money  退款金额 单位为分
     * @return 成功时返回，其他抛异常
     */
    public function refund($transaction_id,$out_refund_no ,$total_money,$money){
        $input = new \WxPayRefund();
        $input->SetTransaction_id($transaction_id);
        $input->SetTotal_fee($total_money|0);
        $input->SetRefund_fee($money|0);
        $input->SetOut_refund_no($out_refund_no);
        $input->SetOp_user_id(WxPayConfig::MCHID);
        $result = \WxPayApi::refund($input);
        if($result['result_code'] == 'SUCCESS'){
            return true;
        }
        throw new \Exception($result['err_code_des']);
    }

    /**
     * 微信订单查询
     * @param string $order_no 商户订单号
     * @param string $transaction_id 微信订单号
     * @return array 成功时返回
     * @throws Exception
     * @throws WxPayException
     */
    public function orderQuery($order_no="", $transaction_id=""){
        $input = new \WxPayOrderQuery();
        if(!empty($order_no)){
            $input->SetOut_trade_no($order_no);
        }elseif(!empty($transaction_id)){
            $input->SetTransaction_id($transaction_id);
        }else{
            throw new \Exception("商户订单号或微信订单号必须！");
        }
        $response = WxPayApi::orderQuery($input);
        $result = [];
        if($response['return_code']!='SUCCESS'){
            if(!empty($response['return_msg'])){
                $result['msg'] = $response['return_msg'];
            }else{
                $result['msg'] = "查询失败，请稍后再试";
            }
        }elseif($response['result_code']!='SUCCESS'){
            $result['msg'] = !empty($response['err_code_des'])?$response['err_code_des']:"请稍后再试";
        }else{
            $result['msg'] = self::$TRADE_STATE[$response['trade_state']];
        }

        return $result;
    }

    public function notify($callback,$msg){
        \WxPayApi::notify($callback,$msg);
    }
}

/**
 * Class WxPay
 * 微信支付
 *
 */
class WxPayStudent{
    static $NOTIFY_URL;         //支付回调地址
    static $TRADE_STATE = [
        "SUCCESS" => "支付成功",
        "REFUND" => "转入退款",
        "NOTPAY" => "未支付",
        "CLOSED" => "已关闭",
        "REVOKED" => "已撤销（刷卡支付）",
        "USERPAYING" => "用户支付中",
        "PAYERROR" => "支付失败"
    ];

    public function __construct()
    {
        vendor("wxpaystudent.lib.WxPay#Api");
        self::$NOTIFY_URL = C('webaddress').'index.php/Home/payment/WeChat';
    }

    /**
     * 微信下单
     * @param string $order_no 商户订单号
     * @param string $txnTime 交易时间 date("YmdHis")
     * @param int $txnAmt 交易金额 单位为分
     * @return array 成功时返回
     * @throws Exception
     * @throws WxPayException
     */
    public function payOrder($order_no, $txnTime, $txnAmt){
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($order_no);
        $input->SetAttach("");
        $input->SetOut_trade_no($order_no);
        $input->SetTotal_fee($txnAmt);
        $input->SetTime_start($txnTime);
        $input->SetTime_expire(date("YmdHis", strtotime($txnTime) + 600));
        $input->SetNotify_url(self::$NOTIFY_URL);
        $input->SetTrade_type("APP");

        $result = \WxPayApi::unifiedOrder($input);
        if($result['return_code']!="SUCCESS"){
            throw new \Exception($result['return_msg']);
        }
        if($result['result_code']!="SUCCESS"){
            throw new \Exception($result['err_code_des']);
        }

        return $result;
    }

    /**
     * 获取APP端的请求参数
     * @param $prepayId
     * @return array
     */
    public function getAppRequest($prepayId){
        $input = new \WxPayRequest();
        $input->setPrepayid($prepayId);
        $result = \WxPayApi::getSignRequest($input);
        return $result;
    }

    /**
     * 微信支付退款
     * @param string $transaction_id    微信订单号
     * @param int $money    交易金额 单位为分
     * @throws WxPayException
     */
    public function refund($transaction_id, $money){
        $input = new \WxPayRefund();
        $input->SetTransaction_id($transaction_id);
        $input->SetTotal_fee($money|0);
        $input->SetRefund_fee($money|0);
        $input->SetOut_refund_no(date("YmdHis"));
        $input->SetOp_user_id(WxPayConfig::MCHID);

        $result = \WxPayApi::refund($input);

    }

    /**
     * 微信订单查询
     * @param string $order_no 商户订单号
     * @param string $transaction_id 微信订单号
     * @return array 成功时返回
     * @throws Exception
     * @throws WxPayException
     */
    public function orderQuery($order_no="", $transaction_id=""){
        $input = new \WxPayOrderQuery();
        if(!empty($order_no)){
            $input->SetOut_trade_no($order_no);
        }elseif(!empty($transaction_id)){
            $input->SetTransaction_id($transaction_id);
        }else{
            throw new \Exception("商户订单号或微信订单号必须！");
        }
        $response = \WxPayApi::orderQuery($input);
        $result = [];
        if($response['return_code']!='SUCCESS'){
            if(!empty($response['return_msg'])){
                $result['msg'] = $response['return_msg'];
            }else{
                $result['msg'] = "查询失败，请稍后再试";
            }
        }elseif($response['result_code']!='SUCCESS'){
            $result['msg'] = !empty($response['err_code_des'])?$response['err_code_des']:"请稍后再试";
        }else{
            $result['msg'] = self::$TRADE_STATE[$response['trade_state']];
        }

        return $result;
    }
}