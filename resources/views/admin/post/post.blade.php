<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '岗位列表'])
</head>
<body class="gray-bg">
<div class="container-div">
    <div class="row">
        <div class="col-sm-12 search-collapse">
            <form id="post-form">
                <div class="select-list">
                    <ul>
                        <li>
                            岗位编码：<input type="text" name="postCode"/>
                        </li>
                        <li>
                            岗位名称：<input type="text" name="postName"/>
                        </li>
                        <li>
                            岗位状态：<select name="status" th:with="type=${@dict.getType('sys_normal_disable')}">
                                <option value="">所有</option>
                                <option th:each="dict : ${type}" th:text="${dict.dictLabel}"
                                        th:value="${dict.dictValue}"></option>
                            </select>
                        </li>
                        <li>
                            <a class="btn btn-primary btn-rounded btn-sm" onclick="$.table.search()"><i
                                    class="fa fa-search"></i>&nbsp;搜索</a>
                            <a class="btn btn-warning btn-rounded btn-sm" onclick="$.form.reset()"><i
                                    class="fa fa-refresh"></i>&nbsp;重置</a>
                        </li>
                    </ul>
                </div>
            </form>
        </div>

        <div class="btn-group-sm" id="toolbar" role="group">
            <a class="btn btn-success" onclick="$.operate.add()" shiro:hasPermission="system:post:add">
                <i class="fa fa-plus"></i> 新增
            </a>
            <a class="btn btn-primary single disabled" onclick="$.operate.edit()"
               shiro:hasPermission="system:post:edit">
                <i class="fa fa-edit"></i> 修改
            </a>
            <a class="btn btn-danger multiple disabled" onclick="$.operate.removeAll()"
               shiro:hasPermission="system:post:remove">
                <i class="fa fa-remove"></i> 删除
            </a>
            <a class="btn btn-warning" onclick="$.table.exportExcel()" shiro:hasPermission="system:post:export">
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
    var datas = @json($sysNormalDisable);
    var prefix = ctx + "system/post";

    $(function () {
        var options = {
            url: prefix + "/list",
            createUrl: prefix + "/add",
            updateUrl: prefix + "/edit/{id}",
            removeUrl: prefix + "/remove",
            exportUrl: prefix + "/export",
            sortName: "postSort",
            modalName: "岗位",
            columns: [{
                checkbox: true
            },
                {
                    field: 'postId',
                    title: '岗位编号'
                },
                {
                    field: 'postCode',
                    title: '岗位编码',
                    sortable: true
                },
                {
                    field: 'postName',
                    title: '岗位名称',
                    sortable: true
                },
                {
                    field: 'postSort',
                    title: '显示顺序',
                    sortable: true
                },
                {
                    field: 'status',
                    title: '状态',
                    align: 'center',
                    formatter: function (value, row, index) {
                        return $.table.selectDictLabel(datas, value);
                    }
                },
                {
                    field: 'createTime',
                    title: '创建时间',
                    sortable: true
                },
                {
                    title: '操作',
                    align: 'center',
                    formatter: function (value, row, index) {
                        var actions = [];
                        actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.postId + '\')"><i class="fa fa-edit"></i>编辑</a> ');
                        actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.postId + '\')"><i class="fa fa-remove"></i>删除</a>');
                        return actions.join('');
                    }
                }]
        };
        $.table.init(options);
    });
</script>
</body>
</html>
