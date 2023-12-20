<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '数据存储'])
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-business-edit">
        <input name="id" value="{{ $data->id }}" type="hidden">
        <div class="form-group">
            <label class="col-sm-3 control-label">数据编号：</label>
            <div class="col-sm-8">
                <input name="data_number" class="form-control" value="{{ $data->data_number }}" type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">数据名称：</label>
            <div class="col-sm-8">
                <input name="data_name" class="form-control" value="{{ $data->data_name }}" type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">存储路径：</label>
            <div class="col-sm-8">
                <input name="storage_path" class="form-control" value="{{ $data->storage_path }}" type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">数据查询：</label>
            <div class="col-sm-8">
                <input name="data_query" class="form-control" value="{{ $data->data_query }}" type="text">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">数据导出：</label>
            <div class="col-sm-8">
                <input name="data_export" class="form-control" value="{{ $data->data_export }}" type="text">
            </div>
        </div>
    </form>
</div>

@include("admin.include.footer")

<script>
    var prefix = ctx + "business/dataStorage";

    $("#form-business-edit").validate({
        focusCleanup: true
    });

    function submitHandler() {
        if ($.validate.form()) {
            $.operate.save(prefix + "/edit", $('#form-business-edit').serialize());
        }
    }
</script>
</body>
</html>
