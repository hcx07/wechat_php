<?php

/**
 * Created by PhpStorm.
 * User: hcx_0
 * Date: 2018/4/15
 * Time: 10:54
 */
namespace app\api\controller;
use Symfony\Component\Finder\Tests\Iterator\RealIteratorTestCase;
use think\Controller;
use think\Request;

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
        $page=Request::instance()->param('page',1);
        $limit=Request::instance()->param('limit',10);
        $res=db('article')
            ->where(['status'=>0])
            ->order('add_time desc')
            ->page($page)
            ->limit($limit)
            ->select();
        foreach ($res as &$item){
            $content=mb_substr(strip_tags($item['content']),0,28).'...';
            $item['content']=[mb_substr($content,0,14),mb_substr($content,15)];
        }
        json_return($res);
    }
    /**
     * 获取文章详情
     */
    public function get_info(){
        $article_id=Request::instance()->param('article_id',0);
        if(!$article_id){
            json_return([],'未获取到文章',300);
        }
        $res=db('article')->where(['article_id'=>$article_id,'status'=>0])->find();
        if(!$res){
            json_return([],'文章不存在或已删除',300);
        }
        $time=date('Y-m-d H:i',$res['add_time']);
        $res['other']=$time;
        json_return($res);
    }

}