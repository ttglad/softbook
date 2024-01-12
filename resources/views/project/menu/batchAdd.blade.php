<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '一键新增菜单'])
</head>
<body>
<div class="main-content">
    <form id="form-user-add" class="form-horizontal">
        <h4 class="form-header h4">菜单信息</h4>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">一级目录 1：</label>
                    <div class="col-sm-8">
                        <input name="menus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 1.1：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 1.1 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 1.2：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 1.2 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">一级目录 2：</label>
                    <div class="col-sm-8">
                        <input name="menus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 2.1：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 2.1 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 2.2：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 2.2 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">一级目录 3：</label>
                    <div class="col-sm-8">
                        <input name="menus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 3.1：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 3.1 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 3.2：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 3.2 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">一级目录 4：</label>
                    <div class="col-sm-8">
                        <input name="menus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 4.1：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 4.1 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 4.2：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 4.2 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-4 control-label is-required">一级目录 5：</label>
                    <div class="col-sm-8">
                        <input name="menus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 5.1：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 5.1 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 5.2：</label>
                    <div class="col-sm-7">
                        <input name="childMenus[]" placeholder="请输入目录名称" class="form-control" type="text"
                               required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <div class="form-group">
                    <label class="col-sm-5 control-label is-required">二级目录 5.2 字段：</label>
                    <div class="col-sm-7">
                        <textarea name="childKeys[]" placeholder="目录字段不少于5个，使用|分割，例如 名称|编号|性别|年龄|状态" maxlength="100" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@include("admin.include.footer")

<script>
    var prefix = ctx + "project/menu/{{ $project->project_id }}";

    function submitHandler() {
        var data = $("#form-user-add").serializeArray();
        $.operate.save(prefix + "/batchAdd", data);
    }

</script>
</body>
</html>
