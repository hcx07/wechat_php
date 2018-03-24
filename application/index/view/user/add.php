
<!DOCTYPE HTML>
<html>
<head>
    <link href="/cool/cool.css" rel="stylesheet">
<title>添加用户</title>
</head>
<body>
	<form action="" method="post" class="basic-grey" id="form-admin-role-add">
        <h1>添加用户
        </h1>
        <label>
            <span>用户名 :</span>
            <input id="name" type="text" name="username" placeholder="" required/>
        </label>
        <label>
            <span>密码 :</span>
            <input id="name" type="password" name="password" placeholder="" required/>
        </label>
        <label>
            <span>确认密码 :</span>
            <input id="name" type="password" name="re_password" placeholder="" required/>
        </label>
        <label>
            <span>&nbsp;</span>
            <input type="submit" class="button" value="提交" />
        </label>
	</form>
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script src="/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#form-admin-role-add").validate({
		rules:{
			roleName:{
				required:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit();
			var index = parent.layer.getFrameIndex(window.name);
            parent.layer.msg("添加成功",{icon: 1,time:1000});
			parent.layer.close(index);
            parent.reload();
        }
	});
});
</script>
</body>
</html>