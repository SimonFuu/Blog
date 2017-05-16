@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/comments/list">评论管理</a></li>
        <li class="active">评论列表</li>
    </ol>
@endsection
@section('content')
    <link href="//cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <div class="search-header">
    {!! Form::open(['url' => '/admin/comments/list', 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
    <!-- class include {'form-horizontal'|'form-inline'} -->
        <!--- User Field --->
        <div class="form-group">
            {!! Form::label('name', '评论人:', ['class' => 'control-label']) !!}
            {!! Form::text('name', isset($defaults['default']['name']) ? $defaults['default']['name'] : null,
                ['class' => 'form-control']) !!}
        </div>
        <!--- Comment Field --->
        <div class="form-group">
            {!! Form::label('comment', '评论内容:') !!}
            {!! Form::text('comment', isset($defaults['default']['comment']) ? $defaults['default']['comment'] : null,
                ['class' => 'form-control']) !!}
        </div>
        <!--- Title Field --->
        <div class="form-group">
            {!! Form::label('title', '文章标题:') !!}
            {!! Form::text('title', isset($defaults['default']['title']) ? $defaults['default']['title'] : null,
                ['class' => 'form-control']) !!}
        </div>
        <button class="btn btn-primary">查询</button>
        {!! Form::close() !!}
    </div>
    <hr>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
        <tr>
            <th style="width: 50px">
                评论人
            </th>
            <th style="width: 200px">
                评论内容
            </th>
            <th style="width: 100px">
                文章标题
            </th>
            <th style="width: 50px">
                发布时间
            </th>
            <th style="width: 50px">
                操作
            </th>
        </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
                <tr>
                    <td>
                        {{ $comment -> name }}
                    </td>
                    <td>
                        {{ $comment -> content }}
                    </td>
                    <td>
                        <a href="/article/{{ $comment -> aId }}" target="_blank">{{ $comment -> title }}</a>
                    </td>
                    <td>
                        {{ $comment -> createdAt }}
                    </td>
                    <td>
                        <a href="/admin/comments/delete/{{ $comment -> cId }}" title="删除"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $comments -> appends(is_null($defaults['pagination']) ? null : $defaults['pagination']) -> links() }}
    </div>
@endsection