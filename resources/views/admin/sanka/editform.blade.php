@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>入力ページ</h1>
@stop
@php
    $enable = "有効";
    $required = "必須";
    $column = "2分割";
    $enablemessage = "「有効」を選択すると、この項目が画面に表示されます。";
    $columnmessage = "「2分割」を選択すると、この項目と次の項目が横2列で表示されます。次の項目のタイトルは表示されません。";
    $lang = "(日本語/英語)";
    $requiredmessage = "※ []で囲まれた文字は赤文字で表示されます。";
    $errortype = "エラーチェック型式";
    $placeholder = "仮置きメッセージ";
    $selectholder = "選択肢メッセージ";
    $errormessage = "エラーメッセージ";
    $title = "タイトル";
    $typearray = ['text','numeric','alpha','alphanumeric','kana'];
    $typemessage = "「text」はすべての文字、「numeric」は数字のみ、「alpha」は英字のみ、「alphanumeric」は半角英数記号のみ、「kana」はカナのみ入力できます。";
    $groupKeyArray = ['text','radio','select','checkbox','postcode','mail','password','textarea' ];
    $othermessage = "備考説明文";
@endphp
@section('content')
    <form method="POST" action="{{ route('sanka.list.editform.update') }}">
        {{-- CSRF対策 --}}
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-primary mb-2 w-100">
            保存
        </button>
        <div class="card">
            <div class="card-body">
                {{-- タイトル --}}
                <div class="form-group">
                    <label for="title">タイトル {{$lang}}</label>
                    <label class="row mb-2 ml-2">
                        <input
                            type="checkbox"
                            name="title[status]"
                            value="1"
                            {{ old('title.status', $form['title']->status ?? 0) ? 'checked' : '' }}
                        > {{$enable}}
                    </label>
                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="title[label_ja]"
                                class="form-control"
                                value="{{ old('title.label_ja', $form['title']->label_ja ?? '') }}"
                            >
                        </div>
                        <div class="col-6">
                            <input
                                type="text"
                                name="title[label_en]"
                                class="form-control"
                                value="{{ old('title.label_en', $form['title']->label_en ?? '') }}"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body ">
                <div class="form-group">
                    <label>戻るボタン名 {{$lang}}</label>
                    <label class="row mb-2 ml-2">
                        <input
                            type="checkbox"
                            name="back[status]"
                            value="1"
                            {{ old('back.status', $form['back']->status ?? 0) ? 'checked' : '' }}
                        > {{$enable}}
                    </label>
                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="back[title_jp]"
                                class="form-control"
                                value="{{ old('back.title_jp', $form['back']->label_ja ?? '') }}"
                            >
                        </div>
                        <div class="col-6">
                            <input
                                type="text"
                                name="back[title_en]"
                                class="form-control"
                                value="{{ old('back.title_en', $form['back']->label_en ?? '') }}"
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>次へボタン名 {{$lang}}</label>
                    <label class="row mb-2 ml-2">
                        <input
                            type="checkbox"
                            name="next[status]"
                            value="1"
                            {{ old('next.status', $form['next']->status ?? 0) ? 'checked' : '' }}
                        > {{$enable}}
                    </label>
                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="next[title_jp]"
                                class="form-control"
                                value="{{ old('next.title_jp', $form['next']->label_ja ?? '') }}"
                            >
                        </div>
                        <div class="col-6">
                            <input
                                type="text"
                                name="next[title_en]"
                                class="form-control"
                                value="{{ old('next.title_en', $form['next']->label_en ?? '') }}"
                            >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>印刷ボタン名 {{$lang}}</label>
                    <label class="row mb-2 ml-2">
                        <input
                            type="checkbox"
                            name="print[status]"
                            value="1"
                            {{ old('print.status', $form['print']->status ?? 0) ? 'checked' : '' }}
                        > {{$enable}}
                    </label>
                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="print[title_jp]"
                                class="form-control"
                                value="{{ old('print.title_jp', $form['print']->label_ja ?? '') }}"
                            >
                        </div>
                        <div class="col-6">
                            <input
                                type="text"
                                name="print[title_en]"
                                class="form-control"
                                value="{{ old('print.title_en', $form['print']->label_en ?? '') }}"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body ">
                <div class="form-group">
                    <label for="title">説明文 {{$lang}}</label>
                    <textarea
                        class="description"
                        name="description[label_ja]"
                    >
                    {{ old('description.label_ja', $form['description']->label_ja ?? '') }}</textarea>
                    <textarea
                        class="description"
                        name="description[label_en]"
                    >
                    {{ old('description.label_en', $form['description']->label_en ?? '') }}</textarea>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body ">
                <ul>
                    <li>{{$enablemessage }}</li>
                    <li>{{$columnmessage }}</li>
                    <li>{{$typemessage }}</li>
                </ul>
                @for ($i = 1; $i <= 50; $i++)
                    @php
                        // DBのnameと同じキーを作成
                        $key = 'add_column_' . $i;

                        // title1 ～ title50 のキーを作成
                        $titleKey = 'title' . $i;
                    @endphp
                    <div class="form-group">
                        <hr />
                        <h4>No{{ $i }}.</h4>
                        <label for="title">{{$title}} {{$lang}}</label>
                        <div class="row">
                            <div class="col-4 ">
                                <label class="mb-0 pb-0">
                                    <input
                                        type="checkbox"
                                        name="{{ $titleKey }}[status]"
                                        value="1"
                                        {{ old($titleKey . '.status', $form[$titleKey]->status ?? 0) ? 'checked' : '' }}
                                    >
                                    {{ $enable }}
                                </label>
                                <div>{{ $requiredmessage }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex">
                                <input
                                    type="text"
                                    name="{{ $titleKey }}[label_ja]"
                                    class="form-control"
                                    value="{{ old($titleKey . '.label_ja', $form[$titleKey]->label_ja ?? '') }}"
                                >
                                <input
                                    type="text"
                                    name="{{ $titleKey }}[label_en]"
                                    class="form-control ml-2"
                                    value="{{ old($titleKey . '.label_en', $form[$titleKey]->label_en ?? '') }}"
                                >
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 d-flex">
                                <label>
                                    <input
                                        type="checkbox"
                                        name="{{ $key }}[status]"
                                        value="1"
                                        {{ old($key . '.status', $form[$key]->status ?? 0) ? 'checked' : '' }}
                                    > {{ $enable }}
                                </label>

                                <label class="ml-2">
                                    <input
                                        type="checkbox"
                                        name="{{ $key }}[required]"
                                        value="1"
                                        {{ old($key . '.required', $form[$key]->required ?? 0) ? 'checked' : '' }}
                                    > {{ $required }}
                                </label>

                                <label class="ml-2">
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
                                            name="{{ $key }}[group_key]"
                                            value="{{ $groupKey }}"
                                            {{ old($key . '.group_key', $form[$key]->group_key ?? 'text') === $groupKey ? 'checked' : '' }}
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
                                    name="{{ $key }}[error_message_ja]"
                                    class="form-control"
                                    value="{{ old($key . '.error_message_ja', $form[$key]->error_message_ja ?? '') }}"
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
                        {{-- チェックボックス選択時の備考説明文 --}}
                        <div class="row mt-2" id="checkbox-note-{{ $i }}" style="display:none;">
                            <div class="col-6">
                                <label class="mb-0 pb-0">{{$othermessage}} {{$lang}}</label>
                                <textarea
                                    name="{{ $key }}[checkbox_note_description]"
                                    class="form-control"
                                    rows="3"
                                >{{ old($key . '.checkbox_note_description', $form[$key]->checkbox_note_description ?? '') }}</textarea>
                            </div>

                            <div class="col-6">
                                <label class="mb-0 pb-0">&nbsp;</label>
                                <textarea
                                    name="{{ $key }}[checkbox_note_description_en]"
                                    class="form-control"
                                    rows="3"
                                >{{ old($key . '.checkbox_note_description_en', $form[$key]->checkbox_note_description_en ?? '') }}</textarea>
                            </div>
                        </div>

                    </div>
                @endfor
            </div>
        </div>
    </form>
@stop

@section('js')
<script>
$(function () {
    // 説明文をリッチテキストエディタにする
    $('.description').summernote({
        height: 120,
        lang: 'ja-JP'
    });

    /**
     * group_key に応じて入力許可文字型を表示・非表示にする
     */
    function changeTypeDisplay(index) {
        var value = $('.group-key-radio[data-index="' + index + '"]:checked').val();
        console.log(value);
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
        if (value === 'checkbox') {
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


});
</script>
@stop
