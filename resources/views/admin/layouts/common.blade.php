@extends('admin.layouts.layouts')
@section('body')
    <nav class="navbar navbar-back navbar-inverse navbar-fixed-top admin-nav">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand admin-title" href="/admin">后台管理系统</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                @include('admin.layouts.widgets.header')
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth() -> check())
                        {{--登录成功后，显示登录用户昵称及头像--}}
                        <li class="back-login-user-info">
                            <a class="back-edit-user-info" href="/admin/user/{{ Auth::user() -> id }}"><i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user() -> name }}</a>
                            <a class="redirect-to-frontend" href="/" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> 前台首页</a>
                            <a class="back-login-user-logout" href="/logout"><i class="fa fa-power-off" aria-hidden="true"></i> 退出</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="main">
        <div class="admin-sidebars">
            @include('admin.layouts.widgets.sidebar')
        </div>
        <div class="admin-right-side">
            @yield('breadcrumb')
            <div class="content-list">
                <div class="notify-area">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissable fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {!! session('success') !!}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissable fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {!! session('error') !!}
                        </div>
                    @endif
                </div>
                @yield('content')
            </div>
        </div>
    </div>
@endsection