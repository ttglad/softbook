<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- base:css -->
    <link rel="stylesheet" href="/vendors/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendors/typicons/typicons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/theme/celestial/css/vertical-layout-light/style.css">
    <!-- endinject -->
</head>
<body class="@if($project->project_id % 2 == 0) sidebar-light @endif">
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav
        class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row {{ 'navbar-' . ['success', 'warning', 'danger', 'info', 'primary', 'dark', 'default'][$project->project_id % 7] }}">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="#">后台管理</a>
            <a class="navbar-brand brand-logo-mini" href="#"></a>
            <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button"
                    data-toggle="minimize">
                <span class="typcn typcn-th-menu"></span>
            </button>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <h4>{{ $project->project_title }}</h4>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item d-none d-lg-flex  mr-2">
                    <a class="nav-link" href="#">
                        帮助中心
                    </a>
                </li>
                <li class="nav-item dropdown d-flex">
                    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                       id="messageDropdown" href="#" data-toggle="dropdown">
                        <i class="typcn typcn-message-typing"></i>
                        <span class="count bg-success">{{ rand(1, 10) }}</span>
                    </a>
                </li>
                <li class="nav-item dropdown  d-flex">
                    <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
                       id="notificationDropdown" href="#" data-toggle="dropdown">
                        <i class="typcn typcn-bell mr-0"></i>
                        <span class="count bg-danger">{{ rand(1, 10) }}</span>
                    </a>
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
                        <i class="typcn typcn-user-outline mr-0"></i>
                        <span class="nav-profile-name">{{ $adminName }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item">
                            <i class="typcn typcn-cog text-primary"></i>
                            设置
                        </a>
                        <a class="dropdown-item">
                            <i class="typcn typcn-power text-primary"></i>
                            退出
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                <span class="typcn typcn-th-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_settings-panel.html -->
        <div class="theme-setting-wrapper">
            <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
            <div id="theme-settings" class="settings-panel">
                <i class="settings-close typcn typcn-delete-outline"></i>
                <p class="settings-heading">SIDEBAR SKINS</p>
                <div class="sidebar-bg-options" id="sidebar-light-theme">
                    <div class="img-ss rounded-circle bg-light border mr-3"></div>
                    Light
                </div>
                <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
                    <div class="img-ss rounded-circle bg-dark border mr-3"></div>
                    Dark
                </div>
                <p class="settings-heading mt-2">HEADER SKINS</p>
                <div class="color-tiles mx-0 px-4">
                    <div class="tiles success"></div>
                    <div class="tiles warning"></div>
                    <div class="tiles danger"></div>
                    <div class="tiles primary"></div>
                    <div class="tiles info"></div>
                    <div class="tiles dark"></div>
                    <div class="tiles default border"></div>
                </div>
            </div>
        </div>
        <!-- partial -->
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <div class="d-flex sidebar-profile">
                        <div class="sidebar-profile-image">
                            <img src="{{ $headerImage }}" alt="image">
                            <span class="sidebar-status-indicator"></span>
                        </div>
                        <div class="sidebar-profile-name">
                            <p class="sidebar-name">
                                {{ $adminName }}
                            </p>
                            <p class="sidebar-designation">
                                欢迎
                            </p>
                        </div>
                    </div>
                    <div class="nav-search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type to search..." aria-label="search"
                                   aria-describedby="search">
                            <div class="input-group-append">
                              <span class="input-group-text" id="search">
                                <i class="typcn typcn-zoom"></i>
                              </span>
                            </div>
                        </div>
                    </div>
                    <p class="sidebar-menu-title">后台菜单</p>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="typcn typcn-device-desktop menu-icon"></i>
                        <span class="menu-title">系统首页</span>
                    </a>
                </li>
                @foreach($menus as $firstMenu)
                    <li class="nav-item @isset($firstMenu['check']) active @endisset">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic-{{ $firstMenu['menu_id'] }}" aria-controls="ui-basic-{{ $firstMenu['menu_id'] }}" @isset($firstMenu['check']) aria-expanded="true" @else aria-expanded="false" @endisset>
                            @if (!empty($firstMenu['icon']))
                                <i class="{{ $firstMenu['icon'] }} typcn menu-icon"></i>
                            @else
                                <i class="typcn typcn-th-menu menu-icon"></i>
                            @endif
                            <span class="menu-title">{{ $firstMenu['menu_name'] }}</span>
                            @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                                <i class="typcn typcn-chevron-right menu-arrow"></i>
                            @endif
                        </a>
                        @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                            <div class="collapse @isset($firstMenu['check']) show @endisset" id="ui-basic-{{ $firstMenu['menu_id'] }}">
                                <ul class="nav flex-column sub-menu">
                                    @foreach($firstMenu['children'] as $secondMenu)
                                        <li class="nav-item">
                                            <a href="/project/book/{{ $secondMenu['menu_id'] }}" class="nav-link @isset($secondMenu['check']) active @endisset">
                                                {{ $secondMenu['menu_name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                @if(in_array($business->data_type, ['chart-01', 'chart-02', 'chart-03']))
                    @include('project.business.chart.base-' . $business->data_type, compact('business', 'businessColumn'))
                @else
                    @include('project.business.list.star', compact('business', 'businessColumn'))
                @endif
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © {{ date('Y') }}</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<script src="/vendors/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<!-- base:js -->
<script src="/theme/celestial/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="/theme/celestial/js/template.js"></script>
<script src="/theme/celestial/js/settings.js"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<!-- End custom js for this page-->

<script src="/static/softbook/js/home.js"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<!-- End custom js for this page -->

@include('project.business.include.modal', compact('business', 'businessColumn'))

</body>
</html>
