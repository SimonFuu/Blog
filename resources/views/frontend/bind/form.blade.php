@extends('frontend.bind.common')
@section('bind-body')
    {!! Form::open(['url' => '/user/bind', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
        <!-- class include {'form-horizontal'|'form-inline'} -->
        <div class="form-group user-bind-page-tip">
            <label>您正在使用：<i class="fa fa-2x fa-{{ $source }} widget-{{ $source }}"></i></label>
        </div>
        <!--- Name Field --->
        <div class="form-group {{ $errors -> has('name') ? 'has-error' : ''}}">
            <label class="control-label" for="name">昵称：<span class="must-be-input">*</span></label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $name }}">
        </div>
        <!--- Email Field --->
        <div class="form-group {{ $errors -> has('email') ? 'has-error' : ''}}">
            <label class="control-label" for="email">邮箱：<span class="must-be-input">*</span></label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $email }}">
        </div>
        <div class="form-group">
            <p class="text-danger">注意：</p>
            <p class="text-danger" style="text-indent: 2em">如输入的邮箱已经存在，绑定验证通过后，将合并两个账户的数据！</p>
        </div>
        <div class="form-group">
            <button class="btn btn-primary form-control user-bind-page-submit">提&nbsp;&nbsp;交</button>
        </div>
        <input type="hidden" name="avatar" value="{{ $avatar }}">
        <input type="hidden" name="source" value="{{ $source }}">
        <input type="hidden" name="oId" value="{{ $oId }}">
    {!! Form::close() !!}
@endsection