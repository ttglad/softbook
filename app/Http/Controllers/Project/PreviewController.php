<?php

namespace App\Http\Controllers\Project;

use App\Models\Project\ProjectInfo;
use App\Models\Project\ProjectMenu;
use App\Models\SysConfig;
use App\Services\SysMenuService;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class PreviewController extends ProjectController
{

    /**
     * 预览登录
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(Request $request, $id)
    {
        // 获取项目信息
        $project = ProjectInfo::findOrFail($id);

        if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
            abort(404);
        }
        $sysConfig = SysConfig::where('config_key', 'sys.account.registerUser')->first();
        $registerValue = is_null($sysConfig) ? false : ($sysConfig->config_value == 'false' ? false : true);
        $rememberMe = true;
        $captchaEnabled = false;

        $view = 'project.preview.login';
        switch ($project->menu_type) {
            case 3:
            case 4:
            case 5:
                $view = Arr::random(['project.preview.login-tabler', 'project.preview.login-ace']);
                break;
            default:
                break;
        }

        $backType = ['', 'bg-github-lt', 'bg-github'];

        return view($view, [
            'registerValue' => $registerValue,
            'rememberMe' => $rememberMe,
            'captchaEnabled' => $captchaEnabled,
            'project' => $project,
            'backType' => Arr::random($backType),
        ]);
    }

    /**
     * 登录提交
     * @param Request $request
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function loginPost(Request $request)
    {
        $result = [
            'code' => 0,
            'message' => '',
        ];

//        // 验证码校验
//        $rules = ['captcha' => 'required|captcha'];
//        $validator = validator()->make(request()->all(), $rules);
//        if ($validator->fails()) {
//            $result['code'] = 1000;
//            $result['message'] = '验证码不正确';
//            return $result;
//        }
//
//        // 登录校验
//        $remember = ($request->input('remember') == 'true') ? true : false;
//        if (!Auth::attempt([
//            'login_name' => $request->input('username'),
//            'password' => $request->input('password'),
//        ], $remember)
//        ) {
//            $result['code'] = 1001;
//            $result['message'] = '用户名或者密码错误，请重新登录';
//        }

        return $result;
    }

    /*
     * 显示页面
     */
    public function index(Request $request, $id)
    {
        // 获取项目信息
        $project = ProjectInfo::findOrFail($id);
        if (!auth()->user()->isAdmin() && auth()->user()->login_name != $project->create_by) {
            abort(404);
        }

        if (empty($project->project_skin)) {
            // 页面主题
            $sysConfig = SysConfig::where('config_key', 'sys.index.sideTheme')->first();
            $sideTheme = is_null($sysConfig) ? false : $sysConfig->config_value;
            $project->project_skin = $sideTheme;
        }
        if (empty($project->project_theme)) {
            // 皮肤
            $sysConfig = SysConfig::where('config_key', 'sys.index.skinName')->first();
            $skinName = is_null($sysConfig) ? false : $sysConfig->config_value;
            $project->project_theme = $skinName;
        }

        // 获取菜单
        $defaultMenu = ProjectMenu::where('project_id', 0)
            ->where('visible', '0')
            ->orderBy('order_num')
            ->get()
            ->toArray();

        $menuService = new SysMenuService();
        $projectMenu = ProjectMenu::where('project_id', $project->project_id)
            ->where('visible', '0')
            ->orderBy('order_num')
            ->orderBy('menu_id')
            ->get()
            ->toArray();
        $menus = $menuService->getChildPerms(array_merge($projectMenu, $defaultMenu), 0);

        // 是否开启页脚
        $sysConfig = SysConfig::where('config_key', 'sys.index.footer')->first();
        $footer = is_null($sysConfig) ? true : $sysConfig->config_value;

        // 是否开启页签
        $sysConfig = SysConfig::where('config_key', 'sys.index.tagsView')->first();
        $tagsView = is_null($sysConfig) ? true : $sysConfig->config_value;

        // 主页样式
        $mainClass = '';
        if (!$footer && !$tagsView) {
            $mainClass = 'tagsview-footer-hide';
        } elseif (!$footer) {
            $mainClass = 'footer-hide';
        } elseif (!$tagsView) {
            $mainClass = 'tagsview-hide';
        }

        // 随机头像
        $headerImage = '/faces/' . rand(1, 21551) . '.png';

        // 随机用户
        $faker = Factory::create('zh_CN');

        // 概率横屏
        $view = 'project.preview.home';
        switch ($project->menu_type) {
            case 0:
                if (rand(0, 9) % 2 == 0) {
                    $view = 'project.preview.home-topnav';
                }
                break;
            case 2:
                $view = 'project.preview.home-topnav';
                break;
            case 3:
            case 4:
            case 5:
                $view = 'project.preview.home-tabler';
                break;
            default:
                break;
        }

        return view($view, [
            'menus' => $menus,
            'footer' => $footer,
            'tagsView' => $tagsView,
            'mainClass' => $mainClass,
            'project' => $project,
            'headerImage' => !empty($project->project_admin_image) ? $project->project_admin_image : $headerImage,
            'adminName' => !empty($project->project_admin) ? $project->project_admin : $faker->name,
            'isRandom' => false,
        ]);
    }
}
