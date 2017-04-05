@extends('frontend.layouts.common')
@section('content')
    @foreach($articles as $key => $arc)
        <div class="module">
            <div class="contents-header">
                <h2><a href="/article/{{ $arc -> id }}">{{ $arc -> title }}</a></h2>
                <div class="row">
                    <div class="col-md-2">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        &nbsp;
                        {{ $arc -> name }}
                    </div>
                    <div class="col-md-4">
                        <i class="fa fa-calculator" aria-hidden="true"></i>
                        &nbsp;
                        {{ $arc -> publishedAt }}
                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        &nbsp;
                        <a href="/catalog/{{ $arc -> catalogId }}">{{ $arc -> catalog }}</a>
                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-tags" aria-hidden="true"></i>
                        &nbsp;
                        <a href="/tag/{{ $arc -> tagId }}">{{ $arc -> tag }}</a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="contents-body">
                <div class="row index-articles-body">
                    <div class="col-md-4">
                        <div class="index-article-thumb-container">
                            <a href="/article/{{ $arc -> id }}"><img class="index-article-thumb img-thumbnail" src="{{ $arc -> thumb }}" alt="文章缩略图"></a>
                            <P class=companyInfo>阅读全文</P>
                            <div class="cornerTop div-2"></div>
                            <div class="cornerRight div-1"></div>
                            <div class="cornerBottom div-2"></div>
                            <div class="cornerLeft div-1"></div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="index-articles-content">
                            <p class="index-article-content-thumb">
                                {{ $arc -> abstractContent }}
                            </p>
                        </div>
                        <div class="read-content">
                            <a href="/article/{{ $arc -> id }}" class="btn btn-info btn-xs">阅读全文</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @if($articles -> lastPage() > 1)
        <div class="module article-pagination">
            {{ $articles -> links() }}
        </div>
    @endif
@endsection

