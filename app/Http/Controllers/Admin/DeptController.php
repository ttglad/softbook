<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysDept;
use App\Models\SysDictData;
use App\Models\SysRole;
use App\Services\SysDeptService;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class DeptController extends AdminController
{
    /**
     * 列表页
     */
    public function show(Request $request)
    {
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();

        return view('admin.dept.dept', [
            'sysNormalDisable' => $sysNormalDisable,
        ]);
    }

    /**
     * 添加页
     */
    public function add(Request $request, $id)
    {
        $dept = SysDept::findOrFail($id);
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();

        return view('admin.dept.add', [
            'dept' => $dept,
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
            $dept = new SysDept();
            $dept->parent_id = $request->post('parentId');
            $dept->dept_name = $request->post('deptName');
            $dept->order_num = $request->post('orderNum');
            $dept->leader = $request->post('leader');
            $dept->phone = $request->post('phone');
            $dept->email = $request->post('email');
            $dept->status = $request->post('status');
            $dept->create_by = auth()->user()->login_name;


            $dept->save();
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 修改页
     */
    public function edit(Request $request, $id)
    {
        $dept = SysDept::findOrFail($id);
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
        if ($dept['parent_id'] > 0) {
            $deptParent = SysDept::find($dept['parent_id']);
        } else {
            $deptParent = new SysDept();
            $deptParent->dept_id = 0;
            $deptParent->dept_name = '无';
        }

        return view('admin.dept.edit', [
            'dept' => $dept,
            'deptParent' => $deptParent,
            'sysNormalDisable' => $sysNormalDisable,
        ]);
    }

    /**
     * 修改提交
     */
    public function editPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('deptId');
            $dept = SysDept::findOrFail($id);

            $dept->parent_id = $request->post('parentId');
            $dept->dept_name = $request->post('deptName');
            $dept->order_num = $request->post('orderNum');
            $dept->leader = $request->post('leader');
            $dept->phone = $request->post('phone');
            $dept->email = $request->post('email');
            $dept->status = $request->post('status');
            $dept->update_by = auth()->user()->login_name;

            $dept->save();
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 删除部门
     * @param Request $request
     * @param $id
     * @return void
     */
    public function remove(Request $request, $id)
    {
        $return = $this->ajaxReturn;
        try {
            $dept = SysDept::findOrFail($id);
            $dept->delete();
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
        $return = [];
        try {
            $model = new SysDept();
            if ($request->post('deptName')) {
                $model = $model->where('dept_name', trim($request->post('deptName')));
            }
            if (strlen($request->post('status')) > 0) {
                $model = $model->where('status', trim($request->post('status')));
            }
            $return = $model->orderBy('dept_id')
                ->orderBy('order_num')
                ->get()
                ->toArray();

        } catch (\Exception $e) {

        }

        return $return;
    }

    /**
     * 列表页
     */
    public function selectDeptTree(Request $request, $id, $excludeId = 0)
    {
        $dept = SysDept::findOrFail($id);
        return view('admin.dept.tree', [
            'deptId' => $id,
            'dept' => $dept,
            'excludeId' => $excludeId,
        ]);
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
     * 校验角色key唯一
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkDeptNameUnique(Request $request)
    {
        try {
            $parentId = trim($request->post('parentId'));
            $deptName = trim($request->post('deptName'));
            if (empty($deptName)) {
                throw new \Exception('部门名称不能为空', 1001);
            }
            $count = SysDept::where('dept_name', $deptName);
            if ($parentId) {
                $count = $count->where('parent_id', $parentId);
            }
            $count = $count->count();
            if ($count > 0) {
                throw new \Exception('部门名称已存在', 1002);
            }
        } catch (\Exception $e) {
            exit('false');
        }
        exit('true');
    }
}
