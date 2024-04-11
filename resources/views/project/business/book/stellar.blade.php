<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- plugins:css -->
    <link rel="stylesheet" href="/vendors/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/stellar/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="/stellar/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/stellar/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/stellar/vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/stellar/vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/stellar/css/style.css"> <!-- End layout styles -->
</head>
<body>
<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex align-items-center">
            <a class="navbar-brand brand-logo"></a>
            <a class="navbar-brand brand-logo-mini"></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
            <h5 class="mb-0 font-weight-medium d-none d-lg-flex">{{ $project->project_title }}</h5>
            <ul class="navbar-nav navbar-nav-right ml-auto">
                <form class="search-form d-none d-md-block" action="#">
                    <i class="icon-magnifier"></i>
                    <input type="search" class="form-control" placeholder="Search Here" title="Search here">
                </form>
                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator message-dropdown" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <i class="icon-speech"></i>
                        <span class="count">{{ rand(1, 10) }}</span>
                    </a>
                </li>
                <li class="nav-item dropdown language-dropdown d-none d-sm-flex align-items-center">
                    <a class="nav-link d-flex align-items-center dropdown-toggle" id="LanguageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <div class="d-inline-flex mr-3">
                            <i class="flag-icon flag-icon-us"></i>
                        </div>
                        <span class="profile-text font-weight-normal">简体中文</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-left navbar-dropdown py-2"
                         aria-labelledby="LanguageDropdown">
                        <a class="dropdown-item">
                            <i class="flag-icon flag-icon-us"></i> 简体中文 </a>
                        <a class="dropdown-item">
                            <i class="flag-icon flag-icon-fr"></i> 繁体中文 </a>
                        <a class="dropdown-item">
                            <i class="flag-icon flag-icon-ae"></i> English </a>
                    </div>
                </li>
                <li class="nav-item dropdown d-none d-xl-inline-flex user-dropdown">
                    <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <img class="img-xs rounded-circle ml-2" src="{{ $headerImage }}" alt="Profile image"> <span class="font-weight-normal"> {{ $adminName }} </span></a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                        <div class="dropdown-header text-center">
                            <img class="img-md rounded-circle" src="{{ $headerImage }}" alt="Profile image">
                            <p class="mb-1 mt-3">{{ $adminName }}</p>
                        </div>
                        <a class="dropdown-item"><i class="dropdown-item-icon icon-user text-primary"></i> 个人中心 <span class="badge badge-pill badge-danger">1</span></a>
                        <a class="dropdown-item"><i class="dropdown-item-icon icon-power text-primary"></i>退出</a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="icon-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <a href="#" class="nav-link">
                        <div class="profile-image">
                            <img class="img-xs rounded-circle" src="{{ $headerImage }}" alt="profile image">
                            <div class="dot-indicator bg-success"></div>
                        </div>
                        <div class="text-wrapper">
                            <p class="profile-name">{{ $adminName }}</p>
                            <p class="designation">管理员</p>
                        </div>
                        <div class="icon-container">
                            <i class="icon-bubbles"></i>
                            <div class="dot-indicator bg-danger"></div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <span class="menu-title">系统首页</span>
                        <i class="icon-home menu-icon"></i>
                    </a>
                </li>

                @foreach($menus as $firstMenu)
                    <li class="nav-item @isset($firstMenu['check']) active @endisset">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-{{ $firstMenu['menu_id'] }}" aria-controls="ui-basic-{{ $firstMenu['menu_id'] }}" @isset($firstMenu['check']) aria-expanded="true" @else aria-expanded="false" @endisset>
                        <span class="menu-title">{{ $firstMenu['menu_name'] }}</span>
                        @if (!empty($firstMenu['icon']))
                            <i class="{{ $firstMenu['icon'] }} menu-icon"></i>
                        @else
                            <i class="icon-menu menu-icon"></i>
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
                    @include('project.business.list.stellar', compact('business', 'businessColumn'))
                @endif

            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © {{ date('Y') }}</span>
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
<script src="/vendors/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="/stellar/vendors/js/vendor.bundle.base.js"></script>
<script src="/stellar/vendors/chart.js/Chart.min.js"></script>
<script src="/stellar/vendors/moment/moment.min.js"></script>
<script src="/stellar/vendors/daterangepicker/daterangepicker.js"></script>
<script src="/stellar/vendors/chartist/chartist.min.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="/stellar/js/off-canvas.js"></script>
<script src="/stellar/js/misc.js"></script>

<script src="/static/softbook/js/home.js"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<!-- End custom js for this page -->

@include('project.business.include.modal', compact('business', 'businessColumn'))

</body>
</html>
