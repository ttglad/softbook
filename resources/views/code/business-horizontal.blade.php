<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ $project->project_title }} - {{ $business->menu_name }}@if(!empty($project->project_author)) - {{ $project->project_author }}@endif</title>
    <link href="/{{ $project->project_code }}/css/business-horizontal.min.css?v={{ rand(1, 2) }}.{{ rand(0, 9) }}.{{rand(0, 9)}}" rel="stylesheet"/>
</head>
<body>
<div class="page">
    <!-- Navbar -->
    <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                {{ $project->project_name }}
            </h1>
            <div class="navbar-nav flex-row order-md-last">
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
    </header>
    <div class="page-wrapper">
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
</div><script src="/{{$project->project_code}}/js/business.min.js?v={{ rand(1,2) . '.' . rand(0, 20) . '.'.rand(0,20) }}" defer></script>
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
</body>
</html>
