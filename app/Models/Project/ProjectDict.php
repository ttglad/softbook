<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ProjectDict extends Model
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'project_dict';

    protected $primaryKey = 'dict_id';

    public $timestamps = false;
}
