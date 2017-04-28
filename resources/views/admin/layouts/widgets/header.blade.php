<ul class="nav navbar-nav">
    @foreach($catalogs as $catalog)
        @if(($uri == '/'))
            <li class="{{ $catalog -> url == $uri ? 'active' : '' }}">
        @else
            <li class="{{ strpos($catalog -> url, $uri) === 0 ? 'active' : '' }}">
        @endif
            <a href="/admin{{ $catalog -> url }}"><i class="fa {{ $catalog -> icon }}" aria-hidden="true"></i>&nbsp;{{ $catalog -> name }}</a>
        </li>
    @endforeach
</ul>