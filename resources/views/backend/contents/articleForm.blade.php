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
    {!! Form::open(['url' => '/backend/articles/add', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
        <!-- class include {'form-horizontal'|'form-inline'} -->
        <!--- Title Field --->
        <div class="form-group">
            {!! Form::label('title', '标题:', ['class' => 'control-label col-md-2']) !!}
            <div class="col-md-5">
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <!--- CatalogId Field --->
        <div class="form-group">
            {!! Form::label('catalogId', '目录:', ['class' => 'control-label col-md-2']) !!}
            <div class="col-md-5">
                {!! Form::select('catalogId', ['foo' => 'bar'], null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <!--- TagID Field --->
        <div class="form-group">
            {!! Form::label('tagId', '标签:', ['class' => 'control-label col-md-2']) !!}
            <div class="col-md-5">
                {!! Form::select('tagId', ['foo' => 'bar'], null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <!--- PublishedAt Field --->
        <div class="form-group">
            {!! Form::label('publishedAt', '发布时间:', ['class' => 'control-label col-md-2']) !!}
            <div class="col-md-5">
                {!! Form::text('publishedAt', date('Y-m-d H:i:00'), ['class' => 'form-control', 'readonly', 'id' => 'articlePublishedAt']) !!}
            </div>
        </div>
        <!--- Abstract Field --->
        <div class="form-group">
            {!! Form::label('abstract', '摘要:', ['class' => 'control-label col-md-2']) !!}
            <div class="col-md-5">
                {!! Form::textarea('abstract', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
        </div>
    {!! Form::close() !!}
    <script src="//cdn.bootcss.com/smalot-bootstrap-datetimepicker/2.4.4/js/bootstrap-datetimepicker.min.js"></script>
    <script src="//cdn.bootcss.com/smalot-bootstrap-datetimepicker/2.4.4/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>
    <script>
        $(window).ready(function () {
            articleFormDateTimePicker();
        });
    </script>
@endsection