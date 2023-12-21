<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '新增字典类型'])
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
				<label class="col-sm-3 control-label is-required">字典类型：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="dictType" id="dictType" required>
					<span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 数据存储中的Key值，如：sys_user_sex</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">状态：</label>
				<div class="col-sm-8">
                    @foreach($sysNormalDisable as $normalDisable)
                        <div class="radio-box">
                            <input type="radio" name="status" value="{{ $normalDisable->dict_value }}" @if($normalDisable->is_default == 'Y') checked @endif>
                            <label>{{ $normalDisable->dict_label }}</label>
                        </div>
                    @endforeach
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">备注：</label>
				<div class="col-sm-8">
					<textarea id="remark" name="remark" class="form-control"></textarea>
				</div>
			</div>
		</form>
	</div>

    @include("admin.include.footer")

	<script type="text/javascript">
		var prefix = ctx + "system/dict";

		$("#form-dict-add").validate({
			onkeyup: false,
			rules:{
				dictType:{
					minlength: 5,
					remote: {
		                url: prefix + "/checkDictTypeUnique",
		                type: "post",
		                dataType: "json",
		                data: {
		                	name : function() {
		                        return $.common.trim($("#dictType").val());
		                    }
		                }
		            }
				},
			},
			messages: {
		        "dictType": {
		            remote: "该字典类型已经存在"
		        }
		    },
		    focusCleanup: true
		});

		function submitHandler() {
	        if ($.validate.form()) {
	        	$.operate.save(prefix + "/add", $('#form-dict-add').serialize());
	        }
	    }
	</script>
</body>
</html>
