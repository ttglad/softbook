<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- plugins:css -->
    <link rel="stylesheet" href="/vendors/mdi/4.5.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/theme/connect-plus/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/theme/connect-plus/css/style.css">
</head>
<body>
<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav">
                <li class="nav-item  dropdown d-none d-md-block">
                    <h3>{{ $project->project_title }}</h3>
                </li>
            </ul>

            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item  dropdown d-none d-md-block">
                    <a class="nav-link dropdown-toggle" id="projectDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false"> 项目 </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="projectDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="mdi mdi-eye-outline me-2"></i>项目预览 </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">
                            <i class="mdi mdi-pencil-outline me-2"></i>编辑项目 </a>
                    </div>
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="nav-profile-img">
                            <img src="{{ $headerImage }}" alt="image">
                        </div>
                        <div class="nav-profile-text">
                            <p class="mb-1 text-black">{{ $adminName }}</p>
                        </div>
                    </a>
                    <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                        <div class="p-3 text-center bg-primary">
                            <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ $headerImage }}" alt="">
                        </div>
                        <div class="p-2">
                            <h5 class="dropdown-header text-uppercase ps-2 text-dark">用户信息</h5>
                            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                <span>个人设置</span>
                                <i class="mdi mdi-settings"></i>
                            </a>
                            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                                <span>修改密码</span>
                                <span class="p-0">
                                  <span class="badge badge-success">1</span>
                                  <i class="mdi mdi-account-outline ms-1"></i>
                                </span>
                            </a>
                            <div role="separator" class="dropdown-divider"></div>
                            <h5 class="dropdown-header text-uppercase  ps-2 text-dark mt-2">操作</h5>
                            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                                <span>锁定</span>
                                <i class="mdi mdi-lock ms-1"></i>
                            </a>
                            <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                                <span>退出</span>
                                <i class="mdi mdi-logout ms-1"></i>
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <span class="icon-bg"><i class="mdi mdi-home menu-icon"></i></span>
                        <span class="menu-title">系统首页</span>
                    </a>
                </li>
                @foreach($menus as $firstMenu)
                    <li class="nav-item @isset($firstMenu['check']) active @endisset">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-{{ $firstMenu['menu_id'] }}" @isset($firstMenu['check']) aria-expanded="true" @else aria-expanded="false" @endisset" aria-controls="ui-basic">
                            <span class="icon-bg">
                                @if (!empty($firstMenu['icon']))
                                    <i class="mdi {{ $firstMenu['icon'] }} menu-icon"></i>
                                @else
                                    <i class="mdi mdi-tooltip-edit menu-icon"></i>
                                @endif
                            </span>
                            <span class="menu-title">{{ $firstMenu['menu_name'] }}</span>
                            @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                                <i class="menu-arrow"></i>
                            @endif
                        </a>
                        @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                            <div class="collapse" id="ui-basic-{{ $firstMenu['menu_id'] }}">
                                <ul class="nav flex-column sub-menu">
                                    @foreach($firstMenu['children'] as $secondMenu)
                                        <li class="nav-item">
                                            <a href="/project/book/{{ $secondMenu['menu_id'] }}"
                                               class="nav-link {{ $secondMenu['class'] }} @if(empty($secondMenu['target'])) menuItem @else {{ $secondMenu['target'] }} @endif"
                                               data-href="{{ $secondMenu['url'] }}">
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
                    @include('project.business.list.connect-plus', compact('business', 'businessColumn'))
                @endif
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            <footer class="footer">
                <div class="footer-inner-wraper">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between py-2">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="/theme/connect-plus/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="/theme/connect-plus/js/misc.js"></script>

<script src="/static/softbook/js/home.js"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<!-- End custom js for this page -->

@include('project.business.include.modal', compact('business', 'businessColumn'))

</body>
</html>

