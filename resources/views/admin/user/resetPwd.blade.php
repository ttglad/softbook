<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '修改密码'])
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-user-resetPwd">
        <input name="userId"  type="hidden" value="{{ $user->user_id }}" />
        <div class="form-group">
            <label class="col-sm-3 control-label">登录名称：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" readonly="true" name="loginName" value="{{ $user->login_name }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">输入密码：</label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="password" id="password">
            </div>
        </div>
    </form>
</div>

@include("admin.include.footer")

<script type="text/javascript">
    $("#form-user-resetPwd").validate({
        rules:{
            password:{
                required:true,
                minlength: 5,
                maxlength: 20
            },
        },
        focusCleanup: true
    });

    function submitHandler() {
        if ($.validate.form()) {
            $.operate.save(ctx + "system/user/resetPwd", $('#form-user-resetPwd').serialize());
        }
    }
</script>
</body>

</html>
