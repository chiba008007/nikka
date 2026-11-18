
@extends('adminlte::page')

@section('plugins.Datatables', true)
@section('title', '講演情報変更履歴')

@section('content_header')
    <p class="h4">講演情報変更履歴</p>
@stop

@section('content')
<div class="table-responsive">
    <div class="alert alert-info py-2 mb-3">
        ・赤字／太字：直前の履歴から変更された項目<br>
        ・通常文字：変更されていない項目<br>
        ・黄色背景：新規登録時の履歴<br>
        ・長い値は省略表示されます。マウスを乗せると全文を確認できます。
    </div>

    <table id="history-table"
           class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>講演受付番号</th>
                <th>発表番号</th>
                <th>講演者名</th>
                <th>操作</th>

                @foreach ($historyColumns as $column)
                    <th>{{ $column['label'] }}</th>
                @endforeach

                <th>著者</th>
                <th>所属機関</th>
                <th>操作日時</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($historyRows as $history)
                <tr class="{{ $history['is_insert'] ? 'history-insert' : '' }}">
                    <td>{{ $history['koen_number'] }}</td>
                    <td>{{ $history['announcenumber'] ?? '' }}</td>
                    <td>{{ $history['participant_name'] ?? '' }}</td>
                    <td>
                        @switch($history['operation'])
                            @case('INSERT')
                                新規登録
                                @break
                            @case('UPDATE')
                                更新
                                @break
                            @case('DELETE')
                                削除
                                @break
                            @case('HARD_DELETE')
                                物理削除
                                @break
                            @default
                                {{ $history['operation'] }}
                        @endswitch
                    </td>

                    @foreach ($historyColumns as $column)
                        @php
                            $isChanged = in_array(
                                $column['name'],
                                $history['changed_columns'],
                                true
                            );

                            $value = $history['values'][$column['name']] ?? '';
                        @endphp

                        <td class="{{ $isChanged ? 'history-changed' : '' }}">
                            <div class="history-cell"
                                 data-toggle="tooltip"
                                 data-placement="top"
                                 title="{{ $value }}">
                                {{ $value }}
                            </div>
                        </td>
                    @endforeach

                    <td class="{{ !empty($history['authors_changed']) ? 'history-changed' : '' }}">
                        @foreach ($history['authors'] ?? [] as $author)
                            <div>{{ $author->author_number }}. {{ $author->family_name_ja }} {{ $author->given_name_ja }}</div>
                        @endforeach
                    </td>
                    <td class="{{ !empty($history['affiliations_changed']) ? 'history-changed' : '' }}">
                        @foreach ($history['affiliations'] ?? [] as $affiliation)
                            <div>{{ $affiliation->affiliation_number }}. {{ $affiliation->organization }} {{ $affiliation->department }}</div>
                        @endforeach
                    </td>

                    <td>{{ $history['operated_at'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($historyColumns) + 3 }}"
                        class="text-center">
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

    #history-table th,
    #history-table td {
        min-width: 180px;
        white-space: nowrap;
        vertical-align: middle;
    }

    #history-table th:nth-child(2),
    #history-table td:nth-child(2) {
        min-width: 90px;
    }

    .history-cell {
        display: block;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    #history-table td.history-changed {
        color: #dc3545;
        font-weight: bold;
        background-color: #fff3f3;
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
    const table = $('#history-table').DataTable({
        searching: true,
        dom: 'lrtip',
        pageLength: 50,
        scrollY: '200px',
        scrollX: true,
        scrollCollapse: true,
        autoWidth: false,
        order: [],
    });

    // 講演受付番号の検索欄
    const $search = $('<input>', {
        type: 'text',
        class: 'form-control form-control-sm mb-3',
        placeholder: '講演受付番号で検索'
    });

    $('#history-table_wrapper').before($search);

    $search.on('keyup change', function () {
        table.column(0).search(this.value).draw();
    });

    $('body').tooltip({
        selector: '[data-toggle="tooltip"]',
        container: 'body'
    });

    function resizeTable() {
        const $scrollBody = $('.dataTables_scrollBody');

        if (!$scrollBody.length) return;

        const tableTop = $scrollBody.offset().top;
        const footerHeight =
            ($('.dataTables_info').outerHeight(true) || 0) +
            ($('.dataTables_paginate').outerHeight(true) || 0) + 30;

        const height = Math.max(
            window.innerHeight - tableTop - footerHeight,
            200
        );

        $scrollBody.css({
            height: height + 'px',
            maxHeight: height + 'px'
        });

        table.columns.adjust();
    }

    resizeTable();
    $(window).on('resize', resizeTable);
});
</script>
@stop
