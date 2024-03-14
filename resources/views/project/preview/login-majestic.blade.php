<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author)) - {{ $project->project_author  }}@endif</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/majestic/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/majestic/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/majestic/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/majestic/images/favicon.png" />
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                        </div>
                        <h4>{{ $project->project_title }}</h4>
                        <h6 class="font-weight-light">登录继续.</h6>
                        <form class="pt-3">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="mt-3">
                                <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="/project/preview/{{ $project->project_id }}/index">登录</a>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input">
                                        记住我
                                    </label>
                                </div>
                                <a href="#" class="auth-link text-black">忘记密码?</a>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                没有账户? <a href="register.html" class="text-primary">注册</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="/majestic/vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="/majestic/js/off-canvas.js"></script>
<script src="/majestic/js/hoverable-collapse.js"></script>
<script src="/majestic/js/template.js"></script>
<!-- endinject -->
</body>

</html>
