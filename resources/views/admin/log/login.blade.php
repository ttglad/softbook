<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '登录日志列表'])
</head>
<body class="gray-bg">
<div class="container-div">
    <div class="row">
        <div class="col-sm-12 search-collapse">
            <form id="logininfor-form">
                <div class="select-list">
                    <ul>
                        <li>
                            <label>登录地址：</label><input type="text" name="ipaddr"/>
                        </li>
                        <li>
                            <label>登录名称：</label><input type="text" name="loginName"/>
                        </li>
                        <li>
                            <label>登录状态：</label>
                            <select name="status">
                                <option value="">所有</option>
                                @foreach($sysStatus as $normalDisable)
                                    <option value="{{ $normalDisable->dict_value }}">{{ $normalDisable->dict_label }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="select-time">
                            <label>登录时间： </label>
                            <input type="text" class="time-input" id="startTime" placeholder="开始时间"/>
                            <span>-</span>
                            <input type="text" class="time-input" id="endTime" placeholder="结束时间"/>
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

{{--        <div class="btn-group-sm" id="toolbar" role="group">--}}
{{--            <a class="btn btn-primary single disabled" onclick="unlock()">--}}
{{--                <i class="fa fa-unlock"></i> 解锁--}}
{{--            </a>--}}
{{--            <a class="btn btn-warning" onclick="$.table.exportExcel()">--}}
{{--                <i class="fa fa-download"></i> 导出--}}
{{--            </a>--}}
{{--        </div>--}}

        <div class="col-sm-12 select-table table-striped">
            <table id="bootstrap-table"></table>
        </div>
    </div>
</div>

@include("admin.include.footer")

<script>
    var datas = @json($sysStatus);
    var prefix = ctx + "log/login";

    $(function () {
        var options = {
            url: prefix + "/list",
            // cleanUrl: prefix + "/clean",
            // removeUrl: prefix + "/remove",
            // exportUrl: prefix + "/export",
            queryParams: queryParams,
            sortName: "login_id",
            sortOrder: "desc",
            modalName: "登录日志",
            escape: true,
            showPageGo: true,
            rememberSelected: true,
            columns: [{
                field: 'state',
                checkbox: true
            },
                {
                    field: 'login_id',
                    title: '访问编号'
                },
                {
                    field: 'login_name',
                    title: '登录名称',
                    sortable: true
                },
                {
                    field: 'ip_addr',
                    title: '登录地址',
                    formatter: function (value, row, index) {
                        return $.table.tooltip(value);
                    }
                },
                {
                    field: 'user_agent',
                    title: '客户agent'
                },
                {
                    field: 'status',
                    title: '登录状态',
                    align: 'center',
                    formatter: function (value, row, index) {
                        return $.table.selectDictLabel(datas, value);
                    }
                },
                {
                    field: 'msg',
                    title: '操作信息'
                },
                {
                    field: 'login_time',
                    title: '登录时间',
                    sortable: true
                }]
        };
        $.table.init(options);
    });

    function queryParams(params) {
        var search = $.table.queryParams(params);
        search.params = {
            beginTime: beginOfTime($("#startTime").val()),
            endTime: endOfTime($("#endTime").val())
        };
        return search;
    }

</script>
</body>
</html>
