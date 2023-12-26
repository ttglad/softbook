<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '代码生成列表'])
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
							<li class="select-time">
								<label>表时间： </label>
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
                <a class="btn btn-success multiple disabled" onclick="batchGenCode()">
			        <i class="fa fa-download"></i> 生成
			    </a>
				<a class="btn btn-success" onclick="createTable()">
					<i class="fa fa-plus"></i> 创建
				</a>
				<a class="btn btn-info" onclick="importTable()">
			        <i class="fa fa-upload"></i> 导入
			    </a>
			    <a class="btn btn-primary single disabled" onclick="$.operate.editTab()">
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

    <script src="/static/ajax/libs/bootstrap-table/extensions/export/bootstrap-table-export.js?v=1.18.3"></script>
    <script src="/static/ajax/libs/bootstrap-table/extensions/export/tableExport.min.js?v=1.10.24"></script>
	<script src="/static/ajax/libs/highlight/highlight.min.js"></script>

	<script>
		var prefix = ctx + "tool/gen";
		// var editFlag = [[${@permission.hasPermi('tool:gen:edit')}]];
		// var removeFlag = [[${@permission.hasPermi('tool:gen:remove')}]];
		// var previewFlag = [[${@permission.hasPermi('tool:gen:preview')}]];
		// var codeFlag = [[${@permission.hasPermi('tool:gen:code')}]];

        var editFlag = true;
        var removeFlag = true;
        var previewFlag = true;
        var codeFlag = true;

		$(function() {
		    var options = {
		        url: prefix + "/list",
		        updateUrl: prefix + "/edit/{id}",
		        removeUrl: prefix + "/remove",
		        sortName: "create_time",
		        sortOrder: "desc",
		        showExport: true,
		        modalName: "生成配置",
		        rememberSelected: true,
		        uniqueId: "table_id",
		        columns: [{
		        	field: 'state',
		            checkbox: true
		        },
		        {
		            field: 'table_id',
		            title: '编号',
		            visible: false
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
		            sortable: true,
		            formatter: function(value, row, index) {
                    	return $.table.tooltip(value);
                    }
		        },
		        {
		            field: 'table_comment',
		            title: '表描述',
		            sortable: true,
		            formatter: function(value, row, index) {
                    	return $.table.tooltip(value, 15);
                    }
		        },
		        {
		            field: 'class_name',
		            title: '实体类名称',
		            sortable: true
		        },
		        {
		            field: 'create_time',
		            title: '创建时间',
		            sortable: true
		        },
		        {
		            field: 'update_time',
		            title: '更新时间',
		            sortable: true
		        },
		        {
		            title: '操作',
		            align: 'center',
		            formatter: function(value, row, index) {
		                var actions = [];
		                actions.push('<a class="btn btn-info btn-xs ' + previewFlag + '" href="javascript:void(0)" onclick="preview(\'' + row.table_id + '\')"><i class="fa fa-search"></i>预览</a> ');
		                actions.push('<a class="btn btn-success btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="$.operate.editTab(\'' + row.table_id + '\')"><i class="fa fa-edit"></i>编辑</a> ');
		                actions.push('<a class="btn btn-danger btn-xs ' + removeFlag + '" href="javascript:void(0)" onclick="$.operate.remove(\'' + row.table_id + '\')"><i class="fa fa-remove"></i>删除</a> ');
		                actions.push('<a class="btn btn-warning btn-xs ' + editFlag + '" href="javascript:void(0)" onclick="synchDb(\'' + row.table_name + '\')"><i class="fa fa-refresh"></i>同步</a> ');
		                actions.push('<a class="btn btn-primary btn-xs ' + codeFlag + '" href="javascript:void(0)" onclick="genCode(\'' + row.table_name + '\',\'' + row.gen_type + '\')"><i class="fa fa-bug"></i>生成代码</a> ');
		                return actions.join('');
		            }
		        }]
		    };
		    $.table.init(options);
		});

		// 预览代码
		function preview(table_id) {
			var preViewUrl = prefix + "/preview/" + table_id;
			$.modal.loading("正在加载数据，请稍候...");
			$.get(preViewUrl, function(result) {
				if (result.code == web_status.SUCCESS) {
					 var items = [];
		                $.each(result.data, function(index, value) {
		                    var templateName = index.substring(index.lastIndexOf("/") + 1, index.length).replace(/\.vm/g, "");
		                    if(!$.common.equals("sql", templateName) && !$.common.equals("tree.html", templateName) && !$.common.equals("sub-domain.java", templateName)){
		                        var codeName = templateName.replace(".", "");
		                        var language = templateName.substring(templateName.lastIndexOf(".") + 1);
		                        var highCode = hljs.highlight(language, value).value;
		                        items.push({
		                            title: templateName , content: "<pre class=\"layui-code\"><a style=\"float:right\" href=\"javascript:copyText('" + codeName + "')\"><i class=\"fa fa-copy\"></i> 复制</a><code id=\"" + codeName + "\">" + highCode + "</code></pre><textarea id=\"t_" + codeName + "\" style='position: absolute;top: 0;left: 0;opacity: 0;z-index: -10;'></textarea><script>function copyText(codeName){var text = document.getElementById(codeName).innerText;var input = document.getElementById(\"t_\"+codeName);input.value = text;input.select();document.execCommand(\"copy\");$.modal.msgSuccess(\"复制成功\");}<\/script>"
		                        })
		                    }
		                });
		                top.layer.tab({
                            area: ['90%', '90%'],
                            shadeClose: true,
                            success: function(layero, index){
                                parent.loadCss(ctx + "ajax/libs/highlight/default.min.css");
                            },
	                        tab: items
		                });
				} else {
					$.modal.alertError(result.msg);
				}
				$.modal.closeLoading();
			});
		}

		// 生成代码
		function genCode(table_name, genType) {
		    $.modal.confirm("确定要生成" + table_name + "表代码吗？", function() {
		    	if(genType === "0") {
			    	location.href = prefix + "/download/" + table_name;
			        layer.msg('执行成功,正在生成代码请稍候…', { icon: 1 });
				} else if(genType === "1") {
					$.operate.get(prefix + "/genCode/" + table_name);
				}
		    })
		}

		// 同步数据库
		function synchDb(table_name){
			$.modal.confirm("确认要强制同步" + table_name + "表结构吗？", function() {
			    $.operate.get(prefix + "/synchDb/" + table_name);
			})
		}

		// 批量生成代码
		function batchGenCode() {
		    var rows = $.table.selectColumns("table_name");
		    if (rows.length == 0) {
		        $.modal.alertWarning("请选择要生成的数据");
		        return;
		    }
		    $.modal.confirm("确认要生成选中的" + rows.length + "条数据吗?", function() {
		    	// location.href = prefix + "/batchGenCode?tables=" + rows;
		        // layer.msg('执行成功,正在生成代码请稍候…', { icon: 1 });
                $.ajax({
                    type: "get",
                    url: prefix + "/batchGenCode?tables=" + rows,
                    success: function(r) {
                        if (r.code == web_status.SUCCESS) {

                        } else {
                            $.modal.msg(r.message);
                        }
                    }
                });
		    });
		}

		// 导入表结构
		function importTable() {
			var importTableUrl = prefix + "/importTable";
			$.modal.open("导入表结构", importTableUrl);
		}

		// 创建表结构
		function createTable() {
			var creatTableUrl = prefix + "/createTable";
			$.modal.open("创建表结构", creatTableUrl);
		}
	</script>
</body>
</html>
