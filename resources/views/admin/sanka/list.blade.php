@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.list'))

@section('content_header')
    <p class="h4">{{ __('sanka.header.list') }}</p>
@stop

@section('content')

<table id="participant-table" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>受付番号</th>
            <th>氏名</th>
            <th>所属機関</th>
            <th>メールアドレス</th>
            <th>合計金額</th>
        </tr>
        {{-- カラム別検索欄 --}}
        <tr class="column-search">
            <th><input type="text" class="form-control form-control-sm" placeholder="受付番号"></th>
            <th><input type="text" class="form-control form-control-sm" placeholder="氏名"></th>
            <th><input type="text" class="form-control form-control-sm" placeholder="所属機関"></th>
            <th><input type="text" class="form-control form-control-sm" placeholder="メール"></th>
            <th><input type="text" class="form-control form-control-sm" placeholder="金額"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($lists as $participant)
            <tr>
                <td>{{ $participant->reception_number }}</td>
                <td>
                    {{ $participant->family_name }}
                    {{ $participant->first_name }}
                </td>
                <td>{{ $participant->organization }}</td>
                <td>{{ $participant->email }}</td>
                <td>{{ number_format($participant->total_amount) }}円</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">
                    参加者情報はありません。
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@stop
@section('js')
<script>
$(function () {
    const table = $('#participant-table').DataTable({
        // 全体検索欄を非表示にする
        searching: true,
        dom: 'lrtip',
        pageLength: 50,
        orderCellsTop: true
    });

    // 各カラムの入力値で検索する
    $('#participant-table thead .column-search th').each(function (index) {
        $('input', this).on('keyup change clear', function () {
            if (table.column(index).search() !== this.value) {
                table.column(index).search(this.value).draw();
            }
        });
    });
});
</script>
@stop
