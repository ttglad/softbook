<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '修改字典数据'])
</head>
<body class="white-bg">
	<div class="wrapper wrapper-content animated fadeInRight ibox-content">
		<form class="form-horizontal m" id="form-dict-edit">
			<input name="dictId" type="hidden" value="{{ $dict->dict_id }}" />
			<div class="form-group">
				<label class="col-sm-3 control-label is-required">字典名称：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="dictName" id="dictName" value="{{ $dict->dict_name }}" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label is-required">字典代码：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="dictValue" id="dictValue" value="{{ $dict->dict_value }}" required>
				</div>
			</div>
		</form>
	</div>

    @include("admin.include.footer")

	<script type="text/javascript">
		var prefix = ctx + "project/dict";

		function submitHandler() {
	        if ($.validate.form()) {
	        	$.operate.save(prefix + "/edit", $('#form-dict-edit').serialize());
	        }
	    }
	</script>
</body>
</html>
