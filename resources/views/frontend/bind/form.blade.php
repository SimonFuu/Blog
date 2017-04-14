@extends('frontend.bind.common')
@section('bind-body')
    {!! Form::open(['url' => '/user/bind', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
    <!-- class include {'form-horizontal'|'form-inline'} -->
    <div class="form-group user-bind-page-tip">
        <label>您正在使用：<i class="fa fa-2x fa-{{ $source }} widget-{{ $source }}"></i></label>
    </div>
    <!--- Name Field --->
    <div class="form-group">
        <label for="name">昵称：<span class="must-be-input">*</span></label>
        <input type="text" id="name" name="name" class="form-control" value="{{ $name }}">
    </div>
    <!--- Email Field --->
    <div class="form-group">
        <label for="email">邮箱：<span class="must-be-input">*</span></label>
        <input type="email" id="email" name="email" class="form-control" value="{{ $email }}">
    </div>
    <div class="form-group">
        <button class="btn btn-primary form-control user-bind-page-submit">提&nbsp;&nbsp;交</button>
    </div>
    <input type="hidden" name="avatar" value="{{ $avatar }}">
    <input type="hidden" name="source" value="{{ $source }}">
    <input type="hidden" name="oId" value="{{ $oId }}">
    {!! Form::close() !!}
@endsection