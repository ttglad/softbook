<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '修改字典数据'])
</head>
<body class="white-bg">
	<div class="wrapper wrapper-content animated fadeInRight ibox-content">
		<form class="form-horizontal m" id="form-dict-edit">
			<input name="dictCode" type="hidden" value="{{ $dict->dict_code }}" />
			<div class="form-group">
				<label class="col-sm-3 control-label is-required">字典标签：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="dictLabel" id="dictLabel" value="{{ $dict->dict_label }}" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label is-required">字典键值：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="dictValue" id="dictValue" value="{{ $dict->dict_value }}" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">字典类型：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" readonly="true" value="{{ $dict->dict_type }}">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">样式属性：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" id="cssClass" name="cssClass" value="{{ $dict->css_class }}">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label is-required">字典排序：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="dictSort" value="{{ $dict->dict_sort }}" required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">回显样式：</label>
				<div class="col-sm-8">
					<select name="listClass" class="form-control m-b">
					    <option value="" >---请选择---</option>
	                    <option value="default" @if($dict->list_class == 'default') selected @endif>默认</option>
	                    <option value="primary" @if($dict->list_class == 'primary') selected @endif>主要</option>
	                    <option value="success" @if($dict->list_class == 'success') selected @endif>成功</option>
	                    <option value="info"    @if($dict->list_class == 'info') selected @endif>信息</option>
	                    <option value="warning" @if($dict->list_class == 'warning') selected @endif>警告</option>
	                    <option value="danger"  @if($dict->list_class == 'danger') selected @endif>危险</option>
	                </select>
	                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> table表格字典列显示样式属性</span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">系统默认：</label>
				<div class="col-sm-8">
                    @foreach($sysYesNo as $yesNo)
                        <div class="radio-box">
                            <input type="radio" name="isDefault" value="{{ $yesNo->dict_value }}" @if($yesNo->dict_value == $dict->is_default) checked @endif>
                            <label>{{ $yesNo->dict_label }}</label>
                        </div>
                    @endforeach
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">状态：</label>
				<div class="col-sm-8">
                    @foreach($sysNormalDisable as $normalDisable)
                        <div class="radio-box">
                            <input type="radio" name="status" value="{{ $normalDisable->dict_value }}" @if($normalDisable->dict_value == $dict->status) checked @endif>
                            <label>{{ $normalDisable->dict_label }}</label>
                        </div>
                    @endforeach
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label">备注：</label>
				<div class="col-sm-8">
					<textarea id="remark" name="remark" class="form-control">{{ $dict->remark }}</textarea>
				</div>
			</div>
		</form>
	</div>

    @include("admin.include.footer")

	<script type="text/javascript">
		var prefix = ctx + "system/dict/data";

		$("#form-dict-edit").validate({
			rules:{
				dictSort:{
					digits:true
				},
			},
			focusCleanup: true
		});

		function submitHandler() {
	        if ($.validate.form()) {
	        	$.operate.save(prefix + "/edit", $('#form-dict-edit').serialize());
	        }
	    }
	</script>
</body>
</html>
