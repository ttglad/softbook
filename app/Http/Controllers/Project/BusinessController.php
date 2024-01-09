<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\ProjectBusiness;
use App\Models\Project\ProjectColumn;
use App\Models\Project\ProjectInfo;
use App\Models\Project\ProjectMenu;
use App\Services\Project\ProjectBusinessService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

/**
 * 业务处理控制器
 *
 * @author SoftBook
 */
class BusinessController extends ProjectController
{

    /**
     * 展示页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        $business = ProjectMenu::findOrFail($id);
        $project = ProjectInfo::findOrFail($business->project_id);

        $businessColumn = ProjectColumn::where('project_id', $business->project_id)
            ->where('menu_id', $business->menu_id)
            ->orderBy('sort')
            ->get();

        return view('project.business.show', [
            'business' => $business,
            'project' => $project,
            'businessColumn' => $businessColumn,
        ]);
    }

    /**
     * 新增页面
     * @param Request $request
     * @param $id
     * @return \Illuminate\View\View
     */
    public function add(Request $request, $id)
    {
        $business = ProjectMenu::findOrFail($id);

        $businessColumn = ProjectColumn::where('project_id', $business->project_id)
            ->where('menu_id', $business->menu_id)
            ->orderBy('sort')
            ->get();
        return view('project.business.add', [
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
    public function addPost(Request $request, $id)
    {
        $return = $this->ajaxReturn;
        try {
            $business = ProjectMenu::findOrFail($id);

            $businessColumn = ProjectColumn::where('project_id', $business->project_id)
                ->where('menu_id', $business->menu_id)
                ->orderBy('sort')
                ->get();

            $postData = $request->post();
            $businessData = new ProjectBusiness();
            $businessData->project_id = $business->project_id;
            $businessData->menu_id = $business->menu_id;
            $businessData->create_by = auth()->user()->login_name;
            $i = 0;
            foreach ($businessColumn as $column) {
                if ($i >= 10) {
                    throw new \Exception('业务参数过多', 1002);
                }
                $i++;
                $key = 'column_' . $i;
                $value = 'value_' . $i;
                $businessData->$key = $column->dict_value;
                $businessData->$value = '';
                if (isset($postData[$column->dict_value])) {
                    $businessData->$value = $postData[$column->dict_value];
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
     * @param $id
     * @param $did
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, $id, $did)
    {
        $business = ProjectMenu::findOrFail($id);

        $businessColumn = ProjectColumn::where('project_id', $business->project_id)
            ->where('menu_id', $business->menu_id)
            ->orderBy('sort')
            ->get();

        $businessData = ProjectBusiness::findOrFail($did);
        if ($businessData->menu_id != $business->menu_id) {
            abort(404);
        }

        $businessService = new ProjectBusinessService();
        $businessData = $businessService->businessDataFormatSingle($businessData, $businessColumn);

        return view('project.business.edit', [
            'business' => $business,
            'businessColumn' => $businessColumn,
            'businessData' => $businessData,
        ]);
    }

    /**
     * 修改页面提交
     * @param Request $request
     * @param $id
     * @return array|mixed
     */
    public function editPost(Request $request, $id)
    {
        $return = $this->ajaxReturn;
        try {
            $business = ProjectMenu::findOrFail($id);

            $dataId = $request->post('id');
            $businessData = ProjectBusiness::findOrFail($dataId);
            if ($businessData->menu_id != $business->menu_id) {
                throw new \Exception('数据权限不正确', 1002);
            }

            // 业务列名称
            $businessColumn = ProjectColumn::where('project_id', $business->project_id)
                ->where('menu_id', $business->menu_id)
                ->orderBy('sort')
                ->get();
            // 业务列名称
            $postData = $request->post();
            $i = 0;
            foreach ($businessColumn as $column) {
                if ($i >= 10) {
                    throw new \Exception('业务参数过多', 1002);
                }
                $i++;
                $key = 'column_' . $i;
                $value = 'value_' . $i;
                $businessData->$key = $column->dict_value;
                $businessData->$value = '';
                if (isset($postData[$column->dict_value])) {
                    $businessData->$value = $postData[$column->dict_value];
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
     * @param $id
     * @return array|mixed
     */
    public function lists(Request $request, $id)
    {
        $return = $this->ajaxReturnWithPage;

        try {
            $business = ProjectMenu::findOrFail($id);

            $businessColumn = ProjectColumn::where('project_id', $business->project_id)
                ->where('menu_id', $business->menu_id)
                ->orderBy('sort')
                ->get();

            $businessServices = new ProjectBusinessService();
            $businessData = $businessServices->businessQuery($business, $businessColumn, $request);

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
    public function remove(Request $request, $id)
    {
        $return = $this->ajaxReturn;
        try {
            $business = ProjectMenu::findOrFail($id);

            $ids = explode(',', trim($request->post('ids')));
            if (empty($ids)) {
                throw new \Exception('选中的记录不能为空', 1001);
            }
            foreach ($ids as $id) {
                try {
                    $businessData = ProjectBusiness::findOrFail($id);
                    if ($businessData->menu_id == $business->menu_id) {
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
     * @param $id
     * @return array|mixed
     */
    public function export(Request $request, $id)
    {
        $return = $this->ajaxReturn;
        try {

            $business = ProjectMenu::findOrFail($id);

            $header = [];
            // 业务列名称
            $businessColumn = ProjectColumn::where('project_id', $business->project_id)
                ->where('menu_id', $business->menu_id)
                ->orderBy('sort')
                ->get();

            $businessServices = new ProjectBusinessService();
            $businessData = $businessServices->businessQuery($business, $businessColumn, $request);

            $data = $businessServices->businessDataFormat($businessData['data']);
            if (empty($data)) {
                abort(404);
            }

            // 遍历业务列，获取头数组
            foreach ($businessColumn as $column) {
                $header[] = $column->dict_name;
            }

            // 临时文件目录
            $directory = storage_path('files');
            // 判断临时文件目录是否存在
            if (!File::isDirectory($directory)) {
                // 创建一个临时文件目录
                File::makeDirectory($directory, 0755, true);
            }

            // 临时文件名称
            $filename = $business->menu_name . date('YmdHis') . '.csv';
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
                    $addRow[] = $row[$column->dict_value];
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
    public function download(Request $request, $id)
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
