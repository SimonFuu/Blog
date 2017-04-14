<p>{{ $data['name'] }}, 您好：</p>
<p>您正在使用【{{ $data['source'] }}】绑定您的邮箱【 {{ $data['email'] }} 】，<br>
    请在{{ env('BIND_CONFIRMATION_EXPIRED_IN') }}分钟内<a href="{{ $data['url'] }}">点击这里</a>以完成绑定！</p>
<div>如无法访问，请复制如下地址到浏览器，直接访问：<span style="word-break: break-all;">{{ $data['url'] }}</span></div>
<p>(UTC+8:00) {{ date('Y-m-d H:i:s') }}</p>