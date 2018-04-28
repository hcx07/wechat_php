<div id="content" class="app-content">
    <div id="loadingbar" class="butterbar hide">
        <span class="bar"></span>
    </div>
    <a class="off-screen-toggle hide"></a>
    <main class="app-content-body">
        <div class="hbox hbox-auto-xs hbox-auto-sm">
            <div class="col">
                <header class="bg-light lter b-b wrapper-md">
                    <h1 class="m-n font-thin h3 text-black l-h">木鸟</h1>
                    <small class="text-muted letterspacing">那就一直飞吧，停留枝头，也落在陆地。</small>
                </header>
                <div class="wrapper-md">
                    <div class="blog-post">
                        <?php foreach ($model as $item):?>
                            <div class="panel">
                                <div id="index-post-img">
                                    <a href="<?=\yii\helpers\Url::toRoute(['index/article','article_id'=>$item->article_id])?>">
                                        <?php if($item->img):?>
                                        <div class="item-thumb" style="background-image: url(<?=$item->img?>)"></div>
                                        <?php endif;?>
                                    </a>
                                </div>
                                <div class="post-meta wrapper-lg">
                                    <h2 class="m-t-none index-post-title">
                                        <a href="<?=\yii\helpers\Url::toRoute(['index/article','article_id'=>$item->article_id])?>"><?=$item->title?></a></h2>
                                    <p class="summary">
                                        <?php
                                        $str=strip_tags($item->content);
                                        if(iconv_strlen($str,'utf-8')<=60)
                                        {
                                            echo $str;
                                        }else{
                                            echo mb_substr($str, 0,60,'UTF-8').'...';
                                        }
                                        ?>
                                    </p>
                                    <div class="line line-lg b-b b-light"></div>
                                    <div class="text-muted">
                                        <i class="fa fa-user text-muted"></i>
                                        <span class="m-r-sm"><?=$item->author?>&nbsp;</span>
                                        <i class="fa fa-clock-o text-muted"></i>&nbsp;<?=date('Y-m-d H:i',$item->created_time)?>
                                        <a href="<?=\yii\helpers\Url::toRoute(['index/article','article_id'=>$item->article_id])?>" class="m-l-sm"><i class="iconfont icon-comments text-muted"></i>&nbsp;<?=$item->guest_count?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <nav class="text-center m-t-lg m-b-lg" role="navigation">
                        <?= \yii\widgets\LinkPager::widget([
                            'pagination' => $page,
                            'hideOnSinglePage' => false,
                            'maxButtonCount' => 5,
                            'options' => ['class' => 'page-navigator'],
                        ]); ?>
                    </nav>
                    <style>.page-navigator > li > a, .page-navigator > li > span {
                            line-height: 1.42857143;
                            padding: 6px 12px;
                        }</style>
                </div>
            </div>