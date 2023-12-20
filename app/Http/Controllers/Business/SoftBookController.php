<?php

namespace App\Http\Controllers\Business;

use App\Models\GenBusinessData;
use App\Models\GenTable;
use App\Models\GenTableColumn;
use App\Services\BusinessDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * 业务处理控制器
 *
 * @author SoftBook
 */
class SoftBookController extends BusinessController
{

    /**
     * 展示页面
     * @param Request $request
     * @param $table
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $table)
    {
        // 业务名称
        $business = GenTable::where('table_name', $table)->first();
        if (is_null($business)) {
            abort(404);
        }
        // 业务列名称
        $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();

        return view('business.show', [
            'business' => $business,
            'businessColumn' => $businessColumn,
        ]);
    }

    /**
     * 新增页面
     * @param Request $request
     * @param $table
     * @return \Illuminate\View\View
     */
    public function add(Request $request, $table)
    {
        // 业务名称
        $business = GenTable::where('table_name', $table)->first();
        if (is_null($business)) {
            abort(404);
        }
        // 业务列名称
        $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();

        return view('business.add', [
            'business' => $business,
            'businessColumn' => $businessColumn,
        ]);
    }

    /**
     * 新增页面提交
     * @param Request $request
     * @param $table
     * @return array|mixed
     */
    public function addPost(Request $request, $table)
    {
        $return = $this->ajaxReturn;
        try {
            // 业务名称
            $business = GenTable::where('table_name', $table)->first();
            if (is_null($business)) {
                throw new \Exception('业务不存在', 1001);
            }

            // 业务列名称
            $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();
            $postData = $request->post();
            $businessData = new GenBusinessData();
            $businessData->table_id = $business->table_id;
            $businessData->table_name = $business->table_name;
            $businessData->create_by = auth()->user()->login_name;
            $i = 0;
            foreach ($businessColumn as $column) {
                if (in_array($column->column_name, ['id'])) {
                    continue;
                }
                if ($i >= 10) {
                    throw new \Exception('业务参数过多', 1002);
                }
                $i++;
                $key = 'column_' . $i;
                $value = 'value_' . $i;
                $businessData->$key = $column->column_name;
                $businessData->$value = '';
                if (isset($postData[$column->column_name])) {
                    $businessData->$value = $postData[$column->column_name];
                }
            }
            $businessData->save();
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }


    /**
     * 修改页面
     * @param Request $request
     * @param $table
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, $table, $id)
    {
        // 业务名称
        $business = GenTable::where('table_name', $table)->first();
        if (is_null($business)) {
            abort(404);
        }
        // 业务列名称
        $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();
        $businessData = GenBusinessData::findOrFail($id);
        if ($businessData->table_id != $business->table_id) {
            abort(404);
        }

        $businessService = new BusinessDataService();
        $businessData = $businessService->businessDataFormatSingle($businessData, $businessColumn);

        return view('business.edit', [
            'business' => $business,
            'businessColumn' => $businessColumn,
            'businessData' => $businessData,
        ]);
    }

    /**
     * 修改页面提交
     * @param Request $request
     * @param $table
     * @return array|mixed
     */
    public function editPost(Request $request, $table)
    {
        $return = $this->ajaxReturn;
        try {
            // 业务名称
            $business = GenTable::where('table_name', $table)->first();
            if (is_null($business)) {
                throw new \Exception('业务不存在', 1001);
            }

            $businessData = GenBusinessData::findOrFail($request->post('id'));
            if ($businessData->table_id != $business->table_id) {
                throw new \Exception('数据权限不正确', 1002);
            }

            // 业务列名称
            $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();
            $postData = $request->post();
            $i = 0;
            foreach ($businessColumn as $column) {
                if (in_array($column->column_name, ['id'])) {
                    continue;
                }
                if ($i >= 10) {
                    throw new \Exception('业务参数过多', 1002);
                }
                $i++;
                $key = 'column_' . $i;
                $value = 'value_' . $i;
                $businessData->$key = $column->column_name;
                $businessData->$value = '';
                if (isset($postData[$column->column_name])) {
                    $businessData->$value = $postData[$column->column_name];
                }
            }
            $businessData->update_by = auth()->user()->login_name;
            $businessData->save();
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 列表接口
     * @param Request $request
     * @param $table
     * @return array|mixed
     */
    public function lists(Request $request, $table)
    {
        $return = $this->ajaxReturnWithPage;

        try {
            // 业务名称
            $business = GenTable::where('table_name', $table)->first();
            if (is_null($business)) {
                return $return;
            }

            // 业务列名称
            $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();

            $businessServices = new BusinessDataService();
            $businessData = $businessServices->businessDataQuery($business, $businessColumn, $request);

            $return['rows'] = $businessServices->businessDataFormat($businessData['data']);
            $return['total'] = $businessData['total'];
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 删除数据类
     * @return void
     */
    public function remove(Request $request, $table)
    {
        $return = $this->ajaxReturn;
        try {
            // 业务名称
            $business = GenTable::where('table_name', $table)->first();
            if (is_null($business)) {
                throw new \Exception('业务不存在', 1001);
            }

            $ids = explode(',', trim($request->post('ids')));
            if (empty($ids)) {
                throw new \Exception('选中的记录不能为空', 1001);
            }
            foreach ($ids as $id) {
                try {
                    $businessData = GenBusinessData::findOrFail($id);
                    if ($businessData->table_id == $business->table_id) {
                        $businessData->delete();
                    }
                } catch (\Exception $e) {

                }
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 数据导出
     * @param Request $request
     * @param $table
     * @return array|mixed
     */
    public function export(Request $request, $table)
    {
        $return = $this->ajaxReturn;
        try {

            // 业务名称
            $business = GenTable::where('table_name', $table)->first();
            if (is_null($business)) {
                throw new \Exception('业务不存在', 1001);
            }
            $header = [];
            // 业务列名称
            $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();

            $businessServices = new BusinessDataService();
            $businessData = $businessServices->businessDataQuery($business, $businessColumn, $request);

            $data = $businessServices->businessDataFormat($businessData['data']);
            if (empty($data)) {
                abort(404);
            }

            // 遍历业务列，获取头数组
            foreach ($businessColumn as $column) {
                if (in_array($column->column_name, ['id'])) {
                    continue;
                }
                $header[] = $column->column_comment;
            }

            // 临时文件目录
            $directory = storage_path('files');
            // 判断临时文件目录是否存在
            if (!File::isDirectory($directory)) {
                // 创建一个临时文件目录
                File::makeDirectory($directory, 0755, true);
            }

            // 临时文件名称
            $filename = $business->table_name . date('YmdHis') . '.csv';
            // 临时文件完整路径
            $path = $directory . '/' . $filename;
            // 打开文件进行写入
            $fileCsv = fopen($path, 'w');
            // 写入头部
            fputcsv($fileCsv, $header);
            // 循环所有的写入数据
            foreach ($data as $row) {
                $addRow = [];
                foreach ($businessColumn as $column) {
                    if (in_array($column->column_name, ['id'])) {
                        continue;
                    }
                    $addRow[] = $row[$column->column_name];
                }
                // 追加到文件
                fputcsv($fileCsv, $addRow);
            }
            // 关闭文件
            fclose($fileCsv);

            $return['msg'] = $filename;
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 下载文件
     *
     * @return void
     */
    public function download(Request $request)
    {
        if (!empty($request->get('fileName'))) {
            $path = storage_path('files');
            $fileName = urldecode(trim($request->get('fileName')));
            if ($request->exists('delete')) {
                return response()->download($path . '/' . $fileName, $fileName)->deleteFileAfterSend();
            } else {
                return response()->download($path . '/' . $fileName, $fileName);
            }
        }
    }
}
