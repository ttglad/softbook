<tr data-id="{{ $businessData['id'] }}">
    <td class="w-1">
        <input class="form-check-input m-0 align-middle visible-md"
               type="checkbox">
    </td>
    @foreach($businessData as $key => $item)
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
