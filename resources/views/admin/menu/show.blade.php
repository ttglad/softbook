<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '菜单列表'])
</head>
<body class="gray-bg">
    <div class="container-div">
		<div class="row">
			<div class="col-sm-12 search-collapse">
				<form id="menu-form">
					<div class="select-list">
						<ul>
							<li>
								菜单名称：<input type="text" name="menuName"/>
							</li>
							<li>
								菜单状态：<select name="visible">
									<option value="">所有</option>
                                    @foreach($sysShowList as $type)
                                        <option value="{{ $type->dict_value }}">{{ $type->dict_label }}</option>
                                    @endforeach
								</select>
							</li>
							<li>
								<a class="btn btn-primary btn-rounded btn-sm" onclick="$.treeTable.search()"><i class="fa fa-search"></i>&nbsp;搜索</a>
								<a class="btn btn-warning btn-rounded btn-sm" onclick="$.form.reset()"><i class="fa fa-refresh"></i>&nbsp;重置</a>
							</li>
						</ul>
					</div>
				</form>
			</div>

            <div class="btn-group-sm" id="toolbar" role="group">
		        <a class="btn btn-success" onclick="$.operate.add(0)">
                    <i class="fa fa-plus"></i> 新增
                </a>
                <a class="btn btn-primary" onclick="$.operate.edit()">
		            <i class="fa fa-edit"></i> 修改
		        </a>
                <a class="btn btn-info" id="expandAllBtn">
                    <i class="fa fa-exchange"></i> 展开/折叠
                </a>
	        </div>
       		 <div class="col-sm-12 select-table table-striped">
	            <table id="bootstrap-tree-table"></table>
	        </div>
	    </div>
	</div>

    @include("admin.include.footer")

	<script>
		// var addFlag = [[${@permission.hasPermi('system:menu:add')}]];
		// var editFlag = [[${@permission.hasPermi('system:menu:edit')}]];
		// var removeFlag = [[${@permission.hasPermi('system:menu:remove')}]];
		// var datas = [[${@dict.getType('sys_show_hide')}]];
        var addFlag = true;
        var editFlag = true;
        var removeFlag = true;
        var datas = @json($sysShowList);
		var prefix = ctx + "system/menu";

		$(function() {
		    var options = {
		        code: "menu_id",
		        parentCode: "parent_id",
		        uniqueId: "menu_id",
		        expandAll: false,
		        expandFirst: false,
		        url: prefix + "/list",
		        createUrl: prefix + "/add/{id}",
		        updateUrl: prefix + "/edit/{id}",
		        removeUrl: prefix + "/remove/{id}",
		        modalName: "菜单",
		        columns: [{
                    field: 'selectItem',
                    radio: true
                 },
                 {
		            title: '菜单名称',
		            field: 'menu_name',
		            width: '20',
		            widthUnit: '%',
		            formatter: function(value, row, index) {
		                if ($.common.isEmpty(row.icon)) {
		                    return row.menu_name;
		                } else {
		                    return '<i class="' + row.icon + '"></i> <span class="nav-label">' + row.menu_name + '</span>';
		                }
		            }
		        },
		        {
		            field: 'order_num',
		            title: '排序',
		            width: '10',
		            widthUnit: '%',
		            align: "left"
		        },
		        {
		            field: 'url',
		            title: '请求地址',
		            width: '15',
		            widthUnit: '%',
		            align: "left",
		            formatter: function(value, row, index) {
                    	return $.table.tooltip(value);
                    }
		        },
		        {
		            title: '类型',
		            field: 'menu_type',
		            width: '10',
		            widthUnit: '%',
		            align: "left",
		            formatter: function(value, item, index) {
		                if (item.menu_type == 'M') {
		                    return '<span class="label label-success">目录</span>';
		                }
		                else if (item.menu_type == 'C') {
		                    return '<span class="label label-primary">菜单</span>';
		                }
		                else if (item.menu_type == 'F') {
		                    return '<span class="label label-warning">按钮</span>';
		                }
		            }
		        },
		        {
		            field: 'visible',
		            title: '可见',
		            width: '10',
		            widthUnit: '%',
		            align: "left",
		            formatter: function(value, row, index) {
		            	if (row.menu_type == 'F') {
		                    return '-';
		                }
		            	return $.table.selectDictLabel(datas, row.visible);
		            }
		        },
		        {
		            field: 'perms',
		            title: '权限标识',
		            width: '15',
		            widthUnit: '%',
		            align: "left",
		            formatter: function(value, row, index) {
                    	return $.table.tooltip(value);
                    }
		        },
		        {
		            title: '操作',
		            width: '20',
		            widthUnit: '%',
		            align: "left",
		            formatter: function(value, row, index) {
		                var actions = [];
		                actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.menu_id + '\')"><i class="fa fa-edit"></i>编辑</a> ');
		                actions.push('<a class="btn btn-info btn-xs ' + addFlag + '" href="javascript:void(0)" onclick="$.operate.add(\'' + row.menu_id + '\')"><i class="fa fa-plus"></i>新增</a> ');
		                actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.menu_id + '\')"><i class="fa fa-trash"></i>删除</a>');
		                return actions.join('');
		            }
		        }]
		    };
		    $.treeTable.init(options);
		});
	</script>
</body>
</html>
