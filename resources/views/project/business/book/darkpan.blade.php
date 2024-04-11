<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/theme/darkpan/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/theme/darkpan/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/theme/darkpan/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/theme/darkpan/css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-secondary navbar-dark">
            <a href="#" class="navbar-brand mx-4 mb-3">
                <h5 class="text-primary">后台管理</h5>
            </a>
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle" src="{{ $headerImage }}" alt="" style="width: 40px; height: 40px;">
                    <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0">{{ $adminName }}</h6>
                    <span>管理员</span>
                </div>
            </div>
            <div class="navbar-nav w-100">
                <a class="nav-item nav-link"><i class="fa fa-home me-2"></i>系统首页</a>
                @foreach($menus as $firstMenu)
                    @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle @isset($firstMenu['check']) show active @endisset" data-bs-toggle="dropdown" @isset($firstMenu['check']) aria-expanded="true" @else aria-expanded="false" @endisset">
                            @if ($firstMenu['menu_id'] == 1)
                                <i class="fa fa-cog me-2"></i>
                            @elseif ($firstMenu['menu_id'] == 2)
                                <i class="fa fa-tv me-2"></i>
                            @elseif (!empty($firstMenu['icon']))
                                <i class="fa {{ $firstMenu['icon'] }} me-2"></i>
                            @else
                                <i class="fa fa-bars me-2"></i>
                                @endif
                                {{ $firstMenu['menu_name'] }}
                                </a>
                                <div class="dropdown-menu bg-transparent border-0 @isset($firstMenu['check']) show @endisset">
                                    @foreach($firstMenu['children'] as $secondMenu)
                                        <a href="/project/book/{{ $secondMenu['menu_id'] }}" class="dropdown-item @isset($secondMenu['check']) active @endisset">
                                            {{ $secondMenu['menu_name'] }}
                                        </a>
                                    @endforeach
                                </div>
                        </div>
                    @else
                        <a href="{{ $firstMenu['url'] }}" class="nav-item nav-link @isset($firstMenu['check']) active @endisset">
                            @if ($firstMenu['menu_id'] == 1)
                                <i class="fa fa-cog me-2"></i>
                            @elseif ($firstMenu['menu_id'] == 2)
                                <i class="fa fa-tv me-2"></i>
                            @elseif (!empty($firstMenu['icon']))
                                <i class="fa {{ $firstMenu['icon'] }} me-2"></i>
                            @else
                                <i class="fa fa-bars me-2"></i>
                            @endif
                            {{ $firstMenu['menu_name'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </nav>
    </div>
    <!-- Sidebar End -->


    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
            <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
            </a>
            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars"></i>
            </a>
            <div class="navbar-nav align-items-center"><h5>{{$project->project_title }}</h5></div>
            <div class="navbar-nav align-items-center ms-auto">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-envelope me-lg-2"></i>
                        <span class="d-none d-lg-inline-flex">消息</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item text-center">查看全部</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa fa-bell me-lg-2"></i>
                        <span class="d-none d-lg-inline-flex">通知</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">Profile updated</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">New user added</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item">
                            <h6 class="fw-normal mb-0">Password changed</h6>
                            <small>15 minutes ago</small>
                        </a>
                        <hr class="dropdown-divider">
                        <a href="#" class="dropdown-item text-center">See all notifications</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2" src="{{ $headerImage }}" alt="" style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex">{{ $adminName }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                        <a href="#" class="dropdown-item">个人中心</a>
                        <a href="#" class="dropdown-item">设置</a>
                        <a href="#" class="dropdown-item">退出登录</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Navbar End -->

        <!-- Blank Start -->
        <div class="container-fluid pt-4 px-4">
            @if(in_array($business->data_type, ['chart-01', 'chart-02', 'chart-03']))
                @include('project.business.chart.base-' . $business->data_type, compact('business', 'businessColumn'))
            @else
                @include('project.business.list.darkpan', compact('business', 'businessColumn'))
            @endif
        </div>
        <!-- Blank End -->

        <!-- Footer Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary rounded-top p-4">
                <div class="row">
                    <div class="col-12 col-sm-6 text-center text-sm-start">
                        &copy; {{ date('Y') }}, All Right Reserved.
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
    </div>
    <!-- Content End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/theme/darkpan/lib/chart/chart.min.js"></script>
<script src="/theme/darkpan/lib/easing/easing.min.js"></script>
<script src="/theme/darkpan/lib/waypoints/waypoints.min.js"></script>
<script src="/theme/darkpan/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="/theme/darkpan/lib/tempusdominus/js/moment.min.js"></script>
<script src="/theme/darkpan/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="/theme/darkpan/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Template Javascript -->
<script src="/theme/darkpan/js/main.js"></script>

<script src="/static/softbook/js/home.js"></script>

@include('project.business.include.modal', compact('business', 'businessColumn'))

</body>

</html>
