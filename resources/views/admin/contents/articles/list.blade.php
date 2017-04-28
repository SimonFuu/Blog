@php($now = date('Y-m-d H:i:s'))
@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/contents/articles">内容管理</a></li>
        <li><a href="/admin/contents/articles">文章管理</a></li>
        <li class="active">文章列表</li>
    </ol>
@endsection
@section('content')
    <link href="//cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <div class="search-header">
        {!! Form::open(['url' => '/admin/contents/articles', 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
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
            <div class="checkbox">
                <label class="isRecommendPosts">
                    <input type="checkbox" name="isRecommend" {{ isset($defaults['default']['isRecommend']) ? 'checked' : ''}}> 置顶
                </label>
            </div>
            <button class="btn btn-primary">查询</button>
            <a class="btn btn-success" href="/admin/contents/articles/add">发布</a>
        {!! Form::close() !!}
    </div>
    <hr>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th style="width: 200px">
                    标题
                </th>
                <th style="width: 50px">
                    作者
                </th>
                <th style="width: 50px">
                    分类
                </th>
                <th style="width: 50px">
                    标签
                </th>
                <th style="width: 50px">
                    权重
                </th>
                <th style="width: 150px">
                    发布时间
                </th>
                <th style="width: 150px">
                    创建时间
                </th>
                <th style="width: 70px">
                    操作
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr class="{{ $article -> recommendTo > $now ? 'stick-article success' : '' }}">
                    <td>
                        <a href="/article/{{ $article -> id }}" target="_blank">{{ $article -> title }}</a>
                    </td>
                    <td>{{ $article -> author }}</td>
                    <td>{{ $article -> catalog }}</td>
                    <td>{{ $article -> tag }}</td>
                    <td>{{ $article -> weight }}</td>
                    <td>{{ $article -> publishedAt }}</td>
                    <td>{{ $article -> createdAt }}</td>
                    <td class="edit-action">
                        @if($article -> recommendTo < $now)
                            <a href="#" class="stick-article-button" title="置顶" data-toggle="modal" data-target="#stickArticleWeight"
                               data-article-id="{{ $article -> id }}" data-article-title="{{ $article -> title }}"
                               data-article-weight="{{ $article -> weight }}">
                                <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                            </a>
                        @else
                            <a href="/admin/contents/articles/un-stick/{{ $article -> id }}" title="取消置顶"><i class="fa fa-times" aria-hidden="true"></i></a>
                        @endif
                        <a href="/admin/contents/articles/edit/{{ $article -> id }}" title="编辑"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <a href="/admin/contents/articles/delete/{{ $article -> id }}" title="删除"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $articles -> appends(is_null($defaults['pagination']) ? null : $defaults['pagination']) -> links() }}
    </div>
    <div class="modal fade" id="stickArticleWeight" tabindex="-1" role="dialog" aria-labelledby="stickArticleWeightLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="stickArticleWeightLabel">文章置顶</h4>
                </div>
                {!! Form::open(['url' => '/admin/contents/articles/stick', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                    <!-- class include {'form-horizontal'|'form-inline'} -->
                    <div class="modal-body stickArticleWeightForm">
                        <!--- Title Field --->
                        <div class="form-group {{ $errors -> has('id') ? 'has-error' : '' }}">
                            {!! Form::label('title', '标题:', ['class' => 'control-label']) !!}
                            {!! Form::text('title', null, ['class' => 'form-control toStickArticleTitle', 'readonly']) !!}
                        </div>
                        <!--- Weight Field --->
                        <div class="form-group {{ $errors -> has('weight') ? 'has-error' : '' }}">
                            {!! Form::label('weight', '权重:', ['class' => 'control-label']) !!}
                            {!! Form::number('weight', null, ['class' => 'form-control toStickArticleWeight']) !!}
                        </div>
                        <!--- Weight Field --->
                        <div class="form-group {{ $errors -> has('recommendTo') ? 'has-error' : '' }}">
                            {!! Form::label('recommendTo', '推荐结束时间:', ['class' => 'control-label']) !!}
                            {!! Form::text('recommendTo', date('Y-m-d'), ['class' => 'form-control toStickArticleTimeTo', 'readonly']) !!}
                        </div>
                        <!--- Id Field --->
                        <div class="form-group hidden">
                            {!! Form::hidden('id', null, ['class' => 'form-control toStickArticleId']) !!}
                        </div>
                        @if ($errors->has('id'))
                            <div class="stickArticleErrorMessage">
                                <span class="help-block alert-danger">
                                    <strong>{{ $errors->first('id') }}</strong>
                                </span>
                            </div>
                        @elseif($errors->has('weight'))
                            <div class="stickArticleErrorMessage">
                                <span class="help-block alert-danger">
                                    <strong>{{ $errors->first('weight') }}</strong>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script src="//cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/js/bootstrap-datepicker.min.js"></script>
    <script src="//cdn.bootcss.com/bootstrap-datepicker/1.7.0-RC2/locales/bootstrap-datepicker.zh-CN.min.js"></script>
    <script>
        $(window).ready(function () {
            searchFormDatePicker();
            $('#stickArticleWeight').on('show.bs.modal', function () {
                stickArticleDatePicker();
            });
            @if($errors->has('id') || $errors->has('weight'))
                $('#stickArticleWeight').modal('show');
            @endif
        });
    </script>
@endsection