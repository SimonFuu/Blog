<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
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
    </head>
    <body>
        <nav class="navbar navbar-front navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Brand</a>
                    </div>

                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                            <li><a href="#">Link</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#">登陆</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="body">
            <div class="container" style="border: 1px solid black">
                <div class="row">
                    <div class="main-container col-md-8" style="border: 1px solid red">
                        <div class="left-part">
                            <div class="contents-header">
                                <h2><a href="#">文章标题1</a></h2>
                                <div class="row">
                                    <div class="col-md-2">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        &nbsp;
                                        管理员
                                    </div>
                                    <div class="col-md-4">
                                        <i class="fa fa-calculator" aria-hidden="true"></i>
                                        &nbsp;
                                        2017-03-20 11:00:00
                                    </div>
                                    <div class="col-md-3">
                                        <i class="fa fa-th-list" aria-hidden="true"></i>
                                        &nbsp;
                                        <a href="#catalog">目录</a>
                                    </div>
                                    <div class="col-md-3">
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                        &nbsp;
                                        <a href="#tag">标签</a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="contents-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="#"><img src="http://baijunyao.com/Upload/image/ueditor/20170225/1488005139158472.jpeg" alt="#" class="img-thumbnail"></a>
                                    </div>
                                    <div class="col-md-8">
                                        <p class="">
                                            这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍这是个介绍
                                        </p>
                                        <div class="pull-right read-content">
                                            <a href="#" class="btn btn-info btn-xs">阅读全文</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-container col-md-4" style="border: 1px solid blue; height: 1000px">
                        <div class="right-part article-tags">
                            <h4>文章标签</h4>
                            <div class="tags-main">
                                <button class="article-tag btn btn-xs btn-primary" type="button">
                                    Messages <span class="badge">4</span>
                                </button>
                                <button class="article-tag btn btn-xs btn-info" type="button">
                                    Messages <span class="badge">4</span>
                                </button>
                                <button class="article-tag btn btn-xs btn-danger" type="button">
                                    Messages <span class="badge">4</span>
                                </button>
                                <button class="article-tag btn btn-xs btn-success" type="button">
                                    Messages <span class="badge">4</span>
                                </button>
                                <button class="article-tag btn btn-xs btn-warning" type="button">
                                    Messages <span class="badge">4</span>
                                </button>
                            </div>
                        </div>
                        <div class="right-part pin-top">
                            <h4>置顶</h4>
                        </div>
                        <div class="right-part recent-comment">
                            <h4>最近评论</h4>
                        </div>
                        <div class="right-part friendly-links">
                            <h4>友情链接</h4>
                            <div class="links-main">
                                <a href="https://www.baidu.com" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> 百度</a>
                            </div>
                        </div>
                        <div class="right-part search-article">
                            {!! Form::open(['url' => '/article/search', 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
                                <!-- class include {'form-horizontal'|'form-inline'} -->
                                <!---  Field --->
                                <div class="form-group">
                                    {!! Form::text('words', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary form-control" type="submit" value="搜索全站">
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="toTop hidden">
            <i class="fa fa-angle-double-up fa-3x" aria-hidden="true"></i>
        </div>
        <div class="footer text-center">
            <p>Powered By
            <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a> |
            <a href="http://jquery.com/" target="_blank">jQuery</a> |
            <a href="http://fontawesome.io/" target="_blank">Font Awesome</a>|
            <a href="https://laravel.com/" target="_blank">Laravel</a></p>
            <p>
                <i class="fa fa-copyright"></i> 2017 -
                <script type="text/javascript">
                    var date = new Date();
                    var year = date.getFullYear();
                    document.write(year)
                </script> By Simon Fu, E-Mail: <a href="mailto:fushupeng@outlook.com">fushupeng@outlook.com</a>
            </p>
            <p>Some Rights Reserved: <a href="http://www.fushupeng.com">www.fushupeng.com</a></p>
        </div>
        <script src="/assets/js/frontend/common.js?{{ time() }}"></script>
    </body>
</html>
