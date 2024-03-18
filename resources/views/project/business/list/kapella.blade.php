<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#project-add" id="button-project-add">新增
                    </button>
                    <button type="button" class="btn btn-warning project-export">导出</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-1"></div>
    <div class="col-lg-1"></div>
    <div class="col-lg-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="business-table" class="table {{ ['table-striped', 'table-bordered', 'table-dark'][$project->id % 3] }}">
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

    <div class="col-lg-1"></div>
</div>
