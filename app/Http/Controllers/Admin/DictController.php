<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysDictData;
use App\Models\SysDictType;
use App\Models\SysPost;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class DictController extends AdminController
{
    /**
     * 列表页
     */
    public function show(Request $request)
    {
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();

        return view('admin.dict.type.type', [
            'sysNormalDisable' => $sysNormalDisable,
        ]);
    }

    /**
     * 添加页
     */
    public function add(Request $request)
    {
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
        return view('admin.dict.type.add', [
            'sysNormalDisable' => $sysNormalDisable,
        ]);
    }

    /**
     * 新增提交
     */
    public function addPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $model = new SysDictType();

            $model->dict_name = $request->post('dictName');
            $model->dict_type = $request->post('dictType');
            $model->status = $request->post('status');
            $model->remark = $request->post('remark');
            $model->create_by = auth()->user()->login_name;

            $model->save();
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $dict = SysDictType::findOrFail($id);
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
        return view('admin.dict.type.edit', [
            'dict' => $dict,
            'sysNormalDisable' => $sysNormalDisable,
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
            $id = $request->post('dictId');
            $model = SysDictType::findOrFail($id);

            $model->dict_name = $request->post('dictName');
            $model->dict_type = $request->post('dictType');
            $model->status = $request->post('status');
            $model->remark = $request->post('remark');
            $model->update_by = auth()->user()->login_name;

            $model->save();

        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 删除
     * @param Request $request
     * @param $id
     * @return void
     */
    public function remove(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $ids = explode(',', $request->post('ids'));
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $model = SysDictType::findOrFail($id);
                    $model->delete();
                }
            }
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
            $model = new SysDictType();
            if ($request->post('dictType')) {
                $model = $model->where('dict_type', trim($request->post('dictType')));
            }
            if ($request->post('dictName')) {
                $model = $model->where('dict_name', 'like', '%' . trim($request->post('dictName')) . '%');
            }
            if (strlen($request->post('status')) > 0) {
                $model = $model->where('status', trim($request->post('status')));
            }
            $params = $request->post('params');
            if ($params['beginTime']) {
                $model = $model->where('create_time', '>=', $params['beginTime']);
            }
            if ($params['endTime']) {
                $model = $model->where('create_time', '<=', $params['endTime']);
            }
            $pageSize = $request->post('pageSize');
            $list = $model->orderBy('dict_id')
                ->paginate($pageSize ?? 10)
                ->toArray();

            $return['rows'] = $list['data'];
            $return['total'] = $list['total'];
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 校验字典类型唯一
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkDictTypeUnique(Request $request)
    {
        try {
            $dictId = trim($request->post('dictId'));
            $dictType = trim($request->post('dictType'));
            if (empty($dictType)) {
                throw new \Exception('字典类型值不能为空', 1001);
            }
            $count = SysDictType::where('dict_type', $dictType);
            if ($dictId) {
                $count = $count->where('dict_id', '!=', $dictId);
            }
            $count = $count->count();
            if ($count > 0) {
                throw new \Exception('字典类型值已存在', 1002);
            }
        } catch (\Exception $e) {
            exit('false');
        }
        exit('true');
    }

    /**
     * 列表页
     */
    public function showDetail(Request $request, $id)
    {
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();

        $dictTypes = SysDictType::all();

        return view('admin.dict.data.data', [
            'dictTypes' => $dictTypes,
            'dictTypeId' => $id,
            'sysNormalDisable' => $sysNormalDisable,
        ]);
    }

    /**
     * 添加页
     */
    public function addDetail(Request $request, $dictType)
    {
        $sysYesNo = SysDictData::where('dict_type', 'sys_yes_no')->get();
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
        return view('admin.dict.data.add', [
            'dictType' => $dictType,
            'sysNormalDisable' => $sysNormalDisable,
            'sysYesNo' => $sysYesNo,
        ]);
    }

    /**
     * 新增提交
     */
    public function addPostDetail(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $model = new SysDictData();

            $model->dict_label = $request->post('dictLabel');
            $model->dict_value = $request->post('dictValue');
            $model->dict_type = $request->post('dictType');
            $model->css_class = $request->post('cssClass');
            $model->dict_sort = $request->post('dictSort');
            $model->list_class = $request->post('listClass');
            $model->is_default = $request->post('isDefault');
            $model->status = $request->post('status');
            $model->remark = $request->post('remark');
            $model->create_by = auth()->user()->login_name;

            $model->save();
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editDetail(Request $request, $id)
    {
        $sysYesNo = SysDictData::where('dict_type', 'sys_yes_no')->get();
        $dict = SysDictData::findOrFail($id);
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
        return view('admin.dict.data.edit', [
            'dict' => $dict,
            'sysNormalDisable' => $sysNormalDisable,
            'sysYesNo' => $sysYesNo,
        ]);
    }

    /**
     * 修改提交
     * @param Request $request
     * @return array|mixed
     */
    public function editPostDetail(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('dictCode');
            $model = SysDictData::findOrFail($id);

            $model->dict_label = $request->post('dictLabel');
            $model->dict_value = $request->post('dictValue');
            $model->css_class = $request->post('cssClass');
            $model->dict_sort = $request->post('dictSort');
            $model->list_class = $request->post('listClass');
            $model->is_default = $request->post('isDefault');
            $model->status = $request->post('status');
            $model->remark = $request->post('remark');
            $model->update_by = auth()->user()->login_name;

            $model->save();

        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 删除
     * @param Request $request
     * @param $id
     * @return void
     */
    public function removeDetail(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $ids = explode(',', $request->post('ids'));
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $model = SysDictData::findOrFail($id);
                    $model->delete();
                }
            }
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
    public function listsDetail(Request $request)
    {
        $return = $this->ajaxReturnWithPage;
        try {
            $model = new SysDictData();
            if ($request->post('dictType')) {
                $model = $model->where('dict_type', trim($request->post('dictType')));
            }
            if ($request->post('dictLabel')) {
                $model = $model->where('dict_label', 'like', '%' . trim($request->post('dictLabel')) . '%');
            }
            if (strlen($request->post('status')) > 0) {
                $model = $model->where('status', trim($request->post('status')));
            }
            $pageSize = $request->post('pageSize');
            $list = $model->orderBy('dict_sort')
                ->paginate($pageSize ?? 10)
                ->toArray();

            $return['rows'] = $list['data'];
            $return['total'] = $list['total'];
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }
}
