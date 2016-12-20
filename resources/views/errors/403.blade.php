@if(Request::get('back_error') == 'json')
{'code':'403','success':false,'msg':'出错啦,您可能没有权限执行此操作!请刷新重试或者联系管理员!'}
@else
    {{ var_dump($exception) }}
@endif