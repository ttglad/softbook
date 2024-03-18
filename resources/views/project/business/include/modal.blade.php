<!-- 新增弹框 开始 -->
<div class="modal fade" id="project-add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">新增 <span>{{ $business->menu_name }}</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach($businessColumn as $column)
                    @if($column->is_list == 1)
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">{{ $column->dict_name }}:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control project-add-input"
                                       name="{{ $column->dict_value }}" value="测试{{ $column->dict_name }}">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <a class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    取消
                </a>
                <a class="btn btn-primary ms-auto project-add-submit">
                    新增
                </a>
            </div>
        </div>
    </div>
</div>
<!-- 新增弹框 结束 -->
<!-- 编辑弹框 开始 -->
<div class="modal fade" id="project-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">编辑 <span>{{ $business->menu_name }}</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach($businessColumn as $column)
                    @if($column->is_list == 1)
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label">{{ $column->dict_name }}:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control project-edit-input"
                                       name="{{ $column->dict_value }}" value="">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <a class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    取消
                </a>
                <a class="btn btn-primary ms-auto project-edit-submit">
                    编辑
                </a>
            </div>
        </div>
    </div>
</div>
<!-- 编辑弹框 结束 -->
<!-- 失败弹框 -->
<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24"
                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M12 9v2m0 4v.01"></path>
                    <path
                        d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75"></path>
                </svg>
                <div class="text-muted">确定要删除选中记录</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a class="btn btn-white w-100" data-bs-dismiss="modal">
                                取消
                            </a>
                        </div>
                        <div class="col">
                            <a class="btn btn-danger w-100 project-delete-submit" data-bs-dismiss="modal">
                                删除
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 失败弹框 -->

<script>
    $(function () {

        // 定义弹框方法
        const bootAlert = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div id="alert-div" class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            $('.mainContent').prepend(wrapper);

            setTimeout(function () {
                $("#alert-div").alert('close');
            }, 1500);
        }

        // 选中全部
        $('.checkbox-all').off('click').on('click', function () {
            if ($(this).is(":checked")) {
                $('input.form-check-input').prop("checked", true);
            } else {
                $('input.form-check-input').prop("checked", false);
            }
        });


        // 新增提交
        $('#project-add .project-add-submit').off('click').on('click', function () {

            var that = $(this);
            var param = {};
            $('#project-add .project-add-input').each(function () {
                param[$(this).attr('name')] = $(this).val();
            });

            // ajax 请求页面内容
            $.ajax({
                cache: true,
                type: "POST",
                url: '/project/business/' + {{ $business->menu_id }} + '/add',
                data: param,
                async: true,
                error: function (request) {
                    bootAlert('请求失败', 'danger');
                },
                success: function (data) {
                    bootAlert('操作成功', 'success');
                    if (data.html) {
                        if ($("tr.data-empty").length > 0) {
                            $("tr.data-empty").remove();
                        }
                        $('tbody').prepend(data.html);
                    }
                },
                complete: function () {
                    $('#project-add').modal('hide');
                }
            });

        });

        // 编辑按钮点击
        $("#business-table").on('click', '.project-edit', function () {
            var that = $(this);
            var id = that.parents('tr').attr('data-id');
            $.ajax({
                cache: true,
                type: "GET",
                url: '/project/business/' + {{ $business->menu_id }} + '/detail/' + id,
                data: {},
                async: true,
                error: function (request) {
                    bootAlert('请求失败', 'danger');
                },
                success: function (data) {
                    // console.log(data);
                    for (var key in data) {
                        if ($('#project-edit input[name=' + key + ']') != null) {
                            $('#project-edit input[name=' + key + ']').val(data[key]);
                        }
                    }
                    $('#project-edit').modal('show');

                    // 修改提交
                    $('#project-edit .project-edit-submit').off('click').on('click', function () {

                        var that = $(this);
                        var param = {};
                        $('#project-edit .project-edit-input').each(function () {
                            param[$(this).attr('name')] = $(this).val();
                        });

                        // ajax 请求页面内容
                        $.ajax({
                            cache: true,
                            type: "POST",
                            url: '/project/business/' + {{ $business->menu_id }} + '/edit/' + id,
                            data: param,
                            async: true,
                            error: function (request) {
                                bootAlert('请求失败', 'danger');
                            },
                            success: function (data) {
                                // bootAlert('操作成功', 'success');
                            },
                            complete: function () {
                                $('#project-edit').modal('hide');
                            }
                        });

                    });
                },
                complete: function () {

                }
            });
        });

        // 删除按钮点击
        $("#business-table").on('click', '.project-delete', function () {
            var that = $(this);
            var id = that.parents('tr').attr('data-id');

            $('#modal-delete').modal('show');

            // 修改提交
            $('#modal-delete .project-delete-submit').off('click').on('click', function () {

                // ajax 请求页面内容
                $.ajax({
                    cache: true,
                    type: "POST",
                    url: '/project/business/' + {{ $business->menu_id }} + '/remove',
                    data: {"ids": id},
                    async: true,
                    error: function (request) {
                        bootAlert('请求失败', 'danger');
                    },
                    success: function (data) {
                        bootAlert('操作成功', 'success');
                        that.parents('tr').remove();
                    },
                    complete: function () {
                        $('#modal-delete').modal('hide');
                    }
                });

            });
        });
    });
</script>
