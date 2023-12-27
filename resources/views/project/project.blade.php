<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '项目列表'])
</head>
<body class="gray-bg">
<div class="container-div">
    <div class="row">
        <div class="col-sm-12 search-collapse">
            <form id="data-form">
                <div class="select-list">
                    <ul>
                        <li>
                            项目名称：<input type="text" name="projectTitle"/>
                        </li>
                        <li>
                            项目状态：<select name="status">
                                <option value="">所有</option>
                                @foreach($sysNormalDisable as $normalDisable)
                                    <option
                                        value="{{ $normalDisable->dict_value }}">{{ $normalDisable->dict_label }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <a class="btn btn-primary btn-rounded btn-sm" onclick="$.table.search()"><i
                                    class="fa fa-search"></i>&nbsp;搜索</a>
                            <a class="btn btn-warning btn-rounded btn-sm" onclick="resetPre()"><i
                                    class="fa fa-refresh"></i>&nbsp;重置</a>
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
    var menuFlag = true;
    var datas = @json($sysNormalDisable);
    var prefix = ctx + "project";

    $(function () {
        var options = {
            url: prefix + "/list",
            createUrl: prefix + "/add",
            updateUrl: prefix + "/edit/{id}",
            removeUrl: prefix + "/remove",
            uniqueId: "project_id",
            sortName: "create_time",
            sortOrder: "desc",
            modalName: "项目列表",
            columns: [
                {
                    checkbox: true
                },
                {
                    field: 'project_title',
                    title: '项目名称'
                },
                {
                    field: 'project_name',
                    title: '项目简称'
                },
                {
                    field: 'project_code',
                    title: '项目编码'
                },
                {
                    field: 'project_author',
                    title: '项目作者'
                },
                {
                    field: 'project_sector',
                    title: '软件行业'
                },
                {
                    field: 'code_line',
                    title: '程序量'
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
                    field: 'create_time',
                    title: '创建时间',
                    sortable: true
                },
                {
                    title: '操作',
                    align: 'center',
                    formatter: function (value, row, index) {
                        var actions = [];
                        actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="preview(\'' + row.project_id + '\')"><i class="fa fa-file-image-o"></i>预览</a> ');
                        actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.project_id + '\')"><i class="fa fa-edit"></i>编辑</a> ');
                        actions.push('<a class="btn btn-info btn-xs ' + menuFlag + '" href="javascript:void(0)" onclick="menu(\'' + row.project_id + '\')"><i class="fa fa-list-ul"></i>菜单</a> ');
                        actions.push('<a class="btn btn-info btn-xs ' + menuFlag + '" href="javascript:void(0)" onclick="getCode(\'' + row.project_id + '\')"><i class="fa fa-download"></i>下载</a> ');
                        actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.project_id + '\')"><i class="fa fa-remove"></i>删除</a>');
                        return actions.join('');
                    }
                }]
        };
        $.table.init(options);
    });

    // 菜单管理
    function preview(projectId) {
        var url = prefix + '/login/' + projectId;
        window.open(url);
    }

    // 菜单管理
    function menu(projectId) {
        var url = prefix + '/menu/' + projectId;
        $.modal.openTab("项目菜单", url);
    }

    // 菜单管理
    function getCode(projectId) {
        var url = prefix + '/download/' + projectId;
        window.open(url);
    }
</script>
</body>
</html>
