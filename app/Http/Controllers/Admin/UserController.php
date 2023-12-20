<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysConfig;
use App\Models\SysDictData;
use App\Models\SysPost;
use App\Models\SysRole;
use App\Models\SysUser;
use App\Models\SysUserRole;
use App\Services\SysDeptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class UserController extends AdminController
{

    /**
     * 列表页
     */
    public function show()
    {
        // 获取菜单展示名称
        $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();

        return view('admin.user.user', [
            'sysNormalDisable' => $sysNormalDisable,
        ]);
    }

    /**
     * 新增页
     */
    public function add()
    {
        // 获取菜单展示名称
        $sysUserSex = SysDictData::where('dict_type', 'sys_user_sex')->get();

        // 密码类型
        $sysConfig = SysConfig::where('config_key', 'sys.account.chrtype')->first();
        $passType = is_null($sysConfig) ? '0' : $sysConfig->config_value;

        // 获取角色
        $roles = SysRole::where('status', 0)->get();

        // 岗位
        $posts = SysPost::where('status', 0)->get();

        return view('admin.user.add', [
            'passType' => $passType,
            'sysUserSex' => $sysUserSex,
            'roles' => $roles,
            'posts' => $posts,
        ]);
    }

    /**
     * 新增提交
     */
    public function addPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $user = new SysUser();
            $user->login_name = $request->post('loginName');
            $user->user_name = $request->post('userName');
            $user->user_type = '00';
            $user->dept_id = $request->post('deptId');
            $user->phonenumber = $request->post('phonenumber');
            $user->email = $request->post('email');
            $user->sex = $request->post('sex');
            $user->password = Hash::make($request->post('password'));
            $user->status = $request->post('status');
            $user->remark = $request->post('remark');
            $user->create_by = auth()->user()->login_name;

            if ($user->save()) {
                // 新增角色关联
                $roles = explode(',', $request->post('roleIds'));
                $user->roles()->sync($roles);

                // 新增岗位关联
                $posts = explode(',', $request->post('postIds'));
                $user->posts()->sync($posts);
            }

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
        $user = SysUser::with('roles', 'posts', 'dept')->findOrFail($id);

        $userRoles = [];
        foreach ($user->roles as $role) {
            $userRoles[] = $role->role_id;
        }

        $userPosts = [];
        foreach ($user->posts as $post) {
            $userPosts[] = $post->post_id;
        }

        // 获取菜单展示名称
        $sysUserSex = SysDictData::where('dict_type', 'sys_user_sex')->get();

        // 密码类型
        $sysConfig = SysConfig::where('config_key', 'sys.account.chrtype')->first();
        $passType = is_null($sysConfig) ? '0' : $sysConfig->config_value;

        // 获取角色
        $roles = SysRole::where('status', 0)->get();

        // 岗位
        $posts = SysPost::where('status', 0)->get();

        return view('admin.user.edit', [
            'user' => $user,
            'passType' => $passType,
            'sysUserSex' => $sysUserSex,
            'roles' => $roles,
            'posts' => $posts,
            'userRoles' => $userRoles,
            'userPosts' => $userPosts,
        ]);
    }

    /**
     * 修改提交
     */
    public function editPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('userId');
            $user = SysUser::findOrFail($id);

            $user->user_name = $request->post('userName');
            $user->dept_id = $request->post('deptId');
            $user->phonenumber = $request->post('phonenumber');
            $user->email = $request->post('email');
            $user->sex = $request->post('sex');
            $user->status = $request->post('status');
            $user->remark = $request->post('remark');
            $user->update_by = auth()->user()->login_name;

            if ($user->save()) {
                // 新增角色关联
                $roles = explode(',', $request->post('roleIds'));
                $user->roles()->sync($roles);

                // 新增岗位关联
                $posts = explode(',', $request->post('postIds'));
                $user->posts()->sync($posts);
            }

        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 更改用户状态
     * @return void
     */
    public function changeStatus(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('userId');
            $user = SysUser::findOrFail($id);

            $user->status = $request->post('status');
            $user->update_by = auth()->user()->login_name;

            $user->save();

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
            $model = new SysUser();
            if ($request->post('login_name')) {
                $model = $model->where('login_name', trim($request->post('login_name')));
            }
            if ($request->post('phonenumber')) {
                $model = $model->where('phonenumber', trim($request->post('phonenumber')));
            }
            if (strlen($request->post('status')) > 0) {
                $model = $model->where('status', trim($request->post('status')));
            }

            $list = $model->orderBy('user_id')
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
     * 删除
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function remove(Request $request)
    {
        $return = $this->ajaxReturn;

        try {
            $ids = explode(',', $request->post('ids'));
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    $user = SysUser::findOrFail($id);

                    // 删除角色关系
                    $user->roles()->detach();
                    // 删除岗位关系
                    $user->posts()->detach();
                    // 删除用户
                    SysUser::where('user_id', $user->user_id)->delete();
                }
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 重置密码
     */
    public function resetPwd(Request $request, $id)
    {
        $user = SysUser::findOrFail($id);

        return view('admin.user.resetPwd', [
            'user' => $user,
        ]);
    }

    /**
     * 修改提交
     */
    public function resetPwdPost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('userId');
            $user = SysUser::findOrFail($id);

            $user->password = Hash::make($request->post('password'));

            $user->save();
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }


    /**
     * 重置密码
     */
    public function authRole(Request $request, $id)
    {
        $user = SysUser::with('roles')->findOrFail($id);

        $userRoles = [];
        foreach ($user->roles as $role) {
            $userRoles[] = $role->role_id;
        }

        // 获取角色
        $roles = SysRole::where('status', 0)->get();
        foreach ($roles as $role) {
            if (in_array($role->role_id, $userRoles)) {
                $role->flag = true;
            }
        }

        return view('admin.user.authRole', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * 修改提交
     */
    public function authRolePost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $id = $request->post('userId');
            $user = SysUser::findOrFail($id);

            // 新增角色关联
            $roles = explode(',', $request->post('roleIds'));
            $user->roles()->sync($roles);

        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 个人中心
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function profile(Request $request)
    {
        // 密码类型
        $sysConfig = SysConfig::where('config_key', 'sys.account.chrtype')->first();
        $passType = is_null($sysConfig) ? '0' : $sysConfig->config_value;

        $user = SysUser::findOrFail(auth()->user()->user_id);
        return view('admin.user.profile', [
            'user' => $user,
            'passType' => $passType,
        ]);
    }

    /**
     * 修改头像
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function profileAvatar(Request $request)
    {
        // 密码类型
        $sysConfig = SysConfig::where('config_key', 'sys.account.chrtype')->first();
        $passType = is_null($sysConfig) ? '0' : $sysConfig->config_value;

        $user = SysUser::findOrFail(auth()->user()->user_id);
        return view('admin.user.profile.avatar', [
            'user' => $user,
            'passType' => $passType,
        ]);
    }

    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function passRet(Request $request)
    {
        // 密码类型
        $sysConfig = SysConfig::where('config_key', 'sys.account.chrtype')->first();
        $passType = is_null($sysConfig) ? '0' : $sysConfig->config_value;

        $user = SysUser::findOrFail(auth()->user()->user_id);
        return view('admin.user.profile.password', [
            'user' => $user,
            'passType' => $passType,
        ]);
    }

    /**
     * 修改用户信息
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function update(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            SysUser::where('user_id', auth()->user()->user_id)->update([
                'user_name' => $request->post('user_name'),
                'phonenumber' => $request->post('phonenumber'),
                'email' => $request->post('email'),
                'sex' => $request->post('sex'),
            ]);
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 更新密码
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function resetPassword(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $user = SysUser::find(auth()->user()->user_id);
            $password = $request->get('oldPassword');
            if (!Hash::check($password, $user->password)) {
                throw new \Exception('旧密码不正确', 1001);
            }
            if ($request->get('newPassword') != $request->get('confirmPassword')) {
                throw new \Exception('密码和确认密码不匹配', 1002);
            }
            SysUser::where('user_id', auth()->user()->user_id)->update([
                'password' => Hash::make($request->post('newPassword')),
            ]);
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 修改头像提交
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function updateAvatar(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            if ($request->hasFile('file')) {

                $file = $request->file('file');
                $file->move(public_path('avatar'), auth()->user()->user_id . '.png');

                SysUser::where('user_id', auth()->user()->user_id)->update([
                    'avatar' => '/avatar/' . auth()->user()->user_id . '.png',
                ]);
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 校验用户密码
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkPassword(Request $request)
    {
        try {
            $user = SysUser::find(auth()->user()->user_id);
            $password = $request->get('password');
            if (!Hash::check($password, $user->password)) {
                throw new \Exception('旧密码不正确', 1002);
            }
        } catch (\Exception $e) {
            exit('false');
        }
        exit('true');
    }

    /**
     * 校验用户邮箱唯一
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkEmailUnique(Request $request)
    {
        try {
            $email = trim($request->post('email'));
            if (empty($email)) {
                throw new \Exception('邮箱不能为空', 1001);
            }
            $userId = $request->post('userId') ? $request->post('userId') : auth()->user()->user_id;
            $count = SysUser::where('email', $email)
                ->where('user_id', '!=', $userId)
                ->count();
            if ($count > 0) {
                throw new \Exception('邮箱地址已存在', 1002);
            }
        } catch (\Exception $e) {
            exit('false');
        }
        exit('true');
    }

    /**
     * 校验用户手机号码唯一
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkPhoneUnique(Request $request)
    {
        try {
            $phone = trim($request->post('phonenumber'));
            if (empty($phone)) {
                throw new \Exception('手机号码不能为空', 1001);
            }
            $userId = $request->post('userId') ? $request->post('userId') : auth()->user()->user_id;
            $count = SysUser::where('phonenumber', $phone)
                ->where('user_id', '!=', $userId)
                ->count();
            if ($count > 0) {
                throw new \Exception('手机号码地址已存在', 1002);
            }
        } catch (\Exception $e) {
            exit('false');
        }
        exit('true');
    }

    /**
     * 校验用户登录名唯一
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkLoginNameUnique(Request $request)
    {
        try {
            $loginName = trim($request->post('loginName'));
            if (empty($loginName)) {
                throw new \Exception('手机号码不能为空', 1001);
            }
            $userId = $request->post('userId') ? $request->post('userId') : auth()->user()->user_id;
            $count = SysUser::where('login_name', $loginName)
                ->where('user_id', '!=', $userId)
                ->count();
            if ($count > 0) {
                throw new \Exception('登录名已存在', 1002);
            }
        } catch (\Exception $e) {
            exit('false');
        }
        exit('true');
    }

    /**
     * 获取部门树
     * @param Request $request
     * @return array
     */
    public function deptTreeData(Request $request): array
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
}
