@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/contents/articles">内容管理</a></li>
        <li class="active">目录分类</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <h4>添加新的目录分类</h4>
            {!! Form::open(['url' => '/admin/contents/catalogs/store', 'method' => 'post', 'class' => 'form-horizontal list-form', 'role' => 'form']) !!}
                <!-- class include {'form-horizontal'|'form-inline'} -->
                <!--- Name Field --->
                <div class="form-group {{ $errors -> has('name') ? ' has-error': '' }}">
                    {!! Form::label('name', '名称:', ['class' => 'control-label ']) !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                @if($errors -> has('name'))
                    <div class="errorMessages">
                        <span class="help-block alert-danger">
                            <strong>{{ $errors -> first('name') }}</strong>
                        </span>
                    </div>
                @endif
                <!--- DisplayWeight Field --->
                <div class="form-group {{ $errors -> has('displayWeight') ? ' has-error': '' }}">
                    {!! Form::label('displayWeight', '展示权重:', ['class' => 'control-label']) !!}
                    {!! Form::number('displayWeight', 100, ['class' => 'form-control']) !!}
                </div>
                @if($errors -> has('displayWeight'))
                    <div class="errorMessages">
                        <span class="help-block alert-danger">
                            <strong>{{ $errors -> first('displayWeight') }}</strong>
                        </span>
                    </div>
                @endif
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
                        <th>展示权重</th>
                        <th>文章数量</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($catalogs as $catalog)
                        <tr>
                            <td>
                                <a href="/admin/contents/articles?catalog={{ $catalog -> id }}">
                                    {{ $catalog -> name }} {{ $catalog -> id == 1 ? '（default）' : '' }}
                                </a>
                            </td>
                            <td>{{ $catalog -> displayWeight }}</td>
                            <td>
                                <a href="/admin/contents/articles?catalog={{ $catalog -> id }}">
                                    {{ $catalog -> articlesCount }}
                                </a>
                            </td>
                            <td class="edit-action">
                                @if($catalog -> id !== 1)
                                    <a href="/admin/contents/catalogs/edit/{{ $catalog -> id }}" title="编辑">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    </a>
                                    <a href="/admin/contents/catalogs/delete/{{ $catalog -> id }}" class="del-actions" title="删除">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection