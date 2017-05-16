<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>{{ isset($title) ? $title . ' - ': ''}}付淑鹏的博客 | Simon Fu Blog | 技术类博客 | 个人技术总结 | PHP、Python总结 | 代码、运维总结 | PHP博客 | Laravel博客</title>
    {{--<title>付淑鹏的博客 | Simon Fu Blog | 技术类博客 | 个人技术总结 | PHP、Python总结 | 代码、运维总结 | PHP博客 | Laravel博客</title>--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="付淑鹏,Simon Fu,个人博客系统,个人博客模板,Laravel博客系统,php博客,技术博客" />
    <meta name="description" content="{{ isset($description) ? $description : '付淑鹏的博客,Simon Fu\'s Blog,个人技术博客,SF-Blog,SF-Blog官方网站' }}" />
    <meta name="author" content="Simon Fu, contact@fushupeng.com" />
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
    <link rel="stylesheet" href="/assets/css/frontend/style.css?{{ time() }}">
    <link rel="Shortcut Icon" href="/favicon.ico">
    <meta name="baidu-site-verification" content="rGvzczVODV" />
</head>
<body>
    @yield('body')
    <script src="/assets/js/frontend/functions.js?{{ time() }}"></script>
</body>
</html>
