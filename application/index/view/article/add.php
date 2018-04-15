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

<script type="text/javascript" charset="utf-8" src="/jquery/jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="/layer/layer.js"></script>

<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.js"> </script>
<script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>

<link href="/webuploader/dist/webuploader.css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="/webuploader/dist/webuploader.js"></script>

<body class="nav-md" style="background: #ffffff">
<div class="row" >
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <br />
                <form id="demo-form2" class="form-horizontal form-label-left" onsubmit="return false">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">文章标题 <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" name="title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">图片 <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="uploader-demo">
                                <div id="vi-demo">
                                    <!--用来存放item-->
                                    <div id="viList" class="vi-list">

                                    </div>
                                    <div id="viPicker">选择封面</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">内容<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea id="container" name="content" type="text/plain" style="width:1024px;height:500px;"></textarea>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    var ue = UE.getEditor('container');
    var vi_count=0;

    $('.btn-success').click(function () {
        var url="{:url('article/add')}";
        var from_data = $('#demo-form2').serializeArray();
        var data = [];
        $.each(from_data,function(i){
            data[from_data[i].name] = from_data[i].value;
        });
        data = array_to_object(data);
        $.ajax({
            url:url,
            type:'post',
            data:data,
            dataType:'json',
            success:function (re) {
                console.log(re);
                if(re.code==200){
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.msg('添加成功',{icon: 1,time:1000});
                    parent.layer.close(index);
                    parent.reload();
                }else{
                    layer.msg('添加失败', {icon: 5,time:1000});
                }
            },
            error:function(){
                layer.msg('请求失败', {icon: 5,time:1000});
            }
        });
    });
    function array_to_object($arr){
        var object = new Object();
        for(var key in $arr){
            object[key] = $arr[key];
        }
        return object;
    }
    /**
     * 图片
     */
    function delParent(object) {
        $(object).parent().remove();
        vi_count-=1;
    }

    //上传图片
    $(function () {
        //上传视频封面
        var url_del='/images/h-ui/del.png';
        var $vi_list = $("#viList");
        var vi_uploader = WebUploader.create({
            auto: true,
            // swf文件路径

            // 文件接收服务端。
            server: "{:url('uploader/upload')}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#viPicker',

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
        vi_uploader.on( 'fileQueued', function( file ) {
            var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<div onclick="delParent(this)" style="cursor: pointer;background: url(' + url_del + ') no-repeat;background-size:contain;height: 20px;width: 20px;position: absolute;z-index: 10;right: 5px;"></div>'+
                    '<img style="width: 100px;height: 100px;">' +
                    '<input name="vi" type="hidden" value="">'+
                    '<div class="info">' + file.name + '</div>' +
                    '</div>'
                ),
                $img = $li.find('img');


            // $list为容器jQuery实例
            $vi_list.append( $li );

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            vi_uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, 100, 100 );
        });
        vi_uploader.on( 'beforeFileQueued', function( file ) {
            if(vi_count>0){
                return false;
            }
            return true;
        });
        // 文件上传过程中创建进度条实时显示。
        vi_uploader.on( 'uploadProgress', function( file, percentage ) {
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
        vi_uploader.on( 'uploadSuccess', function( file,res ) {
            var url = res.data;
            console.log(re);
            vi_count+=1;
            $( '#'+file.id).find("img").attr("src",url);
            $( '#'+file.id).find("input").val(url);
            $( '#'+file.id ).addClass('upload-state-done');
        });
        // 文件上传失败，显示上传出错。
        vi_uploader.on( 'uploadError', function( file ) {
            var $li = $( '#'+file.id ),
                $error = $li.find('div.error');

            // 避免重复创建
            if ( !$error.length ) {
                $error = $('<div class="error"></div>').appendTo( $li );
            }

            $error.text('上传失败');
        });
        // 完成上传完了，成功或者失败，先删除进度条。
        vi_uploader.on( 'uploadComplete', function( file ) {
            $( '#'+file.id ).find('.progress').remove();
        });
    });
</script>