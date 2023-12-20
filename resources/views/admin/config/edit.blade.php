<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '修改参数'])
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-config-edit">
        <input id="configId" name="configId" value="{{ $data->config_id }}" type="hidden">
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">参数名称：</label>
            <div class="col-sm-8">
                <input id="configName" name="configName" value="{{ $data->config_name }}" class="form-control" type="text" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">参数键名：</label>
            <div class="col-sm-8">
                <input id="configKey" name="configKey" value="{{ $data->config_key }}" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">参数键值：</label>
            <div class="col-sm-8">
                <input id="configValue" name="configValue" value="{{ $data->config_value }}" class="form-control" type="text" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">系统内置：</label>
            <div class="col-sm-8">
                @foreach($sysYesNo as $item)
                <div class="radio-box">
                    <input type="radio" id="{{ $item->dict_code }}" name="configType" value="{{ $item->dict_value }}" @if($item->dict_value == $data->config_type) checked @endif>
                    <label>{{ $item->dict_label }}</label>
                </div>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">备注：</label>
            <div class="col-sm-8">
                <textarea id="remark" name="remark" class="form-control">{{ $data->remark }}</textarea>
            </div>
        </div>
    </form>
</div>

@include("admin.include.footer")

<script type="text/javascript">

    var prefix = ctx + "system/config";

    function submitHandler() {
        if ($.validate.form()) {
            $.operate.save(prefix + "/edit", $('#form-config-edit').serialize());
        }
    }
</script>
</body>
</html>
