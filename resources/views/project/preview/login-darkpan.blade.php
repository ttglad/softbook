<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author  }}@endif</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="/theme/darkpan/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="/theme/darkpan/css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid position-relative d-flex p-0">

    <!-- Sign Up Start -->
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="/project/preview/{{ $project->project_id }}/index" class="">
                            <h3 class="text-primary">{{ $project->project_title }}</h3>
                        </a>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingText" placeholder="jhondoe">
                        <label for="floatingText">用户名</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">密码</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">记住我</label>
                        </div>
                        <a href="">忘记密码</a>
                    </div>
                    <a type="button" class="btn btn-primary py-3 w-100 mb-4" href="/project/preview/{{ $project->project_id }}/index">登录</a>
                    <p class="text-center mb-0">还没有账户? <a href="">注册</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign Up End -->
</div>
</body>

</html>
