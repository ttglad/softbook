<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SysDept extends Model
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'sys_dept';

    protected $primaryKey = 'dept_id';

    public $timestamps = true;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';
}
