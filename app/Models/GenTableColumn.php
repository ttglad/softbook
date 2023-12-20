<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GenTableColumn extends Model
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'gen_table_column';

    protected $primaryKey = 'column_id';

    public $timestamps = true;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';
}
