@extends('frontend.layouts.common')
@section('content')
    <div class="module">
        <div class="contents-header article-detail">
            <h2>{{ $article -> title }}</h2>
            <div class="row">
                <div class="col-md-2">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    &nbsp;
                    {{ $article -> name }}
                </div>
                <div class="col-md-4">
                    <i class="fa fa-calculator" aria-hidden="true"></i>
                    &nbsp;
                    {{ $article -> publishedAt }}

                </div>
                <div class="col-md-2">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    &nbsp;
                    <a href="/catalog/{{ $article -> catalogId }}">{{ $article -> catalog }}</a>
                </div>
                <div class="col-md-2">
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    &nbsp;
                    <a href="/tag/{{ $article -> tagId }}">{{ $article -> tag }}</a>
                </div>
            </div>
        </div>
        <hr>
        <div class="contents-body">
            {{ $article -> content }}
        </div>
        <div class="copyright-content">
            <p>文章内容为Simon Fu原创，转载请注明来自 <a href="{{ env('APP_URL') }}">Simon Fu's Blog-{{ env('APP_URL') }}</a>，谢谢！</p>
        </div>
        <div class="prev-next-articles">
            <div class="prev-article">上一篇：{!! is_null($article -> prevArticle) ? '没有了' : sprintf('<a href="/article/%s">%s</a>', $article -> prevArticle -> id, $article -> prevArticle -> title) !!}</div>
            <div class="next-article">下一篇：{!! is_null($article -> nextArticle) ? '没有了' : sprintf('<a href="/article/%s">%s</a>', $article -> nextArticle -> id, $article -> nextArticle -> title) !!}</div>
        </div>
    </div>
    <div class="module comment-module">
        评论区域
    </div>
@endsection