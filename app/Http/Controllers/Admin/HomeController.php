<?php

namespace App\Http\Controllers\Admin;

use App\Events\SystemLogEvent;
use App\Models\SysConfig;
use App\Services\SysMenuService;
use Auth;
use Jenssegers\Agent\Agent;

/**
 * 后台管理员用户登录统一认证
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class HomeController extends AdminController
{

    /**
     * 添加路由过滤中间件
     */
    public function __construct()
    {

    }

    /**
     * main页
     */
    public function base()
    {
        return view('admin.base');
    }

    /*
     * 显示页面
     */
    public function home()
    {
        // 页面主题
        $sysConfig = SysConfig::where('config_key', 'sys.index.sideTheme')->first();
        $sideTheme = is_null($sysConfig) ? false : $sysConfig->config_value;
        // 皮肤
        $sysConfig = SysConfig::where('config_key', 'sys.index.skinName')->first();
        $skinName = is_null($sysConfig) ? false : $sysConfig->config_value;

        // 获取菜单
        $menuService = new SysMenuService();
        $menus = $menuService->getUserMenus(auth()->user());

        // 是否开启页脚
        $sysConfig = SysConfig::where('config_key', 'sys.index.footer')->first();
        $footer = is_null($sysConfig) ? true : $sysConfig->config_value;

        // 是否开启页签
        $sysConfig = SysConfig::where('config_key', 'sys.index.tagsView')->first();
        $tagsView = is_null($sysConfig) ? true : $sysConfig->config_value;

        // 软件名称
        $sysConfig = SysConfig::where('config_key', 'sys.soft.name')->first();
        $softName = $sysConfig->config_value;

        // 软件名称
        $sysConfig = SysConfig::where('config_key', 'sys.soft.shortName')->first();
        $softShortName = $sysConfig->config_value;


        // 主页样式
        $mainClass = '';
        if (!$footer && !$tagsView) {
            $mainClass = 'tagsview-footer-hide';
        } elseif (!$footer) {
            $mainClass = 'footer-hide';
        } elseif (!$tagsView) {
            $mainClass = 'tagsview-hide';
        }

        // 获取agent
        $agent = new Agent();

        return view('admin.home.home', [
            'sideTheme' => $sideTheme,
            'skinName' => $skinName,
            'menus' => $menus,
            'footer' => $footer,
            'tagsView' => $tagsView,
            'mainClass' => $mainClass,
            'softName' => $softName,
            'softShortName' => $softShortName,
            'isMobile' => $agent->isMobile(),
        ]);
    }

    /**
     * 切换主题
     * @return \Illuminate\View\View
     */
    public function switchSkin()
    {
        return view('admin.home.skin');
    }
}
