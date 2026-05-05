@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.list'))

@section('content_header')
    <h1>{{ __('sanka.header.list') }}</h1>
@stop

@section('content')
    <table id="sankaFormTable" class="table table-bordered table-hover dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>グループ</th>
                <th>項目名</th>
                <th>ラベル</th>
                <th>タイプ</th>
                <th>選択肢</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->group_key }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->label_ja }}</td>
                    <td>{{ $item->type }}</td>
                    <td>
                        @foreach ($item->options as $option)
                            <div>{{ $option->label_ja }}</div>
                        @endforeach
                    </td>
                    <td class="d-flex gap-1">
                        <a href="{{ route('sanka.form.edit', $item->id) }}" class="btn btn-sm btn-primary">編集</a>

                        <form action="{{ route('sanka.form.delete', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm ml-1 btn-danger">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@stop
@section('js')
<script>
$(function () {
    let table = $('#sankaFormTable').DataTable({
        dom: '<"row mb-2"<"col-sm-6"l><"col-sm-6"f>>' +
             '<"row mb-2"<"col-sm-12"p>>' +
             'rt' +
             '<"row mt-2"<"col-sm-12"i>>',
        language: {
            lengthMenu: "_MENU_ 件表示",
            zeroRecords: "データが見つかりません",
            info: "_TOTAL_ 件中 _START_ 〜 _END_ 件",
            infoEmpty: "0 件",
            infoFiltered: "(全 _MAX_ 件から抽出)",
            search: "検索:",
            paginate: {
                first: "先頭",
                last: "最後",
                next: "次へ",
                previous: "前へ"
            }
        }
    });
    $('#custom-length').append($('.dataTables_length'));
    $('#custom-search').append($('.dataTables_filter'));
});
</script>
@stop
