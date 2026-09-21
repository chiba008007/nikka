@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.list'))

@section('content_header')
    <p class="h4">{{ __('sanka.header.list') }}</p>
@stop

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="table-responsive">
    <table id="participant-table" class="table table-bordered table-striped" >
        <thead>
            <tr>
                <th rowspan="2" class="text-center align-middle">詳細</th>
                @foreach ($headers as $header)
                    {{-- DBで一覧表示対象になっている項目名を表示 --}}
                    <th>{{ $header->label_ja }}</th>
                @endforeach
                <th>参加種別</th>
                <th>懇親会参加</th>
                <th>参加費用</th>
                <th>懇親会費</th>
                <th>支払(参加費)</th>
                <th>支払(懇親会費)</th>
                <th>更新時間</th>
                <th>講演受付番号</th>
            </tr>
            {{-- カラム別検索欄 --}}
            <tr class="column-search">
                @foreach ($headers as $header)
                    {{-- DBで一覧表示対象になっている項目名を表示 --}}
                    <th>
                        <input type="text" class="form-control form-control-sm" placeholder="{{ $header->label_ja }}">
                    </th>
                @endforeach
                <th><input type="text" class="form-control form-control-sm" placeholder="参加種別"></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="懇親会参加"></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="参加費用"></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="懇親会費"></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="支払(参加費)"></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="支払(懇親会費)"></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="更新時間"></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="講演受付番号"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lists as $participant)
                <tr>
                    <td class="d-flex">
                        <a href="{{ route('sanka.list.edit', $participant->id) }}"
                            class="form-control btn btn-primary">
                                編集
                        </a>
                        <form
                            method="POST"
                            action="{{ route('sanka.list.destroy', $participant->id) }}"
                            class="ml-2"
                            onsubmit="return confirm('削除してよろしいですか？');"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="form-control btn btn-danger">
                                削除
                            </button>
                        </form>

                    </td>
                    @foreach ($headers as $header)
                        <td>
                            {{ $displayValues[$participant->id][$header->name] ?? '' }}
                        </td>
                    @endforeach
                    <td>{{ $displayValues[$participant->id]['participation_type'] ?? '' }}</td>
                    <td>{{ $displayValues[$participant->id]['banquet_type'] ?? '' }}</td>
                    @php
                        $participationAmount = $displayValues[$participant->id]['participation_amount'] ?? '';
                        $participationSearch = str_replace([',', '円'], '', $participationAmount);
                        $banquetAmount = $displayValues[$participant->id]['banquet_amount'] ?? '';
                        $banquetSearch = str_replace([',', '円'], '', $banquetAmount);
                    @endphp
                    <td data-search="{{ $participationSearch }} {{ $participationAmount }}">
                        {{ $participationAmount }}円
                    </td>
                    <td data-search="{{ $banquetSearch }} {{ $banquetAmount }}">
                        {{ $banquetAmount }}円
                    </td>
                    <td>
                        <label class="mb-0">
                            <input
                                type="checkbox"
                                class="payment-status-checkbox"
                                data-url="{{ route('sanka.payment-status.update', $participant->id) }}"
                                data-payment-type="participation"
                                {{ (int) $participant->participation_payment_status
                                    === (int) config('const.payment_status.paid.value')
                                        ? 'checked'
                                        : '' }}
                            >

                            <span class="payment-status-label">
                                {{ $displayValues[$participant->id]['participation_payment_status'] ?? '' }}
                            </span>
                        </label>
                    </td>
                    <td>
                        <label class="mb-0">
                            <input
                                type="checkbox"
                                class="payment-status-checkbox"
                                data-url="{{ route('sanka.payment-status.update', $participant->id) }}"
                                data-payment-type="banquet"
                                {{ (int) $participant->banquet_payment_status
                                    === (int) config('const.payment_status.paid.value')
                                        ? 'checked'
                                        : '' }}
                            >

                            <span class="payment-status-label">
                                {{ $displayValues[$participant->id]['banquet_payment_status'] ?? '' }}
                            </span>
                        </label>
                    </td>
                    <td>
                       {{ $participant->updated_at }}
                    </td>
                    <td>No</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $headers->count() }}" class="text-center">
                        参加者情報はありません。
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@stop

@section('css')
<style>
    /* テーブルを横スクロール可能にする */
    .table-responsive {
        overflow-x: auto;
    }

    /* 通常列の幅を固定 */
    #participant-table th,
    #participant-table td {
        width: 220px;
        min-width: 220px;
        max-width: 220px;
        white-space: nowrap;
    }

    /* 詳細列だけ幅を変更 */
    #participant-table th:first-child,
    #participant-table td:first-child {
        width: 160px;
        min-width: 160px;
        max-width: 160px;
    }

    /* ヘッダーとセルを改行させない */
    #participant-table th,
    #participant-table td {
        white-space: nowrap;
    }
    .dataTables_scrollHead thead tr:first-child th:first-child::before,
    .dataTables_scrollHead thead tr:first-child th:first-child::after {
        display: none !important;
        content: none !important;
    }

    .dataTables_scrollHead thead tr:first-child th:first-child {
        background-image: none !important;
    }
</style>

@stop
@section('js')
<script>
$(function () {
    const table = $('#participant-table').DataTable({
        // 全体検索欄を非表示にする
        searching: true,
        dom: 'lrtip',
        pageLength: 50,
        orderCellsTop: true,
        scrollY: '200px',
        scrollX: true,
        scrollCollapse: true,
        autoWidth: false,
    });

    // カラム別検索
    $('.dataTables_scrollHead .column-search input').on('keyup change', function () {
        const columnIndex = $(this).closest('th').index()+1;

        table
            .column(columnIndex)
            .search(this.value)
            .draw();
    });

    // テーブル高さを画面サイズに合わせる
    function resizeTable() {
        const $scrollBody = $('.dataTables_scrollBody');

        // テーブル本体の上位置を取得する
        const tableTop = $scrollBody.offset().top;

        // info・ページャー分の高さを確保する
        const footerHeight =
            $('.dataTables_info').outerHeight(true) +
            $('.dataTables_paginate').outerHeight(true) +
            30;

        // 画面内に収まる高さを計算する
        const height = Math.max(
            window.innerHeight - tableTop - footerHeight,
            200
        );

        // テーブル本体だけ高さを変更する
        $scrollBody.css({
            height: height + 'px',
            maxHeight: height + 'px'
        });

        // 列幅を再調整する
        table.columns.adjust();
    }

    // 初回表示時に高さ調整する
    resizeTable();

    // ブラウザサイズ変更時にも高さ調整する
    $(window).on('resize', resizeTable);

    $(document).on('change', '.payment-status-checkbox', function () {
    const $checkbox = $(this);
    const $label = $checkbox
        .closest('label')
        .find('.payment-status-label');

    const isPaid = $checkbox.prop('checked');

    // 通信中の連打防止
    $checkbox.prop('disabled', true);

    $.ajax({
        url: $checkbox.data('url'),
        type: 'PATCH',
        data: {
            _token: '{{ csrf_token() }}',
            payment_type: $checkbox.data('payment-type'),
            is_paid: isPaid ? 1 : 0,
        },
        success: function (response) {
            $label.text(response.label);
        },
        error: function () {
            // DB更新失敗時はチェック状態を元に戻す
            $checkbox.prop('checked', !isPaid);

            alert('支払ステータスの更新に失敗しました。');
        },
        complete: function () {
            $checkbox.prop('disabled', false);
        }
    });
});
});
</script>
@stop
