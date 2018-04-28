<section class="Hui-article-box">
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i>首页
        <span class="c-gray en">&gt;</span>
        管理员
        <span class="c-gray en">&gt;</span>
        管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="Hui-article">
        <article class="cl pd-20">
            <?=\common\widgets\Alert::widget()?>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="<?php echo Yii::$app->request->hostInfo ?>/index.php?r=user/add"
                   class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>
            </span>
            </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                    <tr class="text-c">
                        <th>ID</th>
                        <th>用户名</th>
                        <th>最后登陆时间</th>
                        <th>最后修改时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model as $admin): ?>
                        <tr>
                            <td><?=$admin->id?></td>
                            <td><?=$admin->username?></td>
                            <td><?=date('Y-m-d H:i:s',$admin->created_at)?></td>
                            <td><?=$admin->updated_at?date('Y-m-d H:i:s',$admin->updated_at):'未修改'?></td>
                            <td>

                                    <?=\yii\bootstrap\Html::a('修改',['user/edit','id'=>$admin->id],['class'=>'btn btn-info btn-xs'])?>
                                    <a href="javascript:;" class="btn btn-warning btn-xs del " name="<?=$admin->id?>">删除</a>
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
</script>





