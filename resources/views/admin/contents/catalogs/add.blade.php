@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/admin/contents/articles">内容管理</a></li>
        <li><a href="/admin/contents/catalogs">目录分类</a></li>
        <li class="active">编辑目录</li>
    </ol>
@endsection
@section('content')
    {!! Form::open(['url' => '/admin/contents/catalogs/store', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
        <!-- class include {'form-horizontal'|'form-inline'} -->
        <!--- Title Field --->
        <div class="form-group {{ $errors -> has('name') || $errors -> has('id') ? 'has-error' : ''}}">
            {!! Form::label('name', '标题:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-3">
                {!! Form::text('name', is_null($catalog) ? null : $catalog -> name, ['class' => 'form-control']) !!}
            </div>
            @if($errors -> has('name'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('name') }}</strong>
                    </span>
                </div>
            @elseif($errors -> has('id'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('id') }}</strong>
                    </span>
                </div>
            @endif
        </div>
        <!--- Title Field --->
        <div class="form-group {{ $errors -> has('displayWeight') ? 'has-error' : ''}}">
            {!! Form::label('displayWeight', '权重:', ['class' => 'control-label col-md-1']) !!}
            <div class="col-md-3">
                {!! Form::text('displayWeight', is_null($catalog) ? null : $catalog -> displayWeight, ['class' => 'form-control']) !!}
            </div>
            @if($errors -> has('displayWeight'))
                <div class="col-md-5">
                    <span class="help-block">
                        <strong>{{ $errors -> first('displayWeight') }}</strong>
                    </span>
                </div>
            @endif
        </div>
        <div class="col-md-offset-2 submit-buttons">
            <button class="btn btn-primary" type="submit">提交</button>
            <a href="/admin/contents/catalogs" class="btn btn-default">返回</a>
        </div>
        <div class="form-group hidden">
            {!! Form::hidden('id', is_null($catalog) ? null : $catalog -> id, ['class' => 'form-control']) !!}
        </div>
    {!! Form::close() !!}
@endsection