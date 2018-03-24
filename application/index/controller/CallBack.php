<?php

namespace app\index\controller;


use think\Controller;
use think\Request;
use think\Session;

/**
 * Class CallBackController
 * @package V1\Controller
 * 支付回调控制器
 */
class CallBack extends Controller
{
    public function _initialize()
    {
        $user_id=Session::get('user_id');
        $url=db('user')->where(['user_id'=>$user_id])->field('ali_url,we_url')->find();
        return $url;
    }

    /**
     * 支付宝支付回调
     */
    public function alipay(){
        $order_sn =  Request::instance()->param('out_trade_no');  // 支付宝返回的商户订单号
        $trade_no =  Request::instance()->param('trade_no');  // 支付宝交易号
        $money =  Request::instance()->param('total_fee');  //支付的金额
        $trade_status=Request::instance()->param('trade_status');
        $data['out_trade_no']=$order_sn;
        $data['trade_no']=$trade_no;
        $data['total_fee']=$money;
        $data['trade_status']=$trade_status;

        if ( $order_sn &&  ($trade_status == 'TRADE_SUCCESS')) {
            $order=db('order')->where(['order_sn'=>$order_sn])->find();
            $user=db('user')->where(['user_id'=>$order['user_id']])->find();
            $url=$user['ali_url'];
            $order_id=$order['order_id'];
            $update=[
                'pay_time'=>time(),
                'status'=>1,
            ];
            $res1=db('order')->where(['order_id'=>$order_id])->update($update);
            $data['status']=1;
            $res=http_post($url,json_encode($data));

            if($res && $res1){
                echo 'success';
                exit;
            }else{
                echo 'fail';exit;
            }

        }elseif($trade_status == 'WAIT_BUYER_PAY'){
            $data['status']=2;
            $update=[
                'pay_time'=>time(),
                'status'=>0,
            ];
            http_post('http://pay.muniao.org/index/test/test.html',json_encode(['status'=>2]));
        }elseif($trade_status == 'TRADE_CLOSED'){
            $data['status']=3;
            $update=[
                'pay_time'=>time(),
                'status'=>0,
            ];
            http_post('http://pay.muniao.org/index/test/test.html',json_encode(['status'=>3]));
        }elseif($trade_status == 'TRADE_FINISHED'){
            $data['status']=4;
            $update=[
                'pay_time'=>time(),
                'status'=>0,
            ];
            http_post('http://pay.muniao.org/index/test/test.html',json_encode(['status'=>4]));
        }else{
            $data['status']=5;
            $update=[
                'pay_time'=>time(),
                'status'=>0,
            ];
            http_post('http://pay.muniao.org/index/test/test.html',json_encode(['status'=>5]));
        }

        echo 'fail';exit;
    }

    /**
     * 微信支付回调
     */
    public function wxPay(){
        $request_body = file_get_contents("php://input");
        $xml = simplexml_load_string($request_body, 'SimpleXMLElement', LIBXML_NOCDATA);
        $return_code=strval($xml->return_code);
        $order_sn = strval($xml->out_trade_no);  // 订单编号
        $money = ($xml->total_fee)/100;   //支付的金额

        $data['return_code']=$return_code;
        $data['out_trade_no']=$order_sn;
        $data['total_fee']=$money;
        if ($return_code == 'SUCCESS' && $order_sn) {
            $order=db('order')->where(['order_sn'=>$order_sn])->find();
            $user=db('user')->where(['user_id'=>$order['user_id']])->find();
            $url=$user['we_url'];
            $order_id=$order['order_id'];
            $update=[
                'pay_time'=>time(),
                'status'=>1,
            ];
            db('order')->where(['order_id'=>$order_id])->update($update);

            $data['status']=1;
            $res=http_post($url,json_encode($data));
            if($res){
                echo '<xml><return_code><![CDATA[FAIL]]></return_code></xml>';exit;
            }
            echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';exit;
        }
    }

    /**
     *微信公众号支付回调
     */
    public function repairWxPayG(){
        $request_body = file_get_contents("php://input");
        $xml = simplexml_load_string($request_body, 'SimpleXMLElement', LIBXML_NOCDATA);
        if (strval($xml->return_code) == 'SUCCESS' && strval($xml->out_trade_no)) {
            $order_sn = strval($xml->out_trade_no);  // 订单编号
            $money = ($xml->total_fee)/100;   //支付的金额
            $callBack = new CallBackLogic();
            $res = $callBack->repairOrder($order_sn, $money,3);
            if($res){
                echo '<xml><return_code><![CDATA[FAIL]]></return_code></xml>';exit;
            }
            echo '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';exit;
        }
    }

    /**
     * 银联支付回调
     */
    public function repairUnionPay(){
        header("Access-Control-Allow-Origin:*");
        vendor("unionPay.sdk.acp_service");
        if(isset($_REQUEST['signature'])) {
            \AcpService::validate($_REQUEST) ?: exit();     //验证签名
            $order_sn = $_REQUEST['orderId'];
            $money = $_REQUEST['txnAmt'] / 100;
            $callBack = new CallBackLogic();
            $res = $callBack->repairOrder($order_sn, $money, 2);
            if ($res) {
                get_op_put(200,'回调成功');
            }
            get_op_put(501,'回调失败');
        }
    }
}