<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>系统首页 - {{ $project->project_title }}</title>
    <link href="/theme/tabler/css/tabler.min.css" rel="stylesheet"/>
    <link href="/theme/tabler/css/tabler-flags.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"/>
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
    </style>
</head>
<body>
<script src="/tabler/js/demo-theme.min.js?1668287865"></script>
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
                            <a class="nav-link" href="/index">
                                <span class="nav-link-title">首页</span>
                            </a>
                        </li>
                        @foreach($menus as $firstMenu)
                            <li class="nav-item dropdown">
                                <a class="nav-link @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0) dropdown-toggle @endif {{ $firstMenu['class'] }}"
                                   href="#" data-bs-toggle="dropdown"
                                   data-bs-auto-close="outside" role="button" aria-expanded="false">
                                    <span class="nav-link-title">
                                    {{ $firstMenu['menu_name'] }}
                                    </span>
                                </a>
                                @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                @foreach($firstMenu['children'] as $secondMenu)
                                                    <a href="/project/book/{{ $secondMenu['menu_id'] }}" class="dropdown-item {{ $secondMenu['class'] }} @if(empty($secondMenu['target'])) menuItem @else {{ $secondMenu['target'] }} @endif" data-href="{{ $secondMenu['url'] }}">
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
<!-- 弹框 集合 开始-->
<div class="alert alert-success alert-dismissible fade" role="alert">
    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<div class="alert alert-warning alert-dismissible fade" role="alert">
    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<!-- 弹框 集合 结束-->
<!-- Libs JS -->
<!-- Tabler Core -->

<!-- Tabler Core -->
<script src="/theme/tabler/js/tabler.min.js" defer></script>

<script src="/vendors/jquery/3.4.1/jquery.min.js"></script>

<!-- softbook script -->
<script src="/static/softbook/js/home.js"></script>
<!-- softbook script -->
</body>
</html>
