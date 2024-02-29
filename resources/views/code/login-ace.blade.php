<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author  }} @endif</title>
    <link href="/{{ $project->project_code }}/css/login.min.css?v={{ rand(1, 2) }}.{{ rand(0, 9) }}.{{rand(0, 9)}}" rel="stylesheet"/>
</head>
<body>
<div class="login-box">
    <div class="login-logo">
        <b>{{ $project->project_title }}</b>系统
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">登录开始您的会话</p>
        <form method="post" action="{{ route('admin_post_login', [], false) }}" accept-charset="utf-8">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" maxlength="20" name="username" placeholder="用户名"/>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" maxlength="20" name="password" placeholder="登录密码"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> 记住我
                        </label>
                    </div>
                </div>
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
