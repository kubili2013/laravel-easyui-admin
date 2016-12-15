<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Action extends Model
{
    // 当类名与表明不匹配时,定义此属性,类名是可数名词,不定义此属性会自动使用复数形式
    protected $table = "actions";
    // 定义哪些列是可写的
    protected $fillable = [
        'name', 'url', 'action_type', 'description', 'parent_id',
    ];
    public function perms()
    {
        return $this->belongsToMany(Config::get('entrust.permission'), 'action_permission', 'action_id', 'permission_id');
    }
}
