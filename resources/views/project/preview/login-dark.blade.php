<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author  }}@endif</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="/theme/dark/css/style.{{ \Illuminate\Support\Arr::random(['default', 'red', 'green', 'violet', 'sea', 'blue']) }}.premium.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="/theme/dark/css/custom.css">
</head>
<body>
<div class="login-page">
    <div class="container d-flex align-items-center position-relative py-5">
        <div class="card shadow-sm w-100 rounded overflow-hidden bg-none">
            <div class="card-body p-0">
                <div class="row gx-0 align-items-stretch">
                    <!-- Logo & Information Panel-->
                    <div class="col-lg-6">
                        <div class="info d-flex justify-content-center flex-column p-4 h-100">
                            <div class="py-5">
                                <h1 class="display-6 fw-bold">{{ $project->project_title }}</h1>
                            </div>
                        </div>
                    </div>
                    <!-- Form Panel    -->
                    <div class="col-lg-6 bg-white">
                        <div class="d-flex align-items-center px-4 px-lg-5 h-100 bg-dash-dark-2">
                            <form class="login-form py-5 w-100" method="get" action="/project/preview/{{ $project->project_id }}/index">
                                <div class="input-material-group mb-3">
                                    <input class="input-material" id="login-username" type="text" name="loginUsername" autocomplete="off" data-validate-field="loginUsername">
                                    <label class="label-material" for="login-username">用户名</label>
                                </div>
                                <div class="input-material-group mb-4">
                                    <input class="input-material" id="login-password" type="password" name="loginPassword" data-validate-field="loginPassword">
                                    <label class="label-material" for="login-password">密码</label>
                                </div>
                                <button class="btn btn-primary mb-3" id="login" type="submit">登录</button><br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
