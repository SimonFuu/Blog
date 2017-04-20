@extends('frontend.layouts.layouts')
@section('body')
    @include('frontend.layouts.widgets.navigation')
    <div class="body">
        <div class="container">
            <div class="notify-area">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissable fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {!! session('success') !!}
                    </div>
                    <script>
                        setTimeout(function () {
                            $('.alert').alert('close')
                        }, 2000);
                    </script>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissable fade in">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {!! session('error') !!}
                    </div>
                    <script>
                        setTimeout(function () {
                            $('.alert').alert('close')
                        }, 4000);
                    </script>
                @endif
            </div>
            <div class="row">
                <div class="main-container col-md-8">
                    @yield('content')
                </div>
                <div class="main-container col-md-4">
                    @include('frontend.layouts.widgets.sidebar')
                </div>
            </div>
        </div>
    </div>

    <div class="toTop hidden">
        <i class="fa fa-2x fa-arrow-up" aria-hidden="true"></i>
    </div>
    @include('frontend.layouts.widgets.footer')
    @if(!Auth::check())
        {{--登录模态框--}}
        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-label">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="login-modal-label">请登录</h4>
                    </div>
                    <div class="modal-body">
                        <div class="login-form">
                            <div class="login-form-div">
                                <form action="/login" method="post">
                                    <div class="input-group input-group-md form-group{{ ($errors->has('username') || $errors->has('password')) ? ' has-error' : '' }}">
                                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        <input type="text" name="username" class="form-control" placeholder="邮箱" value="" aria-describedby="sizing-addon1">
                                    </div>
                                    <div class="input-group input-group-md form-group{{ ($errors->has('username') || $errors->has('password')) ? ' has-error' : '' }}">
                                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-lock"></i></span>
                                        <input type="password" name="password" class="form-control" placeholder="密码" value="" aria-describedby="sizing-addon1">
                                    </div>
                                    @if ($errors->has('username'))
                                        <div class="login-message">
                                        <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        </div>
                                    @elseif($errors->has('password'))
                                        <div class="login-message">
                                        <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        </div>
                                    @endif
                                    <div class="login-submit">
                                        <button class="btn btn-primary">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
                                    </div>
                                    {{ csrf_field() }}
                                </form>
                            </div>
                            <div class="widget-login">
                                快读登录
                                <div class="widgets">
                                    <div class="widget-github">
                                        <a href="/oauth/github" onclick='connectToOAuth($(this)); return false;'><i class="fa fa-github fa-2x" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="widget-weibo">
                                        <a href="/oauth/weibo" onclick='connectToOAuth($(this)); return false;'><i class="fa fa-weibo fa-2x" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="widget-weixin">
                                        <a href="/oauth/weixin" onclick='connectToOAuth($(this)); return false;'><i class="fa fa-weixin fa-2x" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="widget-qq">
                                        <a href="/oauth/qq" onclick='connectToOAuth($(this)); return false;'><i class="fa fa-qq fa-2x" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var loginModal = $('#login-modal');
            if ('{{ $errors->has('username') || $errors->has('password') ? 0 : 1 }}' === '0') { loginModal.modal(); }
            loginModal.on('hidden.bs.modal', function () {
                $('.input-group').removeClass('has-error');
                @php($errors = null)
            })
        </script>
    @endif
@endsection