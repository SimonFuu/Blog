@extends('frontend.layouts.layouts')
@section('body')
    <div class="container">
        <div class="oauth-login-notification">
            登陆成功，正在跳转！如长时间未跳转，请<a href="#" onclick="loginRedirect();">点击这里</a>
        </div>
    </div>
    <script>
        var loginRedirect = function () {
            window.opener.postMessage("hello", "*");
            window.close();
        };
        setTimeout(function () {
            loginRedirect();
        }, 2000);
    </script>
@endsection