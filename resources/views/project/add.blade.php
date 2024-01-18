<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '新增项目'])
</head>
<body>
<div class="main-content">
    <form id="form-user-add" class="form-horizontal">
        <h4 class="form-header h4">基本信息</h4>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">项目名称：</label>
                    <div class="col-sm-8">
                        <input name="projectTitle" placeholder="请输入项目名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">项目简称：</label>
                    <div class="col-sm-8">
                        <input name="projectName" type="text" placeholder="请输入项目简称" class="form-control"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">项目编码：</label>
                    <div class="col-sm-8">
                        <input name="projectCode" placeholder="请输入项目编码" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">所属行业：</label>
                    <div class="col-sm-8">
                        <input name="projectSector" type="text" placeholder="请输入所属行业" class="form-control"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label">项目作者：</label>
                    <div class="col-sm-8">
                        <input name="projectAuthor" placeholder="请输入项目作者" class="form-control" type="text">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">软件版本：</label>
                    <div class="col-sm-8">
                        <input name="projectVersion" type="text" placeholder="请选择软件版本" class="form-control"
                               value="V1.0">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">软件分类：</label>
                    <div class="col-sm-8">
                        <input name="projectCategory" placeholder="请输入软件分类" class="form-control" type="text"
                               value="应用软件">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">程序量：</label>
                    <div class="col-sm-8">
                        <input name="codeLine" type="text" placeholder="请输入程序量" class="form-control"
                               value="{{ $codeLines }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">项目主题背景：</label>
                    <div class="col-sm-8">
                        <input name="skinTheme" placeholder="请输入项目主题背景" class="form-control" type="text">
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">登录页背景图：</label>
                    <div class="col-sm-8">
                        <input name="loginImage" placeholder="请输入登录背景图" class="form-control" type="text">
{{--                        <select name="loginImage" class="form-control m-b">--}}
{{--                            @foreach($loginImages as $image)--}}
{{--                                <option value="{{ $image['value'] }}">{{ $image['name'] }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="row">--}}
{{--            <div class="col-sm-6">--}}
{{--                <div class="form-group">--}}
{{--                    <label class="col-sm-4 control-label">项目状态：</label>--}}
{{--                    <div class="col-sm-8">--}}
{{--                        <label class="toggle-switch switch-solid">--}}
{{--                            <input type="checkbox" id="status" checked>--}}
{{--                            <span></span>--}}
{{--                        </label>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <h4 class="form-header h4">其他信息</h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-xs-2 control-label">开发目的：</label>
                    <div class="col-xs-10">
                        <textarea name="developPurpose" maxlength="500" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-xs-2 control-label">主要功能：</label>
                    <div class="col-xs-10">
                        <textarea name="projectFeature" maxlength="500" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-xs-2 control-label">技术特点：</label>
                    <div class="col-xs-10">
                        <textarea name="projectSkill" maxlength="500" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="col-xs-2 control-label">备注：</label>
                    <div class="col-xs-10">
                        <textarea name="remark" maxlength="500" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@include("admin.include.footer")

<script>
    var prefix = ctx + "project";

    function submitHandler() {
        var data = $("#form-user-add").serializeArray();
        var status = $("input[id='status']").is(':checked') == true ? 0 : 1;
        data.push({"name": "status", "value": status});
        $.operate.save(prefix + "/add", data);
    }

    $("input[name='skinTheme']").focus(function() {
        layer.open({
            type : 2,
            shadeClose : true,
            title : "选择主题",
            area : ["530px", "482px"],
            content : [prefix + "/switchSkin", 'no']
        });
    });

    $("input[name='loginImage']").focus(function() {
        layer.open({
            type : 2,
            shadeClose : true,
            title : "选择背景图",
            area : ["630px", "482px"],
            content : [prefix + "/switchImage", 'no']
        });
    });

    $("input[name='projectName']").on('change', function() {
        var projectName = $(this).val();
        if (projectName) {
            $.operate.post(prefix + "/getProjectCode", {"projectName": projectName}, function (data) {
                if (data.code == 0) {
                    $("input[name='projectCode']").val(data.projectCode);
                }
            });
        }
    });

</script>
</body>
</html>
