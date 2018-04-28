<?php

use yii\helpers\Url;
?>
<link rel="stylesheet" type="text/css" href="static/h-ui/css/H-ui.min.css"/>
<link rel="stylesheet" type="text/css" href="css/site.css"/>
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.js"></script>
<link href="lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript" charset="utf-8" src="uedit/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="uedit/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="uedit/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="uedit/edit.js"></script>
<article class="page-container">
    <?=\common\widgets\Alert::widget()?>
    <?php
    $form = \yii\bootstrap\ActiveForm::begin([
        'options' => ['class' => 'form form-horizontal', 'id' => 'form-article-add']
    ]); ?>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>标题：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <?= $form->field($model, 'title')->textInput(['class' => 'input-text','style'=>'width:500px'])->label(false) ?>
        </div>
    </div>

    <div class="row cl" id="vi_hide">
        <label class="form-label col-xs-4 col-sm-2">封面：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <div id="uploader-demo">
                <!--用来存放item-->
                <div id="fileList" class="uploader-list">
                    <?php if($model->img):?>
                    <div id="<?= uniqid('img')?>" class="file-item thumbnail">
                        <div onclick="delParent(this)" style="cursor: pointer;background: url('<?= Yii::getAlias("@web/images/h-ui/del.png")?>') no-repeat;background-size:contain;height: 20px;width: 20px;position: absolute;z-index: 10;right: 5px;"></div>
                        <img style="width: 100px;height: 100px;" src="<?= $model->img?>">
                        <input name="img" type="hidden" value="<?= $model->img?>">
                        <div class="info"></div>
                    </div>
                    <?php endif;?>
                </div>
                <div id="filePicker">选择图片</div>
            </div>
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>查看次数：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <?= $form->field($model, 'views')->textInput(['class' => 'input-text','value'=>'0'])->label(false) ?>
        </div>
    </div>

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>文章内容：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <div>
                <textarea id="editor"  name="content"   type="text/plain" style="width:1024px;height:500px;"><?=$model->content?></textarea>
            </div>
        </div>
    </div>

    <div class="row cl">
        <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
            <input  id="tijiao" class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        </div>
    </div>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
</article>
<script>
    var count=0;
    function delParent(object){
        $(object).parent().remove();
        count-=1;
    }
    //上传图片
    $(function(){
        var $list = $("#fileList");
        var uploader = WebUploader.create({
            auto: true,
            // swf文件路径

            // 文件接收服务端。
            server: '<?= Url::toRoute(['uploader/web-upload',"img_type"=>2],true)?>',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
            resize: false,
            duplicate:true,

            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
        });
        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function( file ) {
            console.log(file);
            var $li = $(
                '<div id="' + file.id + '" class="file-item thumbnail">' +
                '<div onclick="delParent(this)" style="cursor: pointer;background: url(<?= Yii::getAlias("@web/images/h-ui/del.png")?>) no-repeat;background-size:contain;height: 20px;width: 20px;position: absolute;z-index: 10;right: 5px;"></div>'+
                '<img style="width: 100px;height: 100px;">' +
                '<input name="img" type="hidden" value="">'+
                '<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
                $img = $li.find('img');


            // $list为容器jQuery实例
            $list.append( $li );

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, 100, 100 );
        });
        uploader.on( 'beforeFileQueued', function( file ) {
            if(count>0){
                return false;
            }
            return true;
        });
        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#'+file.id ),
                $percent = $li.find('.progress span');

            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<p class="progress"><span></span></p>')
                    .appendTo( $li )
                    .find('span');
            }


            $percent.css( 'width', percentage * 100 + '%' );
        });
        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file,res ) {
            var url = res;
            count+=1;
            $( '#'+file.id).find("img").attr("src",url);
            $( '#'+file.id).find("input").val(url);
            $( '#'+file.id ).addClass('upload-state-done');
        });
        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            var $li = $( '#'+file.id ),
                $error = $li.find('div.error');

            // 避免重复创建
            if ( !$error.length ) {
                $error = $('<div class="error"></div>').appendTo( $li );
            }

            $error.text('上传失败');
        });
        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress').remove();
        });
    });
</script>













