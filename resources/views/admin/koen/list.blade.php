@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('koen.title.list'))

@section('content_header')
    <p class="h4">{{ __('koen.header.list') }}</p>
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
                <th>講演受付番号</th>
                <th>講演者名</th>
                @foreach ($headers as $header)
                    {{-- DBで一覧表示対象になっている項目名を表示 --}}
                    <th>{{ $header->label_ja_clean }}</th>
                @endforeach
                <th>発表番号</th>
                <th>ファイルDL</th>
                <th>更新日</th>
                <th>参加者ID</th>
            </tr>
            {{-- カラム別検索欄 --}}
            <tr class="column-search">
                <th><input type="text" class="form-control form-control-sm" placeholder="講演受付番号"></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="講演者名"></th>
                @foreach ($headers as $header)
                    {{-- DBで一覧表示対象になっている項目名を表示 --}}
                    <th>
                        <input type="text" class="form-control form-control-sm" placeholder="{{ $header->label_ja_clean }}">
                    </th>
                @endforeach
                <th><input type="text" class="form-control form-control-sm" placeholder="発表番号"></th>
                <th><input type="text" class="form-control form-control-sm" disabled ></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="更新日" ></th>
                <th><input type="text" class="form-control form-control-sm" placeholder="参加者ID" ></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($lists as $koen)
                <tr>
                    <td >
                        <div class="d-flex">
                        <a href="{{ route('koen.list.edit', $koen->id) }}"
                            class=" btn btn-primary btn-sm">
                                編集
                        </a>
                        <form
                            method="POST"
                            action="{{ route('koen.list.destroy', $koen->id) }}"
                            class="ml-1"
                            onsubmit="return confirm('削除してよろしいですか？');"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class=" btn btn-danger btn-sm">
                                削除
                            </button>
                        </form>
                        </div>
                    </td>

                    {{-- 講演受付番号 --}}
                    <td>{{ $koen->koen_number }}</td>
                    <td>
                        {{ $koen->participant?->add_column_1 }}
                        {{ $koen->participant?->add_column_2 }}
                    </td>

                    {{-- DB設定による可変項目 --}}
                    @foreach ($headers as $header)
                        @php
                            $value = $koen->{$header->name} ?? null;
                            $option = $header->options->firstWhere('value', (string) $value);
                        @endphp
                        <td>
                            {{ $option?->label_ja ?? strip_tags($value ?? '') }}
                        </td>
                    @endforeach

                    {{-- 発表番号 --}}
                    <td>{{ $koen->announcenumber }}</td>
                    <td class=" justify-content-center">
                        @if($koen->uploadfile1)
                            <a class="btn btn-success  btn-sm" href="{{ route('koen.download', [$koen->id, 'uploadfile1']) }}" >予行原稿</a>
                        @endif
                        @if($koen->uploadfile2)
                            <a class="btn btn-success ml-1  btn-sm" href="{{ route('koen.download', [$koen->id, 'uploadfile2']) }}">ﾌﾗｯｼｭ</a>
                        @endif
                        @if($koen->uploadfile3)
                            <a class="btn btn-success ml-1  btn-sm" href="{{ route('koen.download', [$koen->id, 'uploadfile3']) }}">ﾎﾟｽﾀ-</a>
                        @endif
                    </td>
                    <td>{{ $koen->updated_at }}</td>
                    <td>
                        <a href="{{ route('sanka.list.edit',[$koen->participant?->id ?? '']) }}">
                        {{ $koen->participant?->reception_number ?? '' }}
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $headers->count() + 3 }}" class="text-center">
                        講演情報はありません。
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
