<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author  }}@endif</title>
    <!-- inject:css -->
    <link rel="stylesheet" href="/theme/kapella/css/style.css">
    <!-- endinject -->
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
            <div class="row flex-grow">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <div class="auth-form-transparent text-left p-3">
                        <div class="brand-logo">
                        </div>
                        <h4>{{ $project->project_title }}</h4>
                        <h6 class="font-weight-light">Happy to see you again!</h6>
                        <form class="pt-3">
                            <div class="form-group">
                                <label for="exampleInputEmail">用户名</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg border-left-0" id="exampleInputEmail" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword">密码</label>
                                <div class="input-group">
                                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary"></i>
                      </span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg border-left-0" id="exampleInputPassword" placeholder="Password">
                                </div>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input">
                                        Keep me signed in
                                    </label>
                                </div>
                                <a href="#" class="auth-link text-black">Forgot password?</a>
                            </div>
                            <div class="my-3">
                                <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="/project/preview/{{ $project->project_id }}/index">LOGIN</a>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                Don't have an account? <a href="" class="text-primary">Create</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 login-half-bg d-flex flex-row" style="background: url(/theme/kapella/images/login-bg.jpg)")>
                    <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; {{ date('Y') }}  All rights reserved.</p>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- endinject -->
</body>

</html>
