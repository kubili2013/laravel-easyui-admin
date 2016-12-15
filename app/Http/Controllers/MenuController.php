<?php

namespace App\Http\Controllers;

use App\Action;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Validator;

class MenuController extends Controller
{
    /**
     * 界面跳转
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMenuManager()
    {
        return view('admin.menu');
    }
    /**
     * 主界面 根据当前登录用户,结合权限树,获取树形菜单,json输出
     * @return array
     */
    public function getMenusByUser()
    {
        $user = Auth::user();
        $menus = Menu::all();
        $myMenus = Menu::getMyMenus($user->id);
        // dd($myMenus);
        // 目前开发状态 所有菜单都显示
        return $this->buildTree($myMenus);
    }

    /**
     * 获取符合easyui树形结构的菜单json
     */
    public function getAllMenusByTree(){
        $menus = Menu::all();
        return [[
            'id'=>0,
            'text'=>'ROOT',
            'children'=>$this->buildEasyUITree($menus)
        ]];
    }
    /**
     * 菜单管理,根据分页条件以及查询条件获取分页数据
     * @param Request $request
     * @return mixed
     */
    public function getAllMenus(Request $request)
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
            $menus = Menu::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")
                ->where('name','like','%'.$data['qname'].'%')->paginate($data['rows']);
            return $menus;
        }
        $menus = Menu::orderBy(isset($data['sort'])?$data['sort']:"id",isset($data['order'])?$data['order']:"asc")->paginate($data['rows']);
        return $menus;
    }

    /**
     * 新增一个菜单,post提交
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {
        $data = $request->all();
        // 校验数据
        $validator = Validator::make($data,[
            'name' => 'required|string|max:16|unique:menus',
            'icon' => 'required|string|max:48',
            'description' => 'required|string|max:100',
            'parent_id' => 'numeric',
            'action' => 'required|numeric',
        ]);
        if($validator->fails()){
            return ['success' => false,'msg' => $validator->errors()->first()];
        }
        $menu = Menu::create([
            'name' => $data['name'],
            'icon' => $data['icon'],
            'description' =>  $data['description'],
            'parent_id' =>  $data['parent_id'],
        ]);
        if(isset($data['action']) && count($data['action']) > 0) {
            $menu->action()->save(Action::find($data['action']));
        }
        return ['success' => true,'msg' => '新增成功!'];
    }

    /**
     * 根据id删除
     * @param Request $request
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        Menu::destroy($id);
        return ['success' => true,'msg' => '删除成功!'];
    }
    /**
     * 递归生成树 以 0 开始
     * @param $table
     * @param string $p_id
     * @return array
     */
    public function buildTree($table,$p_id='0') {
        $tree = array();
        foreach($table as $row){
            if($row -> parent_id == $p_id){
                $tmp = $this->buildTree($table,$row->id);
                if($tmp){
                    $row -> children=$tmp;
                }else{
                    $row -> leaf = true;
                }
                $tree[]=$row;
            }
        }
        return $tree;
    }
    /**
     * 递归生成适用于easyui的树 以0开始
     * @param $table
     * @param string $p_id
     * @return array
     */
    public function buildEasyUITree($table,$p_id='0') {
        $tree = array();
        foreach($table as $row){
            if($row->parent_id == $p_id){
                $tmp = $this->buildEasyUITree($table,$row->id);
                $row->text = $row->name;
                if($tmp){
                    $row->children= $tmp;
                }else{
                    $row->leaf = true;
                }
                $tree[]=$row;
            }
        }
        return $tree;
    }
}
