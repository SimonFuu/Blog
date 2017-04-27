<ul class="nav navbar-nav">
    @foreach($catalogs as $catalog)
        <li class="{{ $catalog -> url == $uri? 'active' : '' }}">
            <a href="/admin{{ $catalog -> url }}"><i class="fa {{ $catalog -> icon }}" aria-hidden="true"></i>&nbsp;{{ $catalog -> name }}</a>
        </li>
    @endforeach
</ul>