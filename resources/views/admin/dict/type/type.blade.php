<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '字典类型列表'])
</head>
<body class="gray-bg">
	<div class="container-div">
		<div class="row">
			<div class="col-sm-12 search-collapse">
				<form id="type-form">
					<div class="select-list">
						<ul>
							<li>
								字典名称：<input type="text" name="dictName"/>
							</li>
							<li>
								字典类型：<input type="text" name="dictType"/>
							</li>
							<li>
								字典状态：<select name="status">
                                    <option value="">所有</option>
                                    @foreach($sysNormalDisable as $normalDisable)
                                        <option value="{{ $normalDisable->dict_value }}">{{ $normalDisable->dict_label }}</option>
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
	        </div>

	        <div class="col-sm-12 select-table table-striped">
			    <table id="bootstrap-table"></table>
			</div>
		</div>
	</div>

    @include("admin.include.footer")

	<script>
		var editFlag = true;
		var listFlag = true;
		var removeFlag = true;
		var datas = @json($sysNormalDisable);
		var prefix = ctx + "system/dict";

		$(function() {
		    var options = {
		        url: prefix + "/list",
		        createUrl: prefix + "/add",
		        updateUrl: prefix + "/edit/{id}",
		        removeUrl: prefix + "/remove",
		        exportUrl: prefix + "/export",
		        sortName: "dict_id",
		        sortOrder: "asc",
		        modalName: "类型",
		        columns: [{
		            checkbox: true
		        },
		        {
		            field: 'dict_id',
		            title: '字典主键'
		        },
		        {
		            field: 'dict_name',
		            title: '字典名称',
		            sortable: true
		        },
		        {
		            field: 'dict_type',
		            title: '字典类型',
		            sortable: true,
		            formatter: function(value, row, index) {
		                return '<a href="javascript:void(0)" onclick="detail(\'' + row.dict_id + '\')">' + value + '</a>';
		            }
		        },
		        {
		            field: 'status',
		            title: '状态',
		            align: 'center',
		            formatter: function(value, row, index) {
		            	return $.table.selectDictLabel(datas, value);
		            }
		        },
		        {
		            field: 'remark',
		            title: '备注',
		            formatter: function(value, row, index) {
                        return $.table.tooltip(value);
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
		                actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.dict_id + '\')"><i class="fa fa-edit"></i>编辑</a> ');
		                actions.push('<a class="btn btn-info btn-xs ' + listFlag + '" href="javascript:void(0)" onclick="detail(\'' + row.dict_id + '\')"><i class="fa fa-list-ul"></i>列表</a> ');
		                actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.dict_id + '\')"><i class="fa fa-remove"></i>删除</a>');
		                return actions.join('');
		            }
		        }]
		    };
		    $.table.init(options);
		});

		/*字典列表-详细*/
		function detail(dict_id) {
		    var url = prefix + '/detail/' + dict_id;
		    $.modal.openTab("字典数据", url);
		}
	</script>
</body>
</html>
