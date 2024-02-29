<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author }}@endif</title>
    <meta name="description" content="{{ $project->project_title }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/{{ $project->project_code }}/css/login.min.css?v={{ rand(1, 2) }}.{{ rand(0, 9) }}.{{rand(0, 9)}}"
          rel="stylesheet"/>
</head>
<body class="signin">
<div class="signinpanel">
    <div class="row">
        <div class="col-sm-7">
            <div class="signin-info">
                <div class="logopanel m-b">
                </div>
                <div class="m-b"></div>
                <h1><strong>{{ $project->project_title }}</strong></h1>
            </div>
        </div>
        <div class="col-sm-5">
            <form id="signupForm" autocomplete="off">
                <h4 class="no-margins">登录：</h4>
                <input type="text" name="username" autocomplete="off" class="form-control uname" placeholder="用户名"
                       value=""/>
                <input type="password" name="password" autocomplete="off" class="form-control pword" placeholder="密码"
                       value=""/>
                <div class="row m-t">
                    <div class="col-xs-6">
                        <input type="text" name="validateCode" class="form-control code" placeholder="验证码"
                               maxlength="5"/>
                    </div>
                    <div class="col-xs-6">
                        <a href="javascript:void(0);" title="点击更换验证码">
                            <img src="{{ captcha_src('math') }}" class="imgcode" width="85%"/>
                        </a>
                    </div>
                </div>
                <div class="checkbox-custom @if (!$captchaEnabled) m-t @endif">
                    <input type="checkbox" id="rememberme" name="rememberme"> <label for="rememberme">记住我</label>
                </div>
                <button class="btn btn-success btn-block" id="btnSubmit" data-loading="...">登录</button>
            </form>
        </div>
    </div>
    <div class="signup-footer">
        <div class="pull-left">
            Copyright © <?php echo date('Y'); ?> All Rights Reserved. <br>
        </div>
    </div>
</div>
<script src="/{{ $project->project_code }}/js/login.js?v={{ rand(1, 2) }}.{{ rand(0, 9) }}.{{rand(0, 9)}}"></script>
</body>
</html>
