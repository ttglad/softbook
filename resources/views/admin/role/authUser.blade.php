<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '角色分配用户'])
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

        <div class="btn-group-sm" id="toolbar" role="group">
            <a class="btn btn-success" onclick="selectUser()">
                <i class="fa fa-plus"></i> 添加用户
            </a>
            <a class="btn btn-danger multiple disabled" onclick="cancelAuthUserAll()">
                <i class="fa fa-remove"></i> 批量取消授权
            </a>
            <a class="btn btn-warning" onclick="closeItem()">
                <i class="fa fa-reply-all"></i> 关闭
            </a>
        </div>

        <div class="col-sm-12 select-table table-striped">
            <table id="bootstrap-table"></table>
        </div>
    </div>
</div>

@include("admin.include.footer")

<script>
    var removeFlag = true;
    var datas = @json($sysNormalDisable);
    var prefix = ctx + "system/role/authUser";

    $(function() {
        var options = {
            url: prefix + "/allocatedList",
            queryParams: queryParams,
            sortName: "create_time",
            sortOrder: "desc",
            columns: [{
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
                },
                {
                    title: '操作',
                    align: 'center',
                    formatter: function(value, row, index) {
                        var actions = [];
                        actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="cancelAuthUser(\'' + row.user_id + '\')"><i class="fa fa-remove"></i>取消授权</a> ');
                        return actions.join('');
                    }
                }]
        };
        $.table.init(options);
    });

    function queryParams(params) {
        var search = $.table.queryParams(params);
        search.roleId = $("#roleId").val();
        return search;
    }

    /* 分配用户-选择用户 */
    function selectUser() {
        var url = prefix + '/selectUser/' + $("#roleId").val();
        $.modal.open("选择用户", url);
    }

    /* 分配用户-批量取消授权 */
    function cancelAuthUserAll(userId) {
        var rows = $.table.selectFirstColumns();
        if (rows.length == 0) {
            $.modal.alertWarning("请至少选择一条记录");
            return;
        }
        $.modal.confirm("确认要删除选中的" + rows.length + "条数据吗?", function() {
            var data = { "roleId": $("#roleId").val(), "userIds": rows.join() };
            $.operate.submit(prefix + "/cancelAll", "post", "json", data);
        });
    }

    /* 分配用户-取消授权 */
    function cancelAuthUser(userId) {
        $.modal.confirm("确认要取消该用户角色吗？", function() {
            $.operate.post(prefix + "/cancel", { "roleId": $("#roleId").val(), "userId": userId });
        })
    }
</script>
</body>
</html>
