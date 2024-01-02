<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\ProjectInfo;
use App\Models\SysDictData;
use App\Services\Project\ProjectDocService;
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
            $docService = new ProjectDocService();
            if ($file = $docService->saveDocByProjectId($project, true)) {
                return response()->download($file, $project->project_title . '.zip')->deleteFileAfterSend();
            }
        } catch (\Exception $e) {
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
            if (empty($file) || empty($name)) {
                throw new \Exception('图片内容或者名称不能为空', 1001);
            }
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $file, $res)) {
                //获取图片类型
                $type = $res[2];
                $imagePath = rtrim(env('SOFTBOOK_IMAGE_DIR', resource_path('softbook/image')), '/');
                $fileName = $imagePath . '/' . $name . '.' . $type;
                if (file_exists($fileName)) {
                    unlink($fileName);
                }
                if (!file_put_contents($fileName, base64_decode(str_replace($res[1], '', $file)))) {
                    throw new \Exception('图片保存失败', 1002);
                }
            }
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
                $project = ProjectInfo::where('project_id', '>', $maxId)->where('status', 0)->orderBy('project_id')->first();
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
}
