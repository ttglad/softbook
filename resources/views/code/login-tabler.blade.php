<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>登录 - {{ $project->project_title }} @if(!empty($project->project_author)) - {{ $project->project_author  }} @endif</title>
    <link href="/{{ $project->project_code }}/css/login.min.css?v={{ rand(1, 2) }}.{{ rand(0, 9) }}.{{rand(0, 9)}}" rel="stylesheet"/>
</head>
<body>
<div class="page page-center {{ $backType }}">
    <div class="container container-tight py-4">
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">{{ $project->project_title }}</h2>
                <form action="/project/preview/{{ $project->project_id }}/index" method="get" autocomplete="off" novalidate>
                    <div class="mb-3">
                        <label class="form-label">用户名</label>
                        <input type="user_name" class="form-control" placeholder="请输入您的用户名" autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            密码
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control"  placeholder="请输入您的密码"  autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input"/>
                            <span class="form-check-label">记住我</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="/{{ $project->project_code }}/js/login.min.js?v={{ rand(1, 2) }}.{{ rand(0, 9) }}.{{rand(0, 9)}}" defer></script>
</body>
</html>
