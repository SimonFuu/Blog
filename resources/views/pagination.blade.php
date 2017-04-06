<ul class="pagination pagination-lg">
    @if($articles -> onFirstPage())
        @if($articles -> lastPage() >= 3)
            <li class="disabled"><span aria-hidden="true">首页</span></li>
        @endif
        @if($articles -> lastPage() >= 2)
            <li class="disabled"><span aria-hidden="true">上一页</span></li>
        @endif
    @else
        @if($articles -> lastPage() >= 3)
            <li><a href="{{ $articles -> url(1) }}"><span aria-hidden="true">首页</span></a></li>
        @endif
        @if($articles -> lastPage() >= 2)
            <li><a href="{{ $articles -> previousPageUrl() }}"><span aria-hidden="true">上一页</span></a></li>
        @endif
    @endif

    @php
        if ($articles -> lastPage() <= 5) {
            $maxDisplayPage = $articles -> lastPage();
            $pageOffset = 0;
        } else {
            $maxDisplayPage = 5;
            $pageOffset = ($articles -> currentPage() > 3) ? $articles -> currentPage() - 3 : 0;
        }
    @endphp
    @if($maxDisplayPage < 5 || $articles -> lastPage() - $articles -> currentPage() >= 2)
        @for($i = 1; $i <= $maxDisplayPage; $i++)
            @php($page = $i + $pageOffset)
            @if($articles -> currentPage() == $page)
                <li class="active"><a>{{ $page }} <span class="sr-only"></span></a></li>
            @else
                <li><a href="{{ $articles -> url($page) }}">{{ $page }} <span class="sr-only"></span></a></li>
            @endif
        @endfor
    @else
        @for($i = 4; $i >= 0; $i--)
            @php($page = $articles -> lastPage() - $i)
            @if($articles -> currentPage() == $page)
                <li class="active"><a>{{ $page }} <span class="sr-only"></span></a></li>
            @else
                <li><a href="{{ $articles -> url($page) }}">{{ $page }} <span class="sr-only"></span></a></li>
            @endif
        @endfor
    @endif

    @if($articles -> hasMorePages())
        @if($articles -> lastPage() >= 2)
            <li><a href="{{ $articles -> nextPageUrl() }}"><span aria-hidden="true">下一页</span></a></li>
        @endif
        @if($articles -> lastPage() >= 3)
            <li><a href="{{ $articles -> url($articles -> lastPage()) }}"><span aria-hidden="true">尾页</span></a></li>
        @endif

    @else
        @if($articles -> lastPage() >= 2)
            <li class="disabled"><span aria-hidden="true">下一页</span></li>
        @endif
        @if($articles -> lastPage() >= 3)
            <li class="disabled"><span aria-hidden="true">尾页</span></li>
        @endif
    @endif
</ul>