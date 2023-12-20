<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SysPost extends Model
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'sys_post';

    protected $primaryKey = 'post_id';

    public $timestamps = true;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';
}
