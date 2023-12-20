<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '角色数据权限'])
    <link href="/static/ajax/libs/jquery-ztree/3.5/css/metro/zTreeStyle.css" rel="stylesheet"/>
</head>
<body class="white-bg">
<div class="wrapper wrapper-content animated fadeInRight ibox-content">
    <form class="form-horizontal m" id="form-role-edit">
        <input id="roleId" name="roleId" type="hidden" value="{{ $role->role_id }}"/>
        <div class="form-group">
            <label class="col-sm-3 control-label">角色名称：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="roleName" id="roleName" value="{{ $role->role_name }}" readonly="true"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">权限字符：</label>
            <div class="col-sm-8">
                <input class="form-control" type="text" name="roleKey" id="roleKey" value="{{ $role->role_key }}" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">数据范围：</label>
            <div class="col-sm-8">
                <select id="dataScope" name="dataScope" class="form-control m-b">
                    <option value="1" @if($role->data_scope == 1) selected @endif>全部数据权限</option>
                    <option value="2" @if($role->data_scope == 2) selected @endif>自定数据权限</option>
                    <option value="3" @if($role->data_scope == 3) selected @endif>本部门数据权限</option>
                    <option value="4" @if($role->data_scope == 4) selected @endif>本部门及以下数据权限</option>
                    <option value="5" @if($role->data_scope == 5) selected @endif>仅本人数据权限</option>
                </select>
                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 特殊情况下，设置为“自定数据权限”</span>
            </div>
        </div>
        <div class="form-group" id="authDataScope" style="display: @if($role->data_scope == 2) block @else none @endif">
            <label class="col-sm-3 control-label">数据权限：</label>
            <div class="col-sm-8">
                <label class="check-box">
                    <input type="checkbox" value="1" checked>展开/折叠</label>
                <label class="check-box">
                    <input type="checkbox" value="2">全选/全不选</label>
                <label class="check-box">
                    <input type="checkbox" value="3" checked>父子联动</label>
                <div id="deptTrees" class="ztree ztree-border"></div>
            </div>
        </div>
    </form>
</div>

@include("admin.include.footer")
<script src="/static/ajax/libs/jquery-ztree/3.5/js/jquery.ztree.all-3.5.js"></script>

<script type="text/javascript">

    $(function() {
        var url = ctx + "system/role/deptTreeData?roleId=" + $("#roleId").val();
        var options = {
            id: "deptTrees",
            url: url,
            check: { enable: true, nocheckInherit: true, chkboxType: { "Y": "ps", "N": "ps" } },
            expandLevel: 2
        };
        $.tree.init(options);
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

    function submitHandler() {
        if ($.validate.form()) {
            edit();
        }
    }

    function edit() {
        var roleId = $("input[name='roleId']").val();
        var roleName = $("input[name='roleName']").val();
        var roleKey = $("input[name='roleKey']").val();
        var dataScope = $("#dataScope").val();
        var deptIds = $.tree.getCheckedNodes();
        $.ajax({
            cache : true,
            type : "POST",
            url : ctx + "system/role/authDataScope",
            data : {
                "roleId": roleId,
                "roleName": roleName,
                "roleKey": roleKey,
                "dataScope": dataScope,
                "deptIds": deptIds
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

    $("#dataScope").change(function(event){
        var dataScope = $(event.target).val();
        dataScopeVisible(dataScope);
    });

    function dataScopeVisible(dataScope) {
        if (dataScope == 2) {
            $("#authDataScope").show();
        } else {
            $._tree.checkAllNodes(false);
            $("#authDataScope").hide();
        }
    }
</script>
</body>
</html>
