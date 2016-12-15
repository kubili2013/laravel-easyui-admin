<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use Validator;

class PermissionController extends Controller
{
    //
    public function showPermissionManager()
    {
        return view('admin.permission');
    }

    public function create(Request $request)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'name' => 'required|string|max:64',
            'display_name' => 'required|string|max:48',
            'description' => 'required|string|max:128',
            'parent_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return ['success' => false,'msg' => $validator->errors()->first()];
        }
        Permission::create([
            'name' => $data['name'],
            'display_name' => $data['display_name'],
            'description' => $data['description'],
            'parent_id' => $data['parent_id'],
        ]);
        return ['success' => true,'msg' => '新增成功!'];
    }

    public function update(Request $request,$id)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'name' => 'required|string|max:64',
            'display_name' => 'required|string|max:48',
            'description' => 'required|string|max:128',
            'parent_id' => 'required|integer',
        ]);
        if($validator->fails()){
            return ['success' => false,'msg' => $validator->errors()->first()];
        }
        $permission = Permission::find($id);
        $permission -> name = $data['name'];
        $permission -> display_name = $data['display_name'];
        $permission -> description = $data['description'];
        $permission -> parent_id = $data['parent_id'];
        $permission -> save();
        return ['success'=>true,'msg'=>'更新成功'];

    }
    /**
     * 删除权限,将关联的权限全部删除
     * @param Request $request
     * @param $id
     * @return array
     */
    public function delete(Request $request,$id)
    {
        Permission::destroy($id);
        Permission::where('parent_id',$id)->delete();
        return ['success' => true,'msg' => '删除成功!'];
    }
    /**
     * 菜单管理,根据分页条件以及查询条件获取分页数据
     * @param Request $request
     * @return mixed
     */
    public function getAllPermissions(Request $request)
    {
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
            $permission = Permission::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")
                ->where('display_name','like','%'.$data['qname'].'%')->paginate($data['rows']);
            return $permission;
        }
        $permission = Permission::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")->paginate($data['rows']);
        return $permission;
    }
    /**
     * 获取符合easyui树形结构的权限json,不带有根节点
     */
    public function getAllPermissionByTree(){
        $permission = Permission::all();
        return $this->buildEasyUITree($permission);
    }

    /**
     * 获取符合easyui树形结构的权限json,带有根节点
     * @return array
     */
    public function getAllPermissionByRootTree(){
        return [[
            'id'=>0,
            'text'=>'ROOT',
            'children'=> $this->getAllPermissionByTree()
        ]];
    }
    /**
     * 递归生成适用于easyui的树 以parent_id=0开始
     * @param $table
     * @param string $p_id
     * @return array
     */
    public function buildEasyUITree($table,$p_id='0') {
        $tree = array();
        foreach($table as $row){
            if($row['parent_id']==$p_id){
                $tmp = $this->buildEasyUITree($table,$row['id']);
                $row['text'] = $row['display_name'];
                if($tmp){
                    $row['children']=$tmp;
                }else{
                    $row['leaf'] = true;
                }
                $tree[]=$row;
            }
        }
        return $tree;
    }
}
