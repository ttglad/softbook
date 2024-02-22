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
    private $keySplitChar = '|';
    /**
     * main页
     */
    public function show(Request $request, $id)
    {
        // 获取项目信息
        $project = ProjectInfo::findOrFail($id);
        if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
            abort(403);
        }

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
        if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
            abort(403);
        }
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
            if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
                throw new \Exception('无此项目权限', 1001);
            }

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
                    $textArr = explode($this->keySplitChar, trim($text, $this->keySplitChar));
                    if (!empty($textArr)) {
                        $dictArr = ProjectDictService::getDictArray($textArr);
                        foreach ($textArr as $sort => $item) {
                            // 空值判断
                            if (empty($item)) {
                                continue;
                            }
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
        if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
            abort(403);
        }
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
            $columnsText .= $this->keySplitChar . $column['dict_name'];
        }
        // 获取菜单展示名称
        $sysShowList = SysDictData::where('dict_type', 'sys_show_hide')->get();

        return view('project.menu.edit', [
            'project' => $project,
            'menu' => $menu,
            'menuParent' => $menuParent,
            'sysShowList' => $sysShowList,
            'columnsText' => trim($columnsText, $this->keySplitChar),
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
            if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
                throw new \Exception('无此项目权限', 1001);
            }

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
                    $textArr = explode($this->keySplitChar, trim($text, $this->keySplitChar));
                    if (!empty($textArr)) {
                        // 清空字段
                        ProjectColumn::where('project_id', $project->project_id)
                            ->where('menu_id', $model->menu_id)
                            ->whereNotIn('dict_name', $textArr)
                            ->delete();

                        $dictArr = ProjectDictService::getDictArray($textArr);
                        foreach ($textArr as $sort => $item) {
                            // 空值判断
                            if (empty($item)) {
                                continue;
                            }
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
            if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
                throw new \Exception('无此项目权限', 1001);
            }

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

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function batchAdd(Request $request, $id)
    {
        // 获取项目信息
        $project = ProjectInfo::findOrFail($id);
        if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
            abort(403);
        }

        return view('project.menu.batchAdd', [
            'project' => $project,
        ]);
    }

    /**
     * 批量新建项目
     * @param Request $request
     * @return array|mixed
     */
    public function batchAddPost(Request $request, $id)
    {
        $return = $this->ajaxReturn;

        try {

            $project = ProjectInfo::findOrFail($id);
            if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
                throw new \Exception('无此项目权限', 1001);
            }
            // 获取数据
            $post = $request->post();
            $childKeyArr = [];

            $menus = $post['menus'];
            $childMenus = $post['childMenus'];
            $childKeys = $post['childKeys'];
            $remarks = $post['remark'];
            $childRemarks = $post['childRemark'];

            // 数据校验
            if (sizeof($menus) < 3) {
                throw new \Exception('一级目录数量不正确', 1002);
            }
            if (sizeof($childMenus) < 6) {
                throw new \Exception('二级目录数量不正确', 1002);
            }
            if (sizeof($childKeys) < 6) {
                throw new \Exception('二级目录字段数量不正确', 1002);
            }

            // 明细校验
            foreach ($menus as $i => &$menu) {
                $menu = trim($menu);
                if ($i < 3 && empty($menu)) {
                    throw new \Exception('一级目录不能为空', 1002);
                }
            }
            foreach ($childMenus as $i => &$menu2) {
                $menu2 = trim($menu2);
                if ($i < 3 && empty($menu2)) {
                    throw new \Exception('二级目录不能为空', 1002);
                }
                $childKeyArr = array_merge($childKeyArr, [$menu2]);
            }
            foreach ($childKeys as $i => &$menu3) {
                $menu3 = trim(trim($menu3), $this->keySplitChar);
                if ($i < 3 && empty($menu3)) {
                    throw new \Exception('二级目录字段不能为空', 1002);
                }
                if (!empty($menu3)) {
                    $menu3 = explode($this->keySplitChar, $menu3);
                    if (sizeof($menu3) < 5) {
                        throw new \Exception('二级目录字段不能小于5个', 1002);
                    }
                    foreach ($menu3 as &$_menu) {
                        $_menu = trim($_menu);
                    }
                    $childKeyArr = array_merge($childKeyArr, $menu3);
                }
            }

            unset($menu, $menu2, $menu3);

            $childKeyArr = array_unique($childKeyArr);
            $dictArr = ProjectDictService::getDictArray($childKeyArr);

            foreach ($menus as $sort => $itemMenu) {
                if (empty($itemMenu)) {
                    continue;
                }
                // 父菜单创建
                $menuModel = new ProjectMenu();
                $menuModel->project_id = $project->project_id;
                $menuModel->parent_id = 0;
                $menuModel->menu_name = $itemMenu;
                $menuModel->menu_code = '';
                $menuModel->order_num = $sort;
                $menuModel->visible = 0;
                $menuModel->create_by = auth()->user()->login_name;
                $menuModel->url = '#';
                $menuModel->class = '';
                $menuModel->menu_type = 'M';
                $menuModel->remark = isset($remarks[$sort]) ? $remarks[$sort] : '';
                if ($menuModel->save()) {
                    for ($i = $sort * 2; $i < ($sort + 1) * 2; $i++) {
                        if (!isset($childMenus[$i]) || empty($childMenus[$i])) {
                            continue;
                        }
                        $childMenu = new ProjectMenu();
                        $childMenu->project_id = $project->project_id;
                        $childMenu->parent_id = $menuModel->menu_id;
                        $childMenu->menu_name = $childMenus[$i];
                        $childMenu->menu_code = isset($dictArr[$childMenus[$i]]) ? $dictArr[$childMenus[$i]]['dict_value'] : '';
                        $childMenu->order_num = $i;
                        $childMenu->visible = 0;
                        $childMenu->create_by = auth()->user()->login_name;
                        $childMenu->class = 'menuItemShot';
                        $childMenu->menu_type = 'C';
                        $childMenu->remark = isset($childRemarks[$i]) ? $childRemarks[$i] : '';

                        if ($childMenu->save()) {
                            $childMenu->url = '/project/business/' . $childMenu->menu_id;
                            $childMenu->save();

                            // 新建菜单列
                            foreach ($childKeys[$i] as $keySort => $itemKey) {
                                if (isset($dictArr[$itemKey])) {
                                    $dict = $dictArr[$itemKey];
                                    $projectColumn = new ProjectColumn();
                                    $projectColumn->project_id = $project->project_id;
                                    $projectColumn->menu_id = $childMenu->menu_id;
                                    $projectColumn->dict_id = $dict['dict_id'];
                                    $projectColumn->dict_name = $dict['dict_name'];
                                    $projectColumn->dict_value = $dict['dict_value'];
                                    $projectColumn->query_type = 'LIKE';
                                    $projectColumn->sort = $keySort;
                                    $projectColumn->create_by = auth()->user()->login_name;
                                    $projectColumn->save();
                                }
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
}
