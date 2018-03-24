<?php

namespace app\index\logic;
use Think\Exception;

/**
 * Class CallBackLogic
 * @package V1\Logic
 * 支付回调逻辑层
 */
class CallBackLogic
{
    /**
     * @param $order_sn   订单号
     * @param $money   支付的金额
     * @param $type   支付方式 0-支付宝  1-微信
     * @return bool
     * 报修支付回调处理
     */
    public function repairOrder($order_sn,$money,$type){
        $orderInfo = M('order_repair')->where(['order_sn'=>$order_sn])->find();
        if(!$orderInfo){
            $this->orderLog("报修订单<{$order_sn}>未找到,支付回调失败");
            return false;
        }
        if($orderInfo['status'] != 0){
            $this->orderLog("报修订单<{$order_sn}>不是待支付,支付回调失败");
            return false;
        }
        if($orderInfo['amount'] != $money){
            $this->orderLog("报修订单<{$order_sn}>支付金额不正确,支付回调失败");
            //return false;
        }
        M()->startTrans();
        $res1 = M('order_repair')->where(['order_sn'=>$order_sn])->save(['status'=>1,'pay_time'=>time(),'pay_type'=>$type]);
        $res2 = M('personal_repair')->where(['repair_id'=>$orderInfo['repair_id']])->save(['status'=>3]);
        if($res2===false || $res1===false) {
            $this->orderLog("报修订单<{$order_sn}>订单状态修改失败,支付回调失败");
            M()->rollback();
            return false;
        }
        M()->commit();
        return true;
    }


    /**
     * @param $order_sn   订单号
     * @param $money   支付的金额
     * @param $type   支付方式 0-支付宝  1-微信
     * @param string $trade_no  支付宝交易号
     * @return bool
     * 商品支付回调处理
     */
    public function goodsOrder($order_sn,$money,$type,$trade_no = ''){
        $source = 0;
        $orderInfo = M('order_goods')->where(['order_sn'=>$order_sn])->find();
        if(empty($orderInfo)){
            $source = 1;
            $orderInfo = M('order_goods_child')->where(['order_sn'=>$order_sn])->find();
        }
        if(!$orderInfo){
            $this->orderLog("商品订单<{$order_sn}>未找到,支付回调失败");
            return false;
        }
        if($orderInfo['status'] != 0){
            $this->orderLog("商品订单<{$order_sn}>不是待支付,支付回调失败");
            return false;
        }
        if($orderInfo['amount'] != $money){
            $this->orderLog("商品订单<{$order_sn}>支付金额不正确,支付回调失败");
           // return false;
        }
        if($source == 1){
            $order_ids = [$orderInfo['order_id']];
        }else{
            $order_ids = array_filter(explode(',',$orderInfo['order_child']));
        }
        M()->startTrans();
        //  减少商品库存
        $res = $this->reduceStock($order_sn,$order_ids);
        if($res === false){
            $this->orderLog("商品订单<{$order_sn}>库存减少失败,支付回调失败");
            M()->rollback();
            return false;
        }
        // 增加钱包记录和商家冻结余额
        $res3 = $this->merchantAddRecord($order_sn,$order_ids);
        if($res3 === false){
            $this->orderLog("商品订单<{$order_sn}>商家信息更新失败,支付回调失败");
            M()->rollback();
            return false;
        }
        $res1 = $res2 = $res3 = true;
        if($source == 1){
            $res2 = M('order_goods_child')->where(['order_id'=>['in',$order_ids],'type'=>1])->save(['status'=>1,'pay_type'=>$type,'pay_time'=>time(),'trade_no'=>$trade_no]);
            $res3 = M('order_goods_child')->where(['order_id'=>['in',$order_ids],'type'=>2])->save(['status'=>2,'pay_type'=>$type,'pay_time'=>time(),'trade_no'=>$trade_no]);
        }else{
            $res1 = M('order_goods')->where(['order_sn'=>$order_sn])->save(['status'=>1,'pay_type'=>$type,'pay_time'=>time(),'trade_no'=>$trade_no]);
            $res2 = M('order_goods_child')->where(['order_id'=>['in',$order_ids],'type'=>1])->save(['status'=>1,'pay_type'=>$type,'pay_time'=>time()]);
            $res3 = M('order_goods_child')->where(['order_id'=>['in',$order_ids],'type'=>2])->save(['status'=>2,'pay_type'=>$type,'pay_time'=>time()]);
        }
        if($res2===false || $res1===false || $res3===false) {
            $this->orderLog("商品订单<{$order_sn}>订单状态修改失败,支付回调失败");
            M()->rollback();
            return false;
        }
        M()->commit();
        return true;
    }

    /**
     * @param $order_sn    订单号
     * @param $order_ids   子单id   数组
     * @return bool
     * 减少商品库存
     */
    private function reduceStock($order_sn,$order_ids){
        $detail = M('order_goods_detail')->field('goods_id,goods_num')->where(['order_id'=>['in',$order_ids]])->select();
        if(empty($detail)){
            return false;
        }
        foreach ($detail as $item) {
            $info = M('goods')->where(['goods_id'=>$item['goods_id']])->find();
            if($info['stock'] < $item['goods_num']){
                // 库存不足  给商家发送消息
                $message = new MessageLogic();
                try{
                    $message->sendMerchantMessage($info['merchants_id'],'库存不足',"你的商品{$info['name']}库存不足,已有人下单,请及时补充库存",[],0);
                }catch(Exception $e){
                    $this->orderLog("{$e->getMessage()}");
                }
                $res = M('goods')->where(['goods_id'=>$item['goods_id']])->save(['stock'=>0]);
            }else{
                $res = M('goods')->where(['goods_id'=>$item['goods_id']])->setDec('stock',$item['goods_num']);
            }
            if($res === false){
                return false;
            }
        }
        return true;
    }

    /**
     * @param $order_sn     总订单号<支付用的>
     * @param $order_ids   子单号数组
     * @return bool
     * 商家收支记录
     */
    public function merchantAddRecord($order_sn,$order_ids){
        $child = M('order_goods_child')->where(['order_id'=>['in',$order_ids]])->select();
        if(empty($child)){
            return false;
        }
        foreach($child as $item){
            // 增加商家冻结余额
            $res = M('Merchants')->where(['merchants_id'=>$item['merchants_id']])->setInc('d_money',$item['amount']);
            if($res === false){
                $this->orderLog("订单<$order_sn>子单<{$item['order_id']}>增加冻结余额失败");
                return false;
            }
            // 增加商家钱包记录
            $data = [
                'merchants_id' => $item['merchants_id'],
                'type' => 1,
                'remark' => '订单号:'.$item['order_sn'],
                'order_id' => $item['order_id'],
                'money' => $item['amount'],
                'created_time' => time()
            ];
            $res1 = M('merchant_record')->add($data);
            if($res1 === false){
                $this->orderLog("订单<$order_sn>子单<{$item['order_id']}>生成收支记录失败");
                return false;
            }

            // 向商家推送消息
            $message = new MessageLogic();

            try{
                $message->sendMerchantMessage($item['merchants_id'],'订单消息',"你有一个新订单，请尽快发货",['order_id'=>$item['order_id']],1);
            }catch(Exception $e){
                $this->orderLog("{$e->getMessage()}");
            }
        }
        return true;
    }

    /**
     * @param $order_sn   订单号
     * @param $money   支付的金额
     * @param $type   支付方式 0-支付宝  1-微信
     * @param int $trade_no  支付宝交易号
     * @return bool
     * 快递外发支付回调处理
     */
    public function expressOrder($order_sn,$money,$type,$trade_no = 0){
        $orderInfo = M('order_express')->where(['order_sn'=>$order_sn])->find();
        if(!$orderInfo){
            $this->orderLog("快递订单<{$order_sn}>未找到,支付回调失败");
            return false;
        }
        if($orderInfo['status'] != 0){
            $this->orderLog("快递订单<{$order_sn}>不是待支付,支付回调失败");
            return false;
        }
        if($orderInfo['amount'] != $money){
            $this->orderLog("快递订单<{$order_sn}>支付金额不正确,支付回调失败");
            //return false;
        }
        M()->startTrans();
        $res1 = M('order_express')->where(['order_sn'=>$order_sn])->save(['status'=>1,'pay_time'=>time(),'pay_type'=>$type]);
        $res2 = M('express_deliver')->where(['deliver_id'=>$orderInfo['deliver_id']])->save(['status'=>3]);
        if($res2===false || $res1===false) {
            $this->orderLog("快递订单<{$order_sn}>订单状态修改失败,支付回调失败");
            M()->rollback();
            return false;
        }
        M()->commit();
        return true;
    }


    /**
     * @param $order_sn   订单号
     * @param $money   支付的金额
     * @param $type   支付方式 0-支付宝  1-微信
     * @param int $trade_no 交易号
     * @return bool
     * 配送订单支付回调处理
     */
    public function distributionOrder($order_sn,$money,$type,$trade_no = 0){
        $orderInfo = M('order_distribution')->where(['order_sn'=>$order_sn])->find();
        if(!$orderInfo){
            $this->orderLog("配送订单<{$order_sn}>未找到,支付回调失败");
            return false;
        }
        if($orderInfo['status'] != 0){
            $this->orderLog("配送订单<{$order_sn}>不是待支付,支付回调失败");
            return false;
        }
        if($orderInfo['amount'] != $money){
            $this->orderLog("配送订单<{$order_sn}>支付金额不正确,支付回调失败");
            //return false;
        }
        M()->startTrans();
        $res1 = M('order_distribution')->where(['order_sn'=>$order_sn])->save(['status'=>1,'pay_time'=>time(),'pay_type'=>$type,'trade_no'=>$trade_no]);
        $res2 = M('distribution')->where(['distribution_id'=>$orderInfo['distribution_id']])->save(['status'=>1]);
        if($res2===false || $res1===false) {
            $this->orderLog("配送订单<{$order_sn}>订单状态修改失败,支付回调失败");
            M()->rollback();
            return false;
        }
        M()->commit();
        return true;
    }

    /**
     * @param $order_sn   订单号
     * @param $money   支付的金额
     * @param $type   支付方式 0-支付宝  1-微信
     * @return bool
     * 物业缴费支付回调处理
     */
    public function propertyOrder($order_sn,$money,$type){
        $orderInfo = M('property_record')->where(['order_sn'=>$order_sn])->find();
        if(!$orderInfo){
            $this->orderLog("物业缴费订单<{$order_sn}>未找到,支付回调失败");
            return false;
        }
        if($orderInfo['status'] != 0){
            $this->orderLog("物业缴费订单<{$order_sn}>不是待支付,支付回调失败");
            return false;
        }
        if($orderInfo['amount'] != $money){
            $this->orderLog("物业缴费订单<{$order_sn}>支付金额不正确,支付回调失败");
            //return false;
        }
        M()->startTrans();
        $res1 = M('property_record')->where(['order_sn'=>$order_sn])->save(['status'=>1,'pay_time'=>time(),'pay_type'=>$type]);
        if($res1===false) {
            $this->orderLog("物业缴费订单<{$order_sn}>订单状态修改失败,支付回调失败");
            M()->rollback();
            return false;
        }
        try{
            $title = '系统消息';
            $content1 = "尊敬的业主，您已成功缴费，缴费金额{$money}元。谢谢您的支持与理解!";
            $message = new MessageLogic();
            $ext = ['type'=>1,'id'=>0];
            $message->sendUserMessage($orderInfo['user_id'],$title,$content1,$ext,0);
        }catch(Exception $e){
            $this->orderLog("物业缴费订单<{$order_sn}>消息发送失败");
        }
        M()->commit();
        return true;
    }


    /**
     * @param $text
     * 回调错误日志生成
     */
    private function orderLog($text){
        $log = date('Y-m-d H:i:s') . "  [" . get_ip() . "]: {$text}" . PHP_EOL;
        file_put_contents(DOC_ROOT .'/Public/file/payLog.text', $log, FILE_APPEND);
    }
}