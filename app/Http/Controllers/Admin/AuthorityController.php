<?php

namespace App\Http\Controllers\Admin;

use App\Events\SystemLogEvent;
use App\Events\UserLoginEvent;
use App\Models\SysConfig;
use App\Models\SysUser;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;


/**
 * 后台管理员用户登录统一认证
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class AuthorityController extends AdminController
{
    use ThrottlesLogins;

    /**
     * 添加路由过滤中间件
     */
    public function __construct()
    {

    }

    /**
     * 显示登录页面
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        $sysConfig = SysConfig::where('config_key', 'sys.account.registerUser')->first();
        $registerValue = is_null($sysConfig) ? false : ($sysConfig->config_value == 'false' ? false : true);
        $rememberMe = true;
        $captchaEnabled = false;

        // 软件名称
        $sysConfig = SysConfig::where('config_key', 'sys.soft.name')->first();
        $softName = $sysConfig->config_value;

        return view('admin.auth.login', [
            'registerValue' => $registerValue,
            'rememberMe' => $rememberMe,
            'captchaEnabled' => $captchaEnabled,
            'softName' => $softName,
        ]);
    }

    /**
     * 登录提交
     * @param Request $request
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function postLogin(Request $request)
    {
        $result = [
            'code' => 0,
            'message' => '',
        ];

        try {
            // 登录锁定
            if ($this->hasTooManyLoginAttempts($request)) {
                throw new \Exception('登录失败次数过多，已锁定，请稍后再试', 1001);
            }

            // 验证码校验
            $rules = ['captcha' => 'required|captcha'];
            $validator = validator()->make(request()->all(), $rules);
            if ($validator->fails()) {
                throw new \Exception('验证码不正确', 1002);
            }

            // 登录校验
            $remember = ($request->input('remember') == 'true') ? true : false;
            if (!Auth::attempt([
                'login_name' => $request->input('username'),
                'password' => $request->input('password'),
            ], $remember)
            ) {
                $this->incrementLoginAttempts($request);

                throw new \Exception('用户名或者密码错误，请重新登录', 1003);
            }
            // 记录日志
            event(new UserLoginEvent($request->input('username'), 0, '登录成功'));
        } catch (\Exception $e) {

            // 记录日志
            event(new UserLoginEvent($request->input('username'), 1, $e->getMessage()));

            $result['code'] = $e->getCode() == 0 ?? 10001;
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    /**
     * 退出登录
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        // 记录日志
        event(new UserLoginEvent(auth()->user()->login_name, 0, '退出成功'));

        Auth::logout();
        return redirect()->route('admin_login');
    }

    /**
     * @return string
     */
    private function username()
    {
        return 'username';
    }
}
