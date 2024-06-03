<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>登录</title>
    <meta name="description" content="{{ $softName }}">
    <link href="/static/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/static/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="/static/css/style.min.css" rel="stylesheet"/>
    <link href="/static/css/login.min.css" rel="stylesheet"/>
    <link href="/static/ruoyi/css/soft-ui.css" rel="stylesheet"/>
    <!-- 360浏览器急速模式 -->
    <meta name="renderer" content="webkit">
    <!-- 避免IE使用兼容模式 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/static/favicon.ico"/>
    <style type="text/css">
        label.error {
            position: inherit;
        }
    </style>
    <script>
        if (window.top !== window.self) {
            alert('未登录或登录超时。请重新登录');
            window.top.location = window.location
        }
    </script>
</head>
<body class="signin">
<div class="signinpanel">
    <div class="row">
        <div class="col-sm-7">
            <div class="signin-info">
                <div class="logopanel m-b">
                </div>
                <div class="m-b"></div>
                <h1><strong>{{ $softName }}</strong></h1>
                @if ($registerValue)
                    <strong>还没有账号？ <a href="/register">立即注册&raquo;</a></strong>
                @endif
            </div>
        </div>
        <div class="col-sm-5">
            <form id="signupForm" autocomplete="off">
                <h4 class="no-margins">登录：</h4>
                <input type="text" name="username" class="form-control uname" placeholder="用户名" value=""/>
                <input type="password" name="password" class="form-control pword" placeholder="密码" value=""/>
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
                @if ($rememberMe)
                    <div class="checkbox-custom @if (!$captchaEnabled) m-t @endif">
                        <input type="checkbox" id="rememberme" name="rememberme"> <label for="rememberme">记住我</label>
                    </div>
                @endif
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
<script>
    var ctx = "<?php echo '/'; ?>";
    var captchaType = <?php echo "captchaType"; ?>;
</script>
<!--[if lte IE 8]>
<script>window.location.href = ctx + 'html/ie.html';</script><![endif]-->
<!-- 全局js -->
<script src="/static/js/jquery.min.js"></script>
<script src="/static/ajax/libs/validate/jquery.validate.min.js"></script>
<script src="/static/ajax/libs/layer/layer.min.js"></script>
<script src="/static/ajax/libs/blockUI/jquery.blockUI.js"></script>
<script src="/static/ruoyi/js/soft-ui.js"></script>
<script src="/static/ruoyi/login.js"></script>
</body>
</html>
