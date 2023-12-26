<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '项目字典列表'])
</head>
<body class="gray-bg">
	<div class="container-div">
		<div class="row">
			<div class="col-sm-12 search-collapse">
				<form id="data-form">
					<div class="select-list">
						<ul>
							<li>
								字典名称：<input type="text" name="dictName"/>
							</li>
                            <li>
                                字典代码：<input type="text" name="dictValue"/>
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
	        </div>

	        <div class="col-sm-12 select-table table-striped">
			    <table id="bootstrap-table"></table>
			</div>
		</div>
	</div>

    @include("admin.include.footer")

	<script>
		var editFlag = true;
		var prefix = ctx + "project/dict";

		$(function() {
			var options = {
				url: prefix + "/list",
				createUrl: prefix + "/add",
				updateUrl: prefix + "/edit/{id}",
				sortName: "dict_id",
		        sortOrder: "desc",
				modalName: "字典列表",
				columns: [{
						checkbox: true
					},
                    {
                        field: 'dict_id',
                        title: '字典ID'
                    },
					{
						field: 'dict_name',
						title: '字典名称'
					},
                    {
                        field: 'dict_value',
                        title: '字典值'
                    },
					{
						title: '操作',
						align: 'center',
						formatter: function(value, row, index) {
							var actions = [];
							actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.dict_id + '\')"><i class="fa fa-edit"></i>编辑</a> ');
							return actions.join('');
						}
					}]
				};
			$.table.init(options);
		});
	</script>
</body>
</html>
