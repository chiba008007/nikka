@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>講演登録フォーム</h1>
@stop
@php
    $enable = "有効";
    $lang = "(日本語/英語)";
    $required = "必須";
    $column = "2分割";
    $title = "タイトル";
    $listDisplay = "一覧表示";
    $requiredmessage = "※ []で囲まれた文字は赤文字で表示されます。";
    $groupKeyArray = ['text','radio','select','checkbox','postcode','address','mail','mailcheck','password','textarea' ];
    $placeholder = "仮置きメッセージ";
    $selectholder = "選択肢メッセージ";
    $errormessage = "エラーメッセージ";
    $errortype = "エラーチェック型式";
    $typearray = ['text','numeric','alpha','alphanumeric','kana'];
    $othermessage = "備考説明文";
@endphp
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <form method="POST" action="{{ route('koen.list.koenform.update') }}">

        {{-- CSRF対策 --}}
        @csrf
        <button type="submit" class="btn btn-primary mb-2 w-100 sticky-save">
            保存
        </button>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">タイトル {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="title[label_ja]"
                            value="{{ old('title.label_ja', $form['title']->label_ja ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="title[label_en]"
                            value="{{ old('title.label_en', $form['title']->label_en ?? '') }}"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">印刷ボタン {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="print[label_ja]"
                            value="{{ old('print.label_ja', $form['print']->label_ja ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="print[label_en]"
                            value="{{ old('print.label_en', $form['print']->label_en ?? '') }}"
                        >
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">戻るボタン {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="back[label_ja]"
                            value="{{ old('back.label_ja', $form['back']->label_ja ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="back[label_en]"
                            value="{{ old('back.label_en', $form['back']->label_en ?? '') }}"
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">登録ボタン {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="regist[label_ja]"
                            value="{{ old('regist.label_ja', $form['regist']->label_ja ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="regist[label_en]"
                            value="{{ old('regist.label_en', $form['regist']->label_en ?? '') }}"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">日本語入力欄について {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <textarea
                         class="description"
                         name="koen_form_descript[note_ja]"
                        >
                        {{ old('koen_form_descript.note_ja', $form['koen_form_descript']->note_ja ?? '') }}
                        </textarea>
                    </div>
                    <div class="col-12">
                        <textarea
                         class="description"
                         name="koen_form_descript[note_en]"
                        >
                        {{ old('koen_form_descript.note_en', $form['koen_form_descript']->note_en ?? '') }}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
        @for ($i = 1; $i <= 20; $i++)
            @php
                $key = 'add_column_' . $i;
            @endphp

            <div class="form-group">
                <hr />
                <h4>No{{ $i }}.</h4>

                <div class="row">
                    <div class="col-4">

                        <label class="mb-0 pb-0">
                            <input type="hidden" name="{{ $key }}[status]" value="0">
                            <input
                                type="checkbox"
                                name="{{ $key }}[status]"
                                value="1"
                                {{ old($key . '.status', $form[$key]->status ?? 0) ? 'checked' : '' }}
                            >
                            {{ $enable }}
                        </label>

                        <label class="mb-0 pb-0">
                            <input type="hidden" name="{{ $key }}[list_display]" value="0">
                            <input
                                type="checkbox"
                                name="{{ $key }}[list_display]"
                                value="1"
                                {{ old($key . '.list_display', $form[$key]->list_display ?? 0) ? 'checked' : '' }}
                            >
                            {{ $listDisplay }}
                        </label>

                    </div>
                </div>
                <div>{{ $requiredmessage }}</div>

                <div class="row">
                    <div class="col-12 d-flex">
                        <input
                            type="text"
                            name="{{ $key }}[label_ja]"
                            class="form-control"
                            value="{{ old($key . '.label_ja', $form[$key]->label_ja ?? '') }}"
                        >
                        <input
                            type="text"
                            name="{{ $key }}[label_en]"
                            class="form-control ml-2"
                            value="{{ old($key . '.label_en', $form[$key]->label_en ?? '') }}"
                        >
                    </div>
                </div>

                <div class="row mt-3">
                    <label for="title">説明文{{$lang}}</label>
                    <div class="col-12 d-flex">
                        <textarea
                            name="{{ $key }}[explain_jp]"
                            class="form-control"
                            rows=4
                        >{{ old($key . '.explain_jp', $form[$key]->explain_jp ?? '') }}</textarea>
                        <textarea
                            name="{{ $key }}[explain_en]"
                            class="form-control ml-2"
                            rows=4
                        >{{ old($key . '.explain_en', $form[$key]->explain_en ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12 d-flex">

                        <label class="ml-2">
                            <input type="hidden" name="{{ $key }}[required]" value="0">
                            <input
                                type="checkbox"
                                name="{{ $key }}[required]"
                                value="1"
                                {{ old($key . '.required', $form[$key]->required ?? 0) ? 'checked' : '' }}
                            > {{ $required }}
                        </label>

                        <label class="ml-2">
                            <input type="hidden" name="{{ $key }}[column]" value="1">
                            <input
                                type="checkbox"
                                name="{{ $key }}[column]"
                                value="2"
                                {{ old($key . '.column', $form[$key]->column ?? 1) == 2 ? 'checked' : '' }}
                            > {{ $column }}
                        </label>
                    </div>
                    <div class="col-12 d-flex">
                        @foreach ($groupKeyArray as $groupKey)
                            <label class="mr-3">
                                <input
                                    class="group-key-radio"
                                    data-index="{{ $i }}"
                                    type="radio"
                                    name="{{ $key }}[type_code]"
                                    value="{{ $groupKey }}"
                                    {{ old($key . '.type_code', $form[$key]->type_code ?? 'text') === $groupKey ? 'checked' : '' }}
                                >
                                {{ $groupKey }}
                            </label>
                        @endforeach
                    </div>

                </div>

                {{-- テキスト用 --}}
                <div class="row" id="text-option-{{ $i }}">
                    <label for="title" class="mb-0 pb-0">{{ $placeholder }}{{$lang}}</label>
                    <div class="col-12 d-flex" >
                        <input
                            type="text"
                            name="{{ $key }}[placeholder_ja]"
                            class="form-control"
                            value="{{ old($key . '.placeholder_ja', $form[$key]->placeholder_ja ?? '') }}"
                        >

                        <input
                            type="text"
                            name="{{ $key }}[placeholder_en]"
                            class="form-control ml-2"
                            value="{{ old($key . '.placeholder_en', $form[$key]->placeholder_en ?? '') }}"
                        >
                    </div>
                </div>
                {{-- テキスト用以外 --}}
                <div class="row" id="check-option-{{ $i }}">
                    <div class="col-12">
                    <label for="title" class="mb-0 pb-0">{{ $selectholder }}{{$lang}}</label>
                    </div>
                    <div class="col-12">
                        @php
                            // 登録済みの選択肢数
                            $optionCount = isset($form[$key])
                                ? $form[$key]->options->count()
                                : 1;
                        @endphp
                        <select
                            class="form-control w-25 option-count"
                            data-index="{{ $i }}"
                        >
                        @for($j = 1; $j <= 20; $j++)
                            <option value="{{$j}}" {{ $optionCount == $j ? 'selected' : '' }}>{{$j}}</option>
                        @endfor
                        </select>
                    </div>
                    @for($j = 1; $j <= 20; $j++)
                        @php
                            // 現在のフォーム項目に紐づく選択肢を取得
                            $option = isset($form[$key])
                                ? $form[$key]->options->firstWhere('sort_order', $j)
                                : null;
                        @endphp

                        <div
                            class="col-6 option-item-{{ $i }}"
                            data-option-number="{{ $j }}"
                        >
                            <input
                                type="text"
                                name="{{ $key }}[options][{{ $j }}][label_ja]"
                                class="form-control mt-1"
                                placeholder="選択肢を入力してください(日本語)"
                                value="{{ old($key . '.options.' . $j . '.label_ja', $option->label_ja ?? '') }}"
                            >
                        </div>

                        <div
                            class="col-6 option-item-{{ $i }}"
                            data-option-number="{{ $j }}"
                        >
                            <input
                                type="text"
                                name="{{ $key }}[options][{{ $j }}][label_en]"
                                class="form-control mt-1"
                                placeholder="選択肢を入力してください(英語)"
                                value="{{ old($key . '.options.' . $j . '.label_en', $option->label_en ?? '') }}"
                            >
                        </div>
                    @endfor
                </div>

                {{-- エラーメッセージ --}}
                <div class="row">
                    <label for="title" class="mb-0 pb-0">{{ $errormessage }}{{$lang}}</label>
                    <div class="col-12 d-flex">
                        <input
                            type="text"
                            name="{{ $key }}[error_message]"
                            class="form-control"
                            value="{{ old($key . '.error_message', $form[$key]->error_message ?? '') }}"
                        >
                        <input
                            type="text"
                            name="{{ $key }}[error_message_en]"
                            class="form-control ml-2"
                            value="{{ old($key . '.error_message_en', $form[$key]->error_message_en ?? '') }}"
                        >
                    </div>
                </div>

                 <div class="row type-row" id="type-row-{{ $i }}">
                    <label for="title" class="mb-0 pb-0">{{ $errortype }}</label>
                    <div class="col-12 ">
                        <select
                            name="{{ $key }}[type]"
                            class="form-control"
                        >
                            @foreach ($typearray as $type)
                                <option
                                    value="{{ $type }}"
                                    {{ old($key . '.type', $form[$key]->type ?? '') === $type ? 'selected' : '' }}
                                >
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- チェックボックスとselectbox選択時の備考説明文 --}}
                <div class="row mt-2" id="checkbox-note-{{ $i }}" style="display:none;">
                    <div class="col-6">
                        <label class="mb-0 pb-0">{{$othermessage}} {{$lang}}</label>
                        <textarea
                            name="{{ $key }}[checkbox_note_description]"
                            class="form-control"
                            rows="8"
                        >{{ old($key . '.checkbox_note_description', $form[$key]->checkbox_note_description ?? '') }}</textarea>
                    </div>

                    <div class="col-6">
                        <label class="mb-0 pb-0">&nbsp;</label>
                        <textarea
                            name="{{ $key }}[checkbox_note_description_en]"
                            class="form-control"
                            rows="8"
                        >{{ old($key . '.checkbox_note_description_en', $form[$key]->checkbox_note_description_en ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <label>表示条件</label>
                </div>

                <div class="col-6">
                    <label>参照する項目</label>

                    <select
                        name="{{ $key }}[enable_source_name]"
                        class="form-control enable-source-name"
                        data-index="{{ $i }}"
                    >
                        <option value="">常に有効</option>

                        @for ($j = 1; $j <= 20; $j++)
                            @php
                                $sourceKey = 'add_column_' . $j;
                            @endphp

                            @if ($j !== $i)
                                <option
                                    value="{{ $sourceKey }}"
                                    {{ old(
                                        $key . '.enable_source_name',
                                        $form[$key]->enable_source_name ?? ''
                                    ) === $sourceKey ? 'selected' : '' }}
                                >
                                    No{{ $j }}
                                </option>
                            @endif
                        @endfor
                    </select>
                </div>

                <div class="col-6">
                    <label>参照する値</label>

                    <input
                        type="text"
                        name="{{ $key }}[enable_source_value]"
                        class="form-control"
                        value="{{ old(
                            $key . '.enable_source_value',
                            $form[$key]->enable_source_value ?? ''
                        ) }}"
                    >
                </div>
            </div>

        @endfor

    </form>
@stop

@section('js')
<script>
$(function () {

    /**
     * group_key に応じて入力許可文字型を表示・非表示にする
     */
    function changeTypeDisplay(index) {
        var value = $('.group-key-radio[data-index="' + index + '"]:checked').val();
        $('#type-row-' + index).hide();
        $('#text-option-' + index).hide();
        $('#check-option-' + index).hide();

        if (value === 'radio' || value === 'select' || value === 'checkbox' ) {
            $('#type-row-' + index).hide();
            $('#text-option-' + index).hide();
            $('#check-option-' + index).show();
        } else {
            $('#type-row-' + index).show();
            $('#text-option-' + index).show();
            $('#check-option-' + index).hide();
        }

        // checkboxの場合のみ備考説明文を表示
        if (value === 'checkbox' || value === "select") {
            $('#checkbox-note-' + index).show();
        } else {
            $('#checkbox-note-' + index).hide();
        }

    }

    // 選択変更時
    $('.group-key-radio').on('change', function () {
        changeTypeDisplay($(this).data('index'));
    });

    // 初期表示
    $('.group-key-radio:checked').each(function () {
        changeTypeDisplay($(this).data('index'));
    });

    /**
     * 選択された件数まで選択肢入力欄を表示する
     */
    function changeOptionCount(index, count) {
        $('.option-item-' + index).each(function () {
            var optionNumber = Number($(this).data('option-number'));

            if (optionNumber <= count) {
                $(this).show();
            } else {
                $(this).hide();
            }

            // 選択数を超えた入力欄は送信しない
            $(this).find('input').prop('disabled', optionNumber > count);
        });
    }

    // 件数変更時
    $('.option-count').on('change', function () {

        var index = $(this).data('index');
        var count = Number($(this).val());

        changeOptionCount(index, count);
    });

    // 初期表示
    $('.option-count').each(function () {

        var index = $(this).data('index');
        var count = Number($(this).val());

        changeOptionCount(index, count);
    });

    // 説明文をリッチテキストエディタにする
    $('.description').summernote({
        height: 200,
        lang: 'ja-JP',
    });
});
</script>
@vite(['resources/js/app.js'])
@stop
@section('css')
<style>
.sticky-save {
    position: sticky;
    top: 10px;
    z-index: 1030;
}
</style>
@stop
