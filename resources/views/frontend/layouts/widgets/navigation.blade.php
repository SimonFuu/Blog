<nav class="navbar navbar-front navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">付淑鹏的博客</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    @foreach($catalogs as $key => $catalog)
                        @php
                            $activeMark = '';
                            if (isset($article)) {
                                if ($article -> catalogId == $catalog -> id) {
                                    $activeMark = 'active';
                                }
                            } else {
                                if ((($uri == '/' || (strpos($uri, 'tag') !== false)) && $key == 0) || ($uri == '/catalog/' . $catalog -> id)) {
                                    $activeMark = 'active';
                                }
                            }
                        @endphp
                        <li class="{{ $activeMark }}"><a href={{ $catalog -> id == 1 ? '/' : sprintf("/catalog/%s", $catalog -> id) }}>{{ $catalog -> name }}</a></li>
                    @endforeach
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth() -> check())
                        {{--登录成功后，显示登录用户昵称及头像--}}
                        <li class="front-login-user-info">
                            <img class="front-login-user-avatar" src="{{ Auth::user() -> avatar }}" alt="">
                            <span>{{ Auth::user() -> name }}</span>
                            &nbsp;
                            @if(Auth::user() -> roleId == 1)
                                <a class="redirect-to-admin" href="/admin"><i class="fa fa-tachometer" aria-hidden="true"></i> 进入后台</a>
                            @endif
                            <a class="front-login-user-logout" href="/logout"><i class="fa fa-power-off" aria-hidden="true"></i> 退出</a>
                        </li>
                    @else
                        <li><a href="#"  data-toggle="modal" data-target="#login-modal">登录</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>