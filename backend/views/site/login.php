<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link href="static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
    <link href="static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css" />
    <link href="lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style type="text/css">
        #loginform-code-image{
            height: 40px;
        }
        .field-loginform-rememberme{
            width: 500px;
            height: 20px;
        }
        .col-xs-offset-3{
            margin-left:22.5%;
        }
        .loginBox{
            background: none;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>

        <div class="loginWraper">

            <div id="loginform" class="loginBox" >
                <?php $form=\yii\widgets\ActiveForm::begin([
                    'method' => 'post',
                    'action'=>\yii\helpers\Url::to(['site/login']),
                    'options'=>['class'=>'form form-horizontal']
                ]);?>
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'class'=>'input-text size-L','placeholder'=>'账户'])->label(false) ?>
                </div>
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <?= $form->field($model, 'password')->passwordInput(['class'=>'input-text size-L','placeholder'=>'密码'])->label(false) ?>
                </div>
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <?=$form->field($model,'code',['options'=>['class'=>'checkcode']])->widget(yii\captcha\Captcha::className(),[
                        'template'=>'<input type="text" id="loginform-code" class="input-text size-L"  style="width:150px;  placeholder="验证码"  name="LoginForm[code]" aria-invalid="true">&nbsp;&nbsp;&nbsp;{image}'
                    ])->label(false);?>
                </div>
                <div class="formControls col-xs-8 col-xs-offset-3" style="margin-left:25%;">
                    <label >
                        <?= $form->field($model, 'rememberMe')->checkbox()->label(false) ?>
                    </label>
                </div>
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <?= \yii\helpers\Html::submitButton('&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;', ['class' => 'btn btn-success radius size-L', 'name' => 'login-button']) ?>
                </div>
                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>










