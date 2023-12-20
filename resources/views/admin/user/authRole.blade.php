<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '用户分配角色'])
</head>
<body>
<div class="main-content">
    <form id="form-user-add" class="form-horizontal">
        <input type="hidden" id="userId" name="userId" value="{{ $user->user_id }}">
        <h4 class="form-header h4">基本信息</h4>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">用户名称：</label>
                    <div class="col-sm-8">
                        <input name="userName" class="form-control" type="text" disabled value="{{ $user->user_name }}">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">登录账号：</label>
                    <div class="col-sm-8">
                        <input name="loginName" class="form-control" type="text" disabled value="{{ $user->login_name }}">
                    </div>
                </div>
            </div>
        </div>

        <h4 class="form-header h4">分配角色</h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-12 select-table table-striped">
                    <table id="bootstrap-table"></table>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-sm-offset-5 col-sm-10">
        <button type="button" class="btn btn-sm btn-primary" onclick="submitHandler()"><i class="fa fa-check"></i>保 存</button>&nbsp;
        <button type="button" class="btn btn-sm btn-danger" onclick="closeItem()"><i class="fa fa-reply-all"></i>关 闭 </button>
    </div>
</div>

@include("admin.include.footer")

<script>
    var prefix = ctx + "system/user/authRole";
    var roles = @json($roles);

    $(function() {
        var options = {
            data: roles,
            sidePagination: "client",
            sortName: "role_sort",
            showSearch: false,
            showRefresh: false,
            showToggle: false,
            showColumns: false,
            clickToSelect: true,
            maintainSelected: true,
            columns: [{
                checkbox: true,
                formatter:function (value, row, index) {
                    if($.common.isEmpty(value)) {
                        return { checked: row.flag };
                    } else {
                        return { checked: value }
                    }
                }
            },
                {
                    field: 'role_id',
                    title: '角色编号'
                },
                {
                    field: 'role_sort',
                    title: '排序',
                    sortable: true,
                    visible: false
                },
                {
                    field: 'role_name',
                    title: '角色名称'
                },
                {
                    field: 'role_key',
                    title: '权限字符',
                    sortable: true
                },
                {
                    field: 'create_time',
                    title: '创建时间',
                    sortable: true
                }]
        };
        $.table.init(options);
    });

    /* 添加角色-提交 */
    function submitHandler(index, layero){
        var roleIds = [];
        var data = $('#bootstrap-table').bootstrapTable('getData');
        for (var i = 0; i < data.length; i++) {
            if (data[i][0] || ($.common.isEmpty(data[i][0]) && data[i].flag)) {
                roleIds.push(data[i].role_id)
            }
        }
        $.operate.saveTab(prefix, { "userId": $("#userId").val(), "roleIds": roleIds.join() });
    }
</script>
</body>
</html>
