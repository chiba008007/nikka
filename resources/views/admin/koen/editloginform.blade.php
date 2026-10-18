@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>講演申込編集ログインフォーム編集</h1>
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
    <form method="POST" action="{{ route('koen.edit.login.update') }}">
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
                            name="authors[editlogintitle][note_ja]"
                            value="{{ old('authors.editlogintitle.note_ja', $form['editlogintitle']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editlogintitle][note_en]"
                            value="{{ old('authors.editlogintitle.note_en', $form['editlogintitle']->note_en) }}"
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
                              name="authors[editloginexplain][note_ja]"
                            >{{ old('authors.editloginexplain.note_ja', $form['editloginexplain']->note_ja) }}</textarea>
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <textarea
                            rows=4
                            class="form-control description"
                            name="authors[editloginexplain][note_en]"
                            >{{ old('authors.editloginexplain.note_en', $form['editloginexplain']->note_en) }}</textarea>
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
                            name="authors[editloginid][note_ja]"
                            value="{{ old('authors.editloginid.note_ja', $form['editloginid']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginid][note_en]"
                            value="{{ old('authors.editloginid.note_en', $form['editloginid']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">{{config('const.placeholder')}}{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginidplaceholder][note_ja]"
                            value="{{ old('authors.editloginidplaceholder.note_ja', $form['editloginidplaceholder']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginidplaceholder][note_en]"
                            value="{{ old('authors.editloginidplaceholder.note_en', $form['editloginidplaceholder']->note_en) }}"
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
                            name="authors[editloginpassword][note_ja]"
                            value="{{ old('authors.editloginpassword.note_ja', $form['editloginpassword']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginpassword][note_en]"
                            value="{{ old('authors.editloginpassword.note_en', $form['editloginpassword']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">{{config('const.placeholder')}}{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginpasswordplacdholder][note_ja]"
                            value="{{ old('authors.editloginpasswordplacdholder.note_ja', $form['editloginpasswordplacdholder']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginpasswordplacdholder][note_en]"
                            value="{{ old('authors.editloginpasswordplacdholder.note_en', $form['editloginpasswordplacdholder']->note_en) }}"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">講演登録ページへボタン{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginbutton][note_ja]"
                            value="{{ old('authors.editloginbutton.note_ja', $form['editloginbutton']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginbutton][note_en]"
                            value="{{ old('authors.editloginbutton.note_en', $form['editloginbutton']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">前のページへボタン{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginbuttonback][note_ja]"
                            value="{{ old('authors.editloginbuttonback.note_ja', $form['editloginbuttonback']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginbuttonback][note_en]"
                            value="{{ old('authors.editloginbuttonback.note_en', $form['editloginbuttonback']->note_en) }}"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">講演登録ページエラーメッセージ{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginerrormessage][note_ja]"
                            value="{{ old('authors.editloginerrormessage.note_ja', $form['editloginerrormessage']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[editloginerrormessage][note_en]"
                            value="{{ old('authors.editloginerrormessage.note_en', $form['editloginerrormessage']->note_en) }}"
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
