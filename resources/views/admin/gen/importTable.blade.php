<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '导入表结构'])
</head>
<body class="gray-bg">
    <div class="container-div">
		<div class="row">
			<div class="col-sm-12 search-collapse">
				<form id="gen-form">
					<div class="select-list">
						<ul>
							<li>
								表名称：<input type="text" name="tableName"/>
							</li>
							<li>
								表描述：<input type="text" name="tableComment"/>
							</li>
							<li>
								<a class="btn btn-primary btn-rounded btn-sm" onclick="$.table.search()"><i class="fa fa-search"></i>&nbsp;搜索</a>
								<a class="btn btn-warning btn-rounded btn-sm" onclick="$.form.reset()"><i class="fa fa-refresh"></i>&nbsp;重置</a>
							</li>
						</ul>
					</div>
				</form>
			</div>

		    <div class="col-sm-12 select-table table-striped">
			    <table id="bootstrap-table"></table>
			</div>
		</div>
	</div>

    @include("admin.include.footer")

	<script type="text/javascript">
		var prefix = ctx + "tool/gen";

		$(function() {
		    var options = {
		        url: prefix + "/tableLists",
		        showSearch: false,
		        showRefresh: false,
		        showToggle: false,
		        showColumns: false,
		        clickToSelect: true,
		        rememberSelected: true,
		        uniqueId: "table_name",
		        columns: [{
		        	field: 'state',
		            checkbox: true
		        },
		        {
                    title: "序号",
                    formatter: function (value, row, index) {
                 	    return $.table.serialNumber(index);
                    }
                },
		        {
		            field: 'table_name',
		            title: '表名称',
		            formatter: function(value, row, index) {
                    	return $.table.tooltip(value);
                    }
		        },
		        {
		            field: 'table_comment',
		            title: '表描述',
		            formatter: function(value, row, index) {
                    	return $.table.tooltip(value);
                    }
		        },
		        {
		            field: 'create_time',
		            title: '创建时间'
		        },
		        {
		            field: 'update_time',
		            title: '更新时间'
		        }]
		    };
		    $.table.init(options);
		});

		/* 导入表结构-选择表结构-提交 */
		function submitHandler() {
			var rows = $.table.selectColumns("table_name");
			if (rows.length == 0) {
       			$.modal.alertWarning("请至少选择一条记录");
       			return;
       		}
			var data = {"tables": rows.join()};
			$.operate.save(prefix + "/importTable", data);
		}
	</script>
</body>
</html>
