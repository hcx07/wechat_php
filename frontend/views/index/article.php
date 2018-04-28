<?php

use yii\helpers\Html;

?>
<div id="content" class="app-content markdown-body">
    <div id="loadingbar" class="butterbar hide">
        <span class="bar"></span>
    </div>
    <a class="off-screen-toggle hide"></a>
    <main class="app-content-body">
        <div class="hbox hbox-auto-xs hbox-auto-sm">
            <div class="col">
                <header id="small_widgets" class="bg-light lter b-b wrapper-md">
                    <h1 class="entry-title m-n font-thin h3 text-black l-h"><?= $model->title ?></h1>
                    <ul class="entry-meta text-muted list-inline m-b-none small">
                        <li class="meta-author"><i class="fa fa-user" aria-hidden="true"></i><span
                                    class="sr-only">作者：</span>  <?= $model->author ?></li>
                        <li class="meta-date"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;<span
                                    class="sr-only">发布时间：</span>
                            <time class="meta-value"><?=date('Y-m-d',$model->created_time)?></time>
                        </li>
                        <li class="meta-views"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;<span
                                    class="meta-value"><?= $model->views ?>&nbsp;次浏览</span></li>
                        <li class="meta-comments"><i class="iconfont icon-comments" aria-hidden="true"></i>&nbsp;<a
                                    class="meta-value" href="#comments">&nbsp;<?php
                                $res = \backend\models\Guestbook::find()->where(['article_id' => $model->article_id])->count();
                                if ($res > 0) {
                                    echo $res . ' 条评论';
                                } else {
                                    echo '暂无评论';
                                }
                                ?></a></li>
                        <li class="meta-categories"><i class="fa fa-tags" aria-hidden="true"></i> <span class="sr-only">分类：</span>
                            <span class="meta-value"><a
                                        href="<?= \yii\helpers\Url::toRoute(['index/cate', 'cate_id' => $model->cate_id]) ?>"><?= $model->cate_name ?></a></span>
                        </li>
                    </ul>
                </header>
                <div class="wrapper-md">
                    <ol class="breadcrumb bg-white b-a" itemscope="">
                        <li>
                            <a href="<?= \yii\helpers\Url::toRoute(['index/index']) ?>" itemprop="breadcrumb"
                               title="返回首页" data-toggle="tooltip"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;首页</a>
                        </li>
                        <li class="active">正文&nbsp;&nbsp;</li>
                        <div style="float:right;">
                            分享到：
                            <style>i.iconfont.icon-qzone:after {
                                    padding: 0 0px 0 5px;
                                    color: #ccc;
                                    content: "/\00a0";
                                }</style>
                            <a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://muniao.org<?= \yii\helpers\Url::toRoute(['index/index', 'article_id' => $model->article_id]) ?>&title=<?= $model->title ?>&site=http://muniao.org<?= \yii\helpers\Url::toRoute(['index/index']) ?>"
                               itemprop="breadcrumb" target="_blank" title="" data-toggle="tooltip"
                               data-original-title="分享到QQ空间"
                               onclick="window.open(this.href, 'qzone-share', 'width=550,height=335');return false;"><i
                                        style="font-size:15px;" class="iconfont icon-qzone" aria-hidden="true"></i></a>
                            <a href="http://service.weibo.com/share/share.php?url=http://muniao.org<?= \yii\helpers\Url::toRoute(['index/index', 'article_id' => $model->article_id]) ?>&title=<?= $model->title ?>"
                               target="_blank" itemprop="breadcrumb" title="" data-toggle="tooltip"
                               data-original-title="分享到微博"
                               onclick="window.open(this.href, 'weibo-share', 'width=550,height=335');return false;"><i
                                        style="font-size:15px;" class="fa fa-weibo" aria-hidden="true"></i></a>
                        </div>
                    </ol>
                    <div id="postpage" class="blog-post">
                        <article class="panel">
                            <?php if($model->img):?>
                                <div class="entry-thumbnail" aria-hidden="true">
                                    <div class="item-thumb" style="background-image: url(<?=$model->img?>)"></div>
                                </div>
                            <?php endif;?>
                            <div id="post-content" class="wrapper-lg">
                                <div class="entry-content l-h-2x">
                                    <?php
                                    $res = preg_replace('/\/ueditor\/php\/upload\/image/', "http://blog2.com/ueditor/php/upload/image", $model->content);
                                    echo $res;
                                    ?>
                                </div>
                                <div class="show-foot">
                                    <div class="notebook">
                                        <i class="fa fa-clock-o"></i>
                                        <span>最后修改：<?= date('Y-m-d H:i:s') ?></span>
                                    </div>
                                    <div class="copyright" data-toggle="tooltip" data-html="true"
                                         data-original-title="转载请联系作者获得授权，并注明转载地址"><span>© 著作权归作者所有</span>
                                    </div>
                                </div>
                                <div class="support-author">
                                    <button data-toggle="modal" data-target="#myModal" class="btn btn-pay btn-danger"><i
                                                class="fa fa-gratipay" aria-hidden="true"></i>&nbsp;赞赏支持
                                    </button>
                                    <div class="mt20 text-center article__reward-info">
                                        <span class="mr10">如果你喜欢这篇文章，请随意赞赏</span>
                                    </div>
                                </div>
                                <div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog"
                                     aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span
                                                            aria-hidden="true">&times;</span><span
                                                            class="sr-only">Close</span></button>
                                                <h4 class="modal-title">赞赏作者</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-center"><strong
                                                            class="article__reward-text">扫一扫支付</strong></p>
                                                <div class="tab-content">
                                                    <?php echo Html::img('@web/common/img/ali.png', ['class' => 'pay-img tab-pane fade in active', 'aria-labelledby' => 'alipay-tab', 'id' => 'alipay_author', 'role' => 'tabpanel']) ?>

                                                    <?php echo Html::img('@web/common/img/we.png', ['class' => 'pay-img tab-pane fade', 'aria-labelledby' => 'alipay-tab', 'id' => 'wechatpay_author', 'role' => 'tabpanel']) ?>
                                                </div>
                                                <div class="article__reward-border mb20 mt10"></div>
                                                <div class="text-center" role="tablist">
                                                    <div class="pay-button" role="presentation" class="active">
                                                        <button href="#alipay_author" id="alipay-tab"
                                                                aria-controls="alipay_author" role="tab"
                                                                data-toggle="tab" class="btn m-b-xs btn-info"><i
                                                                    class="iconfont icon-alipay" aria-hidden="true"></i><span>&nbsp;支付宝支付</span>
                                                        </button>
                                                    </div>
                                                    <div class="pay-button" role="presentation">
                                                        <button href="#wechatpay_author" id="wechatpay-tab"
                                                                aria-controls="wechatpay_author" role="tab"
                                                                data-toggle="tab" class="btn m-b-xs btn-success"><i
                                                                    class="iconfont icon-wechatpay"
                                                                    aria-hidden="true"></i><span>&nbsp;微信支付</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <div id="comments">
                        <div id="respond-post-735" class="respond comment-respond">
                            <h4 id="reply-title" class="comment-reply-title m-t-lg m-b">发表评论</h4>

                            <form id="comment_form" method="post" onsubmit="return false" class="comment-form" role="form">
                                <div class="comment-form-comment form-group">
                                    <label for="comment">评论 <span class="required text-danger">*</span></label>
                                    <textarea id="comment" class="textarea form-control OwO-textarea" name="text"
                                              rows="5" placeholder="说点什么吧……"
                                              onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
                                    <div class="OwO"></div>
                                </div>
                                <div id="author_info" class="row row-sm">
                                    <div class="comment-form-author form-group col-sm-6 col-md-4">
                                        <label for="author">名称 <span class="required text-danger">*</span></label>
                                        <input id="author" class="form-control" name="author" type="text" value=""
                                               maxlength="245" placeholder="姓名或昵称">
                                    </div>
                                    <div class="comment-form-email form-group col-sm-6 col-md-4">
                                        <label for="email">邮箱 <span class="required text-danger">*</span>
                                        </label>
                                        <input type="text" name="mail" id="mail" class="form-control"
                                               placeholder="邮箱 (必填,将保密)" value=""/>
                                    </div>
                                    <div class="comment-form-url form-group col-sm-12 col-md-4">
                                        <label for="url">地址</label>
                                        <input id="url" class="form-control" name="url" type="url" value=""
                                               maxlength="200" placeholder="网站或博客"></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="submit" id="submit"
                                            class="submit btn btn-success padder-lg">
                                        <span class="text">发表评论</span>
                                        <span class="text-active">提交中...</span>
                                    </button>
                                    <i class="animate-spin fa fa-spinner hide" id="spin"></i>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script type="text/javascript">
                        (function () {
                            window.TypechoComment = {
                                dom: function (id) {
                                    return document.getElementById(id);
                                }, create: function (tag, attr) {
                                    var el = document.createElement(tag);
                                    for (var key in attr) {
                                        el.setAttribute(key, attr[key]);
                                    }
                                    return el;
                                }, reply: function (cid, coid) {
                                    var comment = this.dom(cid), parent = comment.parentNode,
                                        response = this.dom('respond-post-735'), input = this.dom('comment-parent'),
                                        form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                                        textarea = response.getElementsByTagName('textarea')[0];
                                    if (null == input) {
                                        input = this.create('input', {
                                            'type': 'hidden', 'name': 'parent', 'id': 'comment-parent'
                                        });
                                        form.appendChild(input);
                                    }
                                    input.setAttribute('value', coid);
                                    if (null == this.dom('comment-form-place-holder')) {
                                        var holder = this.create('div', {
                                            'id': 'comment-form-place-holder'
                                        });
                                        response.parentNode.insertBefore(holder, response);
                                    }
                                    comment.appendChild(response);
                                    this.dom('cancel-comment-reply-link').style.display = '';
                                    if (null != textarea && 'text' == textarea.name) {
                                        textarea.focus();
                                    }
                                    return false;
                                }, cancelReply: function () {
                                    var response = this.dom('respond-post-735'),
                                        holder = this.dom('comment-form-place-holder'),
                                        input = this.dom('comment-parent');
                                    if (null != input) {
                                        input.parentNode.removeChild(input);
                                    }
                                    if (null == holder) {
                                        return true;
                                    }
                                    this.dom('cancel-comment-reply-link').style.display = 'none';
                                    holder.parentNode.insertBefore(response, holder);
                                    return false;
                                }
                            };
                        })();

                        var registCommentEvent = function () {
                            var event = document.addEventListener ? {
                                add: 'addEventListener', focus: 'focus', load: 'DOMContentLoaded'
                            } : {
                                add: 'attachEvent', focus: 'onfocus', load: 'onload'
                            };
                            var r = document.getElementById('respond-post-735');
                            if (null != r) {
                                var forms = r.getElementsByTagName('form');
                                if (forms.length > 0) {
                                    var f = forms[0], textarea = f.getElementsByTagName('textarea')[0], added = false;
                                    if (null != textarea && 'text' == textarea.name) {
                                        textarea[event.add](event.focus, function () {
                                            if (!added) {
                                                var input = document.createElement('input');
                                                input.type = 'hidden';
                                                input.name = '_';
                                                input.value = (function () {
                                                    var _jWRe = 'd' + 'e'
                                                        + 'd7'
                                                        + '82'
                                                        + '83f'
                                                        +
                                                        '22' +
                                                        '70' +
                                                        '8cb' + '440'
                                                        + 'a'
                                                        + '79d'
                                                        + '' +
                                                        '59' +
                                                        'ed' +
                                                        'V8' +
                                                        '315' +
                                                        'ce', _Q5AnJ = [[27, 29]];
                                                    for (var i = 0; i < _Q5AnJ.length; i++) {
                                                        _jWRe = _jWRe.substring(0, _Q5AnJ[i][0]) + _jWRe.substring(_Q5AnJ[i][1]);
                                                    }
                                                    return _jWRe;
                                                })();
                                                f.appendChild(input);
                                                input = document.createElement('input');
                                                input.type = 'hidden';
                                                input.name = 'checkReferer';
                                                input.value = 'false';
                                                f.appendChild(input);
                                                added = true;
                                            }
                                        });
                                    }
                                }
                            }
                        };

                        $('#submit').click(function () {
                            var from_data = $('#comment_form').serializeArray();
                            var data = [];
                            $.each(from_data,function(i){
                                data[from_data[i].name] = from_data[i].value;
                            });

                            data = array_to_object(data);
                            var add_url="<?= \yii\helpers\Url::toRoute(['index/guest'])?>";
                            if(data){
                                ajax_post(add_url,data,function (re) {
                                    check_data(re,1);
                                    if(re.ecode==200){
                                        msg(re.msg,200);
                                        location.reload();
                                    }
                                });
                            }else{
                                return msg('请填写资料',201);
                            }
                        });
                    </script>

                </div>
            </div>
