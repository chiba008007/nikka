<style>
    /* 参加区分1行分 */
    .join-type-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 12px 16px;
        margin-bottom: 8px;
        cursor: pointer;
        background: #fff;
    }

    /* 左側のラジオと名称 */
    .join-type-left {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: bold;
    }

    /* 金額を横並びで表示する */
    .join-type-price {
        display: flex;
        align-items: baseline;
        justify-content: flex-end;
        gap: 4px;
        min-width: 100px;
        color: #333;
    }

    .join-type-price-main {
        font-size: 18px;
        font-weight: bold;
    }

    .join-type-price-unit {
        font-size: 13px;
        color: #666;
    }

    /* フォーム内の項目見出し */
    .section-title {
        margin-bottom: 12px;
        padding: 8px 12px;
        border-left: 4px solid #007bff;
        font-size: 16px;
        font-weight: bold;
    }

    /* 必須表示 */
    .required-label {
        margin-left: 6px;
        color: #dc3545;
        font-size: 13px;
    }

    /* ラジオボタンを横並びにする */
    .radio-group {
        display: flex;
        gap: 12px;
    }

    /* 選択肢をカード風にする */
    .radio-card {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 160px;
        padding: 12px 16px;
        margin: 0;
        border: 1px solid #ced4da;
        border-radius: 6px;
        cursor: pointer;
        background: #fff;
    }

    /* 選択中を強調する */
    .radio-card:has(input:checked) {
        border-color: #007bff;
        background: #f0f7ff;
    }

    /* ラジオボタンを少し大きくする */
    .radio-card input[type="radio"] {
        width: 18px;
        height: 18px;
    }

</style>

@props([
    'action',
    'method' => 'POST',
    'formItems' => [],
    'feeItems' => [],
])
{{-- バリデーションエラーを表示する --}}
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

{{-- 管理画面・公開画面で共通利用する参加者フォーム --}}
<form action="{{ $action }}" method="POST" >
    @csrf

    {{-- POST以外の場合はLaravelのHTTPメソッドを指定する --}}
    @if (strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="card">
        <x-language-switch />

        <div class="card-body">
            <div class="form-group jp ">
                {!! $formItems[ 'description' ]->label_ja !!}
            </div>
            <div class="form-group en ">
                {!! $formItems[ 'description' ]->label_en !!}
            </div>
            <hr />
            @for ($i = 1; $i <= 50; $i++)
                @php
                    // title1 ～ title50 のキーを作成する
                    $titleKey = 'title' . $i;

                    // title番号と同じ add_column を取得する
                    $inputKey = 'add_column_' . $i;
                    $input = $formItems[$inputKey] ?? null;

                    // $required = ($input && $input->required) ? 'required' : '';
                    $required = "";
                @endphp

                @if (isset($formItems[$titleKey]))
                    {{-- 項目タイトル --}}
                    <div class="section-title mt-3 jp">
                        {{ $formItems[$titleKey]->label_ja }}

                        @if ($formItems[$titleKey]->required_text ?? '')
                            <span class="required-label">
                                {{ $formItems[$titleKey]->required_text }}
                            </span>
                        @endif
                    </div>
                    <div class="section-title mt-3 en">
                        {{ $formItems[$titleKey]->label_en }}

                        @if ($formItems[$titleKey]->required_text ?? '')
                            <span class="required-label">
                                {{ $formItems[$titleKey]->required_text_en }}
                            </span>
                        @endif
                    </div>

                    @if ($input)
                        <div class="form-row">
                            @if ($input->group_key === 'postcode')
                                <div class="col-md-12">
                                    <input
                                        style="width:300px;"
                                        type="text"
                                        name="{{ $input->name }}"
                                        class="form-control js-postcode js-language-input"
                                        value="{{ old($input->name) }}"
                                        placeholder="{{ $input->placeholder_ja }}"
                                        data-placeholder-ja="{{ $input->placeholder_ja }}"
                                        data-placeholder-en="{{ $input->placeholder_en }}"
                                        {{ $required }}
                                    >
                                </div>
                            @elseif ($input->group_key === 'textarea')
                                <div class="col-md-12">
                                    <textarea
                                        rows=5
                                        name="{{ $input->name }}"
                                        class="form-control js-postcode js-language-input"
                                        placeholder="{{ $input->placeholder_ja }}"
                                        data-placeholder-ja="{{ $input->placeholder_ja }}"
                                        data-placeholder-en="{{ $input->placeholder_en }}"
                                        {{ $required }}
                                    >{{ old($input->name) }}</textarea>
                                </div>
                            @elseif ($input->group_key === 'checkbox')
                                <div class="row">
                                    @foreach ($input->options as $option)
                                        <div class="col-4 ">
                                            <label>
                                                <input
                                                    type="checkbox"
                                                    name="{{ $input->name }}[values][]"
                                                    id="{{ $input->name }}_{{ $option->value }}"
                                                    value="{{ $option->value }}"
                                                    {{ old($input->name) == $option->value ? 'checked' : '' }}
                                                    {{ $required }}
                                                >
                                                <span class="jp">{{ $option->label_ja }}</span>
                                                <span class="en">{{ $option->label_en }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                    <input
                                    type='text'
                                    name="{{ $input->name }}[other]"
                                    class="form-control js-language-input"
                                    placeholder="{{ $input->checkbox_note_description }}"
                                    data-placeholder-ja="{{ $input->checkbox_note_description }}"
                                    data-placeholder-en="{{ $input->checkbox_note_description_en }}"
                                    />
                                </div>

                            @elseif ($input->group_key === 'radio')
                                <div class="col-md-12">
                                    <div class="radio-group">
                                    @foreach ($input->options as $option)
                                        <label
                                            class="radio-card"
                                            for="{{ $input->name }}_{{ $option->value }}"
                                        >
                                            <input
                                                type="radio"
                                                name="{{ $input->name }}"
                                                id="{{ $input->name }}_{{ $option->value }}"
                                                value="{{ $option->value }}"
                                                {{ old($input->name) == $option->value ? 'checked' : '' }}
                                                {{ $required }}
                                            >
                                            <span class="jp">{{ $option->label_ja }}</span>
                                            <span class="en">{{ $option->label_en }}</span>
                                        </label>
                                    @endforeach
                                    </div>
                                </div>
                            @else

                                {{-- 1つ目の入力欄 --}}
                                <div class="{{ $input->column == 2 ? 'col-md-6' : 'col-md-12' }} d-flex">
                                    <input
                                        type="{{ $input->group_key === 'password' ? 'password':'text'}}"
                                        name="{{ $input->name }}"
                                        class="form-control {{$input->group_key}} js-language-input {{$input->group_key === 'password' ? 'w-25':'w-100'}} "
                                        value="{{ old($input->name) }}"
                                        placeholder="{{ $input->placeholder_ja }}"
                                        data-placeholder-ja="{{ $input->placeholder_ja }}"
                                        data-placeholder-en="{{ $input->placeholder_en }}"
                                        {{ $required }}
                                    >
                                    @if($input->group_key === 'password' )
                                    <h3 class="nav-icon fas fa-unlock ml-2 mt-2 lock" ></h3>
                                    @endif
                                </div>
                                @if ($input->column == 2 && isset($formItems['add_column_' . ($i + 1)]))
                                    @php
                                        $secondInput = $formItems['add_column_' . ($i + 1)];
                                    @endphp

                                    <div class="col-md-6">
                                        <input
                                            type="text"
                                            name="{{ $secondInput->name }}"
                                            class="form-control js-language-input"
                                            value="{{ old($secondInput->name) }}"
                                            placeholder="{{ $secondInput->placeholder_ja }}"
                                            data-placeholder-ja="{{ $secondInput->placeholder_ja }}"
                                            data-placeholder-en="{{ $secondInput->placeholder_en }}"
                                        >
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                @endif
            @endfor

            @if (isset($feeItems['registration_fee']))
                <div class="form-row">
                    <div class="col-md-12">

                        {{-- 見出し --}}
                        <div class="section-title mt-3 jp">
                            {{ $feeItems['registration_fee']->label_ja }}

                            @if (!empty($feeItems['registration_fee']->required_text))
                                <span class="required-label">
                                    {{ $feeItems['registration_fee']->required_text }}
                                </span>
                            @endif
                        </div>

                        <div class="section-title mt-3 en">
                            {{ $feeItems['registration_fee']->label_en }}

                            @if (!empty($feeItems['registration_fee']->required_text_en))
                                <span class="required-label">
                                    {{ $feeItems['registration_fee']->required_text_en }}
                                </span>
                            @endif
                        </div>

                        {{-- 説明文：HTMLとして表示する --}}
                        <div class="mb-2 jp">
                            {!! $feeItems['registration_fee']->description_ja ?? '' !!}
                        </div>

                        <div class="mb-2 en">
                            {!! $feeItems['registration_fee']->description_en ?? '' !!}
                        </div>

                        {{-- 選択肢 --}}
                        @foreach ($feeItems['registration_fee']->options as $option)
                            <label class="join-type-row">
                                <div class="join-type-left">
                                    <input
                                        type="radio"
                                        name="registration_fee"
                                        value="{{ $option->value }}"
                                        class="join-type"
                                        data-price="{{ $option->amount }}"
                                        {{ old('registration_fee') == $option->value ? 'checked' : '' }}
                                    >

                                    <span class="jp">{{ $option->label_ja }}</span>
                                    <span class="en">{{ $option->label_en }}</span>
                                </div>

                                <div class="join-type-price">
                                    <span class="join-type-price-main">
                                        {{ number_format($option->amount) }}
                                    </span>

                                    <span class="join-type-price-unit jp">
                                        {{ $feeItems['registration_fee']->currency_label_ja }}
                                    </span>

                                    <span class="join-type-price-unit en">
                                        {{ $feeItems['registration_fee']->currency_label_en }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (isset($feeItems['banquet_fee']))
                <div class="form-row">
                    <div class="col-md-12">

                        {{-- 見出し --}}
                        <div class="section-title mt-3 jp">
                            {{ $feeItems['banquet_fee']->label_ja }}

                            @if (!empty($feeItems['banquet_fee']->required_text))
                                <span class="required-label">
                                    {{ $feeItems['banquet_fee']->required_text }}
                                </span>
                            @endif
                        </div>

                        <div class="section-title mt-3 en">
                            {{ $feeItems['banquet_fee']->label_en }}

                            @if (!empty($feeItems['banquet_fee']->required_text_en))
                                <span class="required-label">
                                    {{ $feeItems['banquet_fee']->required_text_en }}
                                </span>
                            @endif
                        </div>

                        {{-- 説明文 --}}
                        <div class="mb-2 jp">
                            {!! $feeItems['banquet_fee']->description_ja ?? '' !!}
                        </div>

                        <div class="mb-2 en">
                            {!! $feeItems['banquet_fee']->description_en ?? '' !!}
                        </div>

                        {{-- 選択肢 --}}
                        @foreach ($feeItems['banquet_fee']->options as $option)
                            <label class="join-type-row">
                                <div class="join-type-left">

                                    <input
                                        type="checkbox"
                                        name="banquet_fee"
                                        value="{{ $option->value }}"
                                        class="banquet-fee"
                                        data-prices='@json(
                                            $option->prices->pluck("amount", "join_type_id")
                                        )'
                                        {{ old('banquet_fee') == $option->value ? 'checked' : '' }}
                                    >

                                    <span class="jp">{{ $option->label_ja }}</span>
                                    <span class="en">{{ $option->label_en }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 合計 --}}
            @if (isset($feeItems['total_fee']))
                <div class="form-row mt-4">
                    <div class="col-md-12">
                        <div class="join-type-row ">

                            <div class="join-type-left">
                                <h4 class="jp">
                                    {{ $feeItems['total_fee']->label_ja }}
                                </h4>

                                <h4 class="en">
                                    {{ $feeItems['total_fee']->label_en }}
                                </h4>
                            </div>

                            <div class="join-type-price">
                                <h4
                                    id="total-fee"
                                    class=""
                                >
                                    0
                                </h4>

                                <h4 class=" jp">
                                    {{ $feeItems['total_fee']->currency_label_ja }}
                                </h4>

                                <h4 class="en">
                                    {{ $feeItems['total_fee']->currency_label_en }}
                                </h4>
                            </div>

                        </div>

                        {{-- 保存用 --}}
                        <input
                            type="hidden"
                            name="total_fee_amount"
                            id="total-fee-input"
                            value="0"
                        >
                    </div>
                </div>
            @endif

            <div class="d-flex mt-4">

                <button
                    type="submit"
                    name="regist"
                    value="on"
                    class="btn btn-primary jp"
                >{{ $formItems[ 'regist' ]->label_ja }}</button>
                <button
                    type="submit"
                    name="regist"
                    value="on"
                    class="btn btn-primary en"
                >{{ $formItems[ 'regist' ]->label_en }}</button>

                <input
                    class="ml-5"
                    type="checkbox"
                    name="send"
                    id="send"
                    value="on"
                    {{ old('send') == 'on' ? 'checked' : '' }}
                />
                <label for="send" class="mt-2 ml-2">参加者へメールを送る</label>
            </div>


        </div>
    </div>
</form>

@section('js')
<script>

$(function () {
    $('.js-postcode').on('change', function () {
        // ハイフンを除去する
        const postcode = $(this).val().replace('-', '');

        // 郵便番号7桁以外は処理しない
        if (!/^\d{7}$/.test(postcode)) {
            return;
        }

        const $postcode = $(this);

        $.ajax({
            url: 'https://zipcloud.ibsnet.co.jp/api/search',
            type: 'GET',
            dataType: 'jsonp',
            data: {
                zipcode: postcode
            }
        }).done(function (response) {
            if (!response.results || response.results.length === 0) {
                return;
            }

            const result = response.results[0];

            // 郵便番号入力欄の次にある入力欄へ住所を設定する
            const $address = $postcode
                .closest('.form-row')
                .nextAll('.form-row')
                .first()
                .find('input[type="text"]')
                .first();

            $address.val(
                result.address1 +
                result.address2 +
                result.address3
            );
        });

    });

    // パスワード表示
    $(".lock").on("click",function(){
        $(".password").attr("type", "text");
    });


    // 参加登録費 + 懇親会費を計算する
    function calculateTotalFee() {

        let total = 0;

        // 選択されている参加区分
        const $registrationFee = $('.join-type:checked');

        if ($registrationFee.length === 0) {
            $('#total-fee').text('0');
            $('#total-fee-input').val(0);
            return;
        }

        // 参加登録費
        const registrationFee = Number(
            $registrationFee.data('price')
        ) || 0;

        total += registrationFee;

        // 選択した参加区分
        const joinTypeId = String(
            $registrationFee.val()
        );

        // 懇親会に参加する場合
        $('.banquet-fee:checked').each(function () {

            const prices = $(this).data('prices') || {};

            // 参加区分に対応した懇親会費
            const banquetFee = Number(
                prices[joinTypeId]
            ) || 0;

            total += banquetFee;
        });

        // 合計表示
        $('#total-fee').text(
            total.toLocaleString()
        );

        // hiddenへ保存
        $('#total-fee-input').val(total);
    }

    // 参加区分変更
    $('.join-type').on('change', function () {
        calculateTotalFee();
    });

    // 懇親会変更
    $('.banquet-fee').on('change', function () {
        calculateTotalFee();
    });

    // 初期表示
    calculateTotalFee();

});
</script>
@stop
