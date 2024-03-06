<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '一键录入项目信息'])
</head>
<body>
<div class="main-content">
    <form id="form-user-add" class="form-horizontal">
        <h4 class="form-header h4">软著项目信息录入</h4>
        <div class="row">
            <div class="col-sm-12">
                <textarea name="projectInfo" placeholder="项目信息，为json格式内容，请校验格式" class="form-control"
                          rows="15"></textarea>
            </div>
        </div>
        <hr>
    </form>
</div>

@include("admin.include.footer")

<script>
    var prefix = ctx + "project/projectInit";

    function submitHandler() {
        var data = $("textarea").val();
        $.operate.save(prefix, {"data": data});
    }

</script>
</body>
</html>
