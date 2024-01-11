<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>系统首页 - {{ $project->project_title }}</title>
    <!-- 避免IE使用兼容模式 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="/static/favicon.ico" rel="shortcut icon"/>
    @if ($isRandom)
        <link href="/static/css/bootstrap.min.css?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"
              rel="stylesheet"/>
        <link href="/static/css/jquery.contextMenu.min.css?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}" rel="stylesheet"/>
        <link href="/static/css/font-awesome.min.css?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}" rel="stylesheet"/>
        <link href="/static/css/animate.min.css?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}" rel="stylesheet"/>
        <link href="/static/css/style.min.css?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}" rel="stylesheet"/>
        <link href="/static/css/skins.css?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}" rel="stylesheet"/>
        <link href="/static/ruoyi/css/soft-ui.css?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}" rel="stylesheet"/>
    @else
        <link href="/static/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/static/css/jquery.contextMenu.min.css" rel="stylesheet"/>
        <link href="/static/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="/static/css/animate.min.css" rel="stylesheet"/>
        <link href="/static/css/style.min.css" rel="stylesheet"/>
        <link href="/static/css/skins.css" rel="stylesheet"/>
        <link href="/static/ruoyi/css/soft-ui.css" rel="stylesheet"/>
    @endif

    @if (strlen($project->project_name) > 8)
        <style>
            nav .logo {
                font-size: 18px;
            }
        </style>
    @endif
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow: hidden">
<div id="wrapper">

    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close">
            <i class="fa fa-times-circle"></i>
        </div>
        <a href="/index">
            <li class="logo hidden-xs">
                <span class="logo-lg">{{ $project->project_name }}</span>
            </li>
        </a>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                @if(rand(1, 100) % 5 != 0)
                    <li>
                        <div class="user-panel">
                            <a class="menuItem noactive" title="个人中心" href="/system/user/profile">
                                <div class="hide" text="个人中心"></div>
                                <div class="pull-left image">
                                    <img src="{{ $headerImage }}" onerror="this.src='/static/img/profile.jpg'"
                                         class="img-circle" alt="User Image">
                                </div>
                            </a>
                            <div class="pull-left info">
                                <p>{{ $adminName }}</p>
                                <a href="#"><i class="fa fa-circle text-success"></i> 在线</a>
                                <a href="/loginOut" style="padding-left:5px;"><i class="fa fa-sign-out text-danger"></i>
                                    注销</a>
                            </div>
                        </div>
                    </li>
                @endif
                @if(count($menus) > 0)
                    {{-- 一级菜单 --}}
                    @foreach($menus as $firstMenu)
                        <li>
                            <a class="@if(!empty($firstMenu['url']) && $firstMenu['url'] != '#') {{ $firstMenu['target'] }} @endif {{ $firstMenu['class'] }}"
                               href="{{ $firstMenu['url'] ?? '#'  }}"
                               data-refresh="{{ $firstMenu['is_refresh'] == 0 ? 'ture' : 'false' }}">
                                <i class="{{ $firstMenu['icon'] }}"></i>
                                <span class="nav-label"
                                      text="{{ $firstMenu['menu_name'] }}">{{ $firstMenu['menu_name'] }}</span>
                                <span
                                    class="@if(!empty($firstMenu['url']) || $firstMenu['url'] == '#') fa arrow @endif"></span>
                            </a>
                            <ul class="nav nav-second-level collapse">
                                @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                                    {{-- 二级菜单 --}}
                                    @foreach($firstMenu['children'] as $secondMenu)
                                        <li>
                                            @if(empty($secondMenu['children']))
                                                <a class="@if(empty($secondMenu['target'])) menuItem @else {{ $secondMenu['target'] }} @endif {{ $secondMenu['class'] }}"
                                                   href="{{ $secondMenu['url'] }}"
                                                   data-refresh="{{ $secondMenu['is_refresh'] == 0 ? 'ture' : 'false' }}">{{ $secondMenu['menu_name'] }}</a>
                                            @else
                                                <a href="#">{{ $secondMenu['menu_name'] }}<span class="fa arrow"></span></a>
                                                <ul class="nav nav-third-level">
                                                    @if(isset($secondMenu['children']) && count($secondMenu['children']) > 0)
                                                        {{-- 三级菜单 --}}
                                                        @foreach($secondMenu['children'] as $thirdMenu)
                                                            <li>
                                                                @if(empty($thirdMenu['children']))
                                                                    <a class="@if(empty($thirdMenu['target'])) menuItem @else {{ $thirdMenu['target'] }} @endif {{ $thirdMenu['class'] }}"
                                                                       href="{{ $thirdMenu['url'] }}"
                                                                       data-refresh="{{ $thirdMenu['is_refresh'] == 0 ? 'ture' : 'false' }}">{{ $thirdMenu['menu_name'] }}</a>
                                                                @else
                                                                    <a href="#">{{ $thirdMenu['menu_name'] }}<span
                                                                            class="fa arrow"></span></a>
                                                                    <ul class="nav nav-third-level">
                                                                        @if(isset($thirdMenu['children']) && count($thirdMenu['children']) > 0)
                                                                            {{-- 四级菜单 --}}
                                                                            @foreach($thirdMenu['children'] as $fourthMenu)
                                                                                <li>
                                                                                    @if(empty($fourthMenu['children']))
                                                                                        <a class="@if(empty($fourthMenu['target'])) menuItem @else {{ $fourthMenu['target'] }} @endif {{ $fourthMenu['class'] }}"
                                                                                           href="{{ $fourthMenu['url'] }}"
                                                                                           data-refresh="{{ $fourthMenu['is_refresh'] == 0 ? 'ture' : 'false' }}">{{ $fourthMenu['menu_name'] }}</a>
                                                                                    @else
                                                                                        <a href="#">{{ $fourthMenu['menu_name'] }}
                                                                                            <span
                                                                                                class="fa arrow"></span></a>
                                                                                    @endif
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->

    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2" style="color:#FFF;" href="#" title="收起菜单">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right welcome-message">
                    <!--                    <li><a data-toggle="tooltip" data-trigger="hover" data-placement="bottom" title="锁定屏幕" href="#" id="lockScreen"><i class="fa fa-lock"></i> 锁屏</a></li>-->
                    <!--	                <li><a data-toggle="tooltip" data-trigger="hover" data-placement="bottom" title="全屏显示" href="#" id="fullScreen"><i class="fa fa-arrows-alt"></i> 全屏</a></li>-->
                    <li class="dropdown user-menu">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-hover="dropdown">
                            <img src="{{ $headerImage }}" onerror="this.src='/static/img/profile.jpg'"
                                 class="user-image">
                            <span class="hidden-xs">{{ $adminName }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="mt5">
                                <a href="/system/user/profile" class="menuItem noactive">
                                    <i class="fa fa-user"></i> 个人中心</a>
                            </li>
                            <li>
                                <a onclick="resetPwd()">
                                    <i class="fa fa-key"></i> 修改密码</a>
                            </li>
                            <li>
                                <a onclick="switchSkin()" class="switchSkin">
                                    <i class="fa fa-dashboard"></i> 切换主题</a>
                            </li>
                            {{--                            <li>--}}
                            {{--                                <a onclick="toggleMenu()">--}}
                            {{--                                    <i class="fa fa-toggle-off"></i> 横向菜单</a>--}}
                            {{--                            </li>--}}
                            <li class="divider"></li>
                            <li>
                                <a href="/loginOut">
                                    <i class="fa fa-sign-out"></i> 退出登录</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row content-tabs @if(!$tagsView) hide @endif">
            <button class="roll-nav roll-left tabLeft">
                <i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active menuTab" data-id="/main">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right tabRight">
                <i class="fa fa-forward"></i>
            </button>
            <a href="javascript:void(0);" class="roll-nav roll-right tabReload"><i class="fa fa-refresh"></i> 刷新</a>
        </div>

        <a id="ax_close_max" class="ax_close_max" href="#" title="关闭全屏"> <i class="fa fa-times-circle-o"></i> </a>

        <div class="row mainContent {{ $mainClass }}" id="content-main">
            <iframe class="RuoYi_iframe" name="iframe0" width="100%" height="100%" data-id="/main"
                    src="/main" frameborder="0" seamless></iframe>
        </div>

        @if ($footer)
            <div class="footer">
                <div class="pull-right">© {{ date('Y') }} Copyright</div>
            </div>
        @endif
    </div>
    <!--右侧部分结束-->
</div>
<!-- 全局js -->
@if($isRandom)
    <script src="/static/js/jquery.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script src="/static/js/bootstrap.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script
        src="/static/js/plugins/metisMenu/jquery.metisMenu.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script
        src="/static/js/plugins/slimscroll/jquery.slimscroll.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script src="/static/js/jquery.contextMenu.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script
        src="/static/ajax/libs/blockUI/jquery.blockUI.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script src="/static/ajax/libs/layer/layer.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script src="/static/ruoyi/js/soft-ui.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script src="/static/ruoyi/js/common.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script src="/static/ruoyi/index.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
    <script
        src="/static/ajax/libs/fullscreen/jquery.fullscreen.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
@else
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="/static/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/static/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/static/js/jquery.contextMenu.min.js"></script>
    <script src="/static/ajax/libs/blockUI/jquery.blockUI.js"></script>
    <script src="/static/ajax/libs/layer/layer.min.js"></script>
    <script src="/static/ruoyi/js/soft-ui.js"></script>
    <script src="/static/ruoyi/js/common.js"></script>
    <script src="/static/ruoyi/index.js"></script>
    <script src="/static/ajax/libs/fullscreen/jquery.fullscreen.js"></script>
@endif
<script>
    // 方式后退
    window.history.forward(1);

    var ctx = "/";
    // 皮肤缓存
    // history（表示去掉地址的#）否则地址以"#"形式展示
    var mode = "#";
    // 历史访问路径缓存
    var historyPath = storage.get("historyPath");
    // 是否页签与菜单联动
    var isLinkage = true;

    // 本地主题优先，未设置取系统配置
    $("body").addClass("{{ $project->project_skin }}");
    $("body").addClass("{{ $project->project_theme }}");

    /* 用户管理-重置密码 */
    function resetPwd() {
        var url = ctx + 'system/user/profile/resetPwd';
        $.modal.open("重置密码", url, '770', '380');
    }

    /* 切换主题 */
    function switchSkin() {
        layer.open({
            type: 2,
            shadeClose: true,
            title: "切换主题",
            area: ["530px", "482px"],
            content: [ctx + "system/switchSkin", 'no']
        })
    }

    /** 刷新时访问路径页签 */
    function applyPath(url) {
        $('a[href$="' + decodeURI(url) + '"]').click();
        if (!$('a[href$="' + url + '"]').hasClass("noactive")) {
            $('a[href$="' + url + '"]').parent("li").addClass("selected").parents("li").addClass("active").end().parents("ul").addClass("in");
        }
    }

    $(function () {
        var lockPath = storage.get('lockPath');
        if ($.common.equals("history", mode) && window.performance.navigation.type == 1) {
            var url = storage.get('publicPath');
            if ($.common.isNotEmpty(url)) {
                applyPath(url);
            }
        } else if ($.common.isNotEmpty(lockPath)) {
            applyPath(lockPath);
            storage.remove('lockPath');
        } else {
            var hash = location.hash;
            if ($.common.isNotEmpty(hash)) {
                var url = hash.substring(1, hash.length);
                applyPath(url);
            } else {
                if ($.common.equals("history", mode)) {
                    storage.set('publicPath', "");
                }
            }
        }

        $("[data-toggle='tooltip']").tooltip();
    });
</script>
</body>
</html>
