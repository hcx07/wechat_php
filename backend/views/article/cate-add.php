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

<article class="page-container">
    <?=\common\widgets\Alert::widget()?>
    <?php
    $form = \yii\bootstrap\ActiveForm::begin([
        'options' => ['class' => 'form form-horizontal', 'id' => 'form-article-add']
    ]); ?>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类名：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <?= $form->field($model, 'cate_name')->textInput(['class' => 'input-text'])->label(false) ?>
        </div>
    </div>
    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>排序号：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <?= $form->field($model, 'order_no')->textInput(['class' => 'input-text'])->label(false) ?>
        </div>
    </div>
    <div class="row cl">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
            <input  id="tijiao" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        </div>
    </div>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
</article>
<script type="text/javascript">
    function hq(){
        //声明一个随机数变量，默认为1
        var GetRandomn = 1;
        //js生成时间戳
        var timestamp=new Date().getTime();
        //获取随机范围内数值的函数
        function GetRandom(n){
            //由随机数+时间戳+1组成
            GetRandomn=Math.floor(Math.random()*n+timestamp+1);
        }
        //开始调用，获得一个1-100的随机数
        GetRandom("30");
        //把随机数GetRandomn 赋给 input文本框.根据input的id
        $('#number').val(GetRandomn);
        //调试输出查看
        //alert(GetRandomn);
    }


    $("#form-article-add").validate({
        rules:{
            "Category[order_no]":{
                "number":true,
                "min":1
            },
        },
        onkeyup:false,
        focusCleanup:true,
        success:"valid",
        submitHandler:function(form){
            $(form).ajaxSubmit({
                type: 'post',
                url: '<?=\yii\helpers\Url::toRoute(['article/cate-add'])?>',
                success: function(data) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.msg("添加成功",{icon: 1,time:1000});
                    parent.layer.close(index);
                    parent.reload();
                },
                error: function (data) {
                    console.log(data);
                    layer.alert("网络错误");
                }
            });
        }
    });
</script>















