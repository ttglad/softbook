<div class="row">
    <div class="breadcomb-list">
        <div class="row">
            <div class="breadcomb-wp">
                <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#project-add" id="button-project-add">新增
                </button>
                <button type="button" class="btn btn-warning project-export">导出</button>
            </div>
        </div>
    </div>
    <div class="normal-table-list">
        <div class="bsc-tbl">
            <table id="business-table" class="table table-sc-ex {{ ['table-striped', 'table-bordered', 'table-dark'][$project->project_id % 3] }}">
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
            @if(!empty($businessData))
                @include("project.business.include.page")
            @endif
        </div>
    </div>
</div>
