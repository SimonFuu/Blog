@extends('backend.layouts.layouts')
@section('body')
    <nav class="navbar navbar-back navbar-inverse navbar-fixed-top backend-nav">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand backend-title" href="/backend">后台管理系统</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                @include('backend.layouts.widgets.header')
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth() -> check())
                        {{--登录成功后，显示登录用户昵称及头像--}}
                        <li class="back-login-user-info">
                            <a href=""><i class="fa fa-bell-o" aria-hidden="true"></i></a>
                            <a class="back-edit-user-info" href="/backend/user/{{ Auth::user() -> id }}"><i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user() -> name }}</a>
                            <a class="redirect-to-frontend" href="/" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> 前台首页</a>
                            <a class="back-login-user-logout" href="/logout"><i class="fa fa-power-off" aria-hidden="true"></i> 退出</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="main">
        <div class="backend-sidebars">
            @include('backend.layouts.widgets.sidebar')
        </div>
        <div class="backend-content">
            @yield('breadcrumb')
            <div class="content-list">
                @yield('content')
            </div>
        </div>
    </div>
@endsection