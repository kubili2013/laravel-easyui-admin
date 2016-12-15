<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    // 当类名与表明不匹配时,定义此属性,类名是可数名词,不定义此属性会自动使用复数形式
    protected $table = "menus";
    // 没有created_at 与 updated_at
    public $timestamps = false;
    // 定义哪些列是可写的
    protected $fillable = [
        'name', 'action_id', 'icon', 'parent_id',
    ];
//    错误的sql,问题待查
//    protected static $sql = "SELECT * FROM ( ".
//            "SELECT menus.* FROM menus WHERE action_id IN ( ".
//            "SELECT id FROM actions INNER JOIN ( ".
//            "SELECT action_permission.* ".
//            "FROM action_permission ".
//            "WHERE action_permission.permission_id IN ( ".
//            "SELECT DISTINCT (permission_role.permission_id) ".
//            "FROM permission_role ".
//            "INNER JOIN ( ".
//            "SELECT roles.* ".
//            "FROM roles ".
//            "INNER JOIN role_user ".
//            "ON role_user.role_id = roles.id ".
//            "WHERE role_user.user_id = ? ) rls ".
//            "ON rls.id = permission_role.role_id) ".
//            ") aps ON aps.action_id = actions.id WHERE action_type = '请求页面')) cm ".
//            "UNION ALL ".
//            "SELECT * FROM menus WHERE id = ( ".
//            "SELECT DISTINCT (parent_id) FROM menus WHERE action_id IN ( ".
//            "SELECT id FROM actions INNER JOIN ( ".
//            "SELECT action_permission.* ".
//            "FROM action_permission ".
//            "WHERE action_permission.permission_id IN ( ".
//            "SELECT DISTINCT (permission_role.permission_id) ".
//            "FROM permission_role ".
//            "INNER JOIN ( ".
//            "SELECT roles.* ".
//            "FROM roles ".
//            "INNER JOIN role_user ".
//            "ON role_user.role_id = roles.id ".
//            "WHERE role_user.user_id = ? ) rls ".
//            "ON rls.id = permission_role.role_id) ".
//            ") aps ON aps.action_id = actions.id WHERE action_type = '请求页面')) ";
    protected static $sql = 'SELECT * FROM menus WHERE action_id IN ( '.
                            '  SELECT actions.id '.
                            '  FROM actions '.
                            '  WHERE id IN ( '.
                            '    SELECT DISTINCT parent_id '.
                            '    FROM actions '.
                            '    WHERE id IN ( '.
                            '      SELECT action_id '.
                            '      FROM action_permission '.
                            '      WHERE permission_id IN ( '.
                            '        SELECT permission_id '.
                            '        FROM permission_role '.
                            '        WHERE role_id IN (SELECT role_id '.
                            '                          FROM role_user '.
                            '                          WHERE user_id = ?) '.
                            '      ) '.
                            '    ) '.
                            '          AND actions.action_type = "页内操作" '.
                            '  ) '.
                            ') '.
                            'UNION '.
                            '  SELECT * FROM menus WHERE id IN ( '.
                            '    SELECT menus.parent_id '.
                            '    FROM menus '.
                            '    WHERE action_id IN ( '.
                            '      SELECT actions.id '.
                            '      FROM actions '.
                            '      WHERE id IN ( '.
                            '        SELECT DISTINCT parent_id '.
                            '        FROM actions '.
                            '        WHERE id IN ( '.
                            '          SELECT action_id '.
                            '          FROM action_permission '.
                            '          WHERE permission_id IN ( '.
                            '            SELECT permission_id '.
                            '            FROM permission_role '.
                            '            WHERE role_id IN (SELECT role_id '.
                            '                              FROM role_user '.
                            '                              WHERE user_id = ?) '.
                            '          ) '.
                            '        ) '.
                            '              AND actions.action_type = "页内操作" '.
                            '      ) '.
                            '    ) '.
                            '  )';

    public function action()
    {
        return $this->hasOne(Action::class,"id","action_id");
    }

    public static function getMyMenus($user_id){

       return DB::select(Menu::$sql, [$user_id,$user_id]);
    }
}
