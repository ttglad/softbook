<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '新增岗位'])
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-post-add">
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">岗位名称：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="postName" id="postName" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">岗位编码：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="postCode" id="postCode" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">显示顺序：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="postSort" id="postSort" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">岗位状态：</label>
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
    var prefix = ctx + "system/post";

    $("#form-post-add").validate({
        onkeyup: false,
        rules:{
            postName:{
                remote: {
                    url: ctx + "system/post/checkPostNameUnique",
                    type: "post",
                    dataType: "json",
                    data: {
                        "postName" : function() {
                            return $.common.trim($("#postName").val());
                        }
                    }
                }
            },
            postCode:{
                remote: {
                    url: ctx + "system/post/checkPostCodeUnique",
                    type: "post",
                    dataType: "json",
                    data: {
                        "postCode" : function() {
                            return $.common.trim($("#postCode").val());
                        }
                    }
                }
            },
            postSort:{
                digits:true
            },
        },
        messages: {
            "postCode": {
                remote: "岗位编码已经存在"
            },
            "postName": {
                remote: "岗位名称已经存在"
            }
        },
        focusCleanup: true
    });

    function submitHandler() {
        if ($.validate.form()) {
            $.operate.save(prefix + "/add", $('#form-post-add').serialize());
        }
    }
</script>
</body>
</html>
