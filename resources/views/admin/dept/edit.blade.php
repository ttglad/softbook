<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '修改部门'])
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-dept-edit">
        <input name="deptId" type="hidden" value="{{ $dept->dept_id }}" />
        <input id="treeId" name="parentId" type="hidden" value="{{ $deptParent->dept_id }}" />
        <div class="form-group">
            <label class="col-sm-3 control-label">上级部门：</label>
            <div class="col-sm-8">
                <div class="input-group">
                    <input class="form-control" type="text" id="treeName" onclick="selectDeptTree()" readonly="true" value="{{ $deptParent->dept_name }}">
                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">部门名称：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="deptName" value="{{ $dept->dept_name }}" id="deptName" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">显示排序：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="orderNum" value="{{ $dept->order_num }}" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">负责人：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="leader" value="{{ $dept->leader }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">联系电话：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="phone" value="{{ $dept->phone }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">邮箱：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="email" value="{{ $dept->email }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">部门状态：</label>
            <div class="col-sm-8">
                @foreach($sysNormalDisable as $normalDisable)
                    <div class="radio-box">
                        <input type="radio" id="{{ $normalDisable->dict_code }}" name="status"
                               value="{{ $normalDisable->dict_value }}"
                               @if($normalDisable->dict_value == $dept->status) checked @endif />
                        <label>{{ $normalDisable->dict_label }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </form>
</div>

@include("admin.include.footer")

<script type="text/javascript">
    var prefix = ctx + "system/dept";

    $("#form-dept-edit").validate({
        onkeyup: false,
        rules:{
            deptName:{
                remote: {
                    url: prefix + "/checkDeptNameUnique",
                    type: "post",
                    dataType: "json",
                    data: {
                        "deptId": function() {
                            return $("#deptId").val();
                        },
                        "parentId": function() {
                            return $("input[name='parentId']").val();
                        },
                        "deptName": function() {
                            return $.common.trim($("#deptName").val());
                        }
                    }
                }
            },
            orderNum:{
                digits:true
            },
            email:{
                email:true,
            },
            phone:{
                isPhone:true,
            },
        },
        messages: {
            "deptName": {
                remote: "部门已经存在"
            }
        },
        focusCleanup: true
    });

    function submitHandler() {
        if ($.validate.form()) {
            $.operate.save(prefix + "/edit", $('#form-dept-edit').serialize());
        }
    }

    /*部门管理-修改-选择部门树*/
    function selectDeptTree() {
        var deptId = $("#treeId").val();
        var excludeId = $("input[name='deptId']").val();
        if(deptId > 0) {
            var options = {
                title: '部门选择',
                width: "380",
                url: prefix + "/selectDeptTree/" + $("#treeId").val() + "/" + excludeId,
                callBack: doSubmit
            };
            $.modal.openOptions(options);
        } else {
            $.modal.alertError("父部门不能选择");
        }
    }

    function doSubmit(index, layero){
        var tree = layero.find("iframe")[0].contentWindow.$._tree;
        if ($.tree.notAllowLastLevel(tree)) {
            var body = $.modal.getChildFrame(index);
            $("#treeId").val(body.find('#treeId').val());
            $("#treeName").val(body.find('#treeName').val());
            $.modal.close(index);
        }
    }
</script>
</body>
</html>
