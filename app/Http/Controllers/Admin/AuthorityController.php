<?php

namespace App\Http\Controllers\Admin;

use App\Events\SystemLogEvent;
use App\Models\SysConfig;
use Auth;
use Illuminate\Http\Request;


/**
 * 后台管理员用户登录统一认证
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class AuthorityController extends AdminController
{

    /**
     * 添加路由过滤中间件
     */
    public function __construct()
    {

    }

    /*
     * 显示登录页面
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

    /*
     * 登录提交
     * ajax返回
     */
    public function postLogin(Request $request)
    {
        $result = [
            'code' => 0,
            'message' => '',
        ];
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(request()->all(), $rules);
        if ($validator->fails()) {
            $result['code'] = 1000;
            $result['message'] = '验证码不正确';
            return $result;
        }

        if (!Auth::attempt([
            'login_name' => $request->input('username'),
            'password' => $request->input('password'),
        ], $request->has('remember'))
        ) {
            $result['code'] = 1001;
            $result['message'] = '用户名或者密码错误，请重新登录';
        }

        return $result;
    }

    /*
     * 用户退出登录
     */
    public function getLogout()
    {
//        event(new SystemLogEvent('session', '退出登录'));
        Auth::logout();
        return redirect()->route('admin_login');
    }
}
