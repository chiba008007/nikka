@props([
    'id',
    'pageTops',
    'isAdmin' => false,
    'rows' => 4,
    'editorClass' => 'description',
])

@if($isAdmin)
    <div>
        <textarea
            rows="{{ $rows }}"
            class="form-control {{ $editorClass }} w-100"
            id="edit-{{ $id }}"
        >{{ $pageTops[$id - 1]->note ?? '' }}</textarea>
        <button type="button"
                class="btn btn-warning btn-sm editbtn"
                id="t-{{ $id }}">編集</button>
    </div>
@endif
