<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author  }}@endif</title>

    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard Template">
    <meta name="author" content="BootstrapDash">

    <!-- vendor css -->

    <!-- azia CSS -->
    <link rel="stylesheet" href="/theme/azia/css/azia.css">

</head>
<body class="az-body">

<div class="az-signin-wrapper">
    <div class="az-card-signin">
        <div class="az-signin-header">
            <h2>{{ $project->project_title }}</h2>
            <h4>登录继续</h4>

            <form action="/project/preview/{{ $project->project_id }}/index">
                <div class="form-group">
                    <label>用户名</label>
                    <input type="text" class="form-control" placeholder="用户名" value="">
                </div><!-- form-group -->
                <div class="form-group">
                    <label>密码</label>
                    <input type="password" class="form-control" placeholder="密码" value="">
                </div><!-- form-group -->
                <button class="btn btn-az-primary btn-block">登录</button>
            </form>
        </div><!-- az-signin-header -->
        <div class="az-signin-footer">
            <p><a href="">忘记密码?</a></p>
            <p>没有账户? <a href="page-signup.html">创建账户</a></p>
        </div><!-- az-signin-footer -->
    </div><!-- az-card-signin -->
</div><!-- az-signin-wrapper -->

<script src="/theme/azia/js/azia.js"></script>
</body>
</html>
