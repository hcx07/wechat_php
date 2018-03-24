<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:53:"E:\tp5\public/../application/index\view\user\info.php";i:1511333903;}*/ ?>
﻿<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    <link href="/cool/cool.css" rel="stylesheet">
<title>修改支付信息</title>
</head>
<body>
<article class="page-container">
	<form action="" method="post" class="basic-grey" id="form-admin-role-add" enctype="multipart/form-data">
        <h1>
            <span>
                支付宝信息
            </span>
        </h1>


        <label ><span>合作身份者id：</span>
            <input type="text"  value="<?php if(isset($res['PARTNER'])){
                echo $res['PARTNER'];
            }?>" placeholder="" name="PARTNER" >
        </label>
        <label ><span>SELLER_ID：</span>
            <input type="text"  value="<?php if(isset($res['SELLER_ID'])){
                echo $res['SELLER_ID'];
            }?>" placeholder="" id="" name="SELLER_ID" >
        </label>
        <label ><span>应用Id：</span>
            <input type="text"  value="<?php if(isset($res['ALI_APPID'])){
                echo $res['ALI_APPID'];
            }?>" placeholder="" id="" name="ALI_APPID" >
        </label>
        <label ><span>私钥：</span>
            <input type="file"  value="" placeholder="" id="" name="PRIVATE_KEY_PATH" >
            <?php if(($res['PRIVATE_KEY_PATH'])){
                echo '文件地址：'.$res['PRIVATE_KEY_PATH'];
            }?>
        </label>
        <label ><span>公钥：</span>
            <input type="file"  value="" placeholder="" id="" name="ALI_PUBLIC_KEY_PATH" >
            <?php if(($res['ALI_PUBLIC_KEY_PATH'])){
                echo '文件地址：'.$res['ALI_PUBLIC_KEY_PATH'];
            }?>
        </label>
        <label ><span>支付宝回调地址：</span>
            <input type="text"  value="<?php if(isset($res['ali_url'])){
                echo $res['ali_url'];
            }?>" placeholder="" id="" name="ali_url" >
        </label>
        <h1></h1>
        <h1>
            <span>
                微信信息
            </span>
        </h1>
        <label ><span>APPID：</span>
            <div >
                <input type="text"  value="<?php if(isset($res['APPID'])){
                    echo $res['APPID'];
                }?>" placeholder="" id="" name="APPID" >
            </label>
        <label ><span>商户号：</span>
            <div >
                <input type="text"  value="<?php if(isset($res['MCHID'])){
                    echo $res['MCHID'];
                }?>" placeholder="" id="" name="MCHID" >
            </label>

        <label ><span>商户支付密钥：</span>
            <div >
                <input type="text"  value="<?php if(isset($res['KEY'])){
                    echo $res['KEY'];
                }?>" placeholder="" id="" name="KEY" >
            </label>

        <label ><span>SSLCERT_PATH：</span>
            <div >
                <input type="file"  value="" placeholder="" id="" name="SSLCERT_PATH" >
                <?php if(($res['SSLCERT_PATH'])){
                    echo '文件地址：'.$res['SSLCERT_PATH'];
                }?>
            </label>

        <label ><span>SSLKEY_PATH：</span>
            <div >
                <input type="file"  value="" placeholder="" id="" name="SSLKEY_PATH" >
                <?php if(($res['SSLKEY_PATH'])){
                    echo '文件地址：'.$res['SSLKEY_PATH'];
                }?>
            </label>

        <label ><span>微信回调地址：</span>
            <div >
                <input type="text"  value="<?php if(isset($res['we_url'])){
                    echo $res['we_url'];
                }?>" placeholder="" id="" name="we_url" >
            </label>

        <label>
            <span>&nbsp;</span>
            <input type="submit" class="button" value="提交" />
        </label>
	</form>
</article>


<script type="text/javascript">
$(function(){

	
	$("#form-admin-role-add").validate({
		rules:{
			roleName:{
				:true,
			},
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
		submitHandler:function(form){
			$(form).ajaxSubmit();
			var index = parent.layer.getFrameIndex(window.name);
			parent.layer.close(index);
		}
	});
});
</script>
</body>
</html>