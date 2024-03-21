<div class="az-content-body pd-lg-l-40 d-flex flex-column">
    <h2 class="az-content-title">{{ $business->menu_name }}</h2>

    <div class="az-content-label mg-b-5">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#project-add" id="button-project-add">新增
        </button>
        <button type="button" class="btn btn-warning project-export">导出</button>
    </div>

    <div class="ht-40"></div>

    <div class="table-responsive" id="business-table">
        <table class="table table-striped table-bordered mg-b-0">
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
                        <td class="">
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
    </div><!-- table-responsive -->

    <div class="ht-40"></div>

    <div class="az-footer mg-t-auto">
        <div class="container">
            <span
                class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © {{ date('Y') }}</span>
        </div><!-- container -->
    </div><!-- az-footer -->
</div>
