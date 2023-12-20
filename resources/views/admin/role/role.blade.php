<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '角色列表'])
</head>
<body class="gray-bg">
<div class="container-div">
    <div class="row">
        <div class="col-sm-12 search-collapse">
            <form id="role-form">
                <div class="select-list">
                    <ul>
                        <li>
                            角色名称：<input type="text" name="roleName"/>
                        </li>
                        <li>
                            权限字符：<input type="text" name="roleKey"/>
                        </li>
                        <li>
                            角色状态：
                            <select name="status">
                                <option value="">所有</option>
                                @foreach($sysNormalDisable as $normalDisable)
                                    <option value="{{ $normalDisable->dict_value }}">{{ $normalDisable->dict_label }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="select-time">
                            <label>创建时间： </label>
                            <input type="text" placeholder="开始时间"  class="time-input" id="startTime" name="params[beginTime]"/>
                            <span>-</span>
                            <input type="text" class="time-input" id="endTime" placeholder="结束时间" name="params[endTime]"/>
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
            <a class="btn btn-success" onclick="$.operate.add()">
                <i class="fa fa-plus"></i> 新增
            </a>
            <a class="btn btn-primary single disabled" onclick="$.operate.edit()">
                <i class="fa fa-edit"></i> 修改
            </a>
            <a class="btn btn-danger multiple disabled" onclick="$.operate.removeAll()">
                <i class="fa fa-remove"></i> 删除
            </a>
            <a class="btn btn-warning" onclick="$.table.exportExcel()">
                <i class="fa fa-download"></i> 导出
            </a>
        </div>

        <div class="col-sm-12 select-table table-striped">
            <table id="bootstrap-table"></table>
        </div>
    </div>
</div>

@include("admin.include.footer")

<script>
    var editFlag = true;
    var removeFlag = true;
    var prefix = ctx + "system/role";

    $(function() {
        var options = {
            url: prefix + "/list",
            createUrl: prefix + "/add",
            updateUrl: prefix + "/edit/{id}",
            removeUrl: prefix + "/remove",
            exportUrl: prefix + "/export",
            sortName: "role_sort",
            modalName: "角色",
            columns: [{
                checkbox: true
            },
                {
                    field: 'role_id',
                    title: '角色编号'
                },
                {
                    field: 'role_name',
                    title: '角色名称',
                    sortable: true
                },
                {
                    field: 'role_key',
                    title: '权限字符',
                    sortable: true
                },
                {
                    field: 'role_sort',
                    title: '显示顺序',
                    sortable: true
                },
                {
                    visible: editFlag == 'hidden' ? false : true,
                    title: '角色状态',
                    align: 'center',
                    formatter: function (value, row, index) {
                        return statusTools(row);
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
                        if (row.roleId != 1) {
                            var actions = [];
                            actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.role_id + '\')"><i class="fa fa-edit"></i>编辑</a> ');
                            actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.role_id + '\')"><i class="fa fa-remove"></i>删除</a> ');
                            var more = [];
                            more.push("<a class='btn btn-default btn-xs " + editFlag + "' href='javascript:void(0)' onclick='authDataScope(" + row.role_id + ")'><i class='fa fa-check-square-o'></i>数据权限</a> ");
                            more.push("<a class='btn btn-default btn-xs " + editFlag + "' href='javascript:void(0)' onclick='authUser(" + row.role_id + ")'><i class='fa fa-user'></i>分配用户</a>");
                            actions.push('<a tabindex="0" class="btn btn-info btn-xs" role="button" data-container="body" data-placement="left" data-toggle="popover" data-html="true" data-trigger="hover" data-content="' + more.join('') + '"><i class="fa fa-chevron-circle-right"></i>更多操作</a>');
                            return actions.join('');
                        } else {
                            return "";
                        }
                    }
                }]
        };
        $.table.init(options);
    });

    /* 角色管理-分配数据权限 */
    function authDataScope(roleId) {
        var url = prefix + '/authDataScope/' + roleId;
        $.modal.open("分配数据权限", url);
    }

    /* 角色管理-分配用户 */
    function authUser(roleId) {
        var url = prefix + '/authUser/' + roleId;
        $.modal.openTab("分配用户", url);
    }

    /* 角色状态显示 */
    function statusTools(row) {
        if (row.status == 1) {
            return '<i class=\"fa fa-toggle-off text-info fa-2x\" onclick="enable(\'' + row.role_id + '\')"></i> ';
        } else {
            return '<i class=\"fa fa-toggle-on text-info fa-2x\" onclick="disable(\'' + row.role_id + '\')"></i> ';
        }
    }

    /* 角色管理-停用 */
    function disable(roleId) {
        $.modal.confirm("确认要停用角色吗？", function() {
            $.operate.post(prefix + "/changeStatus", { "roleId": roleId, "status": 1 });
        })
    }

    /* 角色管理启用 */
    function enable(roleId) {
        $.modal.confirm("确认要启用角色吗？", function() {
            $.operate.post(prefix + "/changeStatus", { "roleId": roleId, "status": 0 });
        })
    }
</script>
</body>
</html>
