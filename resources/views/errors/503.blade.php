@if(Request::get('back_error') == 'json')
    {'code':'500','success':false,'msg':'服务器出错啦,登录状态可能失效!请刷新重试或者联系管理员!'}
@else
    {{ var_dump($exception) }}
@endif