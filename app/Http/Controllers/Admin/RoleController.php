<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysDept;
use App\Models\SysDictData;
use App\Models\SysRole;
use App\Models\SysUser;
use App\Services\SysDeptService;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class RoleController extends AdminController
{
    public function show()
    {
        // 获取菜单展示名称
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
        return view('admin.role.role', [
            'sysNormalDisable' => $sysNormalDisable,
        ]);
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
            $model = new SysRole();
            if ($request->post('roleName')) {
                $model = $model->where('role_name', trim($request->post('roleName')));
            }
            if ($request->post('roleKey')) {
                $model = $model->where('role_key', trim($request->post('roleKey')));
            }
            $params = $request->post('params');
            if ($params['beginTime']) {
                $model = $model->where('create_time', '>=', $params['beginTime']);
            }
            if ($params['endTime']) {
                $model = $model->where('create_time', '<=', $params['endTime']);
            }
            $list = $model->orderByDesc('role_id')
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
     * 新增页
     */
    public function add()
    {
        return view('admin.role.add');
    }

    /**
     * 新增提交
     */
    public function addPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $role = new SysRole();
            $role->role_name = $request->post('roleName');
            $role->role_key = $request->post('roleKey');
            $role->data_scope = '2';
            $role->role_sort = $request->post('roleSort');
            $role->status = $request->post('status');
            $role->remark = $request->post('remark');
            $role->create_by = auth()->user()->login_name;

            if ($role->save()) {
                // 新增角色菜单关联
                $menus = explode(',', $request->post('menuIds'));
                $role->menus()->sync($menus);
            }

        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 编辑页
     */
    public function edit(Request $request, $id)
    {
        $role = SysRole::findOrFail($id);
        return view('admin.role.edit', [
            'role' => $role,
        ]);
    }

    /**
     * 新增提交
     */
    public function editPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('roleId');
            $role = SysRole::findOrFail($id);
            $role->role_name = $request->post('roleName');
            $role->role_key = $request->post('roleKey');
            $role->role_sort = $request->post('roleSort');
            $role->status = $request->post('status');
            $role->remark = $request->post('remark');
            $role->update_by = auth()->user()->login_name;

            if ($role->save()) {
                // 新增角色菜单关联
                $menus = explode(',', $request->post('menuIds'));
                $role->menus()->sync($menus);
            }

        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 删除
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function remove(Request $request)
    {
        $return = $this->ajaxReturn;

        try {
            $ids = explode(',', $request->post('ids'));
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $role = SysRole::findOrFail($id);
                    // 删除菜单关系
                    $role->menus()->detach();
                    // 删除用户
                    SysRole::where('role_id', $role->role_id)->delete();
                }
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }


    /**
     * 编辑页
     */
    public function authData(Request $request, $id)
    {
        $role = SysRole::findOrFail($id);
        return view('admin.role.authData', [
            'role' => $role,
        ]);
    }


    /**
     * 编辑页
     */
    public function authUser(Request $request, $id)
    {
        // 获取菜单展示名称
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();

        $role = SysRole::findOrFail($id);
        return view('admin.role.authUser', [
            'role' => $role,
            'sysNormalDisable' => $sysNormalDisable,
        ]);
    }

    /**
     * 编辑页
     */
    public function selectUser(Request $request, $id)
    {
        // 获取菜单展示名称
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();

        $role = SysRole::findOrFail($id);
        return view('admin.role.selectUser', [
            'role' => $role,
            'sysNormalDisable' => $sysNormalDisable,
        ]);
    }

    /**
     * 编辑页
     */
    public function selectAll(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('roleId');
            $role = SysRole::findOrFail($id);
            $userIds = explode(',', $request->post('userIds'));
            if (!empty($userIds)) {
                $role->users()->syncWithoutDetaching($userIds);
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 编辑页
     */
    public function cancel(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('roleId');
            $role = SysRole::findOrFail($id);
            $userIds = explode(',', $request->post('userId'));
            if (!empty($userIds)) {
                $role->users()->detach($userIds);
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 编辑页
     */
    public function cancelAll(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('roleId');
            $role = SysRole::findOrFail($id);
            $userIds = explode(',', $request->post('userIds'));
            if (!empty($userIds)) {
                $role->users()->detach($userIds);
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 编辑页
     * roleId: 3
     * roleName: ces2
     * roleKey: 223
     * dataScope: 2
     * deptIds: 100,101,105,106
     */
    public function authDataScope(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('roleId');
            $role = SysRole::findOrFail($id);

            $dataScope = $request->post('dataScope');
            if (!in_array($dataScope, [1, 2, 3, 4, 5])) {
                throw new \Exception('错误的数据格式', 1001);
            }
            SysRole::where('role_id', $id)->update(['data_scope' => $dataScope]);
            $deptIds = explode(',', $request->post('deptIds'));
            if ($dataScope == 2 && !empty($deptIds)) {
                $role->depts()->sync($deptIds);
            } else {
                $role->depts()->detach();
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 获取已授权用户列表
     * @param Request $request
     * @return array|mixed
     */
    public function allocatedList(Request $request)
    {
        $return = $this->ajaxReturnWithPage;
        try {
            $roleId = $request->post('roleId');
            $user = SysUser::whereHas('roles', function ($query) use ($roleId) {
                $query->where('sys_role.role_id', $roleId);
            });
            $loginName = $request->post('loginName');
            $phonenumber = $request->post('phonenumber');
            if ($loginName) {
                $user->where('login_name', 'like', '%' . $loginName . '%');
            }
            if ($phonenumber) {
                $user->where('phonenumber', 'like', '%' . $phonenumber . '%');
            }
            $user = $user->paginate($pageSize ?? 10)->toArray();

            $return['rows'] = $user['data'];
            $return['total'] = $user['total'];
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 获取未授权用户列表
     * @param Request $request
     * @return array|mixed
     */
    public function unAllocatedList(Request $request)
    {
        $return = $this->ajaxReturnWithPage;
        try {
            $roleId = $request->post('roleId');
            $user = SysUser::whereDoesntHave('roles', function ($query) use ($roleId) {
                $query->where('sys_role.role_id', $roleId);
            });

            $loginName = $request->post('loginName');
            $phonenumber = $request->post('phonenumber');
            if ($loginName) {
                $user->where('login_name', 'like', '%' . $loginName . '%');
            }
            if ($phonenumber) {
                $user->where('phonenumber', 'like', '%' . $phonenumber . '%');
            }

            $user = $user->paginate($pageSize ?? 10)->toArray();

            $return['rows'] = $user['data'];
            $return['total'] = $user['total'];
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 更改角色状态
     * @return void
     */
    public function changeStatus(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('roleId');
            $role = SysRole::findOrFail($id);
            $role->status = $request->post('status');
            $role->update_by = auth()->user()->login_name;

            $role->save();

        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 列表页
     */
    public function selectDeptTree(Request $request, $id)
    {
        return view('admin.dept.tree', [
            'deptId' => $id,
        ]);
    }

    /**
     * 列表页
     */
    public function deptTreeData(Request $request)
    {
        $roleDeptIds = [];
        if ($request->get('roleId')) {
            $role = SysRole::with('depts')->findOrFail($request->get('roleId'));
            foreach ($role->depts as $dept) {
                $roleDeptIds[] = $dept['dept_id'];
            }
        }
        // 获取菜单
        $depts = SysDept::where('status', 0)->get();
        $treeData = [];
        foreach ($depts as $dept) {
            $checked = false;
            if (in_array($dept['dept_id'], $roleDeptIds)) {
                $checked = true;
            }
            $treeData[] = [
                'id' => $dept['dept_id'],
                'pId' => $dept['parent_id'],
                'name' => $dept['dept_name'],
                'title' => $dept['dept_name'],
                'checked' => $checked,
                'open' => false,
                'nocheck' => false,
            ];
        }
        return $treeData;
    }

    /**
     * 列表页
     */
    public function treeData(Request $request, $id)
    {
        $return = [];
        $deptService = new SysDeptService();
        $deptLists = $deptService->getDeptLists([]);
        foreach ($deptLists as $deptList) {
            $return[] = [
                'id' => $deptList['dept_id'],
                'pId' => $deptList['parent_id'],
                'name' => $deptList['dept_name'],
                'title' => $deptList['dept_name'],
                'checked' => false,
                'open' => false,
                'nocheck' => false,
            ];
        }
        return $return;
    }

    /**
     * 校验角色名唯一
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkRoleNameUnique(Request $request)
    {
        try {
            $roleId = trim($request->post('roleId'));
            $roleName = trim($request->post('roleName'));
            if (empty($roleName)) {
                throw new \Exception('角色名称不能为空', 1001);
            }
            $count = SysRole::where('role_name', $roleName);
            if ($roleId) {
                $count = $count->where('role_id', '!=', $roleId);
            }
            $count = $count->count();
            if ($count > 0) {
                throw new \Exception('角色名已存在', 1002);
            }
        } catch (\Exception $e) {
            exit('false');
        }
        exit('true');
    }

    /**
     * 校验角色key唯一
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkRoleKeyUnique(Request $request)
    {
        try {
            $roleId = trim($request->post('roleId'));
            $roleKey = trim($request->post('roleKey'));
            if (empty($roleKey)) {
                throw new \Exception('角色key不能为空', 1001);
            }
            $count = SysRole::where('role_key', $roleKey);
            if ($roleId) {
                $count = $count->where('role_id', '!=', $roleId);
            }
            $count = $count->count();
            if ($count > 0) {
                throw new \Exception('角色key已存在', 1002);
            }
        } catch (\Exception $e) {
            exit('false');
        }
        exit('true');
    }
}
