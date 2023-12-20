<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SysRole extends Authenticatable
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'sys_role';

    protected $primaryKey = 'role_id';

    public $timestamps = true;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    /**
     * 关联菜单
     */
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(SysMenu::class, 'sys_role_menu', 'role_id', 'menu_id');
    }

    /**
     * 关联用户
     */
    public function users(): BelongsToMany
    {
        return $this->BelongsToMany(SysUser::class, 'sys_user_role', 'role_id', 'user_id');
    }


    /**
     * 关联部门
     */
    public function depts(): BelongsToMany
    {
        return $this->BelongsToMany(SysDept::class, 'sys_role_dept', 'role_id', 'dept_id');
    }
}
