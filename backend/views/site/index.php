<section class="Hui-article-box">

    <nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/" class="maincolor">首页</a>
        <span class="c-999 en">&gt;</span>
        <span class="c-666">我的桌面</span>
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="Hui-article">
        <article class="cl pd-20">
            <p class="f-20 text-success">欢迎
                <span class="f-14">v1.0</span>
            </p>
            <table class="table table-border table-bordered table-bg mt-20">
                <thead>
                <tr>
                    <th colspan="2" scope="col">服务器信息</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th width="30%">服务器计算机名</th>
                    <td><span id="lbServerName"><?=$_SERVER['SERVER_NAME']?></span></td>
                </tr>
                <tr>
                    <td>服务器IP地址</td>
                    <td><?=$_SERVER['SERVER_ADDR']?></td>
                </tr>
                <tr>
                    <td>服务器端口 </td>
                    <td><?=$_SERVER['REMOTE_PORT']?></td>
                </tr>
                <tr>
                    <td>服务器当前时间 </td>
                    <td><?=date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME'])?></td>
                </tr>
                </tbody>
            </table>
        </article>
    </div>
</section>


