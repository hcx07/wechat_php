<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>

    <link href="/cool/cool.css" rel="stylesheet">
<title>用户修改</title>
</head>
<body>

<form action="" method="post" class="basic-grey" id="form-admin-role-add">

    <label>
        <span>用户名 :</span>
        <input type="text" class="input-text" value="<?php if(isset($res['username'])){
            echo $res['username'];
        }?>" placeholder="" name="username" required readonly>
    </label>
    <label>
        <span>密码 :</span>
        <input type="password" class="input-text" value="<?php if(isset($res['password'])){
            echo $res['password'];
        }?>" placeholder="" id="" name="password" required>
    </label>
    <label>
        <span>确认密码 :</span>
        <input type="password" class="input-text" value="<?php if(isset($res['password'])){
            echo $res['password'];
        }?>" placeholder="" id="" name="re_password" required>
    </label>
    <label>
        <span>&nbsp;</span>
        <input type="submit" class="button" value="提交" />
    </label>
</form>




<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/layer/src/layer.js"></script>
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
            parent.layer.msg("修改成功",{icon: 1,time:1000});
			parent.layer.close(index);
            parent.reload();
		}
	});
});
</script>
</body>
</html>