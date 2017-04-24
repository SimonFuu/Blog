@extends('backend.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/backend/articles">内容管理</a></li>
        <li><a href="/backend/articles">文章管理</a></li>
        <li class="active">文章列表</li>
    </ol>
@endsection

@section('content')
    <link href="//cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <div class="search-header">
        {!! Form::open(['url' => '/backend/articles', 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
        <!-- class include {'form-horizontal'|'form-inline'} -->
            <!--- Title Field --->
            <div class="form-group">
                {!! Form::label('title', '标题:') !!}
                {!! Form::text('title', isset($defaults['default']['title']) ? $defaults['default']['title'] : null,
                    ['class' => 'form-control']) !!}
            </div>
            <!--- Catalog Field --->
            <div class="form-group">
                {!! Form::label('catalog', '目录:') !!}
                {!! Form::select('catalog', $catalogs, isset($defaults['default']['catalog']) ?
                    $defaults['default']['catalog'] : null, ['class' => 'form-control']) !!}
            </div>
            <!--- Tag Field --->
            <div class="form-group">
                {!! Form::label('tag', '标签:') !!}
                {!! Form::select('tag', $tags, isset($defaults['default']['tag']) ? $defaults['default']['tag'] : null,
                    ['class' => 'form-control']) !!}
            </div>
            <!--- Start Field --->
            <div class="form-group">
                {!! Form::label('start', '发布时间:') !!}
                {!! Form::text('start', isset($defaults['default']['start']) ? $defaults['default']['start'] : null,
                    ['class' => 'form-control article-publish-time', 'id' => 'article-publish-start', 'readonly']) !!}
            </div>
            <!--- End Field --->
            <div class="form-group">
                {!! Form::label('end', '-') !!}
                {!! Form::text('end', isset($defaults['default']['end']) ? $defaults['default']['end'] : null,
                    ['class' => 'form-control article-publish-time', 'id' => 'article-publish-end', 'readonly']) !!}
            </div>
            <button class="btn btn-primary">查询</button>
        {!! Form::close() !!}
    </div>
    <hr>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th width="100">
                    标题
                </th>
                <th width="40">
                    作者
                </th>
                <th width="40">
                    目录分类
                </th>
                <th width="40">
                    标签
                </th>
                <th width="40">
                    显示权重
                </th>
                <th width="100">
                    发布时间
                </th>
                <th width="100">
                    创建时间
                </th>
                <th width="40">
                    操作
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr>
                    <td><a href="/article/{{ $article -> id }}" target="_blank">{{ $article -> title }}</a></td>
                    <td>{{ $article -> author }}</td>
                    <td>{{ $article -> catalog }}</td>
                    <td>{{ $article -> tag }}</td>
                    <td>{{ $article -> weight }}</td>
                    <td>{{ $article -> publishedAt }}</td>
                    <td>{{ $article -> createdAt }}</td>
                    <td class="edit-action">
                        @if($article -> weight >= 1000)
                            <a href="" title="置顶"><i class="fa fa-thumb-tack" aria-hidden="true"></i></a>
                        @else
                            <a href="/backend/articles/un-top/{{ $article -> id }}" title="取消置顶"><i class="fa fa-times" aria-hidden="true"></i></a>
                        @endif
                        <a href="/backend/articles/edit/{{ $article -> id }}" title="编辑"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="/backend/articles/delete/{{ $article -> id }}" title="删除"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $articles -> appends(is_null($defaults['pagination']) ? null : $defaults['pagination']) -> links() }}
    </div>
    <script src="//cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/js/bootstrap-datepicker.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/locales/bootstrap-datepicker.zh-CN.min.js"></script>
    <script>

    </script>
@endsection