<ul>
    @foreach($menus as $menu)
        <li>
            <a href="/admin{{ $menu -> url }}"><i class="fa {{ $menu -> icon }} " aria-hidden="true"></i>&nbsp;{{ $menu -> name }}</a>
        </li>
        @if(count($menu -> submenus) > 0)
            @foreach($menu -> submenus as $submenu)
                @php($count = substr_count($submenu -> url, '/'))

                @if($count > 2 || ($count == 2 && substr_count($url, '/') > 3))
                    @php($status = strpos($url , $submenu -> url))
                @else
                    @php($status = ($url == $submenu -> url))
                @endif
                <li class="submenus {{ $status !== false ? 'submenu-active' : '' }}">
                    <a href="/admin{{ $submenu -> url }}"><i class="fa fa-caret-right" aria-hidden="true"></i>&nbsp;{{ $submenu -> name }}</a>
                </li>
            @endforeach
        @endif
    @endforeach
</ul>
