@extends('admin.layouts.common')
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="active">首页</li>
    </ol>
@endsection
@section('content')
    <div class="jumbotron welcome-page">
        <h2>欢迎使用博客后台管理系统</h2>
        <p>本系统及前端页面基于Laravel开发，请到Github首页了解了解系统详情！</p>
        <p><a class="btn btn-primary" href="https://github.com/simonfuu/blog" target="_blank" role="button">Github首页</a></p>
    </div>
@endsection