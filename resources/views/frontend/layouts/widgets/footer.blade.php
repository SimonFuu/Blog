<div class="footer text-center">
    <p>Powered By
        <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a> |
        <a href="http://jquery.com/" target="_blank">jQuery</a> |
        <a href="http://fontawesome.io/" target="_blank">Font Awesome</a>|
        <a href="https://laravel.com/" target="_blank">Laravel</a></p>
    <p>
        <i class="fa fa-copyright"></i> 2017 - {{ date('Y') }} By Simon Fu,
        E-Mail: <a href="mailto:me@fushupeng.com">me@fushupeng.com</a>
    </p>
    <p>Some Rights Reserved: <a href="http://www.fushupeng.com">www.fushupeng.com</a></p>
</div>
{{--登陆模态框--}}
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="login-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="login-modal-label">您可直接使用以下账号直接登陆</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                {{--<button type="button" class="btn btn-primary">Send message</button>--}}
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/frontend/common.js?{{ time() }}"></script>