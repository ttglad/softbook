<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => $business->table_comment])
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-business-edit">
        <input name="id" value="{{ $businessData['id'] }}" type="hidden">
        @foreach($businessColumn as $column)
            @if($column->is_list == 1)
        <div class="form-group">
            <label class="col-sm-3 control-label">{{ $column->dict_name }}：</label>
            <div class="col-sm-8">
                <input name="{{ $column->dict_value }}" class="form-control" type="text" value="{{ $businessData[$column->dict_value] }}">
            </div>
        </div>
            @endif
        @endforeach
    </form>
</div>

@include("admin.include.footer")

<script>
    var prefix = ctx + "project/business/" + @json($business->menu_id);

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
