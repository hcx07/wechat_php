<?php

/**
 * Created by PhpStorm.
 * User: hcx_0
 * Date: 2018/4/15
 * Time: 10:54
 */
namespace app\api\controller;
use think\Controller;

class Home extends Controller
{
    /**
     * 获取当前服务器时间
     */
    public function get_time(){
        $time=date('m月d日');
        $week_str= "星期" . mb_substr( "天一二三四五六",date("w"),1,"utf-8" );
        json_return($time.' '.$week_str);
    }
    /**
     * 获取文章
     */
    public function  get_article(){
        $res=db('article')->where(['status'=>0])->order('add_time desc')->limit(5)->select();
        foreach ($res as &$item){
            $item['content']=mb_substr(strip_tags($item['content']),0,100) ;
        }
        json_return($res);
    }

}