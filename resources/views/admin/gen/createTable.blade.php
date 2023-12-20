<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '创建表结构'])
</head>
<body>
<div class="main-content">
    <label class="col-sm-6 control-label">创建表语句(支持多个建表语句)：</label>
    <div class="col-sm-11 col">
        <textarea class="form-control" id="text_create" name="" placeholder="请输入文本" rows="12" type="text"></textarea>
    </div>
</div>

@include("admin.include.footer")

<script type="text/javascript">
    var prefix = ctx + "tool/gen";

    /* 创建表结构 */
    function submitHandler() {
        var rows = $("#text_create").val();
        if (rows.length == 0) {
            $.modal.alertWarning("请输入建表语句");
            return;
        }
        var data = {"sql": rows};
        $.operate.save(prefix + "/createTable", data);
    }
</script>
</body>
</html>
