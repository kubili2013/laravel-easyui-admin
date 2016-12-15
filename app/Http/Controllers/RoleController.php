<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Validator;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function showRoleManager(){
        return view('admin.role');
    }

    /**
     * 根据id删除
     * @param Request $request
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        Role::destroy($id);
        return ['success' => true,'msg' => '删除成功!'];
    }

    /**
     * 根据分页条件以及查询条件获取分页数据
     * @param Request $request
     * @return mixed
     */
    public function getRolesPage(Request $request)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'page' => 'numeric',
            'rows' => 'numeric',
            'sort' => 'string|max:64',
            'order' => 'in:asc,desc',
            //'qname' => 'string|max:24'
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
//        if(isset($data['qname'])){
//            $menus = Menu::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")
//                ->where('name','like','%'.$data['qname'].'%')->paginate($data['rows']);
//            return $menus;
//        }
        $roles = Role::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")->paginate($data['rows']);
        return $roles;
    }

    /**
     * 获取role所具有的全部权限
     * @param $id
     * @return array
     */
    public function getRolePermissions($id){
        $role = Role::find($id);
        $permissions = $role->perms()->get();
        return ['success'=> true,'msg'=>'请求成功!','data'=>$permissions];
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'name' => 'required|string|max:16',
            'display_name' => 'required|string|max:48',
            'description' => 'required|string|max:64',
            'permissions' => 'required|array',
        ]);
        if($validator->fails()){
            return $validator->errors();
        }
        $role = Role::find($id);
        $role->id = $id;
        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->description = $data['description'];
        $role->save();
        $role->perms()->detach();
        if(isset($data['permissions']) && count($data['permissions']) > 0) {
            $role->perms()->saveMany(Permission::find($data['permissions']));
        }
        return ['success'=>true,'msg'=>'更新成功!'];
    }

    public function create(Request $request)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'name' => 'required|string|max:16',
            'display_name' => 'required|string|max:48',
            'description' => 'required|string|max:64',
            'permissions' => 'required|array',
        ]);
        if($validator->fails()){
            return ['success' => false,'msg' => $validator->errors()->first()];
        }
        $role = new Role();
        $role->name = $data['name'];
        $role->display_name = $data['display_name'];
        $role->description = $data['description'];
        $role->save();
        if(isset($data['permissions']) && count($data['permissions']) > 0) {
            $role->perms()->saveMany(Permission::find($data['permissions']));
        }
        return ['success'=>true,'msg'=>'新增成功!'];
    }
}
