<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    // 定义哪些列是可写的
    protected $fillable = [
        'name', 'display_name', 'description', 'parent_id',
    ];

    public static function getPermissionByActions($ids)
    {
        return DB::table('permissions')
            ->join('action_permission', 'permissions.id', '=', 'action_permission.permission_id')
            ->whereIn('action_permission.action_id',$ids)
            ->get();
    }
}