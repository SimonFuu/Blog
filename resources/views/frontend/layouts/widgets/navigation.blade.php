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
                <a class="navbar-brand" href="#">Brand</a>
            </div>

            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    @foreach($menus as $menu)
                        {{--<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>--}}
                        <li class="{{ $menu -> active ? 'active' : '' }}"><a href="{{ $menu -> url }}">{{ $menu -> name }}</a></li>
                    @endforeach
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">登陆</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>