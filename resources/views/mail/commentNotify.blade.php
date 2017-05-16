<p style=""><span class="fromName">{{ $data['name'] }}</span> 回复了您在 <a class="title" href="{{ env('APP_URL') . 'article/' . $data['aid'] }}">
        【{{ mb_strlen($data['title']) > 20 ? mb_substr($data['title'], 0, 20) . '...' :  $data['title'] }}】
    </a>的评论：
    "<span class="content">{{ mb_strlen($data['content']) > 20 ? mb_substr($data['content'], 0, 20) . '...' :  $data['content']}}</span>"，
    <a href="{{ env('APP_URL') . 'article/' . $data['aid'] }}">请点击查看</a>！
</p>
<p>(UTC+8:00) {{ date('Y-m-d H:i:s') }}</p>

<style>
    p {text-indent: 2em;font-size: 14px;font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;}
    .fromName {color: orangered;font-weight: bold;}
    .content{color: #9BA2AB;}
    .title {color: black;}
    .title:hover {color: blue;}
    a {text-decoration:none !important;color: blue;}
    a:hover {color: blue;}
</style>