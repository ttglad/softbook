<?php

namespace App\Http\Controllers\Project;

use App\Jobs\ProjectDataInit;
use App\Jobs\ProjectMenuDescInit;
use App\Models\Project\ProjectColumn;
use App\Models\Project\ProjectInfo;
use App\Models\Project\ProjectMenu;
use App\Models\SysDictData;
use App\Services\Project\ProjectDictService;
use App\Services\Project\ProjectDocService;
use App\Services\SysMenuService;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class InfoController extends ProjectController
{
    private $skins = ['skin-blue', 'skin-green', 'skin-purple', 'skin-red', 'skin-yellow'];
    private $themes = ['theme-dark', 'theme-light', 'theme-blue'];

    /**
     * 项目列表
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $projectStatusEnum = SysDictData::where('dict_type', 'project_status_enum')->get();
        return view('project.project', [
            'projectStatusEnum' => $projectStatusEnum,
        ]);
    }

    /**
     * 选择主题
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function switchSkin()
    {
        return view('project.skin');
    }

    /**
     * 选择主题
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function switchImage()
    {
        return view('project.back', [
            'loginImages' => config('softbook.login_images'),
        ]);
    }

    /**
     * 新增项目
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $projectMenuType = SysDictData::where('dict_type', 'project_menu_type')
            ->where('status', 0)
            ->orderBy('dict_sort')
            ->get();
        return view('project.add', [
            'projectMenuType' => $projectMenuType,
            'codeLines' => rand(61000, 69000),
            'loginImages' => config('softbook.login_images'),
        ]);
    }

    /**
     * 新建项目
     * @param Request $request
     * @return array|mixed
     */
    public function addPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {

            $model = new ProjectInfo();
            $model->project_title = $request->post('projectTitle');
            $model->project_name = $request->post('projectName');
            $model->project_code = $request->post('projectCode');
            $model->project_sector = $request->post('projectSector');
            $model->project_author = $request->post('projectAuthor');
            $model->project_version = $request->post('projectVersion');
            $model->project_category = $request->post('projectCategory');
            $model->code_line = $request->post('codeLine');
//            $model->status = $request->post('status');
            $model->menu_type = $request->post('menuType', '0');
            $model->develop_purpose = $request->post('developPurpose');
            $model->project_feature = $request->post('projectFeature');
            $model->project_skill = $request->post('projectSkill');
            $model->remark = $request->post('remark');
            $model->create_by = auth()->user()->login_name;

            $faker = Factory::create('zh_CN');
            $model->project_admin = $faker->name;
            $model->project_admin_image = '/faces/' . rand(1, 21551) . '.png';

            // 主题样式列表
            $model->project_skin = Arr::random($this->skins);
            $model->project_theme = Arr::random($this->themes);
            $skinTheme = explode('|', trim($request->post('skinTheme')));
            if (isset($skinTheme[0]) && in_array($skinTheme[0], $this->skins)) {
                $model->project_skin = $skinTheme[0];
            }
            if (isset($skinTheme[1]) && in_array($skinTheme[1], $this->themes)) {
                $model->project_theme = $skinTheme[1];
            }
            $model->login_image = $request->post('loginImage');

            $model->save();
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 编辑项目
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $data = ProjectInfo::findOrFail($id);
        if (!auth()->user()->isAdmin() && auth()->user()->login_name != $data->create_by) {
            abort(404);
        }

        $projectMenuType = SysDictData::where('dict_type', 'project_menu_type')
            ->where('status', 0)
            ->orderBy('dict_sort')
            ->get();

        return view('project.edit', [
            'data' => $data,
            'projectMenuType' => $projectMenuType,
            'loginImages' => config('softbook.login_images'),
        ]);
    }

    /**
     * 编辑项目
     * @param Request $request
     * @return array|mixed
     */
    public function editPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {

            $model = ProjectInfo::findOrFail($request->post('projectId'));
            if (!auth()->user()->isAdmin() && auth()->user()->login_name != $model->create_by) {
                throw new \Exception('没有编辑权限');
            }
            $model->project_title = $request->post('projectTitle');
            $model->project_name = $request->post('projectName');
            $model->project_code = $request->post('projectCode');
            $model->project_sector = $request->post('projectSector');
            $model->project_author = $request->post('projectAuthor');
            $model->project_version = $request->post('projectVersion');
            $model->project_category = $request->post('projectCategory');
            $model->code_line = $request->post('codeLine');
//            $model->status = $request->post('status');
            $model->menu_type = $request->post('menuType', '0');
            $model->develop_purpose = $request->post('developPurpose');
            $model->project_feature = $request->post('projectFeature');
            $model->project_skill = $request->post('projectSkill');
            $model->remark = $request->post('remark');
            $model->update_by = auth()->user()->login_name;

            // 主题样式列表
            $model->project_skin = Arr::random($this->skins);
            $model->project_theme = Arr::random($this->themes);
            $skinTheme = explode('|', trim($request->post('skinTheme')));
            if (isset($skinTheme[0]) && in_array($skinTheme[0], $this->skins)) {
                $model->project_skin = $skinTheme[0];
            }
            if (isset($skinTheme[1]) && in_array($skinTheme[1], $this->themes)) {
                $model->project_theme = $skinTheme[1];
            }
            $model->login_image = $request->post('loginImage');

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
     * @return array|mixed
     */
    public function remove(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $ids = explode(',', $request->post('ids'));
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $model = ProjectInfo::findOrFail($id);
                    if (auth()->user()->isAdmin() || auth()->user()->login_name == $model->create_by) {
                        $model->delete();
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
     * 列表数据
     * @param Request $request
     * @return array|mixed
     */
    public function lists(Request $request)
    {
        $return = $this->ajaxReturnWithPage;
        try {
            $model = new ProjectInfo();
            // 权限控制
            if (!auth()->user()->isAdmin()) {
                $model = $model->where('create_by', auth()->user()->login_name);
            }
            if ($request->post('projectTitle')) {
                $model = $model->where('project_title', 'like', '%' . trim($request->post('projectTitle')) . '%');
            }
            if ($request->post('createBy')) {
                $model = $model->where('create_by', trim($request->post('createBy')));
            }
            if (strlen($request->post('status')) > 0) {
                $model = $model->where('status', trim($request->post('status')));
            }
            $time = $request->post('time');
            if (!empty($time['begin'])) {
                $model = $model->where('create_time', '>=', date('Y-m-d H:i:s', strtotime($time['begin'])));
            }
            if (!empty($time['end'])) {
                $model = $model->where('create_time', '<', date('Y-m-d H:i:s', strtotime($time['end']) + 86400));
            }
            $pageSize = $request->post('pageSize');
            $list = $model->orderByDesc('project_id')
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
     * 下载文档
     * @param Request $request
     * @param $id
     * @return void
     */
    public function download(Request $request, $id)
    {
        try {
            $project = ProjectInfo::findOrFail($id);
            if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
                throw new \Exception('没有下载权限');
            }
            $docService = new ProjectDocService();
            if ($file = $docService->saveDocByProjectId($project, true)) {
                return response()->download($file,
                    str_replace(['/'], '', $project->project_title) . '.zip')->deleteFileAfterSend();
            }
        } catch (\Exception $e) {
            abort(404);
        }
    }

    /**
     * 下载文档
     * @param Request $request
     * @param $id
     * @return void
     */
    public function batchDownload(Request $request)
    {
        try {
            $ids = explode(',', trim($request->get('ids')));
            $downProjects = [];
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $project = ProjectInfo::findOrFail($id);
                    if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
                        continue;
                    }
                    $downProjects[] = $project;
                }
            }
            if (empty($downProjects)) {
                throw new \Exception('目录为空', 1001);
            }
            $docService = new ProjectDocService();
            if ($file = $docService->saveDocByProjectIds($downProjects, true)) {
                return response()->download($file, date('Ymd') . '.zip')->deleteFileAfterSend();
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
            abort(404);
        }
    }

    /**
     * 截图上传保存
     * @param Request $request
     * @return array|mixed
     */
    public function uploadImage(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $file = $request->post('file');
            $name = $request->post('name');
            $type = $request->post('type');
            $projectId = $request->post('projectId');
            $menuId = $request->post('menuId');

            if ($type == 'login' && $projectId > 0) {
                $project = ProjectInfo::findOrFail($projectId);
            } else {
                if ($type == 'menu') {
                    $menu = ProjectMenu::findOrFail($menuId);
                    $project = ProjectInfo::findOrFail($menu->project_id);
                }
            }

            if (empty($file) || empty($name)) {
                throw new \Exception('图片内容或者名称不能为空', 1001);
            }
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $file, $res)) {
                //获取图片类型
                $imageType = $res[2];
                $imagePath = rtrim(env('SOFTBOOK_IMAGE_DIR', resource_path('softbook/image')), '/');
                $fileName = $imagePath . '/' . $name . '.' . $imageType;
                if (file_exists($fileName)) {
                    unlink($fileName);
                }
                if (!file_put_contents($fileName, base64_decode(str_replace($res[1], '', $file)))) {
                    throw new \Exception('图片保存失败', 1002);
                }
            }

            if ($type == 'login') {
                if ($project->menu_type == 3) {
                    // 查询第一个菜单页
                    $menuService = new SysMenuService();
                    $projectMenu = ProjectMenu::where('project_id', $project->project_id)
                        ->where('visible', '0')
                        ->orderBy('order_num')
                        ->orderBy('menu_id')
                        ->get()
                        ->toArray();
                    $menus = $menuService->getChildPerms($projectMenu, 0);
                    if (isset($menus[0]['children']) && isset($menus[0]['children'][0])) {
                        $return['url'] = '/project/book/' . $menus[0]['children'][0]['menu_id'];
                    }
                } else {
                    $return['url'] = '/project/preview/' . $project->project_id . '/index';
                }
            } else {
                if ($type == 'menu') {
                    // 查询第一个菜单页
                    $menuService = new SysMenuService();
                    $projectMenu = ProjectMenu::where('project_id', $project->project_id)
                        ->where('visible', '0')
                        ->orderBy('order_num')
                        ->orderBy('menu_id')
                        ->get()
                        ->toArray();
                    $menus = $menuService->getChildPerms($projectMenu, 0);
                    $returnMenu = false;
                    $returnMenuId = 0;
                    foreach ($menus as $menu) {
                        if (!isset($menu['children']) || empty($menu['children'])) {
                            continue;
                        }
                        if ($returnMenuId > 0) {
                            break;
                        }
                        foreach ($menu['children'] as $child) {
                            if ($returnMenu == true) {
                                $returnMenuId = $child['menu_id'];
                                break;
                            }
                            if (!$returnMenu && $child['menu_id'] == $menuId) {
                                $returnMenu = true;
                            }
                        }
                    }
                    if ($returnMenuId) {
                        $return['url'] = '/project/book/' . $returnMenuId;
                    }
                }
            }

            $return['project_id'] = $project->project_id;
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 截图上传保存
     * @param Request $request
     * @return array|mixed
     */
    public function submit(Request $request)
    {
        $return = $this->ajaxReturn;
        $return['next_id'] = 0;
        try {
            $maxId = 0;
            $ids = explode(',', trim($request->get('ids')));
            $status = $request->get('type') == 'image' ? 1 : 2;
            $next = $request->get('next') == 'true' ? true : false;
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    if ($maxId < $id) {
                        $maxId = $id;
                    }
                    $project = ProjectInfo::findOrFail($id);
                    $project->status = $status;
                    $project->update_by = auth()->user()->login_name;
                    $project->save();
                }
            }
            if ($next && $maxId > 0) {
                $project = new ProjectInfo();
                if (!auth()->user()->isAdmin()) {
                    $project = $project->where('create_by', auth()->user()->login_name);
                }
                $project = $project->where('project_id', '>', $maxId)
                    ->where('status', 0)->orderBy('project_id')
                    ->first();
                if (!is_null($project)) {
                    $return['next_id'] = $project->project_id;
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
     * @return array|mixed
     */
    public function getProjectCode(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $projectName = trim($request->post('projectName'));
            if (empty($projectName)) {
                throw new \Exception('项目简称不能为空', 1001);
            }
            $code = ProjectDictService::getDictValue($projectName);
            if (empty($code)) {
                throw new \Exception('项目编码获取失败', 1002);
            }
            $return['projectCode'] = $code;
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 初始化数据
     * @param Request $request
     * @return array|mixed
     */
    public function dataInit(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $projectId = $request->get('projectId');
//            $projectService = new ProjectInfoService();
//            $projectService->projectDataInit($projectId);
//            $projectService->projectMenuDescInit($projectId);

            $project = ProjectInfo::findOrFail($projectId);

            ProjectDataInit::dispatch($project->project_id);
            ProjectMenuDescInit::dispatch($project->project_id);

            sleep(5);
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 一键初始化项目
     * @return void
     */
    public function projectInit()
    {
        return view('project.dataInit');
    }

    /**
     * 一键初始化项目
     * @return void
     */
    public function projectInitPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $data = trim($request->post('data'));
            $projectInfo = json_decode($data, true);

            $project = new ProjectInfo();
            foreach (['project_title', 'develop_purpose', 'project_skill', 'project_feature'] as $item) {
                if (empty($projectInfo[$item])) {
                    throw new \Exception($item . '不能为空', 1000);
                }
                $project->$item = $projectInfo[$item];
            }
            foreach (['project_name', 'project_sector', 'project_author'] as $item) {
                if (isset($projectInfo[$item]) && !empty($projectInfo[$item])) {
                    $project->$item = $projectInfo[$item];
                }
            }

            $code = ProjectDictService::getDictValue($project->project_sector);
            if (empty($code)) {
                throw new \Exception('项目编码获取失败', 1002);
            }

            // 获取菜单类型集合
            $projectMenuTypes = SysDictData::where('dict_type', 'project_menu_type')
                ->where('status', 0)
                ->get();

            $menuTypes = [];
            foreach ($projectMenuTypes as $type) {
                $menuTypes[] = $type->dict_value;
            }

            $project->project_code = $code;
            $project->project_version = 'V1.0';
            $project->project_category = '应用软件';
            $project->code_line = rand(61000, 69000);

            // 需要初始化数据
            if (isset($projectInfo['project_data']) && $projectInfo['project_data'] == 1) {
                $project->status = 3;
            }

            $project->menu_type = Arr::random($menuTypes);
            $project->login_image = '/static/back/login-back00.jpg';
            $project->create_by = auth()->user()->login_name;

            // 新增管理员
            $faker = Factory::create('zh_CN');
            $project->project_admin = $faker->name;
            $project->project_admin_image = '/faces/' . rand(1, 21551) . '.png';

            if ($project->save()) {
                $menus = $projectInfo['menus'];

                // 获取所有字段结合
                $keys = [];
                foreach ($menus as $itemMenu) {
                    foreach ($itemMenu['childMenus'] as $item) {
                        if (!empty($item['name'])) {
                            $keys = array_merge($keys, [$item['name']]);
                        }
                        if (!empty($item['fields'])) {
                            $item['fields'] = trim($item['fields']);
                            $keys = array_merge($keys, explode('|', trim($item['fields'], '|')));
                        }
                    }
                }

                // 获取所有英文字段
                $dictArr = ProjectDictService::getDictArray(array_unique($keys));

                $itemSort = 0;
                $itemChildSort = 0;
                foreach ($menus as $itemMenu) {
                    // 防止为空则跳出
                    if (empty($itemMenu['name'])) {
                        continue;
                    }
                    // 父菜单创建
                    $menu = new ProjectMenu();
                    $menu->project_id = $project->project_id;
                    $menu->parent_id = 0;
                    $menu->menu_name = $itemMenu['name'];
                    $menu->menu_code = '';
                    $menu->order_num = $itemSort++;
                    $menu->visible = 0;
                    $menu->create_by = auth()->user()->login_name;
                    $menu->url = '#';
                    $menu->class = '';
                    if (isset($itemMenu['remark']) && !empty(trim($itemMenu['remark']))) {
                        $menu->remark = trim($itemMenu['remark']);
                    }
                    $menu->menu_type = 'M';
                    if ($menu->save()) {
                        // 创建子菜单
                        foreach ($itemMenu['childMenus'] as $item) {
                            $childMenu = new ProjectMenu();
                            $childMenu->project_id = $project->project_id;
                            $childMenu->parent_id = $menu->menu_id;
                            $childMenu->menu_name = $item['name'];
                            $childMenu->menu_code = isset($dictArr[$item['name']]) ? $dictArr[$item['name']]['dict_value'] : '';
                            $childMenu->order_num = $itemChildSort++;
                            $childMenu->visible = 0;
                            $childMenu->create_by = auth()->user()->login_name;
                            $childMenu->class = 'menuItemShot';
                            if (isset($item['remark']) && !empty(trim($item['remark']))) {
                                $childMenu->remark = trim($item['remark']);
                            }
                            $childMenu->menu_type = 'C';

                            if (isset($item['data_type']) && in_array($item['data_type'], config('softbook.data_type'))) {
                                $childMenu->data_type = $item['data_type'];
                            }

                            if ($childMenu->save()) {
                                $childMenu->url = '/project/business/' . $childMenu->menu_id;
                                $childMenu->save();

                                $fields = trim($item['fields']);
                                $fields = explode('|', trim($fields, '|'));
                                $columnSort = 0;
                                // 新建菜单列
                                foreach ($fields as $itemKey) {
                                    if (!isset($dictArr[$itemKey])) {
                                        throw new \Exception('不存在该列' . $itemKey);
                                    }
                                    $dict = $dictArr[$itemKey];
                                    $projectColumn = new ProjectColumn();
                                    $projectColumn->project_id = $project->project_id;
                                    $projectColumn->menu_id = $childMenu->menu_id;
                                    $projectColumn->dict_id = $dict['dict_id'];
                                    $projectColumn->dict_name = $dict['dict_name'];
                                    $projectColumn->dict_value = $dict['dict_value'];
                                    $projectColumn->query_type = 'LIKE';
                                    $projectColumn->sort = $columnSort++;
                                    $projectColumn->create_by = auth()->user()->login_name;
                                    $projectColumn->save();
                                }
                            }
                        }
                    }
                }

                if (isset($projectInfo['project_data']) && $projectInfo['project_data'] == 1) {
                    // 加入队列
                    ProjectDataInit::dispatch($project->project_id);
                    ProjectMenuDescInit::dispatch($project->project_id);
                }
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }
}
