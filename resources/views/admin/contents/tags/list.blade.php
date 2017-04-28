@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/contents/articles">内容管理</a></li>
        <li class="active">文章标签</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <h4>添加新标签</h4>
            {!! Form::open(['url' => '/admin/contents/tags/store', 'method' => 'post', 'class' => 'form-horizontal list-form', 'role' => 'form']) !!}
                <!-- class include {'form-horizontal'|'form-inline'} -->
                <!--- Name Field --->
                <div class="form-group">
                    {!! Form::label('name', '名称:', ['class' => 'control-label ']) !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">提交</button>
                </div>

            {!! Form::close() !!}
        </div>
        <div class="col-md-8">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>名称</th>
                        <th>文章数量</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>
                                <a href="/admin/contents/articles?tag={{ $tag -> id }}">
                                    {{ $tag -> name }}
                                </a>
                            </td>
                            <td>
                                <a href="/admin/contents/articles?tag={{ $tag -> id }}">
                                    {{ $tag -> articlesCount }}
                                </a>
                            </td>
                            <td class="edit-action">
                                <a href="/admin/contents/tags/edit/{{ $tag -> id }}" title="编辑">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <a href="/admin/contents/tags/delete{{ $tag -> id }}" title="删除">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection