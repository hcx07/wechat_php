<?php
/**
 * Created by PhpStorm.
 * User: 木鸟
 * Date: 2017/11/26
 * Time: 9:30
 */
namespace frontend\controllers;
use backend\helpers\Helper;
use backend\models\Article;
use backend\models\Category;
use backend\models\Guestbook;
use yii\data\Pagination;
use yii\web\Controller;

class IndexController extends Controller{
    public $enableCsrfValidation = false;
    /**
     * @return string
     * 首页
     */
    public function actionIndex(){
        $query=Article::find();
        $total=$query->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>10,
        ]);
        $model=$query
            ->offset($page->offset)
            ->limit($page->limit)
            ->orderBy(['article.is_top'=>SORT_DESC,'article.created_time'=>SORT_DESC])
            ->all();
        foreach ($model as &$item){
            $guest_count=Guestbook::find()->where(['article_id'=>$item->article_id])->count();
            $item['guest_count']=$guest_count?$guest_count.' 条评论':'暂无评论';
        }
        return $this->render('index',['model'=>$model,'page'=>$page]);
    }

    /**
     * @param $article_id
     * @return string
     * 文章详情页
     */
    public function actionArticle($article_id){
        $model=Article::find()
            ->innerJoin(Category::tableName(),"article.cate_id=category.cate_id")
            ->select('article.*,category.cate_id,category.cate_name')
            ->where(['article_id'=>$article_id])
            ->one();
        return $this->render('article',['model'=>$model]);
    }
    /**
     * 文章评论
     */
    public function actionGuest(){
        $post=\Yii::$app->request->post();
        $model=new Guestbook();
        if($model->load($post,'') && $model->validate()){
            $model->save();
            Helper::response([],'评论成功');
        }else{
            Helper::response([],'评论失败，请重试',300);
        }
    }
}