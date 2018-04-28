<?php
/**
 * Created by PhpStorm.
 * User: 木鸟
 * Date: 2017/11/25
 * Time: 16:44
 */
namespace backend\controllers;
use backend\helpers\Helper;
use backend\models\Article;
use backend\models\Category;
use backend\models\User;
use yii\data\Pagination;
class ArticleController extends BackendController
{
    public $enableCsrfValidation = false;
    /**
     * 文章列表
     * @return string
     */
    public function actionIndex()
    {
        $return=[];
        $query = Article::find()
            ->leftJoin(User::tableName(),"user.id=article.author_id")
            ->select('article.*,user.username');
        if($cate_id=\Yii::$app->request->get('cate_id')){
            $return['cate_id']=$cate_id;
            $query->andWhere(['category.cate_id'=>$cate_id]);
        }
        if($title=\Yii::$app->request->get('title')){
            $return['title']=$title;
            $query->andWhere(['like','article.title',$title]);
        }
        if($start=\Yii::$app->request->get('start')){
            $return['start']=$start;
            $query->andWhere(['>=','article.created_time',strtotime($start)]);
        }
        if($end=\Yii::$app->request->get('end')){
            $return['end']=$end;
            $query->andWhere(['<=','article.created_time',strtotime($end)]);
        }
        $total = $query->count();
        $page = new Pagination([
            'totalCount' => $total,
            'defaultPageSize' => 10,
        ]);
        $model = $query->offset($page->offset)->limit($page->limit)->orderBy(['article.created_time' => SORT_DESC])->all();
        return $this->render('index', ['model' => $model, 'page' => $page,'return'=>$return]);
    }

    /**
     * 文章添加
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Article();
        if($post=\Yii::$app->request->post()){
            $post['content']=html_entity_decode(trim($post['content']));
            if(empty($post['content'])){
                \Yii::$app->session->setFlash('error', '请输入文章内容！');
                return $this->redirect(['article/add']);
            }
            if($model->load($post) && $model->validate()){
                $model->author_id=\Yii::$app->user->getId();
                $model->created_time=time();
                $model->content=$post['content'];
                $model->img=$post['img'];
                $model->save();
                \Yii::$app->session->setFlash('success', '添加成功！');
                return $this->redirect(['article/index']);
            }else{
                $error=array_values($model->getFirstErrors());
                \Yii::$app->session->setFlash('error', $error[0]);
                return $this->redirect(['article/add']);
            }
        }
        return $this->renderPartial('add', ['model' => $model]);
    }

    /**
     * 文章修改
     * @param $article_id
     * @return string|\yii\web\Response
     */
    public function actionEdit($article_id)
    {
        $model = Article::findOne(['article_id' => $article_id]);
        if ($model->load(\Yii::$app->request->post())) {
            $post = \Yii::$app->request->post();
            if (empty($post['content']) || (!$post['content'])) {
                \Yii::$app->session->setFlash('error', '必须要输入内容哦！');
                return $this->redirect(['article/edit']);
            }
            if ($model->validate()) {
                $model->content = $post['content'];
                $model->update_time=time();
                $model->img=$post['img'];
                $model->save();
                \Yii::$app->session->setFlash('success', '修改成功！');
                return $this->redirect(['article/index']);
            }else{
                $error=array_values($model->getFirstErrors());
                \Yii::$app->session->setFlash('error', $error[0]);
                return $this->redirect(['article/index']);
            }
        }
        return $this->renderPartial('add', ['model' => $model]);
    }

    /**
     * 操作
     */
    public function actionOperation(){
        $get=\Yii::$app->request->get();
        $article_id=$get['article_id'];
        $model=Article::findOne(['article_id'=>$article_id]);
        if(isset($get['status'])){//显示隐藏
            $model->status=$get['status'];
            $res=$model->update();
            if($res>=0){
                Helper::response([],'操作成功');
            }else{
                $error=array_values($model->getFirstErrors());
                Helper::response([],$error[0],300);
            }
        }
        if(isset($get['is_top'])){//置顶
            $model->is_top=$get['is_top'];
            $res=$model->update();
            if($res>=0){
                Helper::response([],'操作成功');
            }else{
                $error=array_values($model->getFirstErrors());
                Helper::response([],$error[0],300);
            }
        }
        Helper::response([],'请刷新后再试',300);
    }
}