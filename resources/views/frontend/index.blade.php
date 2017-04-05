@extends('frontend.layouts.common')
@section('content')
    @foreach($archives as $archive)
        <div class="module">
            <div class="contents-header">
                <h2><a href="/archive/{{ $archive -> id }}">{{ $archive -> title }}</a></h2>
                <div class="row">
                    <div class="col-md-3">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        &nbsp;
                        {{ $archive -> author }}
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-calculator" aria-hidden="true"></i>
                        &nbsp;
                        {{ $archive -> createdAt }}
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                        &nbsp;
                        <a href="/catalogs/{{ $archive -> catalog }}">{{ $archive -> catalog }}</a>
                    </div>
                    <div class="col-md-3">
                        <i class="fa fa-tags" aria-hidden="true"></i>
                        &nbsp;
                        <a href="/tags/{{ $archive -> tag }}">{{ $archive -> tag }}</a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="contents-body">
                <div class="row index-archives-body">
                    <div class="col-md-4">
                        <div class="index-archive-thumb-container">
                            <a href="/archive/{{ $archive -> id }}"><img class="index-archive-thumb img-thumbnail" src="{{ $archive -> thumb }}" alt="文章缩略图"></a>
                            <P class=companyInfo>阅读全文</P>
                            <div class="cornerTop div-2"></div>
                            <div class="cornerRight div-1"></div>
                            <div class="cornerBottom div-2"></div>
                            <div class="cornerLeft div-1"></div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="index-archives-content">
                            <p class="index-archive-content-thumb">
                                {{ $archive -> content }}
                            </p>
                        </div>
                        <div class="read-content">
                            <a href="/archive/{{ $archive -> id }}" class="btn btn-info btn-xs">阅读全文</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="module archive-pagination">
        分页的地方
    </div>
@endsection

