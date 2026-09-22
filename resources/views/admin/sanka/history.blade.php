@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('title', '参加者変更履歴')

@section('content_header')
    <p class="h4">
        参加者変更履歴
    </p>
@stop

@section('content')

<div class="table-responsive">
    <div class="alert alert-info py-2 mb-3">
        ・赤字／太字：直前の履歴から変更された項目<br>
        ・通常文字：変更されていない項目<br>
        ・黄色背景：新規登録時の履歴<br>
        ・長い値は省略表示されます。マウスを乗せると全文を確認できます。
    </div>
    <table
        id="history-table"
        class="table table-bordered table-striped"
    >

        <thead>

            <tr>
                <th>参加受付番号</th>
                <th rowspan="2">操作</th>

                {{-- 有効なadd_columnだけ表示 --}}
                @foreach ($historyColumns as $column)
                    <th rowspan="2">
                        {{ $column['label'] }}
                    </th>
                @endforeach

                <th rowspan="2">参加登録種別</th>
                <th rowspan="2">懇親会参加</th>
                <th rowspan="2">支払(参加費)</th>
                <th rowspan="2">支払(懇親会費)</th>
                <th rowspan="2">操作日時</th>
            </tr>

            <tr class="column-search">

                <th>
                    <input
                        type="text"
                        class="form-control form-control-sm reception-search"
                        placeholder="参加受付番号"
                    >
                </th>
            </tr>

        </thead>


        <tbody>

            @forelse ($historyRows as $history)

                <tr class="{{ $history['is_insert'] ? 'history-insert' : '' }}">

                    <td>
                        {{ $history['reception_number'] }}
                    </td>

                    <td>
                      @switch(strtoupper($history['operation']))
                          @case('INSERT')
                              新規登録
                              @break

                          @case('UPDATE')
                              更新
                              @break

                          @case('DELETE')
                              削除
                              @break

                          @default
                              {{ $history['operation'] }}
                      @endswitch
                  </td>

                    {{-- add_column_1～50 --}}
                    @foreach ($historyColumns as $column)

                        @php
                            $isChanged = in_array(
                                $column['name'],
                                $history['changed_columns'] ?? [],
                                true
                            );

                            $value =
                                $history['values'][$column['name']]
                                ?? '';
                        @endphp

                        <td class="{{ $isChanged ? 'history-changed' : '' }}">
                            <div
                                class="history-cell"
                                data-toggle="tooltip"
                                data-placement="top"
                                title="{{ $value }}"
                            >
                                {{ $value }}
                            </div>
                        </td>

                    @endforeach

                    <td>
                        {{ $history['participation_status'] }}
                    </td>

                    <td>
                        {{ $history['banquet_status'] }}
                    </td>

                    <td>
                        {{ $history['participation_payment_status'] }}
                    </td>

                    <td>
                        {{ $history['banquet_payment_status'] }}
                    </td>

                    <td>
                        {{ $history['operated_at'] }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td
                        colspan="{{ count($historyColumns) + 7 }}"
                        class="text-center"
                    >
                        変更履歴はありません。
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@stop


@section('css')

<style>

    .table-responsive {
        overflow-x: auto;
    }

    #history-table th {
        white-space: nowrap;
        vertical-align: middle;
    }

    #history-table td {
        vertical-align: top;
    }

    /*
    * 長い履歴値
    */
    .table-responsive {
        overflow-x: auto;
      }

    /*
    * 基本は1行表示
    */
    #history-table th,
    #history-table td {
        white-space: nowrap;
        vertical-align: middle;
    }

    /*
    * 通常列
    */
    #history-table th,
    #history-table td {
        min-width: 180px;
    }

    /*
    * 参加受付番号
    */
    #history-table th:first-child,
    #history-table td:first-child {
        min-width: 190px;
    }

    /*
    * 操作
    */
    #history-table th:nth-child(2),
    #history-table td:nth-child(2) {
        min-width: 90px;
    }

    /*
    * 長い値
    */
    .history-cell {
        display: block;

        max-width: 300px;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /*
    * UPDATEで変更されたセル
    */
    #history-table td.history-changed {
        color: #dc3545;
        font-weight: bold;
        background-color: #fff3f3;
    }

    /*
    * INSERT行
    */
    #history-table tr.history-insert td {
        font-weight: bold;
        background-color: #fff3cd;
    }

    /*
    * UPDATEで変更された値
    */
    #history-table td.history-changed {
        color: #dc3545;
        font-weight: bold;
        background-color: #fff3f3;
    }

    /*
    * INSERTされた履歴
    */
    #history-table tr.history-insert td {
        font-weight: bold;
        background-color: #fff8dc;
    }

    /*
    * INSERTの中でも値が入っているセル
    */
    #history-table tr.history-insert td.history-changed {
        color: inherit;
    }

    #history-table tbody tr.history-insert td {
        background-color: #ffe082 !important;
        font-weight: bold;
    }

</style>

@stop


@section('js')
<script>
$(function () {

    /*
     * 最後の列 = 操作日時
     */
    const operatedAtColumn =
        $('#history-table thead tr:first th').length - 1;

    const table = $('#history-table').DataTable({
        searching: true,

        // DataTables標準検索欄を非表示
        dom: 'lrtip',

        pageLength: 50,
        orderCellsTop: true,

        scrollY: '200px',
        scrollX: true,
        scrollCollapse: true,
        autoWidth: false,

        // 操作日時の新しい順
        order: [
            [operatedAtColumn, 'desc']
        ],
    });
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]',
        container: 'body'
    });
    /*
     * 参加受付番号だけを検索
     */
    $('.dataTables_scrollHead .reception-search')
        .on('keyup change', function () {

            table
                .column(0)
                .search(this.value)
                .draw();
        });

    /*
     * ブラウザの高さに合わせる
     */
    function resizeTable() {

        const $scrollBody =
            $('.dataTables_scrollBody');

        if (!$scrollBody.length) {
            return;
        }

        const tableTop =
            $scrollBody.offset().top;

        const footerHeight =
            $('.dataTables_info').outerHeight(true)
            +
            $('.dataTables_paginate').outerHeight(true)
            +
            30;

        const height = Math.max(
            window.innerHeight
                - tableTop
                - footerHeight,
            200
        );

        $scrollBody.css({
            height: height + 'px',
            maxHeight: height + 'px'
        });

        table.columns.adjust();
    }

    /*
     * 初回
     */
    resizeTable();

    /*
     * ブラウザサイズ変更時
     */
    $(window).on(
        'resize',
        resizeTable
    );

});
</script>
@stop
