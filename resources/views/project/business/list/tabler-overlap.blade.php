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
                <table id="business-table"
                       class="table table-vcenter table-mobile-md card-table {{ \Illuminate\Support\Arr::random(['', 'table-striped']) }}">
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
