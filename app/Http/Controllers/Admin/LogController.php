<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysDictData;
use App\Models\SysLoginLog;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class LogController extends AdminController
{
    /**
     * 登录日志页面
     */
    public function login(Request $request)
    {
        // 获取菜单展示名称
        $sysStatus = SysDictData::where('dict_type', 'sys_common_status')->get();

        return view('admin.log.login', [
            'sysStatus' => $sysStatus,
        ]);
    }

    /**
     * 登录日志页面
     */
    public function loginList(Request $request)
    {
        $return = $this->ajaxReturnWithPage;
        try {
            $model = new SysLoginLog();
            if ($request->post('ipaddr')) {
                $model = $model->where('ip_addr', trim($request->post('ipaddr')));
            }
            if ($request->post('loginName')) {
                $model = $model->where('login_name', 'like', '%' . trim($request->post('loginName')) . '%');
            }
            if (strlen($request->post('status')) > 0) {
                $model = $model->where('status', trim($request->post('status')));
            }
            $params = $request->post('params');
            if ($params['beginTime']) {
                $model = $model->where('login_time', '>=', $params['beginTime']);
            }
            if ($params['endTime']) {
                $model = $model->where('login_time', '<=', $params['endTime']);
            }
            $pageSize = $request->post('pageSize');
            $list = $model->orderByDesc('login_id')
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
