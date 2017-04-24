<ul>
    @foreach($menus as $menu)
        <li>
            <a href="/backend{{ $menu -> url }}"><i class="fa {{ $menu -> icon }} " aria-hidden="true"></i>&nbsp;{{ $menu -> name }}</a>
        </li>
        @if(count($menu -> submenus) > 0)
            @foreach($menu -> submenus as $submenu)
                @php($count = substr_count($submenu -> url, '/'))
                @if($count > 1 || ($count == 1 && substr_count($url, '/') > 2))
                    @php($status = strpos($url , $submenu -> url))
                @else
                    @php($status = ($url == $submenu -> url))
                @endif
                <li class="submenus {{ $status !== false ? 'submenu-active' : '' }}">
                    <a href="/backend{{ $submenu -> url }}"><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;{{ $submenu -> name }}</a>
                </li>
            @endforeach
        @endif
    @endforeach
</ul>
