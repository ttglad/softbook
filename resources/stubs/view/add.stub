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
            <label class="col-sm-3 control-label">{{ $column->column_comment }}：</label>
            <div class="col-sm-8">
                <input name="{{ $column->column_name }}" class="form-control" value="测试{{ $column->column_comment }}" type="text">
            </div>
        </div>
            @endif
        @endforeach
    </form>
</div>

@include("admin.include.footer")

<script>
    var prefix = ctx + "business/" + @json($business->table_name);
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
