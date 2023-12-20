<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Notifications\Notifiable;

class GenBusinessData extends Authenticate
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'gen_business_data';

    protected $primaryKey = 'id';

    public $timestamps = true;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

}
