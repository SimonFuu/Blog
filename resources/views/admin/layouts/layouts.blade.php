<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>博客后台管理系统</title>
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
    <link rel="stylesheet" href="/assets/css/admin/style.css?{{ time() }}">
    <link rel="Shortcut Icon" href="/favicon.ico">
</head>
<body>
    @yield('body')
    <script src="/assets/js/admin/functions.js?{{ time() }}"></script>
</body>
</html>
