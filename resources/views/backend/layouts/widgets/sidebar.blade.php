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
{{--<ul>--}}
    {{--<li>--}}
        {{--<a href="/backend/"><i class="fa fa-home " aria-hidden="true"></i>&nbsp;首页</a>--}}
    {{--</li>--}}
    {{--<li>--}}
        {{--<a href="/backend/articles"><i class="fa fa-list " aria-hidden="true"></i>&nbsp;内容管理</a>--}}
    {{--</li>--}}
    {{--<li class="submenus">--}}
        {{--<a href="/backend/articles/list"><i class="fa fa-caret-right " aria-hidden="true"></i>&nbsp;子菜单</a>--}}
    {{--</li>--}}
    {{--<li class="submenus submenu-active">--}}
        {{--<a href="/backend/articles"><i class="fa fa-caret-right " aria-hidden="true"></i>&nbsp;子菜单</a>--}}
    {{--</li>--}}
    {{--<li class="submenus">--}}
        {{--<a href="/backend/articles"><i class="fa fa-caret-right " aria-hidden="true"></i>&nbsp;子菜单</a>--}}
    {{--</li>--}}
    {{--<li>--}}
        {{--<a href="/backend/comments"><i class="fa fa-comments " aria-hidden="true"></i>&nbsp;评论管理</a>--}}
    {{--</li>--}}
    {{--<li>--}}
        {{--<a href="/backend/users"><i class="fa fa-users " aria-hidden="true"></i>&nbsp;用户管理</a>--}}
    {{--</li>--}}
    {{--<li>--}}
        {{--<a href="/backend/trash"><i class="fa fa-trash " aria-hidden="true"></i>&nbsp;&nbsp;回收站</a>--}}
    {{--</li>--}}
    {{--<li>--}}
        {{--<a href="/backend/settings"><i class="fa fa-cogs " aria-hidden="true"></i>&nbsp;网站设置</a>--}}
    {{--</li>--}}
{{--</ul>--}}