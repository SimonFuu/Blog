@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/contents/articles">内容管理</a></li>
        <li><a href="/admin/contents/articles">文章管理</a></li>
        <li class="active">{{ $type == 0 ? '发布' : '编辑' }}文章</li>
    </ol>
@endsection
@section('content')
    <link href="//cdn.bootcss.com/smalot-bootstrap-datetimepicker/2.4.4/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/wangeditor/2.1.20/css/wangEditor.min.css" rel="stylesheet">
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
    {!! Form::open(['url' => '/admin/contents/articles/store', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
        <!-- class include {'form-horizontal'|'form-inline'} -->
        <!--- Title Field --->
        <div class="form-group {{ $errors -> has('title') || $errors -> has('id') ? 'has-error' : ''}}">
            {!! Form::label('title', '标题:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-5">
                {!! Form::text('title', is_null($article) ? null : $article -> title, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-5">
                <span class="help-block">
                    <strong>
                        @if($errors -> has('title'))
                            {{ $errors -> first('title') }}
                        @elseif($errors -> has('id'))
                            {{ $errors -> first('id') }}
                        @endif
                    </strong>
                </span>
            </div>
        </div>
        <!--- CatalogId Field --->
        <div class="form-group {{ $errors -> has('catalogId') ? 'has-error' : ''}}">
            {!! Form::label('catalogId', '目录:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-5">
                {!! Form::select('catalogId', $catalogs, is_null($article) ? null : $article -> catalogId, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-1">
                <a href="/admin/contents/catalogs" class="btn btn-info">添加目录</a>
            </div>
            <div class="col-md-3 button-right-errors-bag">
                <span class="help-block">
                    <strong>
                        {{ $errors -> first('catalogId') }}
                    </strong>
                </span>
            </div>
        </div>
        <!--- TagID Field --->
        <div class="form-group {{ $errors -> has('tagId') ? 'has-error' : ''}}">
            {!! Form::label('tagId', '标签:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-5">
                {!! Form::select('tagId', $tags, is_null($article) ? null : $article -> tagId, ['class' => 'form-control article-tags']) !!}
            </div>
            <div class="col-md-1">
                <a href="/admin/contents/tags" class="btn btn-info">添加标签</a>
            </div>
            <div class="col-md-3 button-right-errors-bag">
                <span class="help-block">
                    <strong>
                        {{ $errors -> first('tagId') }}
                    </strong>
                </span>
            </div>
        </div>
        <!--- PublishedAt Field --->
        <div class="form-group {{ $errors -> has('publishedAt') ? 'has-error' : ''}}">
            {!! Form::label('publishedAt', '发布时间:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-5">
                {!! Form::text('publishedAt', is_null($article) ? date('Y-m-d H:i:00') : $article -> publishedAt, ['class' => 'form-control', 'readonly', 'id' => 'articlePublishedAt']) !!}
            </div>
            <div class="col-md-5">
                <span class="help-block">
                    <strong>
                        {{ $errors -> first('publishedAt') }}
                    </strong>
                </span>
            </div>
        </div>
        <!--- Abstract Field --->
        <div class="form-group {{ $errors -> has('abstract') ? 'has-error' : ''}}">
            {!! Form::label('abstract', '摘要:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-5">
                {!! Form::textarea('abstract', is_null($article) ? null : $article -> abstractContent, ['class' => 'form-control', 'rows' => 3, 'placeholder' => '如不填写，则自动获取文章内容的部分文字']) !!}
            </div>
            <div class="col-md-5">
                <span class="help-block">
                    <strong>
                        {{ $errors -> first('abstract') }}
                    </strong>
                </span>
            </div>
        </div>
        <!--- Abstract Field --->
        <div class="form-group {{ $errors -> has('content') ? 'has-error' : ''}}">
            {!! Form::label('content', '内容:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-8">
                {!! Form::textarea('content', is_null($article) ? null : $article -> content, ['class' => 'form-control', 'rows' => 20, 'id' => 'article-content']) !!}
            </div>
            <div class="col-md-2">
                <span class="help-block">
                    <strong>
                        {{ $errors -> first('content') }}
                    </strong>
                </span>
            </div>
        </div>
        <div class="col-md-offset-2 submit-buttons">
            <button class="btn btn-primary" type="submit">提交</button>
            <a href="/admin/contents/articles" class="btn btn-default">返回</a>
        </div>
        <!--- Id Field --->
        @if($type != 0)
            <div class="form-group hidden">
                {!! Form::hidden('id', is_null($article) ? null : $article -> id, ['class' => 'form-control']) !!}
            </div>
        @endif
    {!! Form::close() !!}
    <script src="//cdn.bootcss.com/smalot-bootstrap-datetimepicker/2.4.4/js/bootstrap-datetimepicker.min.js"></script>
    <script src="//cdn.bootcss.com/smalot-bootstrap-datetimepicker/2.4.4/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
    <script src="//cdn.bootcss.com/wangeditor/2.1.20/js/wangEditor.min.js"></script>
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script src="//cdn.bootcss.com/select2/4.0.3/js/i18n/zh-CN.js"></script>
    <script>
        $(window).ready(function () {
            articleFormDateTimePicker();
            $(".article-tags").select2();
            @if(env('APP_ENV') == 'production')
                wangEditor.config.printLog = false;
            @endif
            var editor = new wangEditor('article-content');
            var token = $('input[name="_token"]').val();
            editor.config.uploadParams = {
                '_token': token
            };
            editor.config.uploadImgFns.ontimeout = function (xhr) {
                alert('上传超时，请重试！');
            };
            editor.config.uploadImgFns.onload = function (resultText, xhr) {
                editor.command(null, 'insertHtml', '<img class="content-images" src="' + resultText + '"/>');
            };
            editor.config.uploadImgUrl = '/admin/upload/images';
            editor.config.uploadImgFileName = 'images';
            editor.config.hideLinkImg = true;
            editor.config.menus = [
                'source', '|', 'bold', 'underline', 'italic', 'strikethrough', 'eraser', 'forecolor', 'bgcolor', '|',
                'indent', 'lineheight', 'quote', 'fontfamily', 'fontsize', 'head', 'unorderlist', 'orderlist', 'alignleft',
                'aligncenter', 'alignright', '|', 'link', 'unlink', 'table', 'emotion', '|', 'img', 'video', 'location',
                'insertcode', '|', 'undo', 'redo', 'fullscreen'
            ];
            editor.config.emotions = {
                'default': {
                    title: '默认',
                    data: [
                        {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/ac/smilea_thumb.gif",
                            'value' : "[呵呵]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/0b/tootha_thumb.gif",
                            'value' : "[嘻嘻]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/6a/laugh.gif",
                            'value' : "[哈哈]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/14/tza_thumb.gif",
                            'value' : "[可爱]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/af/kl_thumb.gif",
                            'value' : "[可怜]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/a0/kbsa_thumb.gif",
                            'value' : "[挖鼻屎]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/f4/cj_thumb.gif",
                            'value' : "[吃惊]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/6e/shamea_thumb.gif",
                            'value' : "[害羞]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/c3/zy_thumb.gif",
                            'value' : "[挤眼]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/29/bz_thumb.gif",
                            'value' : "[闭嘴]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/71/bs2_thumb.gif",
                            'value' : "[鄙视]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/6d/lovea_thumb.gif",
                            'value' : "[爱你]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/9d/sada_thumb.gif",
                            'value' : "[泪]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/19/heia_thumb.gif",
                            'value' : "[偷笑]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/8f/qq_thumb.gif",
                            'value' : "[亲亲]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/b6/sb_thumb.gif",
                            'value' : "[生病]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/58/mb_thumb.gif",
                            'value' : "[太开心]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/17/ldln_thumb.gif",
                            'value' : "[懒得理你]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/98/yhh_thumb.gif",
                            'value' : "[右哼哼]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/6d/zhh_thumb.gif",
                            'value' : "[左哼哼]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/a6/x_thumb.gif",
                            'value' : "[嘘]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/af/cry.gif",
                            'value' : "[衰]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/73/wq_thumb.gif",
                            'value' : "[委屈]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/9e/t_thumb.gif",
                            'value' : "[吐]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/f3/k_thumb.gif",
                            'value' : "[打哈欠]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/27/bba_thumb.gif",
                            'value' : "[抱抱]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/7c/angrya_thumb.gif",
                            'value' : "[怒]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/5c/yw_thumb.gif",
                            'value' : "[疑问]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/a5/cza_thumb.gif",
                            'value' : "[馋嘴]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/70/88_thumb.gif",
                            'value' : "[拜拜]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/e9/sk_thumb.gif",
                            'value' : "[思考]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/24/sweata_thumb.gif",
                            'value' : "[汗]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/7f/sleepya_thumb.gif",
                            'value' : "[困]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/6b/sleepa_thumb.gif",
                            'value' : "[睡觉]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/90/money_thumb.gif",
                            'value' : "[钱]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/0c/sw_thumb.gif",
                            'value' : "[失望]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/40/cool_thumb.gif",
                            'value' : "[酷]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/8c/hsa_thumb.gif",
                            'value' : "[花心]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/49/hatea_thumb.gif",
                            'value' : "[哼]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/36/gza_thumb.gif",
                            'value' : "[鼓掌]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/d9/dizzya_thumb.gif",
                            'value' : "[晕]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/1a/bs_thumb.gif",
                            'value' : "[悲伤]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/62/crazya_thumb.gif",
                            'value' : "[抓狂]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/91/h_thumb.gif",
                            'value' : "[黑线]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/6d/yx_thumb.gif",
                            'value' : "[阴险]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/89/nm_thumb.gif",
                            'value' : "[怒骂]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/40/hearta_thumb.gif",
                            'value' : "[心]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/ea/unheart.gif",
                            'value' : "[伤心]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/58/pig.gif",
                            'value' : "[猪头]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/d6/ok_thumb.gif",
                            'value' : "[ok]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/d9/ye_thumb.gif",
                            'value' : "[耶]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/d8/good_thumb.gif",
                            'value' : "[good]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/c7/no_thumb.gif",
                            'value' : "[不要]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/d0/z2_thumb.gif",
                            'value' : "[赞]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/40/come_thumb.gif",
                            'value' : "[来]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/d8/sad_thumb.gif",
                            'value' : "[弱]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/91/lazu_thumb.gif",
                            'value' : "[蜡烛]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/6a/cake.gif",
                            'value' : "[蛋糕]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/d3/clock_thumb.gif",
                            'value' : "[钟]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/1b/m_thumb.gif",
                            'value' : "[话筒]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/7a/shenshou_thumb.gif",
                            'value' : "[草泥马]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/60/horse2_thumb.gif",
                            'value' : "[神马]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/bc/fuyun_thumb.gif",
                            'value' : "[浮云]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/c9/geili_thumb.gif",
                            'value' : "[给力]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/f2/wg_thumb.gif",
                            'value' : "[围观]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/70/vw_thumb.gif",
                            'value' : "[威武]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/6e/panda_thumb.gif",
                            'value' : "[熊猫]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/81/rabbit_thumb.gif",
                            'value' : "[兔子]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/bc/otm_thumb.gif",
                            'value' : "[奥特曼]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/15/j_thumb.gif",
                            'value' : "[囧]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/89/hufen_thumb.gif",
                            'value' : "[互粉]"
                        }, {
                            'icon' : "http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/c4/liwu_thumb.gif",
                            'value' : "[礼物]"
                        }
                    ]
                }
            };
            editor.create();
        });
    </script>
@endsection