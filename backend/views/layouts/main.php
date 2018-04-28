
<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="favicon.ico" >
<link rel="Shortcut Icon" href="favicon.ico" />

<link rel="stylesheet" type="text/css" href="static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />

    <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<title>木鸟</title>
</head>
<body>
<?php $this->beginBody() ?>
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
            <dt ><span class="glyphicon glyphicon-envelope"></span> 留言管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd >
                <ul>
                    <li><a href="<?php echo Yii::$app->request->hostInfo; ?>/index.php?r=message/index" title="留言列表">留言列表</a>
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
<?=$content?>

<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.page.js"></script>
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
</body>
</html>