<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => $business->table_comment])
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-business-add">
        @foreach($businessColumn as $column)
            @if($column->is_list == 1)
        <div class="form-group">
            <label class="col-sm-3 control-label">{{ $column->dict_name }}：</label>
            <div class="col-sm-8">
                <input name="{{ $column->dict_value }}" class="form-control" value="测试{{ $column->dict_name }}" type="text">
            </div>
        </div>
            @endif
        @endforeach
    </form>
</div>

@include("admin.include.footer")

<script>
    var prefix = ctx + "project/business/" + @json($business->menu_id);
    $("#form-business-add").validate({
        focusCleanup: true
    });

    function submitHandler() {
        if ($.validate.form()) {
            $.operate.save(prefix + "/add", $('#form-business-add').serialize());
        }
    }
</script>
</body>
</html>
