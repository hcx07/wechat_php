<script type="text/javascript" charset="utf-8" src="/jquery/jquery.js"></script>
<script type="text/javascript" charset="utf-8" src="/layer/src/layer.js"></script>

<button type="submit" class="btn btn-success">提交</button>
<script>
    $('.btn-success').click(function () {
        layer.msg('aaa', {icon: 1,time:1000});
        parent.location.reload();
    }
</script>