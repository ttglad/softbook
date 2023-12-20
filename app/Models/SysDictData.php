<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SysDictData extends Model
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'sys_dict_data';

    protected $primaryKey = 'dict_code';

    public $timestamps = true;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';
}
