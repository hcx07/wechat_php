<?php

namespace app\index\controller;

use Ramsey\Uuid\Uuid;
use think\Controller;
use think\Db;
use Think\Exception;
use think\Request;
use think\Session;
use think\Url;

/**
 * Class OrderController
 * @package V1\Controller
 * 订单模块
 */
class Order extends Controller
{

    public function _initialize(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods:GET,HEAD,POST,TRACE,OPTIONS");
        header("Access-Control-Allow-Headers:accept, content-type");
        $post=Request::instance()->post();
        if(!$post){
            $data=[
                'status'=>0,
                'msg'=>'请传入数据',
                'data'=>''
            ];
            return $data;
        }

        $uuid=$post['uuid'];
        if(!isset($uuid) || empty($uuid)) {
            $data=[
                'status'=>0,
                'msg'=>'请传入uuid',
                'data'=>''
            ];
            return $data;
        }
        $user=\db('user')->where(['uuid'=>$uuid])->find();
        if(!$user){
            $data=[
                'status'=>0,
                'msg'=>'请传入正确的uuid',
                'data'=>''
            ];
            return $data;
        }
        return [
            'status'=>1,
            'msg'=>'',
            'data'=>$post,
            'user'=>$user
        ];

    }

    /**
     * 订单支付
     */
    public function payOrder(){
        $res=$this->_initialize();
        if($res['status']==0){
            return json_encode($res);
        }
        $post=$res['data'];

        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        $order_sn=$msectime.mt_rand(1000,9999);
        $pay_type = $post['pay_type'];  // 支付方式  0支付宝  1微信 2银联
        $money = $post['amount'];  //订单金额  元
        $content = $post['content'];   //订单内容
        $user=$res['user'];
        $PARTNER=$user['PARTNER']; //合作者身份id
        $SELLER_ID=$user['SELLER_ID'];
        $PRIVATE_KEY_PATH=$user['PRIVATE_KEY_PATH']; //私钥

        //保存到本地
        $data=[
            'order_sn'=>$order_sn,
            'money'=>$money,
            'pay_type'=>$pay_type,
            'created_time'=>time(),
            'status'=>0,
            'user_id'=>$user['user_id']
        ];
        db('order')->insert($data);

        // 支付宝支付
        if($pay_type == 0){

            $alipay = new \aliPay();
            $sign = $alipay->getRequestParam($order_sn,$content,$money,SITE.'/index/call_back/alipay.html',$PARTNER,$SELLER_ID,$PRIVATE_KEY_PATH);
            return json_encode([
                "status" => 200,
                "msg" => 'success',
                "data" => ['ali_info'=>$sign,'order_sn'=>$order_sn],
//                'ali_info'=>$sign,
//                'order_sn'=>$order_sn
            ]);
//            get_op_put(200, '成功',['ali_info'=>$sign,'order_sn'=>$order_sn]);
        }

        // 微信支付
        if($pay_type == 1){
            $wxPay = new \WxPay();
            $txnAmt = intval($money * 100);  // 金额(单位分)
            $txnTime = date("YmdHis");

            $APPID=$user['APPID'];
            $MCHID=$user['MCHID'];
            $KEY=$user['KEY'];

            $result = $wxPay->payOrder($order_sn, $txnTime, $txnAmt,SITE.'/index/call_back/wxPay.html',$APPID,$MCHID,$KEY);
            $appRequest = $wxPay->getAppRequest($result['prepay_id'],$APPID,$MCHID,$KEY);
            $appRequest['_package'] = $appRequest['package'];
            unset($appRequest['package']);
            $sign = [
//                'prepay_id' => $result['prepay_id'],
                "status" => 200,
                "msg" => 'success',
                "data" => ['app_request' => $appRequest,'order_no' => $order_sn,'money' => $txnAmt,'txntime' => $txnTime,]
            ];
            return json_encode($sign);

        }

        //银联支付
        if($pay_type == 2){
            $orderInfo['amount'] = $money;
            $unionPayModel = new \UnionPay();
            $txnAmt = intval($orderInfo['amount'] * 100);
            $txnTime = date("YmdHis");
            try{
                $tn = $unionPayModel->payOrder($orderInfo['order_sn'],$txnAmt,$txnTime,SITE.'/V1/CallBack/repairUnionPay.html');        //银联获取tn(银联受理订单号)
            }catch(Exception $e){
                get_op_put(234,$e->getMessage());
            }
            $data = [
                "order_id" => intval($order_id),
                "order_no" => $orderInfo['order_sn'],
                "tn" => $tn,
                "money" => $txnAmt,
                "txntime" => $txnTime
            ];
            get_op_put(200,'成功',$data);
        }
        get_op_put(243,'支付方式不存在');
    }
}