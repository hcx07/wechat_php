<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"E:\wechatphp\public/../application/index\view\user\index.php";i:1521878560;s:46:"E:\wechatphp\application\index\view\layout.php";i:1521879573;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>后台管理系统 </title>

    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="/index.html" class="site_title"><i class="fa fa-paw"></i> <span>后台管理系统</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">

                    <div class="profile_info">
                        <span>Welcome,</span>

                        <h2>
                            <?php
                            $user_id=\think\Session::get('user_id');
                            $res=\db('user')->where(['user_id'=>$user_id])->find();
                            echo $res['username']
                            ?>
                        </h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-home"></i> 用户管理 <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo Url('user/index'); ?>">用户列表</a></li>
                                </ul>
                            </li>
                            <li><a><i class="fa fa-edit"></i> 文章管理 <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="<?php echo Url('article/article_list'); ?>">文章列表</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="安全退出" href="<?php echo Url('login/logout'); ?>">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <?php echo $res['username'] ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> 安全退出</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->
        <!-- page content -->
        


<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">

            <div class="title_left">
                <small><a class="btn btn-primary radius" onclick="picture_add('添加用户','<?php echo Url('user/add'); ?>')" href="javascript:;">
                        添加用户</a></small>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="搜索">
                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>用户列表</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="100">ID</th>
                                <th width="100">用户名</th>
                                <th width="100">UUID</th>
                                <th width="100">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($result as $item):?>
                                <tr class="text-c">

                                    <td><?php echo $item['user_id']?></td>
                                    <td><?php echo $item['username']?></td>
                                    <td><?php echo $item['uuid']?></td>
                                    <td>
                                        <a style="text-decoration:none" class="fa fa-edit" onClick="member_edit('修改用户','<?php echo Url('user/edit',['user_id'=>$item['user_id']]); ?>')" href="javascript:;" title="修改用户"></a>
                                        <a style="text-decoration:none" class="fa fa-times"   onClick="picture_del(this,'<?php echo Url('user/del',['user_id'=>$item['user_id']]); ?>')" href="javascript:;" title="删除"></a>
                                        <a style="text-decoration:none" class="fa fa-newspaper-o" onClick="member_edit('修改支付信息','<?php echo Url('user/info',['user_id'=>$item['user_id']]); ?>')" href="javascript:;" title="修改支付信息"></a>
                                    </td>

                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                            <?php echo $result->render(); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /page content -->




<script type="text/javascript">
    function picture_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    function picture_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: id,
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                    location.replace(location.href);
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }
    function member_edit(title,url,w,h){
        layer_show(title,url,w,h);
    }
    function layer_show(title,url,w,h){
        if (title == null || title == '') {
            title=false;
        };
        if (url == null || url == '') {
            url="404.html";
        };
        if (w == null || w == '') {
            w=800;
        };
        if (h == null || h == '') {
            h=($(window).height() - 50);
        };
        layer.open({
            type: 2,
            area: [w+'px', h +'px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            title: title,
            content: url
        });
    }

</script>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="/vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="/vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="/vendors/Flot/jquery.flot.js"></script>
<script src="/vendors/Flot/jquery.flot.pie.js"></script>
<script src="/vendors/Flot/jquery.flot.time.js"></script>
<script src="/vendors/Flot/jquery.flot.stack.js"></script>
<script src="/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="/vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="/vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="/vendors/moment/min/moment.min.js"></script>
<script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Custom Theme Scripts -->
<script src="/build/js/custom.min.js"></script>

<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>

</body>
</html>
