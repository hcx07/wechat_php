<?php
/**
 * Created by PhpStorm.
 * User: 木鸟
 * Date: 2017/11/25
 * Time: 10:37
 */
namespace backend\controllers;
use common\models\User;
use yii\data\Pagination;
use yii\web\Controller;

class UserController extends BackendController {

    public function actionIndex()
    {
        $query=User::find();
        $total=$query->count();
        $page=new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>10,
        ]);
        $model=$query->offset($page->offset)->limit($page->limit)->orderBy(['id'=>SORT_ASC])->all();
        return $this->render('index',['model'=>$model,'page'=>$page]);
    }

    public function actionAdd()
    {
        $model = new User();
        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                $hash=\Yii::$app->security->generatePasswordHash($model->password);
                $model->password_hash=$hash;
                $model->save();
                \Yii::$app->session->setFlash('success', '添加成功！');
                return $this->redirect(['user/index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }
    public function actionEdit($id)
    {
        $model = User::findOne(['id'=>$id]);
        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                $hash=\Yii::$app->security->generatePasswordHash($model->password);
                $model->password_hash=$hash;
                $model->save();
                \Yii::$app->session->setFlash('success', '添加成功！');
                return $this->redirect(['user/index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }
    public function actionDel($id){
        $model = User::findOne(['id'=>$id]);
        $model->delete();
        return $this->redirect(['user/index']);
    }
}