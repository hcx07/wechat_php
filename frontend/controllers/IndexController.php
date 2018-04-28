<?php
/**
 * Created by PhpStorm.
 * User: 木鸟
 * Date: 2017/11/26
 * Time: 9:30
 */
namespace frontend\controllers;

use Yii;
use backend\helpers\Helper;
use backend\models\Article;
use backend\models\Category;
use backend\models\Guestbook;
use yii\data\Pagination;
use yii\web\Controller;

class IndexController extends Controller{

    /**
     * 获取当前服务器时间
     */
    public function actionGetTime(){
        $time=date('m月d日');
        $week_str= "星期" . mb_substr( "天一二三四五六",date("w"),1,"utf-8" );
        Helper::response(['time'=>$time.' '.$week_str]);
    }

    /**
     * @return string
     * 首页
     */
    public function actionGetArticle(){
        $page=Yii::$app->request->post('page',1);
        $limit=Yii::$app->request->post('limit',10);
        $offset = intval(($page-1)*$limit);
        $query=Article::find();
        $model=$query
            ->limit($limit)
            ->offset($offset)
            ->orderBy(['article.is_top'=>SORT_DESC,'article.created_time'=>SORT_DESC])
            ->asArray()
            ->all();
        foreach ($model as &$item){
            $content=mb_substr(strip_tags($item['content']),0,37).'...';
            $item['content']=[mb_substr($content,0,19),mb_substr($content,19)];
        }
        Helper::response($model);
    }

    /**
     * @param $article_id
     * @return string
     * 文章详情页
     */
    public function actionGetInfo($article_id){
        $model=Article::find()
            ->where(['article_id'=>$article_id])
            ->asArray()
            ->one();
        $time=date('Y-m-d H:i',$model['created_time']);
        $model['other']=$time;
        Helper::response($model);
    }
    /**
     * 文章评论
     */
    public function actionGuest(){
        $post=\Yii::$app->request->post();
        $model=new Guestbook();
        if($model->load($post,'') && $model->validate()){
            $model->save();
            Helper::response([]);
        }else{
            Helper::response([],'评论失败，请重试',300);
        }
    }
}