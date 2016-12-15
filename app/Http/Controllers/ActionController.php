<?php

namespace App\Http\Controllers;

use App\Action;
use App\Permission;
use Illuminate\Http\Request;
use Validator;

class ActionController extends Controller
{
    //
    public function showActionManager()
    {
        return view('admin.action');
    }

    public function getActionPermissions($id)
    {
        $action = Action::find($id);
        $permission = $action -> perms() -> first();
        return ['success'=> true,'msg'=>'请求成功!','data'=>$permission];
    }
    public function getAllActions(Request $request)
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
            $actions = Action::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")
                ->where('name','like','%'.$data['qname'].'%')->paginate($data['rows']);
            return $actions;
        }
        $actions = Action::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")->paginate($data['rows']);
        return $actions;
    }

    /**
     * 删除
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        Action::destroy($id);
        return ['success' => true,'msg' => '删除成功!'];
    }

    /**
     * 更新
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request,$id)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'name' => 'required|string|max:24',
            'url' => 'required|string|max:64',
            'description' => 'required|string|max:64',
            'action_type' => 'required|string|max:12',
            'parent_id' => 'numeric',
            'permission' => 'required|numeric',
        ]);
        if($validator->fails()){
            return ['success' => false,'msg' => $validator->errors()->first()];
        }
        $action = Action::find($id);
        $action -> name = $data['name'];
        $action -> url = $data['url'];
        $action -> description = $data['description'];
        $action -> action_type = $data['action_type'];
        $action -> parent_id = $data['parent_id'];
        $action -> save();
        $action -> perms() ->detach();
        if(isset($data['permission']) && count($data['permission']) > 0) {
            $action->perms()->save(Permission::find($data['permission']));
        }
        return ['success' => true,'msg' => '更新成功!'];
    }

    /**
     * 新建
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'name' => 'required|string|max:24',
            'url' => 'required|string|max:64',
            'description' => 'required|string|max:64',
            'action_type' => 'required|string|max:12',
            'parent_id' => 'numeric',
            'permission' => 'required|numeric',
        ]);
        if($validator->fails()){
            return ['success' => false,'msg' => $validator->errors()->first()];
        }
        $action = Action::create([
            'name' => $data['name'],
            'url' => $data['url'],
            'description' => $data['description'],
            'action_type' => $data['action_type'],
            'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : 0,
        ]);
        if(isset($data['permission']) && count($data['permission']) > 0) {
            $action -> perms() -> save(Permission::find($data['permission']));
        }
        return ['success' => true,'msg' => '新增成功!'];
    }
    /**
     * 获取符合easyui树形结构的权限json,不带有根节点
     */
    public function getAllActionsByTree(){
        $actions = Action::all();
        return $this->buildEasyUITree($actions);
    }

    /**
     * 获取符合easyui树形结构的权限json,带有根节点
     * @return array
     */
    public function getAllActionsByRootTree(){
        return [[
            'id'=>0,
            'text'=>'ROOT',
            'children'=> $this->getAllActionsByTree()
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
                $row['text'] = $row['name'];
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
