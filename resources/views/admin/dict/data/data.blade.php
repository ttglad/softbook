<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '字典类型列表'])
    <link href="/static/ajax/libs/select2/select2.min.css?v=4.0.13" rel="stylesheet"/>
    <link href="/static/ajax/libs/select2/select2-bootstrap.min.css?v=4.0.13" rel="stylesheet"/>
</head>
<body class="gray-bg">
	<div class="container-div">
		<div class="row">
			<div class="col-sm-12 search-collapse">
				<form id="data-form">
					<div class="select-list">
						<ul>
						    <li>
								字典名称：<select id="dictType" name="dictType" class="form-control">
                                    @foreach($dictTypes as $dictType)
                                        <option value="{{ $dictType->dict_type }}" @if($dictTypeId == $dictType->dict_id) selected @endif>{{ $dictType->dict_name }}</option>
                                    @endforeach
								</select>
							</li>
							<li>
								字典标签：<input type="text" name="dictLabel"/>
							</li>
							<li>
								数据状态：<select name="status">
                                    <option value="">所有</option>
                                    @foreach($sysNormalDisable as $normalDisable)
                                        <option
                                            value="{{ $normalDisable->dict_value }}">{{ $normalDisable->dict_label }}</option>
                                    @endforeach
                                </select>
							</li>
							<li>
								<a class="btn btn-primary btn-rounded btn-sm" onclick="$.table.search()"><i class="fa fa-search"></i>&nbsp;搜索</a>
							    <a class="btn btn-warning btn-rounded btn-sm" onclick="resetPre()"><i class="fa fa-refresh"></i>&nbsp;重置</a>
							</li>
						</ul>
					</div>
				</form>
			</div>

	       <div class="btn-group-sm" id="toolbar" role="group">
	            <a class="btn btn-success" onclick="add()">
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
		        <a class="btn btn-danger" onclick="closeItem()">
		            <i class="fa fa-reply-all"></i> 关闭
		        </a>
	        </div>

	        <div class="col-sm-12 select-table table-striped">
			    <table id="bootstrap-table"></table>
			</div>
		</div>
	</div>

    @include("admin.include.footer")
    <script src="/static/ajax/libs/select2/select2.min.js?v=4.0.13"></script>

	<script>
		var editFlag = true;
		var removeFlag = true;
		var datas = @json($sysNormalDisable);
		var prefix = ctx + "system/dict/data";

		$(function() {
			var options = {
				url: prefix + "/list",
				createUrl: prefix + "/add/{id}",
				updateUrl: prefix + "/edit/{id}",
				removeUrl: prefix + "/remove",
				exportUrl: prefix + "/export",
				queryParams: queryParams,
				sortName: "dictSort",
		        sortOrder: "asc",
				modalName: "数据",
				columns: [{
						checkbox: true
					},
					{
						field: 'dict_code',
						title: '字典编码'
					},
					{
						field: 'dict_label',
						title: '字典标签',
						formatter: function(value, row, index) {
							var listClass = $.common.equals("default", row.listClass) || $.common.isEmpty(row.listClass) ? "" : "badge badge-" + row.listClass;
	                    	return $.common.sprintf("<span class='%s'>%s</span>", listClass, value);
						}
					},
					{
						field: 'dict_value',
						title: '字典键值'
					},
					{
						field: 'dict_sort',
						title: '字典排序'
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
						title: '备注'
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
							actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.edit(\'' + row.dict_code + '\')"><i class="fa fa-edit"></i>编辑</a> ');
							actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.dict_code + '\')"><i class="fa fa-remove"></i>删除</a>');
							return actions.join('');
						}
					}]
				};
			$.table.init(options);
		});

		function queryParams(params) {
			var search = $.table.queryParams(params);
			search.dictType = $("#dictType").val();
			return search;
		}

		/*字典数据-新增字典*/
		function add() {
		    var dictType = $("#dictType option:selected").val();
		    $.operate.add(dictType);
		}

		function resetPre() {
			$.form.reset();
			$("#dictType").val($("#dictType").val()).trigger("change");
		}
	</script>
</body>
</html>
