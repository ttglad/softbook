<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ $business->remark }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $project->project_title }} - {{ $business->menu_name }}@if(!empty($project->project_author)) - {{ $project->project_author }}@endif</title>
    <link href="/{{ $project->project_code }}/css/home.min.css?v={{ rand(1, 2) }}.{{ rand(0, 9) }}.{{rand(0, 9)}}" rel="stylesheet"/>
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
                                    <label>{{ $column->dict_name }}：</label>
                                    <input type="text" name="{{ $column->dict_value }}"/>
                                </li>
                            @endif
                        @endforeach
                        <li>
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
<script src="/{{ $project->project_code }}/js/home.min.js?v={{ rand(1, 2) }}.{{ rand(0, 20) }}.{{rand(0, 9)}}"></script>

<script>
    var editFlag = true;
    var removeFlag = true;
    var prefix = ctx + "project/business/" + @json($business->menu_id);

    $(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var options = {
            url: prefix + "/list",
            createUrl: prefix + "/add",
            updateUrl: prefix + "/edit/{id}",
            removeUrl: prefix + "/remove",
            exportUrl: prefix + "/export",
            modalName: "{{ $business->menu_name }}",
            columns: [{
                checkbox: true
            }, <?php
               echo "\n";
               foreach ($businessColumn as $column) {
                   if ($column->dict_value == 'id') {
                       echo "            {\n                field:'" . $column->dict_value . "',\n                title:'" . $column->dict_name . "',\n                visible: false\n            },";
                   } else {
                       echo "            {\n                field:'" . $column->dict_value . "',\n                title:'" . $column->dict_name . "'\n            },";
                   }
                   echo "\n";
               }
               ?>            {
                title: '操作',
                align: 'center',
                formatter: function (value, row, index) {
                    var actions = [];
                    actions.push('<a class="soft_edit btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.id + '\')"><i class="fa fa-edit"></i>编辑</a> ');
                    actions.push('<a class="soft_remove btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.id + '\')"><i class="fa fa-remove"></i>删除</a>');
                    return actions.join('');
                }
            }]
        };
        $.table.init(options);
    });
</script>
</body>
</html>
