<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        /**  添加用户 */
        DB::table('users')->insert([
            ['id' => 2, 'name' => "李洪彬", 'email' => 'lihongbin@gmail.com', 'password' => bcrypt('123456'),],
            ['id' => 1, 'name' => "超级管理员", 'email' => 'admin@gmail.com', 'password' => bcrypt('123456'),]
        ]);
        /**  添加角色 */
        DB::table('roles')->insert([
            ['id' => 1, 'name' => "admin", 'display_name' => '管理员', 'description' => '超级管理员,可以拥有各种权限',],
        ]);
        /** 添加权限 */
        DB::table('permissions')->insert([
            ['id' => 1, 'name' => "admin-sys", 'display_name' => '初源后台系统管理权限', 'description' => '初源后台系统管理权限', 'parent_id' => 0,],
            ['id' => 2, 'name' => "admin-manager", 'display_name' => '管理员管理权限', 'description' => '获取管理员管理page的权限', 'parent_id' => 1,],
            ['id' => 3, 'name' => "menu-manager", 'display_name' => '菜单管理权限', 'description' => '获取菜单管理page的权限', 'parent_id' => 1,],
            ['id' => 4, 'name' => "role-manager", 'display_name' => '角色管理权限', 'description' => '获取菜单管理page的权限', 'parent_id' => 1,],
            ['id' => 5, 'name' => "permission-manager", 'display_name' => '权限管理权限', 'description' => '获取菜单管理page的权限', 'parent_id' => 1,],
            ['id' => 6, 'name' => "action-manager", 'display_name' => '操作管理权限', 'description' => '获取操作管理page的权限', 'parent_id' => 1,],

            ['id' => 7,'name' => "admin-create",'display_name' => '创建用户权限','description' => '具有创建用户的权限','parent_id' => 2,],
            ['id' => 8,'name' => "admin-delete",'display_name' => '删除用户权限','description' => '具有删除用户的权限','parent_id' => 2,],
            ['id' => 9,'name' => "admin-edit",'display_name' => '编辑用户权限','description' => '具有编辑用户的权限','parent_id' => 2,],

            ['id' => 10,'name' => "menu-create",'display_name' => '创建菜单权限','description' => '具有创建菜单的权限','parent_id' => 3,],
            ['id' => 11,'name' => "menu-delete",'display_name' => '删除菜单权限','description' => '具有删除菜单的权限','parent_id' => 3,],
            ['id' => 12,'name' => "menu-edit",'display_name' => '编辑菜单权限','description' => '具有编辑菜单的权限','parent_id' => 3,],

            ['id' => 13,'name' => "role-create",'display_name' => '创建角色权限','description' => '具有创建角色的权限','parent_id' => 4,],
            ['id' => 14,'name' => "role-delete",'display_name' => '删除角色权限','description' => '具有删除角色的权限','parent_id' => 4,],
            ['id' => 15,'name' => "role-edit",'display_name' => '编辑角色权限','description' => '具有编辑角色的权限','parent_id' => 4,],


            ['id' => 16,'name' => "permission-create",'display_name' => '新增权限的权限','description' => '具有创建权限的权限','parent_id' => 5,],
            ['id' => 17,'name' => "permission-delete",'display_name' => '删除权限的权限','description' => '具有删除权限的权限','parent_id' => 5,],
            ['id' => 18,'name' => "permission-edit",'display_name' => '编辑权限的权限','description' => '具有编辑权限的权限','parent_id' => 5,],

            ['id' => 19,'name' => "action-create",'display_name' => '新增操作的权限','description' => '具有创建操作的权限','parent_id' => 6,],
            ['id' => 20,'name' => "action-delete",'display_name' => '删除操作的权限','description' => '具有删除操作的权限','parent_id' => 6,],
            ['id' => 21,'name' => "action-edit",'display_name' => '编辑操作的权限','description' => '具有编辑操作的权限','parent_id' => 6,],

        ]);
        /** 添加操作  */
        DB::table('actions')->insert([
            ['id' => 1, 'name' => "后台管理", 'action_type' => '系统节点', 'url' => '#admin-sys', 'doc' => '', 'description' => '标识系统,体现层级关系,没有实际操作', 'parent_id' => 0],
            ['id' => 2, 'name' => "请求用户管理", 'action_type' => '请求页面', 'url' => 'user', 'doc' => '', 'description' => '', 'parent_id' => 1],
            ['id' => 3, 'name' => "请求菜单管理", 'action_type' => '请求页面', 'url' => 'menu', 'doc' => '', 'description' => '', 'parent_id' => 1],
            ['id' => 4, 'name' => "请求角色管理", 'action_type' => '请求页面', 'url' => 'role', 'doc' => '', 'description' => '','parent_id' => 1],
            ['id' => 5, 'name' => "请求权限管理", 'action_type' => '请求页面', 'url' => 'permission', 'doc' => '', 'description' => '', 'parent_id' => 1],
            ['id' => 6, 'name' => "请求操作管理", 'action_type' => '请求页面', 'url' => 'action', 'doc' => '', 'description' => '', 'parent_id' => 1],

            ['id' => 7, 'name' => "创建用户", 'action_type' => '页内操作', 'url' => 'user/create', 'doc' => '', 'description' => '', 'parent_id' => 2],
            ['id' => 8, 'name' => "删除用户", 'action_type' => '页内操作', 'url' => 'user/delete/{id}', 'doc' => '', 'description' => '', 'parent_id' => 2],
            ['id' => 9, 'name' => "编辑用户", 'action_type' => '页内操作', 'url' => 'user/update/{id}', 'doc' => '', 'description' => '', 'parent_id' => 2],


            ['id' => 10, 'name' => "创建菜单", 'action_type' => '页内操作', 'url' => 'menu/create', 'doc' => '', 'description' => '', 'parent_id' => 3],
            ['id' => 11, 'name' => "删除菜单", 'action_type' => '页内操作', 'url' => 'menu/delete/{id}', 'doc' => '', 'description' => '', 'parent_id' => 3],
            ['id' => 12, 'name' => "编辑菜单", 'action_type' => '页内操作', 'url' => 'menu/update/{id}', 'doc' => '', 'description' => '', 'parent_id' => 3],


            ['id' => 13, 'name' => "创建角色", 'action_type' => '页内操作', 'url' => 'role/create', 'doc' => '', 'description' => '', 'parent_id' => 4],
            ['id' => 14, 'name' => "删除角色", 'action_type' => '页内操作', 'url' => 'role/delete/{id}', 'doc' => '', 'description' => '', 'parent_id' => 4],
            ['id' => 15, 'name' => "编辑角色", 'action_type' => '页内操作', 'url' => 'role/update/{id}', 'doc' => '', 'description' => '', 'parent_id' => 4],

            ['id' => 16, 'name' => "创建权限", 'action_type' => '页内操作', 'url' => 'permission/create', 'doc' => '', 'description' => '', 'parent_id' => 5],
            ['id' => 17, 'name' => "删除权限", 'action_type' => '页内操作', 'url' => 'permission/delete/{id}', 'doc' => '', 'description' => '', 'parent_id' => 5],
            ['id' => 18, 'name' => "编辑权限", 'action_type' => '页内操作', 'url' => 'permission/update/{id}', 'doc' => '', 'description' => '', 'parent_id' => 5],


            ['id' => 19, 'name' => "创建操作", 'action_type' => '页内操作', 'url' => 'action/create', 'doc' => '', 'description' => '', 'parent_id' => 6],
            ['id' => 20, 'name' => "删除操作", 'action_type' => '页内操作', 'url' => 'action/delete/{id}', 'doc' => '', 'description' => '', 'parent_id' => 6],
            ['id' => 21, 'name' => "编辑操作", 'action_type' => '页内操作', 'url' => 'action/update/{id}', 'doc' => '', 'description' => '', 'parent_id' => 6],

        ]);
        /** 添加菜单 */
        DB::table('menus')->insert([
            ['id' => 1, 'name' => "后台系统设置", 'icon' => 'icon-admin', 'action_id' => 1, 'parent_id' => 0],
            ['id' => 2, 'name' => "管理员管理", 'icon' => 'icon-admin', 'action_id' => 2, 'parent_id' => 1],
            ['id' => 3, 'name' => "菜单管理", 'icon' => 'icon-role', 'action_id' => 3, 'parent_id' => 1],
            ['id' => 4, 'name' => "角色管理", 'icon' => 'icon-permission', 'action_id' => 4, 'parent_id' => 1],
            ['id' => 5, 'name' => "权限管理", 'icon' => 'icon-action', 'action_id' => 5, 'parent_id' => 1],
            ['id' => 6, 'name' => "操作管理", 'icon' => 'icon-menu', 'action_id' => 6, 'parent_id' => 1],
        ]);
        /** 添加用户角色关联 */
        DB::table('role_user')->insert([
            ['user_id' =>1, 'role_id' =>1,],
        ]);
        /**  添加角色权限关联 */
        DB::table('permission_role')->insert([
            ['permission_id' =>1, 'role_id' => 1,],
            ['permission_id' =>2, 'role_id' => 1,],
            ['permission_id' =>3, 'role_id' => 1,],
            ['permission_id' =>4, 'role_id' => 1,],
            ['permission_id' =>5, 'role_id' => 1,],
            ['permission_id' =>6, 'role_id' => 1,],
            ['permission_id' =>7, 'role_id' => 1,],
            ['permission_id' =>8, 'role_id' => 1,],
            ['permission_id' =>9, 'role_id' => 1,],
            ['permission_id' =>10, 'role_id' => 1,],
            ['permission_id' =>11, 'role_id' => 1,],
            ['permission_id' =>12, 'role_id' => 1,],
            ['permission_id' =>13, 'role_id' => 1,],
            ['permission_id' =>14, 'role_id' => 1,],
            ['permission_id' =>15, 'role_id' => 1,],
            ['permission_id' =>16, 'role_id' => 1,],
            ['permission_id' =>17, 'role_id' => 1,],
            ['permission_id' =>18, 'role_id' => 1,],
            ['permission_id' =>19, 'role_id' => 1,],
            ['permission_id' =>20, 'role_id' => 1,],
            ['permission_id' =>21, 'role_id' => 1,],

        ]);
        /** 权限操作关联 */
        DB::table('action_permission')->insert([
            ['permission_id' =>1, 'action_id' =>1,],
            ['permission_id' =>2, 'action_id' =>2,],
            ['permission_id' =>3, 'action_id' =>3,],
            ['permission_id' =>4, 'action_id' =>4,],
            ['permission_id' =>5, 'action_id' =>5,],
            ['permission_id' =>6, 'action_id' =>6,],
            ['permission_id' =>7, 'action_id' =>7,],
            ['permission_id' =>8, 'action_id' =>8,],
            ['permission_id' =>9, 'action_id' =>9,],
            ['permission_id' =>10, 'action_id' =>10,],
            ['permission_id' =>11, 'action_id' =>11,],
            ['permission_id' =>12, 'action_id' =>12,],
            ['permission_id' =>13, 'action_id' =>13,],
            ['permission_id' =>14, 'action_id' =>14,],
            ['permission_id' =>15, 'action_id' =>15,],
            ['permission_id' =>16, 'action_id' =>16,],
            ['permission_id' =>17, 'action_id' =>17,],
            ['permission_id' =>18, 'action_id' =>18,],
            ['permission_id' =>19, 'action_id' =>19,],
            ['permission_id' =>20, 'action_id' =>20,],
            ['permission_id' =>21, 'action_id' =>21,],
        ]);
    }
}
