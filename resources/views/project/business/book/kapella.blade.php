<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- base:css -->
    <link rel="stylesheet" href="/kapella/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/kapella/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/kapella/css/style.css">
    <!-- endinject -->
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
        <nav class="navbar top-navbar col-lg-12 col-12 p-0">
            <div class="container-fluid">
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                    <ul class="navbar-nav navbar-nav-left">
                        <li class="nav-item ms-0 me-5 d-lg-flex d-none">
                            <a href="#" class="nav-link horizontal-nav-left-menu"><i class="mdi mdi-format-list-bulleted"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                                <i class="mdi mdi-bell mx-0"></i>
                                <span class="count bg-success">2</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-success">
                                            <i class="mdi mdi-information mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            Just now
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-warning">
                                            <i class="mdi mdi-settings mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">Settings</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            Private message
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-info">
                                            <i class="mdi mdi-account-box mx-0"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                        <p class="font-weight-light small-text mb-0 text-muted">
                                            2 days ago
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
                                <i class="mdi mdi-email mx-0"></i>
                                <span class="count bg-primary">4</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                                <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                                    </div>
                                    <div class="preview-item-content flex-grow">
                                        <h6 class="preview-subject ellipsis font-weight-normal">David Grey
                                        </h6>
                                        <p class="font-weight-light small-text text-muted mb-0">
                                            The meeting is cancelled
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                                    </div>
                                    <div class="preview-item-content flex-grow">
                                        <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
                                        </h6>
                                        <p class="font-weight-light small-text text-muted mb-0">
                                            New product launch
                                        </p>
                                    </div>
                                </a>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                                    </div>
                                    <div class="preview-item-content flex-grow">
                                        <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
                                        </h6>
                                        <p class="font-weight-light small-text text-muted mb-0">
                                            Upcoming board meeting
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link count-indicator "><i class="mdi mdi-message-reply-text"></i></a>
                        </li>
                        <li class="nav-item nav-search d-none d-lg-block ms-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                      <span class="input-group-text" id="search">
                        <i class="mdi mdi-magnify"></i>
                      </span>
                                </div>
                                <input type="text" class="form-control" placeholder="search" aria-label="search" aria-describedby="search">
                            </div>
                        </li>
                    </ul>
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                        <a class="navbar-brand brand-logo">{{ $project->project_title }}</a>
                    </div>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item dropdown d-lg-flex d-none">
                            <a class="dropdown-toggle show-dropdown-arrow btn btn-inverse-primary btn-sm" id="nreportDropdown" href="#" data-bs-toggle="dropdown">
                                报告
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="nreportDropdown">
                                <p class="mb-0 font-weight-medium float-left dropdown-header">Reports</p>
                                <a class="dropdown-item">
                                    <i class="mdi mdi-file-pdf text-primary"></i>
                                    Pdf
                                </a>
                                <a class="dropdown-item">
                                    <i class="mdi mdi-file-excel text-primary"></i>
                                    Exel
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown d-lg-flex d-none">
                            <button type="button" class="btn btn-inverse-primary btn-sm">系统设置</button>
                        </li>
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                                <span class="nav-profile-name">{{ $adminName }}</span>
                                <span class="online-status"></span>
                                <img src="{{ $headerImage }}" alt="profile"/>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <a class="dropdown-item">
                                    <i class="mdi mdi-settings text-primary"></i>
                                    设置
                                </a>
                                <a class="dropdown-item">
                                    <i class="mdi mdi-logout text-primary"></i>
                                    退出
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </div>
        </nav>
        <nav class="bottom-navbar">
            <div class="container">
                <ul class="nav page-navigation">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="mdi mdi-home menu-icon"></i>
                            <span class="menu-title">系统首页</span>
                        </a>
                    </li>
                    @foreach($menus as $firstMenu)
                        <li class="nav-item @isset($firstMenu['check']) active @endisset">
                            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-{{ $firstMenu['menu_id'] }}" @isset($firstMenu['check']) aria-expanded="true" @else aria-expanded="false" @endisset" aria-controls="ui-basic">
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
                                <div class="submenu @isset($firstMenu['check']) show @endisset" id="ui-basic-{{ $firstMenu['menu_id'] }}">
                                    <ul>
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
            </div>
        </nav>
    </div>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">

                @if(in_array($business->data_type, ['chart-01', 'chart-02', 'chart-03']))
                    @include('project.business.chart.base-' . $business->data_type, compact('business', 'businessColumn'))
                @else
                    @include('project.business.list.kapella', compact('business', 'businessColumn'))
                @endif

            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="footer-wrap">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
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
<!-- base:js -->
<script src="/kapella/vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="/kapella/js/template.js"></script>
<!-- endinject -->
<!-- plugin js for this page -->
<!-- End plugin js for this page -->
<script src="/kapella/vendors/chart.js/Chart.min.js"></script>
<script src="/kapella/vendors/progressbar.js/progressbar.min.js"></script>
<script src="/kapella/vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js"></script>
<script src="/kapella/vendors/justgage/raphael-2.1.4.min.js"></script>
<script src="/kapella/vendors/justgage/justgage.js"></script>
<script src="/kapella/js/jquery.cookie.js" type="text/javascript"></script>
<!-- Custom js for this page-->
<script src="/kapella/js/dashboard.js"></script>

<script src="/static/softbook/js/home.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<!-- End custom js for this page -->

@include('project.business.include.modal', compact('business', 'businessColumn'))

<!-- End custom js for this page-->
</body>
</html>
