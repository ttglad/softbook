<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author  }}@endif</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="/ace/lib/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/ace/lib/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/ace/lib/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/ace/css/admin.css" rel="stylesheet" type="text/css"/>
    <link href="/ace/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
    <link href="/ace/lib/iCheck/1.0.2/square/blue.css" rel="stylesheet" type="text/css"/>

</head>

<body class="login-page">

    <div class="login-box">
        <div class="login-logo">
            <h2>{{ $project->project_title }}</h2>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">登录开始您的会话</p>
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> 警告!</h4>
                    <p>{!! $errors->first('attempt') !!}</p>
                </div>
            @endif

            <form method="get" action="/project/preview/{{ $project->project_id }}/index" accept-charset="utf-8">
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
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                    </div><!-- /.col -->
                </div>
            </form>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</body>

<script src="/ace/lib/jQuery/jQuery-2.2.3.min.js"></script>
<script src="/ace/lib/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="/ace/lib/iCheck/1.0.2/icheck.min.js"></script>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
