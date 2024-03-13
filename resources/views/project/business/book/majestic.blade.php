<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- plugins:css -->
    <link rel="stylesheet" href="/majestic/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/majestic/vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="/majestic/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/majestic/css/style.css">
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center">
            <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                <a class="navbar-brand brand-logo"></a>
                <a class="navbar-brand brand-logo-mini"></a>
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-sort-variant"></span>
                </button>
            </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav mr-lg-4 w-100">
                <li class="nav-item d-none d-lg-block w-100" style="color:#000000">
                    <h3>{{ $project->project_title }}</h3>
                </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item dropdown me-1">
                    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
                        <i class="mdi mdi-message-text mx-0"></i>
                        <span class="count"></span>
                    </a>
                </li>
                <li class="nav-item dropdown me-4">
                    <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                        <i class="mdi mdi-bell mx-0"></i>
                        <span class="count"></span>
                    </a>
                </li>
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                        <img src="{{ $headerImage }}" alt="profile"/>
                        <span class="nav-profile-name">{{ $adminName }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <a class="dropdown-item">
                            <i class="mdi mdi-settings text-primary"></i>
                            个人中心
                        </a>
                        <a class="dropdown-item">
                            <i class="mdi mdi-logout text-primary"></i>
                            退出
                        </a>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="mdi mdi-home menu-icon"></i>
                        <span class="menu-title">系统首页</span>
                    </a>
                </li>
                @foreach($menus as $firstMenu)
                    <li class="nav-item @isset($firstMenu['check']) active @endisset">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic-{{ $firstMenu['menu_id'] }}"
                           @isset($firstMenu['check']) aria-expanded="true" @else aria-expanded="false" @endisset"
                        aria-controls="ui-basic">
                            <span class="icon-bg">
                                @if (!empty($firstMenu['icon']))
                                    <i class="mdi {{ $firstMenu['icon'] }} menu-icon"></i>
                                @else
                                    <i class="mdi mdi-menu menu-icon"></i>
                                @endif
                            </span>
                            <span class="menu-title">{{ $firstMenu['menu_name'] }}</span>
                            @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                                <i class="menu-arrow"></i>
                            @endif
                        </a>
                        @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                            <div class="collapse" id="ui-basic-{{ $firstMenu['menu_id'] }}">
                                <ul class="nav flex-column sub-menu">
                                    @foreach($firstMenu['children'] as $secondMenu)
                                        <li class="nav-item">
                                            <a href="/project/book/{{ $secondMenu['menu_id'] }}"
                                               class="nav-link {{ $secondMenu['class'] }} @if(empty($secondMenu['target'])) menuItem @else {{ $secondMenu['target'] }} @endif"
                                               data-href="{{ $secondMenu['url'] }}">
                                                {{ $secondMenu['menu_name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">

                @if(in_array($business->data_type, ['chart-01', 'chart-02', 'chart-03']))
                    @include('project.business.chart.connect-plus-' . $business->data_type, compact('business', 'businessColumn'))
                @else
                    @include('project.business.list.majestic', compact('business', 'businessColumn'))
                @endif

            </div>
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{ date('Y') }}</span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="/majestic/vendors/base/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<script src="/majestic/vendors/chart.js/Chart.min.js"></script>
<script src="/majestic/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/majestic/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="/majestic/js/off-canvas.js"></script>
<script src="/majestic/js/hoverable-collapse.js"></script>
<script src="/majestic/js/template.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="/majestic/js/dashboard.js"></script>
<script src="/majestic/js/data-table.js"></script>
<script src="/majestic/js/jquery.dataTables.js"></script>
<script src="/majestic/js/dataTables.bootstrap4.js"></script>
<!-- End custom js for this page-->

<script src="/majestic/js/jquery.cookie.js" type="text/javascript"></script>
<script src="/static/softbook/js/home.js?v={{ rand(1,2) . 'laravel-dump-server' . rand(0, 20) . '.'.rand(0,20) }}"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<!-- End custom js for this page -->

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
                <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
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
</body>

</html>
