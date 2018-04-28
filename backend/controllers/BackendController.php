<?php
namespace backend\controllers;
use backend\components\RbacFilter;
use yii\web\Controller;

class BackendController extends Controller{
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
            ]
        ];
    }
}