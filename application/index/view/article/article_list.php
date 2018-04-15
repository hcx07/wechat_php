

{layout name="layout" /}
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">

            <div class="title_left">
                <small><a class="btn btn-primary radius" onclick="picture_add('添加文章','{:Url('article/add')}')" href="javascript:;">添加文章</a></small>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="搜索">
                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>文章列表</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th width="100">ID</th>
                                <th width="100">标题</th>
                                <th width="20">图片</th>
                                <th width="100">添加时间</th>
                                <th width="100">用户</th>
                                <th width="100">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data as $item):?>
                                <tr class="text-c">

                                    <td><?php echo $item['article_id']?></td>
                                    <td><?php echo $item['title']?></td>
                                    <td><img src="<?php echo $item['img']?>" style="width: 20%"></td>
                                    <td><?php echo date('Y-m-d H:i:s',$item['add_time'])?></td>
                                    <td><?php echo $item['username']?></td>
                                    <td>
                                        <a style="text-decoration:none" class="fa fa-edit" onClick="member_edit('修改','{:Url('article/edit',['article_id'=>$item['article_id']])}')" href="javascript:;" title="修改"></a>
                                        <a style="text-decoration:none" class="fa fa-times"   onClick="picture_del(this,'{:Url('article/del',['article_id'=>$item['article_id']])}')" href="javascript:;" title="删除"></a>
                                    </td>

                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                            {$data->render()}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- /page content -->




<script type="text/javascript">
    function picture_add(title,url){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    function picture_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: id,
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                    location.replace(location.href);
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }
    function member_edit(title,url,w,h){
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    function layer_show(title,url,w,h){
        if (title == null || title == '') {
            title=false;
        };
        if (url == null || url == '') {
            url="404.html";
        };
        if (w == null || w == '') {
            w=800;
        };
        if (h == null || h == '') {
            h=($(window).height() - 50);
        };
        layer.open({
            type: 2,
            area: [w+'px', h +'px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            title: title,
            content: url
        });
    }

</script>