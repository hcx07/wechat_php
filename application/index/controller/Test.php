<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 16:36
 */
namespace app\index\controller;

use think\Controller;
use think\Request;

class Test extends Controller{
    public function index(){
        $order_data = [
            "order_no" => 1,
            "amount" => 2,
            "pay_type" => 3,
            "content" => '测试充值',
            "uuid" => 'b5201dc9-0f58-47a7-804c-2030dde17b55',
        ];
        $res=json_encode($order_data);
        $res2=json_decode($res);
        var_dump($res2->order_no);
    }
    public function post(){
        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);

        $order_sn=$msectime;
        var_dump($order_sn);

    }
    public function test(){
        $order=db('order')->where(['order_sn'=>'15123871845237380'])->find();
        $user=db('user')->where(['user_id'=>$order['user_id']])->find();
        $url=$user['ali_url'];
        $order_id=$order['order_id'];
        echo $url;
        echo $order_id;
    }

    public function cool(){
        $data=['status'=>1];
        $url='http://la.com/index/test/test.html';
        $res=http_post($url,json_encode($data));
    }
    public function order(){
        $update=[
            'pay_time'=>time(),
            'status'=>1,
        ];
        $res1=db('order')->where(['order_id'=>30])->update($update);
    }
}