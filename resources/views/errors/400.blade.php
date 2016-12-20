@if(Request::get('back_error') == 'json')
{'code':'400','success':false,'msg':'出错啦,页面没有找见!请刷新重试或者联系管理员!'}
@else
    {{ var_dump($exception) }}
@endif