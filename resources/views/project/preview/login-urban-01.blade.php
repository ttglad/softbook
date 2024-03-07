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
    <link rel="stylesheet" href="/urban/css/login.css">
</head>
<body>
<main class="d-flex align-items-center min-vh-100 py-3 py-md-0">
    <div class="container">
        <div class="card login-card">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <img src="/urban/images/login.jpg" alt="login" class="login-card-img">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <p class="login-card-description">{{ $project->project_title }}</p>
                        <form action="/project/preview/{{ $project->project_id }}/index">
                            <div class="form-group">
                                <label for="email" class="sr-only">用户名</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="用户名">
                            </div>
                            <div class="form-group mb-4">
                                <label for="password" class="sr-only">密码</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="密码">
                            </div>
                            <input name="login" id="login" class="btn btn-block login-btn mb-4" type="submit" value="登录">
                        </form>
                        <a href="#!" class="forgot-password-link">忘记密码？</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="card login-card">
          <img src="/urban/images/login.jpg" alt="login" class="login-card-img">
          <div class="card-body">
            <h2 class="login-card-title">Login</h2>
            <p class="login-card-description">Sign in to your account to continue.</p>
            <form action="#!">
              <div class="form-group">
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
              </div>
              <div class="form-prompt-wrapper">
                <div class="custom-control custom-checkbox login-card-check-box">
                  <input type="checkbox" class="custom-control-input" id="customCheck1">
                  <label class="custom-control-label" for="customCheck1">Remember me</label>
                </div>
                <a href="#!" class="text-reset">Forgot password?</a>
              </div>
              <input name="login" id="login" class="btn btn-block login-btn mb-4" type="button" value="Login">
            </form>
            <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>
          </div>
        </div> -->
    </div>
</main>
<script src="/bootstrap/4.6.2/js/bootstrap.min.js"></script>
</body>
</html>
