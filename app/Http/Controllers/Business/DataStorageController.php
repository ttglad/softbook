<?php

namespace App\Http\Controllers\Business;

use App\Models\Business\DataStorage;
use App\Services\Business\DataStorageService;
use Illuminate\Http\Request;

/**
 * 数据存储控制器
 *
 * @author SoftBook
 */
class DataStorageController extends BusinessController
{
    /**
     * 列表页面
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('business.dataStorage.show');
    }

    /**
     * 新增页面
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function add(Request $request)
    {

        return view('business.dataStorage.add');
    }

    /**
     * 新增提交
     * @param Request $request
     * @return array|mixed
     */
    public function addPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $model = new DataStorage();
            $model->data_number = $request->post('data_number');
            $model->data_name = $request->post('data_name');
            $model->storage_path = $request->post('storage_path');
            $model->data_query = $request->post('data_query');
            $model->data_export = $request->post('data_export');

            DataStorageService::save($model);
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
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $data = DataStorageService::detail($id);
        return view('business.dataStorage.edit', [
            'data' => $data,
        ]);
    }

    /**
     * 修改提交
     * @param Request $request
     * @return array|mixed
     */
    public function editPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $model = DataStorageService::detail($request->post('id'));
            $model->data_number = $request->post('data_number');
            $model->data_name = $request->post('data_name');
            $model->storage_path = $request->post('storage_path');
            $model->data_query = $request->post('data_query');
            $model->data_export = $request->post('data_export');

            DataStorageService::save($model);
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 列表数据
     * @param Request $request
     * @return array|mixed
     */
    public function lists(Request $request)
    {
        $return = $this->ajaxReturnWithPage;

        try {
            $model = new DataStorage();
            $model->data_number = $request->post('data_number');
            $model->data_name = $request->post('data_name');
            $model->storage_path = $request->post('storage_path');
            $model->data_query = $request->post('data_query');
            $model->data_export = $request->post('data_export');

            $list = DataStorageService::query($model, $request->post('pageSize'));

            $return['rows'] = $list['data'];
            $return['total'] = $list['total'];
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 删除数据
     * @return void
     */
    public function remove(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $ids = explode(',', trim($request->post('ids')));
            if (empty($ids)) {
                throw new \Exception('选中的记录不能为空', 1001);
            }
            foreach ($ids as $id) {
                $model = DataStorageService::detail($id);
                DataStorageService::delete($model);
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }
}
