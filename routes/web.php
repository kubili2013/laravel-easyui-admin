<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

// 使用Auth提供的登录与退出
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->middleware('throttle:2,1');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('logout', 'Auth\LoginController@logout');

// 关闭注册入口
//Route::get('register', 'Auth\RegisterController@showRegistrationForm');
//Route::post('register', 'Auth\RegisterController@register');

// 关闭auth默认 重置密码
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// 后台框架首页
Route::get('/home', 'HomeController@index');

// 根据操作请求页面url,重定向到对应的界面
Route::get('/handler/{id}',function($id){
    $menu = \App\Menu::find($id);
    $action = $menu -> action() -> first();
    return redirect($action->url);
})->where('id', '[0-9]+');

// 提供数据支持的各种接口,不用添加到操作表中
Route::group(['middleware' => ['auth']],function(){
    // 获取菜单
    Route::any('GetMyMenus',"MenuController@getMenusByUser");
    Route::any('GetAllMenus',"MenuController@getAllMenus");
    Route::any('GetAllMenusByTree',"MenuController@getAllMenusByTree");
    // 获取角色
    Route::any('GetAllRoles',"RoleController@getRolesPage");
    Route::any('GetRolePermissions/{id}',"RoleController@getRolePermissions")->where('id', '[0-9]+');
    // 获取权限
    Route::any('GetAllPermissionByTree',"PermissionController@getAllPermissionByTree");
    Route::any('GetAllPermissionByRootTree',"PermissionController@getAllPermissionByRootTree");
    Route::any('GetAllPermissions',"PermissionController@getAllPermissions");
    // 获取用户
    Route::any('GetAllUsers',"UserController@getAllUsers");
    // 获取权限数据
    Route::any('GetAllActions',"ActionController@getAllActions");
    Route::any('GetAllActionsByTree',"ActionController@getAllActionsByTree");
    Route::any('GetAllActionsByRootTree',"ActionController@getAllActionsByRootTree");
    Route::any('GetActionPermissions/{id}',"ActionController@getActionPermissions")->where('id', '[0-9]+');

    Route::any('User/{id}/Roles',"UserController@getRoles")->where('id', '[0-9]+');


});
// 需要admin角色才能进入的方法
Route::group(['middleware' => ['action']],function(){
    // 菜单管理
    Route::get('menu',"MenuController@showMenuManager");
    Route::post('menu/create',"MenuController@create");
    Route::get('menu/{id}',"MenuController@menu")->where('id', '[0-9]+');
    Route::post('menu/delete/{id}',"MenuController@delete")->where('id', '[0-9]+');
    Route::post('menu/edit/{id}',"MenuController@edit")->where('id', '[0-9]+');

    // 角色管理 操作
    // 展示页面
    Route::get('role',"RoleController@showRoleManager");
    // 新建角色 提交
    Route::post('role/create', "RoleController@create");
    // 按照id删除
    Route::any('role/delete/{id}',"RoleController@delete")->where('id', '[0-9]+');
    // 更新
    Route::post('role/update/{id}',"RoleController@update")->where('id', '[0-9]+');

    // 展示页面
    Route::get('permission',"PermissionController@showPermissionManager");
    Route::post('permission/create', "PermissionController@create");
    // 按照id删除
    Route::any('permission/delete/{id}',"PermissionController@delete")->where('id', '[0-9]+');
    // 按照id删除
    Route::any('permission/update/{id}',"PermissionController@update")->where('id', '[0-9]+');


    // 展示页面
    Route::get('user',"UserController@showUserManager");
    Route::post('user/create', "UserController@create");
    // 按照id删除
    Route::any('user/delete/{id}',"UserController@delete")->where('id', '[0-9]+');
    // 按照id删除
    Route::any('user/update/{id}',"UserController@update")->where('id', '[0-9]+');

     // 展示页面
    Route::get('action',"ActionController@showActionManager");
    Route::post('action/create', "ActionController@create");
    // 按照id删除
    Route::any('action/delete/{id}',"ActionController@delete")->where('id', '[0-9]+');
    // 按照id删除
    Route::any('action/update/{id}',"ActionController@update")->where('id', '[0-9]+');
});
