<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\ProjectColumn;
use App\Models\Project\ProjectMenu;
use App\Services\Project\ProjectDictService;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class ColumnController extends ProjectController
{
    /**
     * 列表页
     */
    public function show(Request $request, $id)
    {
        $menu = ProjectMenu::findOrFail($id);
        return view('project.menu.column.column', [
            'menu' => $menu,
        ]);
    }

    /**
     * 添加页
     */
    public function add(Request $request, $id)
    {
        $menu = ProjectMenu::findOrFail($id);
        return view('project.menu.column.add', [
            'menu' => $menu,
        ]);
    }

    /**
     * 新增提交
     */
    public function addPost(Request $request, $id)
    {
        $return = $this->ajaxReturn;
        try {
            $menu = ProjectMenu::findOrFail($id);

            $dictName = trim($request->post('dictName'));
            if (ProjectColumn::where('menu_id', $menu->menu_id)->where('dict_name', $dictName)->count() > 0) {
                throw new \Exception('已存在此字典数据', 1001);
            }

            $model = new ProjectColumn();

            $model->project_id = $menu->project_id;
            $model->menu_id = $menu->menu_id;
            $model->dict_name = $dictName;
            $dictObj = ProjectDictService::getDictObj($dictName);
            $model->dict_id = $dictObj->dict_id;
            $model->dict_value = $dictObj->dict_value;
            $model->sort = $request->post('sort');
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
    public function edit(Request $request, $id, $mid)
    {
        $menu = ProjectMenu::findOrFail($id);
        $column = ProjectColumn::findOrFail($mid);
        return view('project.menu.column.edit', [
            'menu' => $menu,
            'column' => $column,
        ]);
    }

    /**
     * 修改提交
     * @param Request $request
     * @return array|mixed
     */
    public function editPost(Request $request, $id)
    {
        $return = $this->ajaxReturn;
        try {

            $menu = ProjectMenu::findOrFail($id);

            $columnId = $request->post('columnId');
            $model = ProjectColumn::findOrFail($columnId);

            if ($menu->menu_id != $model->menu_id) {
                throw new \Exception('权限不一致', 1001);
            }


            $model->dict_name = trim($request->post('dictName'));
//            $dictObj = ProjectDictService::getDictObj($dictName);
//            $model->dict_id = $dictObj->dict_id;
            $model->dict_value = trim($request->post('dictValue'));
            $model->sort = $request->post('sort');
            $model->update_by = auth()->user()->login_name;

            $model->save();

        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|mixed
     */
    public function remove(Request $request, $id)
    {
        $return = $this->ajaxReturn;
        try {
            $menu = ProjectMenu::findOrFail($id);
            $ids = explode(',', $request->post('ids'));
            foreach ($ids as $cid) {
                $model = ProjectColumn::findOrFail($cid);
                if ($model->menu_id == $menu->menu_id) {
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
    public function lists(Request $request, $id)
    {
        $return = $this->ajaxReturnWithPage;
        try {
            $menu = ProjectMenu::findOrFail($id);

            $model = new ProjectColumn();
            $model = $model->where('menu_id', $menu->menu_id);
            if ($request->post('dictName')) {
                $model = $model->where('dict_name', 'like', '%' . trim($request->post('dictName')) . '%');
            }
            if ($request->post('dictValue')) {
                $model = $model->where('dict_value', 'like', '%' . trim($request->post('dictValue')) . '%');
            }
            $pageSize = $request->post('pageSize');
            $list = $model->orderBy('sort')
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
