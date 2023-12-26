<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\ProjectInfo;
use App\Models\SysDictData;
use Illuminate\Http\Request;

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
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
        return view('project.project', [
            'sysNormalDisable' => $sysNormalDisable,
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
     * 新增项目
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        return view('project.add', [
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
            $model->status = $request->post('status');
            $model->develop_purpose = $request->post('developPurpose');
            $model->project_feature = $request->post('projectFeature');
            $model->project_skill = $request->post('projectSkill');
            $model->remark = $request->post('remark');
            $model->create_by = auth()->user()->login_name;

            // 主题样式列表
            $model->project_skin = $this->skins[array_rand($this->skins)];
            $model->project_theme = $this->themes[array_rand($this->themes)];
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
        return view('project.edit', [
            'data' => $data,
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
            $model->project_title = $request->post('projectTitle');
            $model->project_name = $request->post('projectName');
            $model->project_code = $request->post('projectCode');
            $model->project_sector = $request->post('projectSector');
            $model->project_author = $request->post('projectAuthor');
            $model->project_version = $request->post('projectVersion');
            $model->project_category = $request->post('projectCategory');
            $model->code_line = $request->post('codeLine');
            $model->status = $request->post('status');
            $model->develop_purpose = $request->post('developPurpose');
            $model->project_feature = $request->post('projectFeature');
            $model->project_skill = $request->post('projectSkill');
            $model->remark = $request->post('remark');
            $model->create_by = auth()->user()->login_name;

            // 主题样式列表
            $model->project_skin = $this->skins[array_rand($this->skins)];
            $model->project_theme = $this->themes[array_rand($this->themes)];
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
            $model = new ProjectInfo();
            // 权限控制
            if (!auth()->user()->isAdmin()) {
                $model = $model->where('create_by', auth()->user()->login_name);
            }
            if ($request->post('projectTitle')) {
                $model = $model->where('project_title', 'like', '%' . trim($request->post('projectTitle')) . '%');
            }
            if (strlen($request->post('status')) > 0) {
                $model = $model->where('status', trim($request->post('status')));
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
}
