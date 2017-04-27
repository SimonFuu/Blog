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
            {!! $article -> content !!}
        </div>
        <div class="copyright-content">
            <p>文章内容为Simon Fu原创，转载请注明来自 <a href="{{ env('APP_URL') }}">Simon Fu's Blog-{{ env('APP_URL') }}</a>，谢谢！</p>
        </div>
        <div class="prev-next-articles">
            <div class="prev-article">上一篇：{!! is_null($article -> prevArticle) ? '没有了' : sprintf('<a href="/article/%s">%s</a>', $article -> prevArticle -> id, $article -> prevArticle -> title) !!}</div>
            <div class="next-article">下一篇：{!! is_null($article -> nextArticle) ? '没有了' : sprintf('<a href="/article/%s">%s</a>', $article -> nextArticle -> id, $article -> nextArticle -> title) !!}</div>
        </div>
    </div>
    <div class="module comments-module">
        <div class="comment-submit-module">
            {!! Form::open(['url' => '/article/comment', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
                {{--<div class="col-md-4">--}}
                    {{--<!--- Test Field --->--}}
                    {{--<div class="form-group">--}}
                        {{--{!! Form::text('test', null, ['class' => 'form-control']) !!}--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="col-md-9">--}}
                    {{--{!! Form::textarea('content', '请先登录！', ['class' => 'form-control comment-not-login', 'required', 'disabled']) !!}--}}
    {{----}}
                {{--</div>--}}
                <!--- Comment Field --->
                <div class="form-group">
                    <div class="comment-submit">
                        @if(Auth::check())
                            {!! Form::textarea('content', null, ['class' => 'form-control', 'required']) !!}
                        @else
                            {!! Form::textarea('content', '请先登录！', ['class' => 'form-control comment-not-login', 'required', 'disabled']) !!}
                        @endif
                    </div>
                </div>
                <div class="form-group comment-submit-button">
                    <div class="comment-submit-user-info pull-left">
                        @if(Auth::check())
                            <img class="comment-submit-user-avatar" src="{{ Auth::user() -> avatar }}" alt="">
                            <div class="comment-submit-user-nickname">
                                {{ Auth::user() -> name }}
                            </div>
                        @else
                            <div class="comment-submit-user-not-login">
                                请先<a href="#" data-toggle="modal" data-target="#login-modal">登录</a>!
                            </div>
                        @endif
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-primary btn-lg" @if(!Auth::check()) {{ 'disabled' }} @endif>发布评论</button>
                    </div>
                </div>
                <input type="hidden" name="articleId" value="{{ $article -> id }}">
            {!! Form::close() !!}
            <div class="comments-info">
                <div class="pull-left">最新评论</div>
                <div class="pull-right">共计{{ $commentCount }}条评论</div>
            </div>
        </div>
        {{---------------------------------评论列表---------------------------------------}}
        <div class="comments-list">
            @if(count($comments) > 0)
                @foreach($comments as $comment)
                    <div class="user-comment">
                        <img src="{{ $comment -> avatar }}" alt="头像" class="article-comment-avatar">
                        <ul>
                            <li class="comment-nickname">{{ $comment -> name }}：{{ $comment -> content }}</li>
                            <li>{{ $comment -> createdAt }}
                                @if(Auth::check())
                                    <a href="javascript:;" data-article-id="{{ $article -> id }}" data-comment-id="{{ $comment -> id }}" class="replay-comment">回复</a>
                                    {{--只有本人或者管理员才会显示删除--}}
                                    @if(Auth::user() -> id == $comment -> uId || Auth::user() -> roleId == 1)
                                        <a href="/article/comment/delete/{{ $comment -> id }}">删除</a>
                                    @endif
                                @endif
                            </li>
                        </ul>
                        @if(!is_null($comment -> replays))
                            @foreach($comment -> replays as $replay)
                                <div class="children-comment">
                                    <img src="{{ $replay -> avatar }}" alt="头像" class="article-comment-avatar">
                                    <ul>
                                        <li class="comment-nickname">
                                            @if($replay -> parentCommentId != $comment -> id)
                                                <span class="child-comment-host">{{ $replay -> name }}</span> 回复 {{ $replay -> to }}：{{ $replay -> content }}
                                            @else
                                                {{ $replay -> name }}：{{ $replay -> content }}
                                            @endif
                                        </li>
                                        <li>{{ $replay -> createdAt }}
                                            @if(Auth::check())
                                                <a href="javascript:;" data-article-id="{{ $article -> id }}" data-comment-id="{{ $replay -> id }}" class="replay-comment">回复</a>
                                                {{--只有本人或者管理员才会显示删除--}}
                                                @if(Auth::user() -> id == $comment -> uId || Auth::user() -> roleId == 1)
                                                    <a href="/article/comment/delete/{{ $replay -> id }}">删除</a>
                                                @endif
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection