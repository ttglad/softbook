<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysDictData;
use App\Models\SysPost;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class PostController extends AdminController
{
    /**
     * 列表页
     */
    public function show(Request $request)
    {
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();

        return view('admin.post.post', [
            'sysNormalDisable' => $sysNormalDisable,
        ]);
    }

    /**
     * 添加页
     */
    public function add(Request $request)
    {
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
        return view('admin.post.add', [
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
            $model = new SysPost();

            $model->post_name = $request->post('postName');
            $model->post_code = $request->post('postCode');
            $model->post_sort = $request->post('postSort');
            $model->status = $request->post('status');
            $model->remark = $request->post('remark');
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
    public function edit(Request $request, $id)
    {
        $post = SysPost::findOrFail($id);
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
        return view('admin.post.edit', [
            'post' => $post,
            'sysNormalDisable' => $sysNormalDisable,
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
            $id = $request->post('postId');
            $model = SysPost::findOrFail($id);

            $model->post_name = $request->post('postName');
            $model->post_code = $request->post('postCode');
            $model->post_sort = $request->post('postSort');
            $model->status = $request->post('status');
            $model->remark = $request->post('remark');
            $model->update_by = auth()->user()->login_name;

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
     * @param $id
     * @return void
     */
    public function remove(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $ids = explode(',', $request->post('ids'));
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $model = SysPost::findOrFail($id);
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
            $model = new SysPost();
            if ($request->post('postCode')) {
                $model = $model->where('post_code', trim($request->post('postCode')));
            }
            if ($request->post('postName')) {
                $model = $model->where('post_name', 'like', '%' . trim($request->post('postName')) . '%');
            }
            if (strlen($request->post('status')) > 0) {
                $model = $model->where('status', trim($request->post('status')));
            }
            $pageSize = $request->post('pageSize');
            $list = $model->orderBy('post_id')
                ->orderBy('post_sort')
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
     * 校验角色key唯一
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkPostNameUnique(Request $request)
    {
        try {
            $postId = trim($request->post('postId'));
            $postName = trim($request->post('postName'));
            if (empty($postName)) {
                throw new \Exception('岗位名称不能为空', 1001);
            }
            $count = SysPost::where('post_name', $postName);
            if ($postId) {
                $count = $count->where('post_id', '!=', $postId);
            }
            $count = $count->count();
            if ($count > 0) {
                throw new \Exception('岗位名称已存在', 1002);
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
    public function checkPostCodeUnique(Request $request)
    {
        try {
            $postId = trim($request->post('postId'));
            $postCode = trim($request->post('postCode'));
            if (empty($postCode)) {
                throw new \Exception('岗位代码不能为空', 1001);
            }
            $count = SysPost::where('post_code', $postCode);
            if ($postId) {
                $count = $count->where('post_id', '!=', $postId);
            }
            $count = $count->count();
            if ($count > 0) {
                throw new \Exception('岗位代码已存在', 1002);
            }
        } catch (\Exception $e) {
            exit('false');
        }
        exit('true');
    }
}
