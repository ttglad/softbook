<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\ProjectColumn;
use App\Models\Project\ProjectInfo;
use App\Models\Project\ProjectMenu;
use App\Models\SysDictData;
use App\Services\Project\ProjectDictService;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class MenuController extends ProjectController
{
    /**
     * main页
     */
    public function show(Request $request, $id)
    {
        // 获取项目信息
        $project = ProjectInfo::findOrFail($id);

        // 获取菜单展示名称
        $sysShowList = SysDictData::where('dict_type', 'sys_show_hide')->get();

        return view('project.menu.menu', [
            'project' => $project,
            'sysShowList' => $sysShowList,
        ]);
    }

    /**
     * 新增项目
     * @param Request $request
     * @param $id
     * @param $mid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add(Request $request, $id, $mid)
    {
        // 获取项目信息
        $project = ProjectInfo::findOrFail($id);
        $menuParent = ProjectMenu::where('project_id', $id)->where('menu_id', $mid)->first();
        if (is_null($menuParent)) {
            $menuParent = new ProjectMenu();
            $menuParent->menu_id = 0;
            $menuParent->parent_id = 0;
            $menuParent->menu_name = '主目录';
        }

        // 获取菜单展示名称
        $sysShowList = SysDictData::where('dict_type', 'sys_show_hide')->get();

        return view('project.menu.add', [
            'project' => $project,
            'menuParent' => $menuParent,
            'sysShowList' => $sysShowList,
        ]);
    }

    /**
     * 新建项目
     * @param Request $request
     * @return array|mixed
     */
    public function addPost(Request $request, $id)
    {
        $return = $this->ajaxReturn;

        try {

            $project = ProjectInfo::findOrFail($id);

            $model = new ProjectMenu();
            $model->project_id = $project->project_id;
            $model->parent_id = $request->post('parentId');
            $model->menu_name = $request->post('menuName');
            $model->menu_code = '';
            $model->order_num = $request->post('orderNum');
            $model->icon = $request->post('icon');
            $model->visible = $request->post('visible');
            $model->remark = $request->post('remark');
            $model->create_by = auth()->user()->login_name;
            $model->url = '#';
            $model->class = '';

            $menuType = $request->post('menuType') ? $request->post('menuType') : 'M';
            $model->menu_type = $menuType;

            if ($model->save()) {
                if ($menuType == 'C') {
                    if ($request->post('menuCode')) {
                        $model->menu_code = $request->post('menuCode');
                    } else {
                        $model->menu_code = ProjectDictService::getDictValue($model->menu_name);
                    }
                    $model->url = '/project/business/' . $model->menu_id;
                    $model->class = 'menuItemShot';
                    $model->save();

                    // 绑定字段
                    $text = trim($request->post('projectKey'));
                    $textArr = explode(',', trim($text, ','));
                    if (!empty($textArr)) {
                        $dictArr = ProjectDictService::getDictArray($textArr);
                        foreach ($textArr as $sort => $item) {
                            if (isset($dictArr[$item])) {
                                $dict = $dictArr[$item];
                                $projectColumn = new ProjectColumn();
                                $projectColumn->project_id = $project->project_id;
                                $projectColumn->menu_id = $model->menu_id;
                                $projectColumn->dict_id = $dict['dict_id'];
                                $projectColumn->dict_name = $dict['dict_name'];
                                $projectColumn->dict_value = $dict['dict_value'];
                                $projectColumn->query_type = 'LIKE';
                                $projectColumn->sort = $sort;
                                $projectColumn->create_by = auth()->user()->login_name;
                                $projectColumn->save();
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 编辑项目
     * @param Request $request
     * @param $id
     * @param $mid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id, $mid)
    {
        $project = ProjectInfo::findOrFail($id);
        $menu = ProjectMenu::findOrFail($mid);
        if ($menu->project_id != $project->project_id) {
            abort(404);
        }
        $menuParent = ProjectMenu::where('project_id', $id)->where('menu_id', $menu->parent_id)->first();
        if (is_null($menuParent)) {
            $menuParent = new ProjectMenu();
            $menuParent->menu_id = 0;
            $menuParent->parent_id = 0;
            $menuParent->menu_name = '主目录';
        }

        // 获取字段名称
        $columns = ProjectColumn::where('project_id', $project->project_id)
            ->where('menu_id', $menu->menu_id)
            ->get()
            ->toArray();
        $columnsText = '';
        foreach ($columns as $column) {
            $columnsText .= ',' . $column['dict_name'];
        }
        // 获取菜单展示名称
        $sysShowList = SysDictData::where('dict_type', 'sys_show_hide')->get();

        return view('project.menu.edit', [
            'project' => $project,
            'menu' => $menu,
            'menuParent' => $menuParent,
            'sysShowList' => $sysShowList,
            'columnsText' => trim($columnsText, ','),
        ]);
    }

    /**
     * 编辑项目
     * @param Request $request
     * @return array|mixed
     */
    public function editPost(Request $request, $id)
    {
        $return = $this->ajaxReturn;
        try {

            $projectId = $request->post('projectId');
            $project = ProjectInfo::findOrFail($projectId);

            $mid = $request->post('menuId');
            $model = ProjectMenu::findOrFail($mid);

            $model->project_id = $project->project_id;
            $model->parent_id = $request->post('parentId');
            $model->menu_name = $request->post('menuName');
            $model->menu_code = '';
            $model->order_num = $request->post('orderNum');
            $model->icon = $request->post('icon');
            $model->visible = $request->post('visible');
            $model->remark = $request->post('remark');
            $model->update_by = auth()->user()->login_name;
            $model->url = '#';
            $model->class = '';

            $menuType = $request->post('menuType') ? $request->post('menuType') : 'M';
            $model->menu_type = $menuType;

            if ($model->save()) {
                if ($menuType == 'C') {
                    if ($request->post('menuCode')) {
                        $model->menu_code = $request->post('menuCode');
                    } else {
                        $model->menu_code = ProjectDictService::getDictValue($model->menu_name);
                    }
                    $model->url = '/project/business/' . $model->menu_id;
                    $model->class = 'menuItemShot';
                    $model->save();


                    $text = trim($request->post('projectKey'));
                    $textArr = explode(',', trim($text, ','));
                    if (!empty($textArr)) {
                        // 清空字段
                        ProjectColumn::where('project_id', $project->project_id)
                            ->where('menu_id', $model->menu_id)
                            ->where('dict_name', 'not in', "'" . implode("','", $textArr) . "'")
                            ->delete();

                        $dictArr = ProjectDictService::getDictArray($textArr);
                        foreach ($textArr as $sort => $item) {
                            if (isset($dictArr[$item])) {
                                $dict = $dictArr[$item];
                                $projectColumn = ProjectColumn::where('project_id', $project->project_id)
                                    ->where('menu_id', $model->menu_id)
                                    ->where('dict_name', $dict['dict_name'])
                                    ->first();
                                if (is_null($projectColumn)) {
                                    $projectColumn = new ProjectColumn();
                                    $projectColumn->create_by = auth()->user()->login_name;
                                } else {
                                    $projectColumn->update_by = auth()->user()->login_name;
                                }
                                $projectColumn->project_id = $project->project_id;
                                $projectColumn->menu_id = $model->menu_id;
                                $projectColumn->dict_id = $dict['dict_id'];
                                $projectColumn->dict_name = $dict['dict_name'];
                                $projectColumn->dict_value = $dict['dict_value'];
                                $projectColumn->query_type = 'LIKE';
                                $projectColumn->sort = $sort;
                                $projectColumn->save();
                            }
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * @param Request $request
     * @param $id
     * @param $mid
     * @return array|mixed
     */
    public function remove(Request $request, $id, $mid)
    {
        $return = $this->ajaxReturn;
        try {
            $model = ProjectMenu::findOrFail($mid);
            if ($id == $model->project_id) {
                $model->delete();
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
        $return = [];
        try {
            // 获取项目是否存在
            $project = ProjectInfo::findOrFail($id);

            $menus = new ProjectMenu();
            $menus = $menus->where(function ($query) use ($project) {
                $query->where('project_id', $project->project_id)
                    ->orWhere('project_id', '=', 0);
            });
            $menuName = $request->post('menuName');
            if (!empty($menuName)) {
                $menus = $menus->whereLike('menu_name', '%' . $menuName . '%');
            }
            $visible = $request->post('visible');
            if (strlen($visible) > 0) {
                $menus = $menus->where('visible', $visible);
            }
            $return = $menus->orderBy('order_num')
                ->orderBy('menu_id')
                ->get()
                ->toArray();
        } catch (\Exception $e) {
        }

        return $return;
    }

    /**
     * 菜单树页面
     * @param Request $request
     * @param $id
     * @param $mid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tree(Request $request, $id, $mid)
    {
        // 获取项目信息
        $project = ProjectInfo::findOrFail($id);
//        $menu = ProjectMenu::where('project_id', $id)->where('menu_id', $mid)->first();
//        if (is_null($menu)) {
//            $menu = new ProjectMenu();
//            $menu->menu_id = 0;
//            $menu->parent_id = 0;
//            $menu->menu_name = '主目录';
//        }
        return view('project.menu.tree', [
            'project' => $project,
        ]);
    }

    /**
     * 获取项目菜单树选择
     * @param Request $request
     * @param $id
     * @return array
     */
    public function treeLists(Request $request, $id)
    {
        // 获取菜单
        $menus = ProjectMenu::where('project_id', $id)->get();
        $treeData = [];
        foreach ($menus as $menu) {
            $treeData[] = [
                'id' => $menu['menu_id'],
                'pId' => $menu['parent_id'],
                'name' => $menu['menu_name'],
                'title' => $menu['menu_name'],
                'checked' => false,
                'open' => false,
                'nocheck' => false,
            ];
        }
        return $treeData;
    }
}
