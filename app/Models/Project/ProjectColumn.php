<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProjectColumn extends Model
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'project_column';

    protected $primaryKey = 'column_id';

    public $timestamps = true;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';
}
