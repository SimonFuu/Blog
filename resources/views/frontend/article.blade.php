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
    <div class="module comments-module">
        <div class="comment-submit-module">
        {!! Form::open(['url' => '/article/comment', 'method' => 'post', 'class' => 'form-horizontal', 'role' => 'form']) !!}
        <!--- Comment Field --->
            <div class="form-group">
                <div class="comment-submit">
                    {!! Form::textarea('comment', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="form-group comment-submit-button">
                <div class="comment-submit-user-info pull-left">
                    <img class="comment-submit-user-avatar" src="http://qzapp.qlogo.cn/qzapp/101206152/B5A281DC85C5AF7E7C4EA1DEC5E74DBA/100" alt="">
                    <div class="comment-submit-user-nickname">
                        用户名
                    </div>
                </div>
                <div class="pull-right">
                    <button class="btn btn-primary btn-lg">发布评论</button>
                </div>
            </div>

            {!! Form::close() !!}
            <div class="comments-info">
                <div class="pull-left">
                    最新评论
                </div>
                <div class="pull-right">共计{{ count($comments) }}条评论</div>
            </div>
        </div>
        {{---------------------------------评论列表---------------------------------------}}
        <div class="comments-list">
            @php
                foreach ($comments as $comment) {
                    if ($comment -> baseCommentId == 0) {
                        $parentComments[] = $comment;
                    } else {
                        $replays[$comment -> baseCommentId][] = $comment;
                    }
                }
                foreach ($parentComments as $comment) {
                    if (isset($replays[$comment -> id])) {
                        $comment -> replays = $replays[$comment -> id];
                    } else {
                        $comment -> replays = null;
                    }
                }

            @endphp
            @foreach($parentComments as $comment)
                <div class="user-comment">
                    <img src="{{ $comment -> avatar }}" alt="头像" class="article-comment-avatar">
                    <ul>
                        <li class="comment-nickname">{{ $comment -> name }}：{{ $comment -> content }}</li>
                        <li>{{ $comment -> createdAt }}
                            <a href="javascript:;" data-article-id="{{ $article -> id }}" data-comment-id="{{ $comment -> id }}" data-user-id="{{ $comment -> uId }}" class="replay-comment">回复</a>
                            {{--只有本人或者管理员才会显示删除--}}
                            <a href="javascript:;" data-comment-id="">删除</a>
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
                                        <a href="javascript:;" data-article-id="{{ $article -> id }}" data-comment-id="{{ $replay -> id }}" data-user-id="{{ $replay -> uId }}" class="replay-comment">回复</a>
                                        {{--只有本人或者管理员才会显示删除--}}
                                        <a href="javascript:;" data-comment-id="">删除</a></li>
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    </div>

@endsection