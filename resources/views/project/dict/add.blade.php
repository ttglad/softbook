<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '新增字典数据'])
</head>
<body class="white-bg">
	<div class="wrapper wrapper-content animated fadeInRight ibox-content">
		<form class="form-horizontal m" id="form-dict-add">
			<div class="form-group">
				<label class="col-sm-3 control-label is-required">字典名称：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="dictName" id="dictName" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label is-required">字典代码：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="dictValue" id="dictValue" required>
				</div>
			</div>
		</form>
	</div>

    @include("admin.include.footer")

	<script type="text/javascript">
		var prefix = ctx + "project/dict";

		function submitHandler() {
	        if ($.validate.form()) {
	        	$.operate.save(prefix + "/add", $('#form-dict-add').serialize());
	        }
	    }
	</script>
</body>
</html>
