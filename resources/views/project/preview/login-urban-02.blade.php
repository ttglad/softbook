<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author  }}@endif</title>
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/urban/css/login-02.css">
</head>
<body>
<body>
<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 login-section-wrapper">
                <div class="login-wrapper my-auto">
                    <h1 class="login-title">{{ $project->project_title }}</h1>
                    <form action="/project/preview/{{ $project->project_id }}/index">
                        <div class="form-group">
                            <label for="email">管理员</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="管理员">
                        </div>
                        <div class="form-group mb-4">
                            <label for="password">密码</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="请输入管理员密码">
                        </div>
                        <input name="login" id="login" class="btn btn-block login-btn" type="submit" value="登录">
                    </form>
                    <a href="#!" class="forgot-password-link">忘记密码</a>
                </div>
            </div>
            <div class="col-sm-6 px-0 d-none d-sm-block">
                <img src="/urban/images/login-02.jpg" alt="login image" class="login-img">
            </div>
        </div>
    </div>
</main>
<script src="/bootstrap/4.6.2/js/bootstrap.min.js"></script>
</body>
</html>
