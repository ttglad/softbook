<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '分配角色选择用户'])
</head>
<body class="gray-bg">
<div class="container-div">
    <div class="row">
        <div class="col-sm-12 search-collapse">
            <form id="role-form">
                <input type="hidden" id="roleId" name="roleId" value="{{ $role->role_id }}">
                <div class="select-list">
                    <ul>
                        <li>
                            登录名称：<input type="text" name="loginName"/>
                        </li>
                        <li>
                            手机号码：<input type="text" name="phonenumber"/>
                        </li>
                        <li>
                            <a class="btn btn-primary btn-rounded btn-sm" onclick="$.table.search()"><i class="fa fa-search"></i>&nbsp;搜索</a>
                            <a class="btn btn-warning btn-rounded btn-sm" onclick="$.form.reset()"><i class="fa fa-refresh"></i>&nbsp;重置</a>
                        </li>
                    </ul>
                </div>
            </form>
        </div>

        <div class="col-sm-12 select-table table-striped">
            <table id="bootstrap-table"></table>
        </div>
    </div>
</div>

@include("admin.include.footer")

<script>
    var datas = @json($sysNormalDisable);
    var prefix = ctx + "system/role/authUser";

    $(function() {
        var options = {
            url: prefix + "/unallocatedList",
            queryParams: queryParams,
            sortName: "create_time",
            sortOrder: "desc",
            showSearch: false,
            showRefresh: false,
            showToggle: false,
            showColumns: false,
            clickToSelect: true,
            rememberSelected: true,
            columns: [{
                field: 'state',
                checkbox: true
            },
                {
                    field: 'user_id',
                    title: '用户ID',
                    visible: false
                },
                {
                    field: 'login_name',
                    title: '登录名称',
                    sortable: true
                },
                {
                    field: 'user_name',
                    title: '用户名称'
                },
                {
                    field: 'email',
                    title: '邮箱'
                },
                {
                    field: 'phonenumber',
                    title: '手机'
                },
                {
                    field: 'status',
                    title: '用户状态',
                    align: 'center',
                    formatter: function (value, row, index) {
                        return $.table.selectDictLabel(datas, value);
                    }
                },
                {
                    field: 'create_time',
                    title: '创建时间',
                    sortable: true
                }]
        };
        $.table.init(options);
    });

    function queryParams(params) {
        var search = $.table.queryParams(params);
        search.roleId = $("#roleId").val();
        return search;
    }

    /* 添加用户-选择用户-提交 */
    function submitHandler() {
        var rows = $.table.selectFirstColumns();
        if (rows.length == 0) {
            $.modal.alertWarning("请至少选择一条记录");
            return;
        }
        var data = { "roleId": $("#roleId").val(), "userIds": rows.join() };
        $.operate.save(prefix + "/selectAll", data);
    }
</script>
</body>
</html>
