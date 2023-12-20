<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysConfig;
use App\Models\SysDictData;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class ConfigController extends AdminController
{

    /**
     * 列表页
     */
    public function show()
    {
        // 获取菜单展示名称
        $sysYesNo = SysDictData::where('dict_type', 'sys_yes_no')->get();

        return view('admin.config.config', [
            'sysYesNo' => $sysYesNo,
        ]);
    }

    /**
     * 新增页
     */
    public function add()
    {
        abort(404);
    }

    /**
     * 修改页
     */
    public function edit(Request $request, $id)
    {
        $data = SysConfig::findOrFail($id);

        // 获取菜单展示名称
        $sysYesNo = SysDictData::where('dict_type', 'sys_yes_no')->get();

        return view('admin.config.edit', [
            'data' => $data,
            'sysYesNo' => $sysYesNo,
        ]);
    }

    /**
     * 修改页提交
     */
    public function editPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('configId');
            $data = SysConfig::findOrFail($id);
            if ($request->post('configName')) {
                $data->config_name = trim($request->post('configName'));
            }
            if ($request->post('configValue')) {
                $data->config_value = trim($request->post('configValue'));
            }
            if ($request->post('configType')) {
                $data->config_type = trim($request->post('configType'));
            }
            $data->update_by = auth()->user()->login_name;
            $data->remark = trim($request->post('remark'));
            $data->save();
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
            $model = new SysConfig();
            if ($request->post('config_name')) {
                $model = $model->where('config_name', trim($request->post('config_name')));
            }
            if ($request->post('config_key')) {
                $model = $model->where('config_key', trim($request->post('config_key')));
            }
            if ($request->post('config_type')) {
                $model = $model->where('config_type', trim($request->post('config_type')));
            }

            $list = $model->orderByDesc('config_id')
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
