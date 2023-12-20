<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;

class SysUser extends Authenticate
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'sys_user';

    protected $primaryKey = 'user_id';

    public $timestamps = true;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * 关联角色
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(SysRole::class, 'sys_user_role', 'user_id', 'role_id');
    }

    /**
     * 关联角色
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(SysPost::class, 'sys_user_post', 'user_id', 'post_id');
    }

    /**
     * 关联部门
     */
    public function dept():BelongsTo
    {
        return $this->belongsTo(SysDept::class,  'dept_id', 'dept_id');
    }

    /**
     * 是否是超管
     */
    public function isAdmin(): bool
    {
        $admin_ids = explode(',', env('ADMIN_ROLE_IDS', 1));
        return in_array($this->roles()->first()->role_id, $admin_ids);
    }
}
