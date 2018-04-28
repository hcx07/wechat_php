<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<link rel="stylesheet" type="text/css" href="static/h-ui/css/H-ui.min.css"/>
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/H-ui.admin.css"/>
<link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css"/>
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/skin/default/skin.css" id="skin"/>
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/style.css"/>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.page.js"></script>
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="lib/jquery.validation/1.14.0/messages_zh.js"></script>

<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/index.php">木鸟·后台管理系统</a>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs">v1.0</span>

            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>
                        <?php
                        if(!Yii::$app->user->isGuest){
                            echo
                            \yii\helpers\Html::beginForm(['/site/logout'], 'post');
                            echo \yii\helpers\Html::submitButton(
                                '安全退出 (' . Yii::$app->user->identity->username . ')',
                                ['class' => 'btn btn-link logout']
                            );
                            echo \yii\helpers\Html::endForm();
                        }else{
                            echo '<a href="'.Yii::$app->request->hostInfo.'/index.php?r=site/login">登录</a>';
                        }
                        ?>
                    </li>
                </ul>
                </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <dl id="menu-article">
            <dt><span class="glyphicon glyphicon-list-alt"></span> 文章管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="<?php echo Yii::$app->request->hostInfo; ?>/index.php?r=article/index"
                           title="文章列表">文章列表</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture">
            <dt><span class="glyphicon glyphicon-list"></span> 分类管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="<?php echo Yii::$app->request->hostInfo; ?>/index.php?r=article/cate" title="分类列表">分类列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture">
            <dt ><span class="glyphicon glyphicon-envelope"></span> 留言管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd >
                <ul>
                    <li><a href="<?php echo Yii::$app->request->hostInfo; ?>/index.php?r=message/index" title="留言列表">留言列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture">
            <dt ><span class="glyphicon glyphicon-paperclip"></span> 友情链接管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd >
                <ul>
                    <li><a href="<?php echo Yii::$app->request->hostInfo; ?>/index.php?r=link/index" title="链接列表">链接列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture">
            <dt><span class="glyphicon glyphicon-pencil"></span> 操作日志<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd >
                <ul>
                    <li><a href="<?php echo Yii::$app->request->hostInfo; ?>/index.php?r=log/index" title="操作日志列表">操作日志列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture">
            <dt><span class="glyphicon glyphicon-user"></span> 管理员<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd >
                <ul>
                    <li><a href="<?php echo Yii::$app->request->hostInfo; ?>/index.php?r=user/index" title="管理员列表">管理员列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>

<section class="Hui-article-box">
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页
        <span class="c-gray en">&gt;</span>
        管理员
        <span class="c-gray en">&gt;</span>
        管理员列表
        <span class="c-gray en">&gt;</span>
        管理员添加/修改

        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
           href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="Hui-article">
        <?=\common\widgets\Alert::widget()?>
        <article class="cl pd-20">
            <?=\common\widgets\Alert::widget()?>
            <?php
            $form = \yii\bootstrap\ActiveForm::begin([
                'options' => ['class' => 'form form-horizontal', 'id' => 'form-member-add']
            ]); ?>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>账号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <?= $form->field($model, 'username')->textInput(['class' => 'input-text'])->label(false) ?>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <?= $form->field($model, 'password')->passwordInput(['class' => 'input-text'])->label(false) ?>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <?= $form->field($model, 're_password')->passwordInput(['class' => 'input-text'])->label(false) ?>
                </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input  id="tijiao" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
            <?php \yii\bootstrap\ActiveForm::end(); ?>
        </article>
    </div>
</section>
<script type="text/javascript">
    $('.form-group').css('width', '100%');
    $('#tijiao').on('click',function(){
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
    });
</script>












