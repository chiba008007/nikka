@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>講演ログインフォーム</h1>
@stop
@php
    $enable = "有効";
    $lang = "(日本語/英語)";
@endphp
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <form method="POST" action="{{ route('koen.list.loginform.update') }}">

        {{-- CSRF対策 --}}
        @csrf
        <button type="submit" class="btn btn-primary mb-2 w-100">
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
                    <div class="col-6">説明 {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <textarea
                         class="description"
                         name="login_form_descript[note_ja]"
                        >
                        {{ old('login_form_descript.note_ja', $form['login_form_descript']->note_ja ?? '') }}
                        </textarea>
                    </div>
                    <div class="col-12">
                        <textarea
                         class="description"
                         name="login_form_descript[note_en]"
                        >
                        {{ old('login_form_descript.note_en', $form['login_form_descript']->note_en ?? '') }}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row ">
                    <div class="col-6">入力フォーム参加受付番号 {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="reception_number[label_ja]"
                            value="{{ old('reception_number.label_ja', $form['reception_number']->label_ja ?? '') }}"
                        >
                        <div>代用語</div>
                        <input
                            class="form-control"
                            type="text"
                            name="reception_number[placeholder_ja]"
                            value="{{ old('reception_number.placeholder_ja', $form['reception_number']->placeholder_ja ?? '') }}"
                        >
                        <div>エラーメッセージ</div>
                        <input
                            class="form-control"
                            type="text"
                            name="reception_number[error_message]"
                            value="{{ old('reception_number.error_message', $form['reception_number']->error_message ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="reception_number[label_en]"
                            value="{{ old('reception_number.label_en', $form['reception_number']->label_en ?? '') }}"
                        >
                        <div>代用語</div>
                        <input
                            class="form-control"
                            type="text"
                            name="reception_number[placeholder_en]"
                            value="{{ old('reception_number.placeholder_en', $form['reception_number']->placeholder_en ?? '') }}"
                        >
                        <div>エラーメッセージ</div>
                        <input
                            class="form-control"
                            type="text"
                            name="reception_number[error_message_en]"
                            value="{{ old('reception_number.error_message_en', $form['reception_number']->error_message_en ?? '') }}"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row ">
                    <div class="col-6">入力フォームパスワード {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="password[label_ja]"
                            value="{{ old('password.label_ja', $form['password']->label_ja ?? '') }}"
                        >
                        <div>代用語</div>
                        <input
                            class="form-control"
                            type="text"
                            name="password[placeholder_ja]"
                            value="{{ old('password.placeholder_ja', $form['password']->placeholder_ja ?? '') }}"
                        >
                        <div>エラーメッセージ</div>
                        <input
                            class="form-control"
                            type="text"
                            name="password[error_message]"
                            value="{{ old('password.error_message', $form['password']->error_message ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="password[label_en]"
                            value="{{ old('password.label_en', $form['password']->label_en ?? '') }}"
                        >
                        <div>代用語</div>
                        <input
                            class="form-control"
                            type="text"
                            name="password[placeholder_en]"
                            value="{{ old('password.placeholder_en', $form['password']->placeholder_en ?? '') }}"
                        >
                        <div>エラーメッセージ</div>
                        <input
                            class="form-control"
                            type="text"
                            name="password[error_message_en]"
                            value="{{ old('password.error_message_en', $form['password']->error_message_en ?? '') }}"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row ">
                    <div class="col-6">登録ボタン名 {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="regist_button[label_ja]"
                            value="{{ old('regist_button.label_ja', $form['regist_button']->label_ja ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="regist_button[label_en]"
                            value="{{ old('regist_button.label_en', $form['regist_button']->label_en ?? '') }}"
                        >
                    </div>
                </div>
                <div class="row ">
                    <div class="col-6">戻るボタン名 {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="back_button[label_ja]"
                            value="{{ old('back_button.label_ja', $form['back_button']->label_ja ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            class="form-control"
                            type="text"
                            name="back_button[label_en]"
                            value="{{ old('back_button.label_en', $form['back_button']->label_en ?? '') }}"
                        >
                    </div>
                </div>
            </div>
        </div>

    </form>
@stop

@section('js')
<script>
$(function () {
    // 説明文をリッチテキストエディタにする
    $('.description').summernote({
        height: 200,
        lang: 'ja-JP',
    });
});
</script>
@stop
