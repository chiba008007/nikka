@props([
    'id',
    'pageTops',
    'width' => 'w-75',
    'isAdmin' => false,
])

@if($isAdmin)
    <div class="d-flex">
        <input
            type="text"
            value="{{ $pageTops->firstWhere('num', $id)->note ?? '' }}"
            class="form-control {{ $width }}"
            id="edit-{{ $id }}"
        />
        <button
            type="button"
            class="btn btn-warning btn-sm editbtn"
            id="t-{{ $id }}">
            編集
        </button>
    </div>
@endif
