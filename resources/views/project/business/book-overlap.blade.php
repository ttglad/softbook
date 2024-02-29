<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>系统首页 - {{ $project->project_title }}</title>
    <link href="/tabler/css/tabler.min.css?1668287865" rel="stylesheet"/>
    <link href="/tabler/css/tabler-flags.min.css?1668287865" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
    </style>
</head>
<body>
<div class="page">
    <!-- Navbar -->
    <header class="navbar navbar-expand-md navbar-dark navbar-overlap d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
{{--            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">--}}
{{--                {{ $project->project_name }}--}}
{{--            </h1>--}}
            <div class="navbar-nav flex-row order-md-last">
                <div class="d-none d-md-flex">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                           aria-label="Open user menu">
                            <span class="avatar avatar-sm" style="background-image: url({{ $headerImage }})"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ $adminName }}</div>
                                <div class="mt-1 small text-muted">在线</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a class="dropdown-item">注销</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <i class="ti ti-home"></i>
                                </span>
                                    <span class="nav-link-title">首页</span>
                                </a>
                            </li>
                            @foreach($menus as $firstMenu)
                                <li class="nav-item dropdown @isset($firstMenu['check']) active @endisset">
                                    <a class="nav-link @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0) dropdown-toggle @endif {{ $firstMenu['class'] }}"
                                       href="#" data-bs-toggle="dropdown"
                                       data-bs-auto-close="outside" role="button" aria-expanded="false">
                                        @if (!empty($firstMenu['icon']))
                                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <i class="ti {{ $firstMenu['icon'] }}"></i>
                                        </span>
                                        @endif
                                        <span class="nav-link-title">
                                    {{ $firstMenu['menu_name'] }}
                                    </span>
                                    </a>
                                    @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                                        <div class="dropdown-menu">
                                            <div class="dropdown-menu-columns">
                                                <div class="dropdown-menu-column">
                                                    @foreach($firstMenu['children'] as $secondMenu)
                                                        <a href="/project/book/{{ $secondMenu['menu_id'] }}"
                                                           class="dropdown-item {{ $secondMenu['class'] }} @if(empty($secondMenu['target'])) menuItem @else {{ $secondMenu['target'] }} @endif"
                                                           data-href="{{ $secondMenu['url'] }}">
                                                            {{ $secondMenu['menu_name'] }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="page-wrapper">
        <div class="page-header d-print-none text-white">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            {{ $project->project_title }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl mainContent">
                <div class="row row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $business->menu_name }}</h3>
                            </div>
                            <div class="card-body border-bottom py-3">
                                <div class="d-flex">
                                    <div class="text-muted">
                                        <div class="col-auto ms-auto d-print-none">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#project-add" id="button-project-add">新增
                                            </button>
                                            <button type="button" class="btn btn-warning project-export">导出</button>
                                        </div>
                                    </div>
                                    <div class="ms-auto text-muted">
                                        <div class="ms-2 d-inline-block">
                                            <div class="input-icon">
                                <span class="input-icon-addon">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                       viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                       stroke-linecap="round" stroke-linejoin="round">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                      <circle cx="10" cy="10" r="7"></circle>
                                      <line x1="21" y1="21" x2="15" y2="15"></line>
                                  </svg>
                                </span>
                                                <input type="text" class="form-control"
                                                       placeholder="搜索{{ $business->menu_name }}"
                                                       aria-label="全局搜索">
                                            </div>
                                            {{--                            <input type="text" class="form-control form-control-sm"--}}
                                            {{--                                   aria-label="Search {{ $business->menu_name }}">--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="business-table" class="table table-vcenter table-mobile-md card-table">
                                    <thead>
                                    <tr>
                                        <th class="w-1">
                                            <input class="form-check-input m-0 align-middle checkbox-all"
                                                   type="checkbox"
                                                   aria-label="选中全部">
                                        </th>
                                        @foreach($businessColumn as $column)
                                            <th>{{ $column->dict_name}}</th>
                                        @endforeach
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($businessData))
                                        @foreach($businessData as $data)
                                            <tr data-id="{{ $data['id'] }}">
                                                <td class="w-1">
                                                    <input class="form-check-input m-0 align-middle visible-md"
                                                           type="checkbox">
                                                </td>
                                                @foreach($data as $key => $item)
                                                    @if ($key != 'id')
                                                        <td data-label="{{ $businessColumn[$key]->dict_name }}">
                                                            <div class="text-muted">{{ $item }}</div>
                                                        </td>
                                                    @endif
                                                @endforeach
                                                <td class="text-end">
                                                    <div class="btn-list flex-nowrap">
                                                        <a class="btn btn-secondary project-edit">
                                                            编辑
                                                        </a>
                                                        <a class="btn btn-danger project-delete">
                                                            删除
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="data-empty">
                                            <td colspan="{{ sizeof($businessColumn) + 2 }}" class="text-center">
                                                暂无数据
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            @if(!empty($businessData))
                                <div class="card-footer d-flex align-items-center">
                                    <ul class="pagination m-0 ms-auto">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                     height="24"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <polyline points="15 6 9 12 15 18"/>
                                                </svg>
                                            </a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                     height="24"
                                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <polyline points="9 6 15 12 9 18"/>
                                                </svg>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Copyright &copy; {{ date('Y') }}
                                All rights reserved.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="/tabler/js/tabler.min.js?1668287865" defer></script>

<script src="/static/js/jquery.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script src="/static/js/bootstrap.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script
    src="/static/js/plugins/metisMenu/jquery.metisMenu.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script
    src="/static/js/plugins/slimscroll/jquery.slimscroll.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script src="/static/js/jquery.contextMenu.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script
    src="/static/ajax/libs/blockUI/jquery.blockUI.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>
<script src="/static/ajax/libs/layer/layer.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>

<!-- softbook script -->
<script src="/static/softbook/js/home.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}"></script>


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
