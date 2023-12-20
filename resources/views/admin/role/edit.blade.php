<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '修改角色'])
    <link href="/static/ajax/libs/jquery-ztree/3.5/css/metro/zTreeStyle.css" rel="stylesheet"/>
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-role-edit">
        <input id="roleId" name="roleId" type="hidden" value="{{ $role->role_id }}"/>
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">角色名称：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="roleName" id="roleName" value="{{ $role->role_name }}" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">权限字符：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="roleKey" id="roleKey" value="{{ $role->role_key }}" required>
                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 控制器中定义的权限字符，如：@RequiresRoles("")</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label is-required">显示顺序：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="roleSort" id="roleSort" value="{{ $role->role_sort }}" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">状态：</label>
            <div class="col-sm-8">
                <label class="toggle-switch switch-solid">
                    <input type="checkbox" id="status" @if($role->status == '0') checked @endif />
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">备注：</label>
            <div class="col-sm-8">
                <input id="remark" name="remark" class="form-control" type="text" value="{{ $role->remark }}">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">菜单权限：</label>
            <div class="col-sm-8">
                <label class="check-box">
                    <input type="checkbox" value="1">展开/折叠</label>
                <label class="check-box">
                    <input type="checkbox" value="2">全选/全不选</label>
                <label class="check-box">
                    <input type="checkbox" value="3" checked>父子联动</label>
                <div id="menuTrees" class="ztree ztree-border"></div>
            </div>
        </div>
    </form>
</div>

@include("admin.include.footer")
<script src="/static/ajax/libs/jquery-ztree/3.5/js/jquery.ztree.all-3.5.js"></script>

<script type="text/javascript">
    $(function() {
        var url = ctx + "system/menu/roleMenuTreeData?roleId=" + $("#roleId").val();
        var options = {
            id: "menuTrees",
            url: url,
            check: { enable: true },
            expandLevel: 0
        };
        $.tree.init(options);
    });

    $("#form-role-edit").validate({
        onkeyup: false,
        rules:{
            roleName:{
                remote: {
                    url: ctx + "system/role/checkRoleNameUnique",
                    type: "post",
                    dataType: "json",
                    data: {
                        "roleId": function() {
                            return $("#roleId").val();
                        },
                        "roleName": function() {
                            return $.common.trim($("#roleName").val());
                        }
                    }
                }
            },
            roleKey:{
                remote: {
                    url: ctx + "system/role/checkRoleKeyUnique",
                    type: "post",
                    dataType: "json",
                    data: {
                        "roleId": function() {
                            return $("#roleId").val();
                        },
                        "roleKey": function() {
                            return $.common.trim($("#roleKey").val());
                        }
                    }
                }
            },
            roleSort:{
                digits:true
            },
        },
        messages: {
            "roleName": {
                remote: "角色名称已经存在"
            },
            "roleKey": {
                remote: "角色权限已经存在"
            }
        },
        focusCleanup: true
    });

    $('input').on('ifChanged', function(obj){
        var type = $(this).val();
        var checked = obj.currentTarget.checked;
        if (type == 1) {
            if (checked) {
                $._tree.expandAll(true);
            } else {
                $._tree.expandAll(false);
            }
        } else if (type == "2") {
            if (checked) {
                $._tree.checkAllNodes(true);
            } else {
                $._tree.checkAllNodes(false);
            }
        } else if (type == "3") {
            if (checked) {
                $._tree.setting.check.chkboxType = { "Y": "ps", "N": "ps" };
            } else {
                $._tree.setting.check.chkboxType = { "Y": "", "N": "" };
            }
        }
    })

    function edit() {
        var roleId = $("input[name='roleId']").val();
        var roleName = $("input[name='roleName']").val();
        var roleKey = $("input[name='roleKey']").val();
        var roleSort = $("input[name='roleSort']").val();
        var status = $("input[id='status']").is(':checked') == true ? 0 : 1;
        var remark = $("input[name='remark']").val();
        var menuIds = $.tree.getCheckedNodes();
        $.ajax({
            cache : true,
            type : "POST",
            url : ctx + "system/role/edit",
            data : {
                "roleId": roleId,
                "roleName": roleName,
                "roleKey": roleKey,
                "roleSort": roleSort,
                "status": status,
                "remark": remark,
                "menuIds": menuIds
            },
            async : false,
            error : function(request) {
                $.modal.alertError("系统错误");
            },
            success : function(data) {
                $.operate.successCallback(data);
            }
        });
    }

    function submitHandler() {
        if ($.validate.form()) {
            edit();
        }
    }
</script>
</body>
</html>
