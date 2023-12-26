<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\ProjectDict;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class DictController extends ProjectController
{
    /**
     * 列表页
     */
    public function show(Request $request)
    {
        return view('project.dict.dict');
    }

    /**
     * 添加页
     */
    public function add(Request $request)
    {
        return view('project.dict.add');
    }

    /**
     * 新增提交
     */
    public function addPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $dictName = trim($request->post('dictName'));
            if (ProjectDict::where('dict_name', $dictName)->count() > 0) {
                throw new \Exception('已存在此字典数据', 1001);
            }

            $model = new ProjectDict();

            $model->dict_name = $dictName;
            $model->dict_value = $request->post('dictValue');

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
    public function edit(Request $request, $id)
    {
        $dict = ProjectDict::findOrFail($id);
        return view('project.dict.edit', [
            'dict' => $dict,
        ]);
    }

    /**
     * 修改提交
     * @param Request $request
     * @return array|mixed
     */
    public function editPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('dictId');
            $model = ProjectDict::findOrFail($id);

            $model->dict_name = $request->post('dictName');
            $model->dict_value = $request->post('dictValue');
            $model->save();

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
            $model = new ProjectDict();
            if ($request->post('dictName')) {
                $model = $model->where('dict_name', 'like', '%' . trim($request->post('dictName')) . '%');
            }
            if ($request->post('dictValue')) {
                $model = $model->where('dict_value', 'like', '%' . trim($request->post('dictValue')) . '%');
            }
            $pageSize = $request->post('pageSize');
            $list = $model->orderByDesc('dict_id')
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
