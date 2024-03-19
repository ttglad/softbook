<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录 - {{ $project->project_title }}@if(!empty($project->project_author))
            - {{ $project->project_author  }}
        @endif</title>

    <!-- Vendor css -->

    <!-- Base css with customised bootstrap included -->
    <link rel="stylesheet" href="/miri/css/miri-ui-kit-free.css">

    <!-- Stylesheet for demo page specific css -->
</head>
<body class="login-page">
<header class="miri-ui-kit-header header-no-bg-img header-navbar-only">
    <nav class="navbar navbar-expand-lg bg-transparent">
        <div class="container">
            <h4 style="color:#ffffff">{{ $project->project_title }}</h4>
        </div>
    </nav>
</header>
<div class="card login-card">
    <div class="card-body">
        <h3 class="text-center text-white font-weight-light mb-4">登录</h3>
        <form action="/project/preview/{{ $project->project_id }}/index">
            <div class="form-group">
                <input type="text" placeholder="用户名" class="form-control">
            </div>
            <div class="form-group">
                <input type="text" placeholder="密码" class="form-control">
            </div>
            <input type="submit" value="登录" class="btn btn-danger btn-block mb-3">
        </form>
    </div>
</div>
<footer>
    <div class="container">
        <nav
            class="navbar navbar-dark bg-transparent navbar-expand d-block d-sm-flex text-center justify-content-between">
            <div class="d-flex">
                <span class="navbar-text py-0">Copyright © </span><span
                    class="navbar-text py-0 pl-1">{{ date('Y') }}</span>
            </div>
        </nav>
    </div>
</footer>
</body>
</html>
