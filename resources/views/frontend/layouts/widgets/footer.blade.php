<div class="footer text-center">
    <p>Powered By
        <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a> |
        <a href="http://jquery.com/" target="_blank">jQuery</a> |
        <a href="http://fontawesome.io/" target="_blank">Font Awesome</a>|
        <a href="https://laravel.com/" target="_blank">Laravel</a></p>
    <p>
        <i class="fa fa-copyright"></i> 2017 - {{ date('Y') }} By Simon Fu,
        E-Mail: <a href="mailto:contact@fushupeng.com">contact@fushupeng.com</a>
    </p>
    <p>Some Rights Reserved: <a href="http://www.fushupeng.com">www.fushupeng.com</a></p>
</div>
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
                                <div class="input-group input-group-md form-group">
                                    <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                                    <input type="text" name="username" class="form-control" placeholder="用户名" value="" aria-describedby="sizing-addon1">
                                </div>
                                <div class="input-group input-group-md">
                                    <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="密码" value="" aria-describedby="sizing-addon1">
                                </div>
                                <div class="login-submit">
                                    <button class="btn btn-primary">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
                                </div>
                                @if ($errors->has('username') || $errors->has('password'))
                                    <div>
                                        <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    </div>
                                @endif
                                {{ csrf_field() }}
                            </form>
                        </div>
                        <div class="fast-login">
                            快读登录
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
@endif
<script src="/assets/js/frontend/common.js?{{ time() }}"></script>