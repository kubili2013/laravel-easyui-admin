<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function showUserManager()
    {
        return view('admin.user');
    }

    public function getAllUsers(Request $request){
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'page' => 'numeric',
            'rows' => 'numeric',
            'sort' => 'string|max:64',
            'order' => 'in:asc,desc',
            'qname' => 'string|max:24'
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
        if(isset($data['qname'])){
            $users = User::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")
                ->where('name','like','%'.$data['qname'].'%')->paginate($data['rows']);
            return $users;
        }
        $users = User::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")->paginate($data['rows']);
        return $users;
    }

    public function delete(Request $request,$id)
    {
        User::find($id)->delete();
        return ['success' => true,'msg' => '删除成功!'];
    }

    /**
     * 重置密码
     * @param Request $request
     * @param $id
     * @return array
     */
    public function resetPsw(Request $request,$id)
    {
        $user = Auth::user();
        $data = $request->all();
        $validator = Validator::make($data,[
            'old_password' => 'required|min:6',
            'password' => 'required|min:6',
        ]);
        $user -> password = bcrypt($data['password']);
        $user -> save();
        return ['success' => true,'msg' => '重置成功!'];
    }

    /**
     * 新增用户
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'roles' => 'array'
        ]);
        if($validator->fails()){
            return ['success' => false,'msg' => $validator->errors()->first()];
        }
        $user = new User();
        $user -> name = $data['name'];
        $user -> email = $data['email'];
        $user -> password = bcrypt(Config::get('auth.default_psw'));
        $user -> save();
        $user -> roles() -> saveMany(Role::find($data['roles']));
        return ['success' => true,'msg' => '新增成功!'];
    }

    /**
     * 更新用户
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update (Request $request,$id)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'roles' => 'array'
        ]);
        if($validator->fails()){
            return ['success' => false,'msg' => $validator->errors()->first()];
        }
        $user = User::find($id);
        $user -> name = $data['name'];
        $user -> email = $data['email'];
        $user -> password = bcrypt(Config::get('auth.default_psw'));
        $user -> save();
        $user -> roles() -> detach();
        if(isset($data['roles']) && count($data['roles']) > 0){
            $user -> roles() -> saveMany(Role::find($data['roles']));
        }
        return ['success' => true,'msg' => '更新成功!'];
    }

    public function getRoles($id)
    {
        return ['success' => true,'data' => User::find($id)->roles()->get()];
    }
}
