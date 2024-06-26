<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => $business->table_comment])
</head>
<body class="gray-bg">
<div class="container-div">
    <div class="row">
        <div class="col-sm-12 search-collapse">
            <form id="formId">
                <div class="select-list">
                    <ul>@foreach($businessColumn as $column)
                            @if($column->is_query == 1)
                        <li>
                            <label>{{ $column->column_comment }}：</label>
                            <input type="text" name="{{ $column->column_name }}"/>
                        </li>
                            @endif
                        @endforeach<li>
                            <a class="btn btn-primary btn-rounded btn-sm" onclick="$.table.search()">
                                <i class="fa fa-search"></i>&nbsp;搜索
                            </a>
                            <a class="btn btn-warning btn-rounded btn-sm" onclick="$.form.reset()">
                                <i class="fa fa-refresh"></i>&nbsp;重置
                            </a>
                        </li>
                    </ul>
                </div>
            </form>
        </div>

        <div class="btn-group-sm" id="toolbar" role="group">
            <a class="btn btn-success" onclick="$.operate.add()">
                <i class="fa fa-plus"></i> 添加
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
    var prefix = ctx + "business/" + @json($business->table_name);

    $(function () {
        var options = {
            url: prefix + "/list",
            createUrl: prefix + "/add",
            updateUrl: prefix + "/edit/{id}",
            removeUrl: prefix + "/remove",
            exportUrl: prefix + "/export",
            modalName: "{{ $business->table_comment }}",
            columns: [{
                checkbox: true
            }, <?php
               echo "\n";
               foreach ($businessColumn as $column) {
                   if ($column->column_name == 'id') {
                       echo "            {\n                field:'" . $column->column_name . "',\n                title:'" . $column->column_comment . "',\n                visible: false\n            },";
                   } else {
                       echo "            {\n                field:'" . $column->column_name . "',\n                title:'" . $column->column_comment . "'\n            },";
                   }
                   echo "\n";
               }
               ?>            {
                title: '操作',
                align: 'center',
                formatter: function (value, row, index) {
                    var actions = [];
                    actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.id + '\')"><i class="fa fa-edit"></i>编辑</a> ');
                    actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.id + '\')"><i class="fa fa-remove"></i>删除</a>');
                    return actions.join('');
                }
            }]
        };
        $.table.init(options);
    });
</script>
</body>
</html>
