<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class GenTable extends Model
{
    use Notifiable;

//    protected $connection = 'mysql';

    protected $table = 'gen_table';

    protected $primaryKey = 'table_id';

    public $timestamps = true;

    const CREATED_AT = 'create_time';

    const UPDATED_AT = 'update_time';

    /**
     * 关联列
     */
    public function columns(): HasMany
    {
        return $this->hasMany(GenTableColumn::class, 'table_id', 'table_id');
    }
}
