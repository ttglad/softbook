<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author  }}@endif</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="/vendors/bootstrap/4.6.2/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/ace/css/admin.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/ace/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
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
                <div class="form-group has-feedback">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
                </div>
            </form>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</body>
