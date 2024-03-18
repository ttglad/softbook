<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>系统首页 - {{ $project->project_title }}</title>
    <link href="/tabler/css/tabler.min.css?1668287865" rel="stylesheet"/>
    <link href="/tabler/css/tabler-flags.min.css?1668287865" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
    </style>
</head>
<body>
<div class="page">
    <!-- Navbar -->
    <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                {{ $project->project_name }}
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                       aria-label="Open user menu">
                        <span class="avatar avatar-sm" style="background-image: url({{ $headerImage }})"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>{{ $adminName }}</div>
                            <div class="mt-1 small text-muted">在线</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a class="dropdown-item">注销</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar navbar-light">
                <div class="container-xl">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-home"></i>
                                </span>
                                <span class="nav-link-title">首页</span>
                            </a>
                        </li>
                        @foreach($menus as $firstMenu)
                            <li class="nav-item dropdown @isset($firstMenu['check']) active @endisset">
                                <a class="nav-link @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0) dropdown-toggle @endif {{ $firstMenu['class'] }}"
                                   href="#" data-bs-toggle="dropdown"
                                   data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    @if (!empty($firstMenu['icon']))
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <i class="ti {{ $firstMenu['icon'] }}"></i>
                                        </span>
                                    @endif
                                    <span class="nav-link-title">
                                    {{ $firstMenu['menu_name'] }}
                                    </span>
                                </a>
                                @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                @foreach($firstMenu['children'] as $secondMenu)
                                                    <a href="/project/book/{{ $secondMenu['menu_id'] }}"
                                                       class="dropdown-item {{ $secondMenu['class'] }} @if(empty($secondMenu['target'])) menuItem @else {{ $secondMenu['target'] }} @endif"
                                                       data-href="{{ $secondMenu['url'] }}">
                                                        {{ $secondMenu['menu_name'] }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl mainContent">
                @if(in_array($business->data_type, ['chart-01', 'chart-02', 'chart-03']))
                    @include('project.business.chart.tabler-' . $business->data_type, compact('business', 'businessColumn'))
                @else
                    @include('project.business.list.tabler-horizontal', compact('business', 'businessColumn'))
                @endif
            </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Copyright &copy; {{ date('Y') }}
                                All rights reserved.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="/tabler/js/tabler.min.js?1668287865" defer></script>

<script
    src="/static/js/jquery.min.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script
    src="/static/js/bootstrap.min.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script
    src="/static/js/plugins/metisMenu/jquery.metisMenu.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script
    src="/static/js/plugins/slimscroll/jquery.slimscroll.min.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script
    src="/static/js/jquery.contextMenu.min.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script
    src="/static/ajax/libs/blockUI/jquery.blockUI.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script
    src="/static/ajax/libs/layer/layer.min.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>

<!-- softbook script -->
<script
    src="/static/softbook/js/home.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>

@include('project.business.include.modal', compact('business', 'businessColumn'))

</body>
</html>
