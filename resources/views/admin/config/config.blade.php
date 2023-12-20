<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '参数列表'])
</head>
<body class="gray-bg">
<div class="container-div">
    <div class="row">
        <div class="col-sm-12 search-collapse">
            <form id="config-form">
                <div class="select-list">
                    <ul>
                        <li>
                            参数名称：<input type="text" name="config_name"/>
                        </li>
                        <li>
                            参数键名：<input type="text" name="config_key"/>
                        </li>
                        <li>
                            系统内置：<select name="config_type">
                                <option value="">所有</option>
                                @foreach($sysYesNo as $item)
                                    <option value="{{ $item->dict_value }}">{{ $item->dict_label }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="select-time">
                            <label>创建时间： </label>
                            <input type="text" class="time-input" id="startTime" placeholder="开始时间" name="params[beginTime]"/>
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
            <a class="btn btn-danger" onclick="refreshCache()">
                <i class="fa fa-refresh"></i> 刷新缓存
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
    var datas = @json($sysYesNo);
    var prefix = ctx + "system/config";

    $(function() {
        var options = {
            url: prefix + "/list",
            createUrl: prefix + "/add",
            updateUrl: prefix + "/edit/{id}",
            removeUrl: prefix + "/remove",
            exportUrl: prefix + "/export",
            sortName: "config_id",
            sortOrder: "asc",
            modalName: "参数",
            columns: [{
                checkbox: true
            },
                {
                    field: 'config_id',
                    title: '参数主键'
                },
                {
                    field: 'config_name',
                    title: '参数名称',
                    formatter: function(value, row, index) {
                        return $.table.tooltip(value);
                    }
                },
                {
                    field: 'config_key',
                    title: '参数键名',
                    formatter: function(value, row, index) {
                        return $.table.tooltip(value);
                    }
                },
                {
                    field: 'config_value',
                    title: '参数键值'
                },
                {
                    field: 'config_type',
                    title: '系统内置',
                    align: 'center',
                    formatter: function(value, row, index) {
                        return $.table.selectDictLabel(datas, value);
                    }
                },
                {
                    field: 'remark',
                    title: '备注',
                    align: 'center',
                    formatter: function(value, row, index) {
                        return $.table.tooltip(value, 10, "open");
                    }
                },
                {
                    field: 'create_time',
                    title: '创建时间'
                },
                {
                    title: '操作',
                    align: 'center',
                    formatter: function(value, row, index) {
                        var actions = [];
                        actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.config_id + '\')"><i class="fa fa-edit"></i>编辑</a> ');
                        actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.config_id + '\')"><i class="fa fa-remove"></i>删除</a>');
                        return actions.join('');
                    }
                }]
        };
        $.table.init(options);
    });

    /** 刷新参数缓存 */
    function refreshCache() {
        $.operate.get(prefix + "/refreshCache");
    }
</script>
</body>
</html>
