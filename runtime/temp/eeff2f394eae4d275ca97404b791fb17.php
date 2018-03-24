<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"E:\wechatphp\public/../application/index\view\login\index.php";i:1510810538;}*/ ?>
﻿<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/lib/html5shiv.js"></script>
<script type="text/javascript" src="/lib/respond.min.js"></script>
<![endif]-->
<link href="/static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css" />
<link href="/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
<link href="/static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css" />
<link href="/lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css" />
<!--[if IE 6]>
<script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>后台登录</title>
<meta name="keywords" content="">
<meta name="description" content="">
  <script>
      // 判断是否是顶层窗口
      if(window.top!==window.self){window.top.location=window.location};
  </script>
</head>
<body>
<div class="" style="background: "><font size="6" color="#f0f8ff">&nbsp;&nbsp;&nbsp;大总管后台登录</font></div>
<div class="loginWraper">
  <div id="loginform" class="loginBox">
    <form class="form form-horizontal"  method="post">
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
        <div class="formControls col-xs-8">
          <input id="username" name="username" type="text" placeholder="账户" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
        <div class="formControls col-xs-8">
          <input id="password" name="password" type="password" placeholder="密码" class="input-text size-L">
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input class="input-text size-L" name="vertify" type="text" placeholder="验证码" onblur="if(this.value==''){this.value='验证码:'}" onclick="if(this.value=='验证码:'){this.value='';}" value="验证码:" style="width:150px;">
          <img id="verify_img" style="height: 40px" src="<?php echo captcha_src(); ?>" onclick="refreshVerify();"/>
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          点击图片更换验证码<br/>
        </div>
      </div>
      <div class="row cl">
        <div class="formControls col-xs-8 col-xs-offset-3">
          <input name="" type="submit" class="btn btn-success radius size-L" value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
          <input name="" type="reset" class="btn btn-default radius size-L" value="&nbsp;取&nbsp;&nbsp;&nbsp;&nbsp;消&nbsp;">
        </div>
      </div>
    </form>
  </div>
</div>
<div class="footer">PAY</div>
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script>
    function refreshVerify() {
        var ts = Date.parse(new Date())/1000;
        $('#verify_img').attr("src", "/captcha?id="+ts);
    }
</script>
</body>
</html>