<ul class="pagination pagination-lg">
    @if($items -> onFirstPage())
        @if($items -> lastPage() >= 3)
            <li class="disabled"><span aria-hidden="true">首页</span></li>
        @endif
        @if($items -> lastPage() >= 2)
            <li class="disabled"><span aria-hidden="true">上一页</span></li>
        @endif
    @else
        @if($items -> lastPage() >= 3)
            <li><a href="{{ $items -> url(1) }}"><span aria-hidden="true">首页</span></a></li>
        @endif
        @if($items -> lastPage() >= 2)
            <li><a href="{{ $items -> previousPageUrl() }}"><span aria-hidden="true">上一页</span></a></li>
        @endif
    @endif

    @php
        if ($items -> lastPage() <= 5) {
            $maxDisplayPage = $items -> lastPage();
            $pageOffset = 0;
        } else {
            $maxDisplayPage = 5;
            $pageOffset = ($items -> currentPage() > 3) ? $items -> currentPage() - 3 : 0;
        }
    @endphp
    @if($maxDisplayPage < 5 || $items -> lastPage() - $items -> currentPage() >= 2)
        @for($i = 1; $i <= $maxDisplayPage; $i++)
            @php($page = $i + $pageOffset)
            @if($items -> currentPage() == $page)
                <li class="active"><a>{{ $page }} <span class="sr-only"></span></a></li>
            @else
                <li><a href="{{ $items -> url($page) }}">{{ $page }} <span class="sr-only"></span></a></li>
            @endif
        @endfor
    @else
        @for($i = 4; $i >= 0; $i--)
            @php($page = $items -> lastPage() - $i)
            @if($items -> currentPage() == $page)
                <li class="active"><a>{{ $page }} <span class="sr-only"></span></a></li>
            @else
                <li><a href="{{ $items -> url($page) }}">{{ $page }} <span class="sr-only"></span></a></li>
            @endif
        @endfor
    @endif

    @if($items -> hasMorePages())
        @if($items -> lastPage() >= 2)
            <li><a href="{{ $items -> nextPageUrl() }}"><span aria-hidden="true">下一页</span></a></li>
        @endif
        @if($items -> lastPage() >= 3)
            <li><a href="{{ $items -> url($items -> lastPage()) }}"><span aria-hidden="true">尾页</span></a></li>
        @endif

    @else
        @if($items -> lastPage() >= 2)
            <li class="disabled"><span aria-hidden="true">下一页</span></li>
        @endif
        @if($items -> lastPage() >= 3)
            <li class="disabled"><span aria-hidden="true">尾页</span></li>
        @endif
    @endif
</ul>