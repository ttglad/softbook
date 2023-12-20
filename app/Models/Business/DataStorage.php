<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DataStorage
 *
 * @package App\Models\Business
 */
class DataStorage extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'data_storage_1';

    /**
     * model名称
     *
     * @var string
     */
    const MODEL_NAME = '';

    /**
     * 可以被批量赋值的字段
     *
     * @var array
     */
    protected $fillable = [
        'id', //自增字段
        'data_number', //数据编号
        'data_name', //数据名称
        'storage_path', //存储路径
        'data_query', //数据查询
        'data_export', //数据导出
    ];

    // 自增字段
    protected $primaryKey = 'id';

    // 时间戳
    public $timestamps = false;

    // 创建时间
//    const CREATED_AT = 'create_time';

    // 修改时间
//    const UPDATED_AT = 'update_time';
}
