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
                    <li><a href="#">登陆</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>