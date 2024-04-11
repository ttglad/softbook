<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/vendors/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendors/mdi/4.5.95/css/materialdesignicons.min.css" />
{{--    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css" />--}}
    <link rel="stylesheet" href="/theme/breeze/css/main.css" />
{{--    <link rel="stylesheet" href="/vendors/font-awesome/4.7.0/css/font-awesome.min.css" />--}}
{{--    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />--}}
    <link rel="stylesheet" href="/theme/breeze/css/style.css" />
</head>
<body>
<div class="container-scroller">
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
            <a class="sidebar-brand brand-logo" href="#"></a>
            <a class="sidebar-brand brand-logo-mini pl-4 pt-3" href="#"></a>
        </div>
        <ul class="nav">
            <li class="nav-item nav-profile">
                <a href="#" class="nav-link">
                    <div class="nav-profile-image">
                        <img src="{{ $headerImage }}" alt="profile" />
                        <span class="login-status online"></span>
                        <!--change to offline or busy as needed-->
                    </div>
                    <div class="nav-profile-text d-flex flex-column pr-3">
                        <span class="font-weight-medium mb-2">{{ $adminName }}</span>
                        <span class="font-weight-normal">8,753.00</span>
                    </div>
                    <span class="badge badge-danger text-white ml-3 rounded">3</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="mdi mdi-home menu-icon"></i>
                    <span class="menu-title">首页</span>
                </a>
            </li>
            @foreach($menus as $firstMenu)
                <li class="nav-item @isset($firstMenu['check']) active @endisset">
                    <a class="nav-link" data-toggle="collapse" href="#ui-basic-{{ $firstMenu['menu_id'] }}" @isset($firstMenu['check']) aria-expanded="true" @else aria-expanded="false" @endisset aria-controls="ui-basic">
                    @if (!empty($firstMenu['icon']))
                        <i class="mdi {{ $firstMenu['icon'] }} menu-icon"></i>
                    @else
                        <i class="mdi mdi-menu menu-icon"></i>
                    @endif
                    <span class="menu-title">{{ $firstMenu['menu_name'] }}</span>
                    @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                        <i class="menu-arrow"></i>
                    @endif
                    </a>
                    @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                        <div class="collapse @isset($firstMenu['check']) show @endisset" id="ui-basic-{{ $firstMenu['menu_id'] }}">
                            <ul class="nav flex-column sub-menu">
                                @foreach($firstMenu['children'] as $secondMenu)
                                    <li class="nav-item">
                                        <a href="/project/book/{{ $secondMenu['menu_id'] }}"
                                           class="nav-link @isset($secondMenu['check']) active @endisset" {{ $secondMenu['class'] }} @if(empty($secondMenu['target'])) menuItem @else {{ $secondMenu['target'] }} @endif"
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
            <li class="nav-item sidebar-actions">
                <div class="nav-link">
                    <div class="mt-4">
                        <div class="border-none">
                            <p class="text-black">通知</p>
                        </div>
                        <ul class="mt-4 pl-0">
                            <li>退出登录</li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
    <div class="container-fluid page-body-wrapper">
        <div id="theme-settings" class="settings-panel">
            <i class="settings-close mdi mdi-close"></i>
            <p class="settings-heading">SIDEBAR SKINS</p>
            <div class="sidebar-bg-options selected" id="sidebar-default-theme">
                <div class="img-ss rounded-circle bg-light border mr-3"></div> Default
            </div>
            <div class="sidebar-bg-options" id="sidebar-dark-theme">
                <div class="img-ss rounded-circle bg-dark border mr-3"></div> Dark
            </div>
            <p class="settings-heading mt-2">HEADER SKINS</p>
            <div class="color-tiles mx-0 px-4">
                <div class="tiles light"></div>
                <div class="tiles dark"></div>
            </div>
        </div>
        <nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
            <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
                <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href="#"></a>
                <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
                    <i class="mdi mdi-menu"></i>
                </button>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="mdi mdi-bell-outline"></i>
                            <span class="count count-varient1">7</span>
                        </a>
                        <div class="dropdown-menu navbar-dropdown navbar-dropdown-large preview-list" aria-labelledby="notificationDropdown">
                            <h6 class="p-3 mb-0">Notifications</h6>
                            <div class="dropdown-divider"></div>
                            <p class="p-3 mb-0">View all activities</p>
                        </div>
                    </li>
                    <li class="nav-item dropdown d-none d-sm-flex">
                        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown">
                            <i class="mdi mdi-email-outline"></i>
                            <span class="count count-varient2">5</span>
                        </a>
                        <div class="dropdown-menu navbar-dropdown navbar-dropdown-large preview-list" aria-labelledby="messageDropdown">
                            <h6 class="p-3 mb-0">Messages</h6>
                            <a class="dropdown-item preview-item">
                                <div class="preview-item-content flex-grow">
                                    <span class="badge badge-pill badge-success">Request</span>
                                    <p class="text-small text-muted ellipsis mb-0"> Suport needed for user123 </p>
                                </div>
                                <p class="text-small text-muted align-self-start"> 4:10 PM </p>
                            </a>
                            <h6 class="p-3 mb-0">See all activity</h6>
                        </div>
                    </li>
                    <li class="nav-item nav-search border-0 ml-1 ml-md-3 ml-lg-5 d-none d-md-flex">
                        <h3>{{ $project->project_title }}</h3>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right ml-lg-auto">
                    <li class="nav-item dropdown d-none d-xl-flex border-0">
                        <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown">
                            <i class="mdi mdi-earth"></i> 中文简体 </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                            <a class="dropdown-item" href="#"> 中文繁体 </a>
                            <a class="dropdown-item" href="#"> 英文 </a>
                        </div>
                    </li>
                    <li class="nav-item nav-profile dropdown border-0">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
                            <img class="nav-profile-img mr-2" alt="" src="{{ $headerImage }}" />
                            <span class="profile-name">{{ $adminName }}</span>
                        </a>
                        <div class="dropdown-menu navbar-dropdown w-100" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="mdi mdi-cached mr-2 text-success"></i> Activity Log </a>
                            <a class="dropdown-item" href="#">
                                <i class="mdi mdi-logout mr-2 text-primary"></i> Signout </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <div class="main-panel">
            <div class="content-wrapper pb-0">
                @if(in_array($business->data_type, ['chart-01', 'chart-02', 'chart-03']))
                    @include('project.business.chart.base-' . $business->data_type, compact('business', 'businessColumn'))
                @else
                    @include('project.business.list.breeze', compact('business', 'businessColumn'))
                @endif
            </div>
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © {{ date('Y') }}</span>
                </div>
            </footer>
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->

<script src="/vendors/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="/theme/breeze/js/main.js"></script>
{{--<!-- endinject -->--}}
{{--<!-- Plugin js for this page -->--}}
{{--<script src="assets/vendors/chart.js/Chart.min.js"></script>--}}
{{--<script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>--}}
{{--<script src="assets/vendors/flot/jquery.flot.js"></script>--}}
{{--<script src="assets/vendors/flot/jquery.flot.resize.js"></script>--}}
{{--<script src="assets/vendors/flot/jquery.flot.categories.js"></script>--}}
{{--<script src="assets/vendors/flot/jquery.flot.fillbetween.js"></script>--}}
{{--<script src="assets/vendors/flot/jquery.flot.stack.js"></script>--}}
{{--<script src="assets/vendors/flot/jquery.flot.pie.js"></script>--}}
{{--<!-- End plugin js for this page -->--}}
{{--<!-- inject:js -->--}}
{{--<script src="assets/js/off-canvas.js"></script>--}}
{{--<script src="assets/js/hoverable-collapse.js"></script>--}}
{{--<script src="assets/js/misc.js"></script>--}}
{{--<!-- endinject -->--}}
{{--<!-- Custom js for this page -->--}}
<script src="/theme/breeze/js/misc.js"></script>
<!-- End custom js for this page -->

<script src="/static/softbook/js/home.js"></script>

@include('project.business.include.modal', compact('business', 'businessColumn'))
</body>
</html>
