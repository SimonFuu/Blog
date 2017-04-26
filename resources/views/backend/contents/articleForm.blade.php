@extends('backend.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/backend/articles">内容管理</a></li>
        <li><a href="/backend/articles">文章管理</a></li>
        <li class="active">{{ $type == 0 ? '发布' : '编辑' }}文章</li>
    </ol>
@endsection
@section('content')
    <link href="//cdn.bootcss.com/smalot-bootstrap-datetimepicker/2.4.4/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/assets/plugins/wangEditor/css/wangEditor.min.css" rel="stylesheet">
    {!! Form::open(['url' => '/backend/articles/store', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
        <!-- class include {'form-horizontal'|'form-inline'} -->
        <!--- Title Field --->
        <div class="form-group {{ $errors -> has('title') || $errors -> has('id') ? 'has-error' : ''}}">
            {!! Form::label('title', '标题:', ['class' => 'control-label col-md-2']) !!}
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
            {!! Form::label('catalogId', '目录:', ['class' => 'control-label col-md-2']) !!}
            <div class="col-md-5">
                {!! Form::select('catalogId', $catalogs, is_null($article) ? null : $article -> catalogId, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-1">
                <a href="" class="btn btn-info">添加目录</a>
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
            {!! Form::label('tagId', '标签:', ['class' => 'control-label col-md-2']) !!}
            <div class="col-md-5">
                {!! Form::select('tagId', $tags, is_null($article) ? null : $article -> tagId, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-1">
                <a href="" class="btn btn-info">添加标签</a>
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
            {!! Form::label('publishedAt', '发布时间:', ['class' => 'control-label col-md-2']) !!}
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
            {!! Form::label('abstract', '摘要:', ['class' => 'control-label col-md-2']) !!}
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
            {!! Form::label('content', '内容:', ['class' => 'control-label col-md-2']) !!}
            <div class="col-md-8">
                {!! Form::textarea('content', is_null($article) ? null : $article -> content, ['class' => 'form-control', 'rows' => 15, 'id' => 'article-content']) !!}
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
            <a href="/backend/articles" class="btn btn-default">返回</a>
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
    <script src="/assets/plugins/wangEditor/js/wangEditor.min.js"></script>
    <script>
        $(window).ready(function () {
            articleFormDateTimePicker();
            var editor = new wangEditor('article-content');
            // 上传图片（举例）
            editor.config.uploadImgUrl = '/backend/file/upload';
            editor.config.uploadImgFileName = 'images';
            // 隐藏掉插入网络图片功能。该配置，只有在你正确配置了图片上传功能之后才可用。
            editor.config.hideLinkImg = true;
            editor.create();
        });
    </script>
@endsection