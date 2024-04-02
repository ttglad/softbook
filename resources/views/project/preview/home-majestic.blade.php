<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- plugins:css -->
    <link rel="stylesheet" href="/majestic/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/majestic/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="/majestic/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/majestic/css/style.css">
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center">
            <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand brand-logo"></a>
                <a class="navbar-brand brand-logo-mini"></a>
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-sort-variant"></span>
                </button>
            </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav mr-lg-4 w-100">
                <li class="nav-item d-none d-lg-block w-100" style="color:#000000">
                    <h3>{{ $project->project_title }}</h3>
                </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown me-1">
                    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
                        <i class="mdi mdi-message-text mx-0"></i>
                        <span class="count"></span>
                    </a>
                </li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                        <i class="mdi mdi-bell mx-0"></i>
                        <span class="count"></span>
                    </a>
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                        <img src="{{ $headerImage }}" alt="profile"/>
                        <span class="nav-profile-name">{{ $adminName }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item">
                            <i class="mdi mdi-settings text-primary"></i>
                            个人中心
                        </a>
                        <a class="dropdown-item">
                            <i class="mdi mdi-logout text-primary"></i>
                            退出
                        </a>
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
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="mdi mdi-home menu-icon"></i>
                        <span class="menu-title">系统首页</span>
                    </a>
                </li>
                @foreach($menus as $firstMenu)
                    <li class="nav-item active">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-{{ $firstMenu['menu_id'] }}" aria-expanded="false" aria-controls="ui-basic">
                            <span class="icon-bg">
                                @if (!empty($firstMenu['icon']))
                                    <i class="mdi {{ $firstMenu['icon'] }} menu-icon"></i>
                                @else
                                    <i class="mdi mdi-menu menu-icon"></i>
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
                                            <a href="/project/book/{{ $secondMenu['menu_id'] }}" class="nav-link {{ $secondMenu['class'] }}"
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

                <div class="row">
                    <h3>系统首页展示</h3>
                </div>

            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{ date('Y') }}</span>
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
<script src="/majestic/vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="/majestic/vendors/chart.js/Chart.min.js"></script>
<script src="/majestic/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/majestic/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="/majestic/js/off-canvas.js"></script>
<script src="/majestic/js/hoverable-collapse.js"></script>
<script src="/majestic/js/template.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="/majestic/js/dashboard.js"></script>
<script src="/majestic/js/data-table.js"></script>
<script src="/majestic/js/jquery.dataTables.js"></script>
<script src="/majestic/js/dataTables.bootstrap4.js"></script>
<!-- End custom js for this page-->

<!-- endinject -->
<!-- Custom js for this page -->
<!-- End custom js for this page -->

</body>

</html>
