<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>关联邮箱 | 付淑鹏的博客 | Simon Fu Blog</title>
    <script src="//cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    @if(env('APP_ENV') == 'local')
        <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
        <script src="/assets/js/bootstrap.min.js"></script>
    @else
        <link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    @endif
    <link rel="stylesheet" href="/assets/css/frontend/common.css?{{ time() }}">
    <link rel="Shortcut Icon" href="{{ env('IMG_SERVER') }}/favicon.ico">
</head>
<body class="body">
    <div class="container">
        <div class="user-bind-page-header">
            LOGO
        </div>
        <div class="module user-bind-page-body">
            {!! Form::open(['url' => '/user/bind', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                <!-- class include {'form-horizontal'|'form-inline'} -->

                <div class="form-group">
                    <label>您正在使用：<i class="fa fa-2x fa-{{ session('u-source') }}"></i></label>
                </div>
                <!--- Nickname Field --->
                <div class="form-group">
                    <label for="nickname">昵称：<span class="must-be-input">*</span></label>
                    <input type="text" id="nickname" name="nickname" class="form-control">
                </div>
                <!--- Email Field --->
                <div class="form-group">
                    <label for="email">邮箱：<span class="must-be-input">*</span></label>
                    <input type="email" id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary form-control user-bind-page-submit">提交</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</body>
</html>
