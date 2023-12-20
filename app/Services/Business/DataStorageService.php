<?php

namespace App\Services\Business;

use App\Models\Business\DataStorage;

/**
 * Class DataStorageService
 *
 * @package App\Services\Business
 */
class DataStorageService extends BusinessService
{
    /**
     * 新建数据存储
     *
     * @param DataStorage $data
     *
     * @return App\Models\Business\DataStorage
     */
    public static function save(DataStorage $data): bool
    {
        return $data->save();
    }

    /**
     * 查询列表页
     * @param DataStorage $data
     * @param int $page
     * @return array
     */
    public static function query(DataStorage $data, int $page = 10): array
    {
        $model = new DataStorage();
        if ($data->data_number) {
            $model = $model->where('data_number', $data->data_number);
        }
        if ($data->data_name) {
            $model = $model->where('data_name', $data->data_name);
        }
        if ($data->storage_path) {
            $model = $model->where('storage_path', $data->storage_path);
        }
        if ($data->data_query) {
            $model = $model->where('data_query', $data->data_query);
        }
        if ($data->data_export) {
            $model = $model->where('data_export', $data->data_export);
        }

        $list = $model->orderByDesc('id')
            ->paginate($pageSize ?? 10)
            ->toArray();
        return $list;
    }

    /**
     * 查询单条明细
     * @param int $id
     * @return DataStorage
     */
    public static function detail(int $id): DataStorage
    {
        return DataStorage::findOrFail($id);
    }


    /**
     * 删除数据存储
     * @param DataStorage $model
     * @return void
     * @throws \Exception
     */
    public static function delete(DataStorage $model): void
    {
        $model->delete();
    }
}
