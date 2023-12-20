<?php

namespace App\Services;


use App\Models\GenBusinessData;
use App\Models\GenTableColumn;
use App\Models\SysMenu;
use App\Models\SysUser;

class BusinessDataService extends Service
{
    private $columnNums = 10;

    /**
     * 数据查询
     * @param $business
     * @param $businessColumn
     * @param $pageSize
     * @return mixed
     */
    public function businessDataQuery($business, $businessColumn, $request)
    {
        // 初始化查询条件
        $businessData = GenBusinessData::where('table_id', $business->table_id);

        // 增加查询条件
        foreach ($businessColumn as $column) {
            if ($column->is_query == 1 && $request->exists($column->column_name) && !empty(trim($request->post($column->column_name)))) {
                switch (strtoupper($column->query_type)) {
                    case 'LIKE':
                        $businessData = $businessData->where('value_' . ($column->sort - 1), 'like',
                            '%' . trim($request->post($column->column_name)) . '%');
                        break;
                    default:
                        $businessData = $businessData->where('value_' . ($column->sort - 1),
                            trim($request->post($column->column_name)));
                        break;
                }
            }
        }

        $businessData = $businessData->orderByDesc('id')
            ->paginate($request->post('pageSize') ?? 10)
            ->toArray();
        return $businessData;
    }

    /**
     * 格式化数组
     * @param $businessData
     * @return array
     */
    public function businessDataFormat($businessData): array
    {
        $return = [];
        foreach ($businessData as $data) {
            $temp = [];
            $temp['id'] = $data['id'];
            for ($i = 1; $i <= $this->columnNums; $i++) {
                $key = $data['column_' . $i];
                $value = $data['value_' . $i];
                if (!empty($key)) {
                    $temp[$key] = $value;
                }
            }
            $return[] = $temp;
        }
        return $return;
    }

    /**
     * 格式化数组
     * @param $businessData
     * @param $columns
     * @return array
     */
    public function businessDataFormatSingle($businessData, $columns): array
    {
        $return = [];
        // 解析数据
        $temp = [];
        $return['id'] = $businessData->id;
        for ($i = 1; $i <= $this->columnNums; $i++) {
            $key = $businessData['column_' . $i];
            $value = $businessData['value_' . $i];
            if (!empty($key)) {
                $temp[$key] = $value;
            }
        }

        foreach ($columns as $column) {
            if ($column->column_name == 'id') {
                continue;
            }
            if (isset($temp[$column->column_name])) {
                $return[$column->column_name] = $temp[$column->column_name];
            } else {
                $return[$column->column_name] = '';
            }
        }
        return $return;
    }
}
