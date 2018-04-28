<section class="Hui-article-box">
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i>首页
        <span class="c-gray en">&gt;</span>
        文章管理
        <span class="c-gray en">&gt;</span>
        文章列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="Hui-article">
        <article class="cl pd-20">
            <?=\common\widgets\Alert::widget()?>
            <div class="text-c">
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'method' => 'get',
                    'action'=>\yii\helpers\Url::to(['article/index']),
                    'options'=>['class'=>'form-inline']
                ]); ?>
                创建时间：
                <input <?php if(isset($return['start'])){?>
                        value="<?=$return['start']?>"
                        <?php }?>   type="text" name="start" onfocus="WdatePicker({maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}'})" id="logmin" class="input-text Wdate" style="width:120px;">
                -
                <input <?php if(isset($return['end'])){?>
                        value="<?=$return['end']?>"
                        <?php }?>   type="text" name="end" onfocus="WdatePicker({minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d'})" id="logmax" class="input-text Wdate" style="width:120px;">
                <input
                    <?php if(isset($return['title'])){?>
                        value="<?=$return['title']?>"
                        <?php }?>   type="text" name="title" id="" placeholder=" 标题" style="width:250px" class="input-text">
                <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a title="添加文章" href="javascript:;" onclick="add('添加文章','<?=\yii\helpers\Url::toRoute(['article/add'])?>')" class="btn btn-primary radius" style="text-decoration:none"><i class="Hui-iconfont">&#xe600;</i> 添加文章</a>
            </span>
            </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                    <tr class="text-c">
                        <th>标题</th>
                        <th>封面</th>
                        <th>作者</th>
                        <th>查看次数</th>
                        <th>创建时间</th>
                        <th>修改时间</th>
                        <th>状态</th>
                        <th>是否置顶</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model as $item): ?>
                        <tr>
                            <td><?=$item->title?></td>
                            <td width="200px"><img src="<?=$item['img']?>" style="width: 200px"></td>
                            <td><?=$item->username?></td>
                            <td><?=$item->views?></td>
                            <td><?=date('Y-m-d H:i:s',$item->created_time)?></td>
                            <td><?=date('Y-m-d H:i:s',$item->update_time)?></td>
                            <td><?=$item->status==1?'<span class="label label-success radius">正常</span>':'<span class="label label-danger radius">隐藏</span>'?></td>
                            <td><?=$item->is_top==1?'<span class="label label-success radius">置顶</span>':'<span class="label label-danger radius">普通</span>'?></td>
                            <td>
                                <a title="修改" href="javascript:;" onclick="add('修改','<?=\yii\helpers\Url::toRoute(['article/edit','article_id'=>$item->article_id])?>','4','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <?php
                                    if($item->status==1){?>
                                        <a title="隐藏" href="javascript:;" onclick="edit(this,'<?=\yii\helpers\Url::toRoute(['article/operation','article_id'=>$item->article_id,'status'=>0])?>',0)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>
                                    <?php }else{?>
                                        <a title="显示" href="javascript:;" onclick="edit(this,'<?=\yii\helpers\Url::toRoute(['article/operation','article_id'=>$item->article_id,'status'=>1])?>',1)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe725;</i></a>
                                <?php }?>
                                <?php
                                if($item->is_top==1){?>
                                    <a title="取消置顶" href="javascript:;" onclick="edit(this,'<?=\yii\helpers\Url::toRoute(['article/operation','article_id'=>$item->article_id,'is_top'=>0])?>',2)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe69e;</i></a>
                                <?php }else{?>
                                    <a title="置顶" href="javascript:;" onclick="edit(this,'<?=\yii\helpers\Url::toRoute(['article/operation','article_id'=>$item->article_id,'is_top'=>1])?>',3)" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe630;</i></a>
                                <?php }?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $page,
                    'firstPageLabel' => '首页',
                    'lastPageLabel' => '尾页',
                    'hideOnSinglePage' => false,
                    'maxButtonCount' => 5,
                ]); ?>
            </div>

        </article>
    </div>
</section>
<script type="text/javascript">
    $('.del').on('click',function(){
        var id=$(this).attr('name');
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            window.location.href = "/index.php?r=user/del&id="+id;
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
        });
    });

    /**
     * 添加 修改
     * @param title
     * @param url
     */
    function add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }

    /**
     * 操作
     * @param obj
     * @param url
     * @param type
     */
    function edit(obj,url,type) {
        var str='确认？';
        if(type==0){
            str='确认要隐藏吗？';
        } else if(type==1){
            str='确认要显示吗？';
        }else if(type==2){
            str='确认要取消置顶吗？';
        }else if(type==3){
            str='确认要置顶吗？';
        }
        layer.confirm(str,function(index){
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if(data.code==200){
                        layer.msg('操作成功',{icon:1,time:1000});
                        layer.closeAll();
                        window.location.reload();
                    }else{
                        layer.msg(data.msg,{icon:6,time:5000});
                    }
                },
                error:function(data) {
                    layer.msg('操作失败',{icon:6,time:5000});
                },
            });
        });
    }
</script>





