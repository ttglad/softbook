<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SysLoginLog extends Model
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'sys_login_log';

    protected $primaryKey = 'login_id';

    public $timestamps = false;
//
//    const CREATED_AT = 'create_time';
//
//    const UPDATED_AT = 'update_time';
}
