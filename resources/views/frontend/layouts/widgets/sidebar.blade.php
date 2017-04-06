@if(count($tags) > 0)
    <div class="module article-tags">
        <h4>文章标签</h4>
        <div class="tags-main">
            @php($layout = ['info', 'danger', 'success', 'warning', 'primary'])
            @php($maxOffset = count($layout))
            @foreach($tags as $key => $tag)
                @php( $offset = ($key <= $maxOffset) ? $key : ($key % $maxOffset))
                <a class="article-tag btn btn-xs btn-{{ $layout[$offset] }}" type="button" href="/tag/{{ $tag -> id }}">
                    {{ $tag -> name }} <span class="badge">{{ $tag -> articlesCount }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif

@if(count($articles) > 0)
    <div class="module recommend-article">
        <h4>推荐阅读</h4>
        <div class="article-main">
            @foreach($articles as $article)
                <h5>
                    <a href="/article/{{ $article -> id }}">
                        <i class="fa fa-list" aria-hidden="true"></i> {{ $article -> title }}
                    </a>
                </h5>
            @endforeach
        </div>
    </div>
@endif

@if(count($ads) > 0)

@endif

@if(count($comments) > 0)
    <div class="module recent-comment">
        <h4>最近评论</h4>
        <div class="comment-main">
            @foreach($comments as $comment)
                <ul>
                    <img src="{{ $comment -> avatar }}" alt="头像" class="index-comment-avatar">
                    <li class="comment-nickname">
                        {{ $comment -> nickname }}
                        <span class="pull-right index-comment-time"> {{ $comment -> time }}</span>
                    </li>
                    <li class="comment-article">
                        在"<a href="/article/{{ $comment -> articleId }}">{{ $comment -> articleTitle }}</a>"中评论：
                    </li>
                    <li class="comment-content">{{ $comment -> comment }}</li>
                </ul>
            @endforeach
        </div>
    </div>
@endif

@if(count($links) > 0)
    <div class="module recent-comment">
        <h4>友情链接</h4>
        <div class="links-main">
            @foreach($links as $link)
                <h5><a href="{{ $link -> link }}" target="_blank"><i class="fa fa-link" aria-hidden="true"></i> {{ $link -> title }}</a></h5>
            @endforeach
        </div>

    </div>
@endif

<div class="module search-article">
{!! Form::open(['url' => '/search', 'method' => 'GET', 'class' => 'form-inline', 'role' => 'form']) !!}
<!-- class include {'form-horizontal'|'form-inline'} -->
    <!--- Words Field --->
    <div class="form-group">
        {!! Form::text('words', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <input class="btn btn-primary form-control" type="submit" value="搜索全站">
    </div>
    {!! Form::close() !!}
</div>
