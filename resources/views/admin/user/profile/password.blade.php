<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '修改用户密码'])
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-user-resetPwd">
        <div class="form-group">
            <label class="col-sm-3 control-label">登录名称：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" readonly="true" name="loginName" value="{{ $user->login_name }}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">旧密码：</label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="oldPassword" id="oldPassword">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">新密码：</label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="newPassword" id="newPassword">
                @if($passType == '1')
                    <i class="fa fa-info-circle" style="color: red;"></i>  密码只能为0-9数字
                @elseif($passType == '2')
                    <i class="fa fa-info-circle" style="color: red;"></i>  密码只能为a-z和A-Z字母
                @elseif($passType == '3')
                    <i class="fa fa-info-circle" style="color: red;"></i>  密码必须包含（字母，数字）
                @elseif($passType == '4')
                    <i class="fa fa-info-circle" style="color: red;"></i>  密码必须包含（字母，数字，特殊字符!@#$%^&*()-=_+）
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">再次确认：</label>
            <div class="col-sm-8">
                <input class="form-control" type="password" name="confirmPassword" id="confirmPassword">
                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 请再次输入您的密码</span>
            </div>
        </div>
    </form>
</div>

@include("admin.include.footer")

<script>
    $("#form-user-resetPwd").validate({
        rules:{
            oldPassword:{
                required:true,
                remote: {
                    url: ctx + "system/user/profile/checkPassword",
                    type: "get",
                    dataType: "json",
                    data: {
                        password: function() {
                            return $("input[name='oldPassword']").val();
                        }
                    }
                }
            },
            newPassword: {
                required: true,
                minlength: 5,
                maxlength: 20
            },
            confirmPassword: {
                required: true,
                equalTo: "#newPassword"
            }
        },
        messages: {
            oldPassword: {
                required: "请输入原密码",
                remote: "原密码错误"
            },
            newPassword: {
                required: "请输入新密码",
                minlength: "密码不能小于5个字符",
                maxlength: "密码不能大于20个字符"
            },
            confirmPassword: {
                required: "请再次输入新密码",
                equalTo: "两次密码输入不一致"
            }

        },
        focusCleanup: true
    });

    function submitHandler() {
        var chrtype = {{ $passType }};
        var password = $("#newPassword").val();
        if ($.validate.form() && checkpwd(chrtype, password)) {
            $.operate.save(ctx + "system/user/profile/resetPwd", $('#form-user-resetPwd').serialize());
        }
    }
</script>
</body>

</html>
