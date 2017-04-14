@extends('frontend.bind.common')
@section('bind-body')
    <div class="response-text">
        <h3>{{ $name }}：</h3>
        <h4 style="text-indent: 2em">已向您的邮箱: {{ $email }} 发送了一封验证邮件，30分钟以内有效，请注意查收！</h4>
    </div>
    <div class="response-close-button">
        <button class="btn btn-default" type="button" onclick="closeWindows()">关&nbsp;&nbsp;闭</button>
    </div>
    <script>
        var closeWindows = function () {
            window.close();
            window.opener.postMessage("hello", "*");
        };
    </script>
@endsection