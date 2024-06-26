<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '菜单树选择'])
    <link href="/static/ajax/libs/jquery-ztree/3.5/css/metro/zTreeStyle.css" rel="stylesheet"/>
</head>
<style>
    body {
        height: auto;
        font-family: "Microsoft YaHei";
    }

    button {
        font-family: "SimSun", "Helvetica Neue", Helvetica, Arial;
    }
</style>
<body class="hold-transition box box-main">
	<input id="treeId"   name="treeId"    type="hidden" value=""/>
	<input id="treeName" name="treeName"  type="hidden" value=""/>
	<div class="wrapper"><div class="treeShowHideButton" onclick="$.tree.toggleSearch();">
		<label id="btnShow" title="显示搜索" style="display:none;">︾</label>
		<label id="btnHide" title="隐藏搜索">︽</label>
	</div>
	<div class="treeSearchInput" id="search">
		<label for="keyword">关键字：</label><input type="text" class="empty" id="keyword" maxlength="50">
		<button class="btn" id="btn" onclick="$.tree.searchNode()"> 搜索 </button>
	</div>
	<div class="treeExpandCollapse">
		<a href="#" onclick="$.tree.expand()">展开</a> /
		<a href="#" onclick="$.tree.collapse()">折叠</a>
	</div>
	<div id="tree" class="ztree treeselect"></div>
	</div>

    @include("admin.include.footer")

    <script src="/static/ajax/libs/jquery-ztree/3.5/js/jquery.ztree.all-3.5.js"></script>

	<script>
		$(function() {
			var url = ctx + "system/menu/menuTreeData";
			var options = {
		        url: url,
		        expandLevel: 1,
		        onClick : zOnClick
		    };
			$.tree.init(options);
		});

		function zOnClick(event, treeId, treeNode) {
		    var treeId = treeNode.id;
		    var treeName = treeNode.name;
		    $("#treeId").val(treeId);
		    $("#treeName").val(treeName);
		}
	</script>
</body>
</html>
