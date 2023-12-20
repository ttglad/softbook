<?php

namespace App\Services;

use App\Models\SysDept;

class SysDeptService extends Service
{
    /**
     * 获取部门
     * @param $query
     * @return mixed
     */
    public function getDeptLists($query): array
    {
        $dept = new SysDept();
        $dept->where('del_flag', 0);
        if (isset($query['deptId']) && !empty($query['deptId'])) {
            $dept = $dept->where('dept_id', $query['deptId']);
        }
        if (isset($query['parentId']) && !empty($query['parentId'])) {
            $dept = $dept->where('parent_id', $query['parentId']);
        }
        if (isset($query['deptName']) && !empty($query['deptName'])) {
            $dept = $dept->whereLike('dept_name', '%' . $query['deptName'] . '%');
        }
        if (isset($query['status']) && strlen($query['status']) > 0) {
            $dept = $dept->where('status', $query['status']);
        }

        return $dept->get()->toArray();
    }
}
