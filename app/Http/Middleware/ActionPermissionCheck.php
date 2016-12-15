<?php

namespace App\Http\Middleware;

use App\Action;
use App\Permission;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class ActionPermissionCheck
{
    protected $auth;

    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * 检测当前用户是否具有route的权限
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->auth->guest()){
            abort(403);
            return $next($request);
        }
        $action = Action::where('url',$request->route()->getUri())->first();

        if(isset($action)){
            $permissions = $action->perms()->get();
            // 必须有对应权限才可以访问
            foreach ($permissions as $permission){
                if($request->user()->can($permission->name)){
                    // 操作验证成功
                    return $next($request);
                }
            }
            // 如果是请求页面的操作 只要子操作中任意一个有权限,就可以继续访问
            $actions = Action::where('parent_id',$action->id)->get();
            $ids = [];
            foreach ($actions as $a){
               array_push($ids,$a->id);
            }
            // 获取子权限
            $cperms = Permission::getPermissionByActions($ids);
            foreach ($cperms as $permission){
                if($request->user()->can($permission->name)){
                    // 操作验证成功
                    return $next($request);
                }
            }

        }
        abort(403);
        return $next($request);
    }
}
