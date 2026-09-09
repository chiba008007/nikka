@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', '参加登録費ページ')

@section('content_header')
    <h1>参加登録費ページ</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('sanka.fee.update') }}">
        {{-- CSRF対策 --}}
        @csrf
        @method('PUT')

        {{-- =========================
             参加登録費
        ========================== --}}
        <div class="card">
            <div class="card-header">
                <strong>参加登録費</strong>
            </div>

            <div class="card-body">

                {{-- 有効 --}}
                <div class="form-group">
                    {{-- 保存 --}}
                    <button type="submit" class="btn btn-primary w-100 mb-3">
                        保存
                    </button>
                    <label>
                        <input
                            type="checkbox"
                            name="registration[status]"
                            value="1"
                            {{ old('registration.status', $feeItem->status ?? 0) ? 'checked' : '' }}
                        >
                        有効
                    </label>
                </div>

                {{-- タイトル --}}
                <div class="form-group">
                    <label>タイトル（日本語 / 英語）</label>

                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="registration[label_ja]"
                                class="form-control"
                                value="{{ old('registration.label_ja', $feeItem->label_ja ?? '') }}"
                            >
                        </div>

                        <div class="col-6">
                            <input
                                type="text"
                                name="registration[label_en]"
                                class="form-control"
                                value="{{ old('registration.label_en', $feeItem->label_en ?? '') }}"
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>エラーメッセージ（日本語 / 英語）</label>

                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="registration[error_message_ja]"
                                class="form-control"
                                value="{{ old('registration.error_message_ja', $feeItem->error_message_ja ?? '') }}"
                            >
                        </div>

                        <div class="col-6">
                            <input
                                type="text"
                                name="registration[error_message_en]"
                                class="form-control"
                                value="{{ old('registration.error_message_en', $feeItem->error_message_en ?? '') }}"
                            >
                        </div>
                    </div>
                </div>
                {{-- 説明文 --}}
                <div class="form-group">
                    <label>説明文（日本語）</label>

                    <textarea
                        id="description_ja"
                        name="registration[description_ja]"
                        class="form-control"
                    >{{ old('registration.description_ja', $feeItem->description_ja ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label>説明文（英語）</label>

                    <textarea
                        id="description_en"
                        name="registration[description_en]"
                        class="form-control"
                    >{{ old('registration.description_en', $feeItem->description_en ?? '') }}</textarea>
                </div>

                {{-- 通貨 --}}
                <div class="form-group">
                    <label>通貨表記（日本語 / 英語）</label>

                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="registration[currency_label_ja]"
                                class="form-control"
                                value="{{ old('registration.currency_label_ja', $feeItem->currency_label_ja ?? '円') }}"
                            >
                        </div>

                        <div class="col-6">
                            <input
                                type="text"
                                name="registration[currency_label_en]"
                                class="form-control"
                                value="{{ old('registration.currency_label_en', $feeItem->currency_label_en ?? 'yen') }}"
                            >
                        </div>
                    </div>
                </div>

                {{-- 参加登録費 --}}
                <div class="form-group">
                    <label>参加区分・金額</label>

                    <div id="fee-options">
                        @foreach ($feeItem->options as $index => $option)
                            <div class="row mb-2 fee-option-row">
                                {{-- option ID --}}
                                <input
                                    type="hidden"
                                    name="registration[options][{{ $index }}][id]"
                                    value="{{ $option->id }}"
                                >

                                {{-- value --}}
                                <input
                                    type="hidden"
                                    name="registration[options][{{ $index }}][value]"
                                    value="{{ $option->value }}"
                                >

                                {{-- 削除フラグ --}}
                                <input
                                    type="hidden"
                                    class="deleted-flag"
                                    name="registration[options][{{ $index }}][deleted]"
                                    value="0"
                                >

                                <div class="col-4">
                                    <input
                                        type="text"
                                        name="registration[options][{{ $index }}][label_ja]"
                                        class="form-control"
                                        value="{{ old('registration.options.' . $index . '.label_ja', $option->label_ja) }}"
                                        placeholder="日本語"
                                    >
                                </div>

                                <div class="col-4">
                                    <input
                                        type="text"
                                        name="registration[options][{{ $index }}][label_en]"
                                        class="form-control"
                                        value="{{ old('registration.options.' . $index . '.label_en', $option->label_en) }}"
                                        placeholder="英語"
                                    >
                                </div>

                                <div class="col-3">
                                    <input
                                        type="number"
                                        name="registration[options][{{ $index }}][amount]"
                                        class="form-control"
                                        value="{{ old('registration.options.' . $index . '.amount', $option->amount) }}"
                                        placeholder="金額"
                                    >
                                </div>

                                <div class="col-1">
                                    <button
                                        type="button"
                                        class="btn btn-danger remove-fee-option"
                                    >
                                        削除
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button
                        type="button"
                        id="add-fee-option"
                        class="btn btn-secondary mt-2"
                    >
                        金額項目を追加
                    </button>
                </div>

            </div>
        </div>

        {{-- =========================
             懇親会費
        ========================== --}}
        <div class="card mt-4">
            <div class="card-header">
                <strong>懇親会費</strong>
            </div>

            <div class="card-body">

                {{-- 有効 --}}
                <div class="form-group">
                    <label>
                        <input
                            type="checkbox"
                            name="banquet[status]"
                            value="1"
                            {{ old('banquet.status', $banquetFee->status ?? 0) ? 'checked' : '' }}
                        >
                        有効
                    </label>
                </div>

                {{-- タイトル --}}
                <div class="form-group">
                    <label>タイトル（日本語 / 英語）</label>

                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="banquet[label_ja]"
                                class="form-control"
                                value="{{ old('banquet.label_ja', $banquetFee->label_ja ?? '') }}"
                            >
                        </div>

                        <div class="col-6">
                            <input
                                type="text"
                                name="banquet[label_en]"
                                class="form-control"
                                value="{{ old('banquet.label_en', $banquetFee->label_en ?? '') }}"
                            >
                        </div>
                    </div>
                </div>

                {{-- 通貨 --}}
                <div class="form-group">
                    <label>通貨表記（日本語 / 英語）</label>

                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="banquet[currency_label_ja]"
                                class="form-control"
                                value="{{ old('banquet.currency_label_ja', $banquetFee->currency_label_ja ?? '円') }}"
                            >
                        </div>

                        <div class="col-6">
                            <input
                                type="text"
                                name="banquet[currency_label_en]"
                                class="form-control"
                                value="{{ old('banquet.currency_label_en', $banquetFee->currency_label_en ?? 'yen') }}"
                            >
                        </div>
                    </div>
                </div>

                {{-- 懇親会選択肢 --}}
                @foreach ($banquetFee->options as $index => $option)
                    <input
                        type="hidden"
                        name="banquet[options][{{ $index }}][id]"
                        value="{{ $option->id }}"
                    >

                    <div class="form-group">
                        <label>選択肢（日本語 / 英語）</label>

                        <div class="row">
                            <div class="col-6">
                                <input
                                    type="text"
                                    name="banquet[options][{{ $index }}][label_ja]"
                                    class="form-control"
                                    value="{{ old('banquet.options.' . $index . '.label_ja', $option->label_ja) }}"
                                >
                            </div>

                            <div class="col-6">
                                <input
                                    type="text"
                                    name="banquet[options][{{ $index }}][label_en]"
                                    class="form-control"
                                    value="{{ old('banquet.options.' . $index . '.label_en', $option->label_en) }}"
                                >
                            </div>
                        </div>
                    </div>

                    {{-- 区分別懇親会費 --}}
                    <div class="form-group">
                        <label>参加区分別 懇親会費</label>

                        <div id="banquet-price-options">
                            @foreach ($option->prices as $priceIndex => $price)
                                <div class="row mb-2 banquet-price-row">

                                    {{-- 既存料金ID --}}
                                    <input
                                        type="hidden"
                                        name="banquet[prices][{{ $priceIndex }}][id]"
                                        value="{{ $price->id }}"
                                    >

                                    {{-- 参加区分 --}}
                                    <div class="col-5">
                                        <select
                                            name="banquet[prices][{{ $priceIndex }}][join_type_id]"
                                            class="form-control"
                                        >
                                            @foreach ($feeItem->options as $joinOption)
                                                <option
                                                    value="{{ $joinOption->value }}"
                                                    {{ (string) $price->join_type_id === (string) $joinOption->value ? 'selected' : '' }}
                                                >
                                                    {{ $joinOption->label_ja }} / {{ $joinOption->label_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- 金額 --}}
                                    <div class="col-5">
                                        <input
                                            type="number"
                                            name="banquet[prices][{{ $priceIndex }}][amount]"
                                            class="form-control"
                                            value="{{ old(
                                                'banquet.prices.' . $priceIndex . '.amount',
                                                $price->amount
                                            ) }}"
                                        >
                                    </div>

                                    <div class="col-2">
                                        <button
                                            type="button"
                                            class="btn btn-danger remove-banquet-price"
                                        >
                                            削除
                                        </button>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        {{-- 懇親会費追加 --}}
                        <button
                            type="button"
                            id="add-banquet-price"
                            class="btn btn-secondary mt-2"
                        >
                            金額項目を追加
                        </button>
                    </div>
                @endforeach

            </div>
        </div>
        {{-- 合計 --}}
        <div class="card mt-4">
            <div class="card-header">
                <strong>合計</strong>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>合計（日本語 / 英語）</label>

                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="total_fee[label_ja]"
                                class="form-control"
                                value="{{ old('total_fee.label_ja', $feeItems['total_fee']->label_ja ?? '') }}"
                            >
                        </div>

                        <div class="col-6">
                            <input
                                type="text"
                                name="total_fee[label_en]"
                                class="form-control"
                                value="{{ old('total_fee.label_en', $feeItems['total_fee']->label_en ?? '') }}"
                            >
                        </div>
                    </div>

                    <label class="mt-3">通貨表記（日本語 / 英語）</label>

                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="total_fee[currency_label_ja]"
                                class="form-control"
                                value="{{ old('total_fee.currency_label_ja', $feeItems['total_fee']->currency_label_ja ?? '') }}"
                                placeholder="円"
                            >
                        </div>

                        <div class="col-6">
                            <input
                                type="text"
                                name="total_fee[currency_label_en]"
                                class="form-control"
                                value="{{ old('total_fee.currency_label_en', $feeItems['total_fee']->currency_label_en ?? '') }}"
                                placeholder="yen"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
<script>
$(function () {

    // 日本語説明文をリッチテキストエディタにする
    $('#description_ja').summernote({
        height: 200,
        lang: 'ja-JP'
    });

    // 英語説明文をリッチテキストエディタにする
    $('#description_en').summernote({
        height: 200,
        lang: 'ja-JP'
    });

    // 参加登録費の次の配列番号を画面から取得
    let optionIndex = $('.fee-option-row').length;

    // 参加登録費を追加
    $('#add-fee-option').on('click', function () {

        const html = `
            <div class="row mb-2 fee-option-row">
                <input
                    type="hidden"
                    class="deleted-flag"
                    name="registration[options][${optionIndex}][deleted]"
                    value="0"
                >

                <div class="col-4">
                    <input
                        type="text"
                        name="registration[options][${optionIndex}][label_ja]"
                        class="form-control"
                        placeholder="日本語"
                    >
                </div>

                <div class="col-4">
                    <input
                        type="text"
                        name="registration[options][${optionIndex}][label_en]"
                        class="form-control"
                        placeholder="英語"
                    >
                </div>

                <div class="col-3">
                    <input
                        type="number"
                        name="registration[options][${optionIndex}][amount]"
                        class="form-control"
                        value="0"
                        placeholder="金額"
                    >
                </div>

                <div class="col-1">
                    <button
                        type="button"
                        class="btn btn-danger remove-fee-option"
                    >
                        削除
                    </button>
                </div>
            </div>
        `;

        $('#fee-options').append(html);

        optionIndex++;
    });

    // 参加登録費を削除
    $(document).on('click', '.remove-fee-option', function () {
        const row = $(this).closest('.fee-option-row');
        const id = row.find('input[name$="[id]"]').val();

        // DB登録済みの場合は無効化
        if (id) {
            row.find('.deleted-flag').val('1');
            row.hide();
            return;
        }

        // 新規の場合は画面から削除
        row.remove();
    });


    // 懇親会費の金額項目を追加
    $('#add-banquet-price').on('click', function () {

        // 現在ある最後の行を取得
        const lastRow = $('#banquet-price-options .banquet-price-row').last();

        // 行が1件もない場合は追加できない
        if (lastRow.length === 0) {
            return;
        }

        // 最後の行を複製
        const newRow = lastRow.clone();

        // 新しい配列番号
        const newIndex = $('#banquet-price-options .banquet-price-row').length;

        // DBの既存IDは新規行には不要なので削除
        newRow.find('input[name$="[id]"]').remove();

        // 削除フラグを初期化
        newRow.find('.deleted-flag').val('0');

        // 金額を0にする
        newRow.find('input[type="number"]').val('0');

        // 各nameの配列番号を新しい番号へ変更
        newRow.find('input, select').each(function () {
            const name = $(this).attr('name');

            if (!name) {
                return;
            }

            $(this).attr(
                'name',
                name.replace(
                    /banquet\[prices\]\[\d+\]/,
                    'banquet[prices][' + newIndex + ']'
                )
            );
        });

        // 画面へ追加
        $('#banquet-price-options').append(newRow);
    });


    // 懇親会費の金額項目を削除
    $(document).on('click', '.remove-banquet-price', function () {

        const row = $(this).closest('.banquet-price-row');

        // DB登録済みの行か確認
        const id = row.find('input[name$="[id]"]').val();

        // DB登録済みの場合
        if (id) {
            // 削除フラグを1にして画面から隠す
            row.find('.deleted-flag').val('1');
            row.hide();
            return;
        }

        // 新規追加行の場合は画面から削除
        row.remove();
    });


});
</script>
@stop
