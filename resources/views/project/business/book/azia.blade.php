<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="/vendors/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="/azia/lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="/azia/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/azia/lib/typicons.font/typicons.css" rel="stylesheet">
    <link href="/azia/lib/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">

    <!-- azia CSS -->
    <link rel="stylesheet" href="/azia/css/azia.css">

</head>
<body>

<div class="az-header">
    <div class="container">
        <div class="az-header-left">
            <a href="/" class="az-logo" style="font-size: 16px;">{{ $project->project_title }}</a>
        </div><!-- az-header-left -->
        <div class="az-header-menu">
            <ul class="nav">
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="/">--}}
{{--                        <i class="typcn typcn-chart-area-outline"></i>--}}
{{--                        系统首页--}}
{{--                    </a>--}}
{{--                </li>--}}
                @foreach($menus as $firstMenu)
                    <li class="nav-item @isset($firstMenu['check']) show active @endisset">
                        <a class="nav-link with-sub">
                            @if (!empty($firstMenu['icon']))
                                <i class="{{ $firstMenu['icon'] }} typcn"></i>
                            @else
                                <i class="typcn typcn-th-menu"></i>
                            @endif
                            {{ $firstMenu['menu_name'] }}
                        </a>
                        @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                            <nav class="az-menu-sub">
                                @foreach($firstMenu['children'] as $secondMenu)
                                    <a href="/project/book/{{ $secondMenu['menu_id'] }}" class="nav-link">
                                        {{ $secondMenu['menu_name'] }}
                                    </a>
                                @endforeach
                            </nav>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div><!-- az-header-menu -->
        <div class="az-header-right">
            <div class="dropdown az-profile-menu">
                <a href="" class="az-img-user"><img src="{{ $headerImage }}" alt=""></a>
                <div class="dropdown-menu">
                    <div class="az-dropdown-header d-sm-none">
                        <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                    </div>
                    <div class="az-header-profile">
                        <div class="az-img-user">
                            <img src="{{ $headerImage }}" alt="">
                        </div><!-- az-img-user -->
                        <h6>{{ $adminName }}</h6>
                        <span>管理员</span>
                    </div><!-- az-header-profile -->

                    <a href="#" class="dropdown-item"><i class="typcn typcn-user-outline"></i> 个人中心</a>
                    <a href="#" class="dropdown-item"><i class="typcn typcn-power-outline"></i> 退出登录</a>
                </div><!-- dropdown-menu -->
            </div>
        </div><!-- az-header-right -->
    </div><!-- container -->
</div><!-- az-header -->

<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-left az-content-left-components">
            <div class="component-item">
                @foreach($menus as $firstMenu)
                    @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                        <label>{{ $firstMenu['menu_name'] }}</label>
                        <nav class="nav flex-column">
                            @foreach($firstMenu['children'] as $secondMenu)
                                <a href="/project/book/{{ $secondMenu['menu_id'] }}" class="nav-link @isset($secondMenu['check']) active @endif">
                                    {{ $secondMenu['menu_name'] }}
                                </a>
                            @endforeach
                        </nav>
                    @endif
                @endforeach
            </div><!-- component-item -->

        </div><!-- az-content-left -->
        @if(in_array($business->data_type, ['chart-01', 'chart-02', 'chart-03']))
            @include('project.business.chart.azia-' . $business->data_type, compact('business', 'businessColumn'))
        @else
            @include('project.business.list.azia', compact('business', 'businessColumn'))
        @endif
    </div>
</div><!-- az-content -->


<script src="/vendors/bootstrap/5.3.0/js/bootstrap.min.js"></script>
<script src="/azia/lib/jquery/jquery.min.js"></script>
<script src="/azia/lib/chart.js/Chart.bundle.min.js"></script>

<script src="/azia/js/azia.js"></script>

<script src="/static/softbook/js/home.js"></script>

@include('project.business.include.modal', compact('business', 'businessColumn'))

</body>
</html>
