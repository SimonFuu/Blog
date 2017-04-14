@extends('layouts.layouts')
@section('body')
    登陆成功，正在跳转！
    <script>
        setTimeout(function () {
            window.opener.postMessage("hello", "*");
            window.close();
        }, 1000);
    </script>
@endsection