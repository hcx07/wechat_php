<section class="Hui-article-box">
    <nav class="breadcrumb">
        <i class="Hui-iconfont">&#xe67f;</i>首页
        <span class="c-gray en">&gt;</span>
        分类管理
        <span class="c-gray en">&gt;</span>
        分类列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
    </nav>
    <div class="Hui-article">
        <article class="cl pd-20">
            <?=\common\widgets\Alert::widget()?>
            <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">

                <a href="javascript:;" onclick="member_add('添加分类','<?=\yii\helpers\Url::toRoute(['article/cate-add'])?>','400','250')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加分类</a>

            </span>
            </div>
            <div class="mt-20">
                <table class="table table-border table-bordered table-hover table-bg table-sort">
                    <thead>
                    <tr class="text-c">
                        <th>排序</th>
                        <th>名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($model as $item): ?>
                        <tr>
                            <td><?=$item->order_no?></td>
                            <td><?=$item->cate_name?></td>
                            <td>
                                <a title="修改" href="javascript:;" onclick="member_edit('修改','<?=\yii\helpers\Url::toRoute(['article/cate-edit','cate_id'=>$item->cate_id])?>','4','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                                <a title="删除" href="javascript:;" onclick="member_show(this,'<?=\yii\helpers\Url::toRoute(['article/cate-del','cate_id'=>$item->cate_id])?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
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

    /*用户-添加*/
    function member_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*用户-编辑*/
    function member_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }

    function member_show(obj,id){
        layer.confirm('确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            window.location.href = id;
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
        });
    }
</script>





