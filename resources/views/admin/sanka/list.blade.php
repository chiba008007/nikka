@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.list'))

@section('content_header')
    <p class="h4">{{ __('sanka.header.list') }}</p>
@stop

@section('content')
<div class="table-responsive">
    <table id="participant-table" class="table table-bordered table-striped" >
        <thead>
            <tr>
                @foreach ($headers as $header)
                    {{-- DBで一覧表示対象になっている項目名を表示 --}}
                    <th>{{ $header->label_ja }}</th>
                @endforeach
            </tr>
            {{-- カラム別検索欄 --}}
            <tr class="column-search">
                @foreach ($headers as $header)
                    {{-- DBで一覧表示対象になっている項目名を表示 --}}
                    <th>
                        <input type="text" class="form-control form-control-sm" placeholder="{{ $header->label_ja }}">
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($lists as $participant)
                <tr>
                    @foreach ($headers as $header)
                        {{-- ヘッダーのnameに対応する参加者データを表示する --}}
                        <td>{{ $participant->{$header->name} ?? '' }}</td>
                    @endforeach
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
</div>

@stop

@section('css')
<style>
    /* テーブルを横スクロール可能にする */
    .table-responsive {
        overflow-x: auto;
    }

    /* ヘッダーとセルを改行させない */
    #participant-table th,
    #participant-table td {
        white-space: nowrap;
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
        scrollCollapse: true
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
});
</script>
@stop
