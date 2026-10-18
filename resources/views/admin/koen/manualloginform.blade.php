@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>要旨原稿ログインフォーム編集</h1>
@stop
@php
    $enable = "有効";
@endphp
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <form method="POST" action="{{ route('koen.manual.login.update') }}">
        <button type="submit" class="btn btn-primary mb-2 w-100">
            保存
        </button>
        {{-- CSRF対策 --}}
        @csrf

        <div class="card">
            <div class="card-body">
                <input type="hidden" name="status" value="1" />

                <div>{{ config('const.required_message') }}</div>

                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">タイトル{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manuallogintitle][note_ja]"
                            value="{{ old('authors.manuallogintitle.note_ja', $form['manuallogintitle']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manuallogintitle][note_en]"
                            value="{{ old('authors.manuallogintitle.note_en', $form['manuallogintitle']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">説明{{ config('const.lang') }}</label>
                        <textarea
                              type="text"
                              rows=4
                              class="form-control description"
                              name="authors[manualloginexplain][note_ja]"
                            >{{ old('authors.manualloginexplain.note_ja', $form['manualloginexplain']->note_ja) }}</textarea>
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <textarea
                            rows=4
                            class="form-control description"
                            name="authors[manualloginexplain][note_en]"
                            >{{ old('authors.manualloginexplain.note_en', $form['manualloginexplain']->note_en) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">発表受付番号{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginid][note_ja]"
                            value="{{ old('authors.manualloginid.note_ja', $form['manualloginid']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginid][note_en]"
                            value="{{ old('authors.manualloginid.note_en', $form['manualloginid']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">{{config('const.placeholder')}}{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginplaceholder][note_ja]"
                            value="{{ old('authors.manualloginplaceholder.note_ja', $form['manualloginplaceholder']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginplaceholder][note_en]"
                            value="{{ old('authors.manualloginplaceholder.note_en', $form['manualloginplaceholder']->note_en) }}"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">パスワード{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginpassword][note_ja]"
                            value="{{ old('authors.manualloginpassword.note_ja', $form['manualloginpassword']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginpassword][note_en]"
                            value="{{ old('authors.manualloginpassword.note_en', $form['manualloginpassword']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">{{config('const.placeholder')}}{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginpasswordplacdholder][note_ja]"
                            value="{{ old('authors.manualloginpasswordplacdholder.note_ja', $form['manualloginpasswordplacdholder']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginpasswordplacdholder][note_en]"
                            value="{{ old('authors.manualloginpasswordplacdholder.note_en', $form['manualloginpasswordplacdholder']->note_en) }}"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">データ登録ボタン{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginbutton][note_ja]"
                            value="{{ old('authors.manualloginbutton.note_ja', $form['manualloginbutton']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginbutton][note_en]"
                            value="{{ old('authors.manualloginbutton.note_en', $form['manualloginbutton']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">前のページへボタン{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginbuttonback][note_ja]"
                            value="{{ old('authors.manualloginbuttonback.note_ja', $form['manualloginbuttonback']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginbuttonback][note_en]"
                            value="{{ old('authors.manualloginbuttonback.note_en', $form['manualloginbuttonback']->note_en) }}"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">エラーメッセージ{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginerrormessage][note_ja]"
                            value="{{ old('authors.manualloginerrormessage.note_ja', $form['manualloginerrormessage']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualloginerrormessage][note_en]"
                            value="{{ old('authors.manualloginerrormessage.note_en', $form['manualloginerrormessage']->note_en) }}"
                        >
                    </div>
                </div>

            </div>
        </div>

    </form>
@stop

@section('js')
@vite(['resources/js/app.js'])

<script>
$(function () {
    initSummernote('.description', 200);

    // 説明文をリッチテキストエディタにする
    $('.description').summernote({
        height: 150,
        lang: 'ja-JP',
    });
});
</script>
@stop
@section('css')
<style >

</style>
@stop
