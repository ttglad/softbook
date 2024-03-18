<div class="row">
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
                <div class="search-field d-none d-xl-block">
                    <form class="d-flex align-items-center h-100" action="#">
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                            </div>
                            <input type="text" class="form-control border-0" placeholder="搜索{{ $business->menu_name }}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-0">
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table mb-0 {{ ['table-striped', 'table-bordered', 'table-dark'][$project->id % 3] }}" id="business-table">
                    <thead>
                    <tr>
                        <th><input type="checkbox"></th>
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
                                    <input type="checkbox">
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
                @include("project.business.include.page")
            @endif
        </div>
    </div>
</div>
