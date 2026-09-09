@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>参加者申込ログインページ</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('sanka.list.loginform.update') }}">

        {{-- CSRF対策 --}}
        @csrf

        <div class="card">
            <div class="card-body">

                <div class="form-group">
                    <div class="card mt-3">
                        <div class="card-body ">
                            <div class="form-group">
                                <label for="title">{{config('const.title') }} {{config('const.lang') }}</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input
                                            type="text"
                                            name="login_form_title[label_ja]"
                                            class="form-control"
                                            value="{{ old('login_form_title.label_ja', $form['login_form_title']->label_ja ?? '') }}"
                                        >
                                    </div>
                                    <div class="col-6">
                                        <input
                                            type="text"
                                            name="login_form_title[label_en]"
                                            class="form-control"
                                            value="{{ old('login_form_title.label_en', $form['login_form_title']->label_en ?? '') }}"
                                        >
                                    </div>
                                </div>
                                <label for="title" class="mt-3">説明文 {{config('const.lang') }}</label>
                                <div class="row">
                                    <div class="col-12">
                                        <textarea
                                            class="description"
                                            name="login_form_descript[label_ja]"
                                        >
                                        {{ old('login_form_descript.label_ja', $form['login_form_descript']->label_ja ?? '') }}</textarea>
                                        <textarea
                                            class="description"
                                            name="login_form_descript[label_en]"
                                        >
                                        {{ old('login_form_descript.label_en', $form['login_form_descript']->label_en ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <h4>ログインID</h4>
                                    <label for="title">{{config('const.title') }}{{config('const.lang') }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_id[label_ja]"
                                                class="form-control"
                                                value="{{ old('login_form_login_id.label_ja', $form['login_form_login_id']->label_ja ?? '') }}"
                                            >
                                        </div>
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_id[label_en]"
                                                class="form-control"
                                                value="{{ old('login_form_login_id.label_en', $form['login_form_login_id']->label_en ?? '') }}"
                                            >
                                        </div>
                                    </div>
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="login_form_login_id[required]"
                                            value="1"
                                            {{ old('login_form_login_id.required', $form['login_form_login_id']->required ?? 0) ? 'checked' : '' }}
                                        > {{config('const.required') }}
                                    </label>

                                    <div class="d-block mt-2">
                                        <label for="title">{{config('const.placeholder') }}{{config('const.lang') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_id[placeholder_ja]"
                                                class="form-control"
                                                value="{{ old('login_form_login_id.placeholder_ja', $form['login_form_login_id']->placeholder_ja ?? '') }}"
                                            >
                                        </div>
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_id[placeholder_en]"
                                                class="form-control"
                                                value="{{ old('login_form_login_id.placeholder_en', $form['login_form_login_id']->placeholder_en ?? '') }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="d-block mt-2">
                                        <label for="title">{{config('const.errormessage') }}{{config('const.lang') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_id[error_message_ja]"
                                                class="form-control"
                                                value="{{ old('login_form_login_id.error_message_ja', $form['login_form_login_id']->error_message_ja ?? '') }}"
                                            >
                                        </div>
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_id[error_message_en]"
                                                class="form-control"
                                                value="{{ old('login_form_login_id.error_message_en', $form['login_form_login_id']->error_message_en ?? '') }}"
                                            >
                                        </div>
                                    </div>

                                </div>


                                <div class="form-group">
                                    <h4>パスワード</h4>
                                    <label for="title">{{config('const.title') }}{{config('const.lang') }}</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_password[label_ja]"
                                                class="form-control"
                                                value="{{ old('login_form_login_password.label_ja', $form['login_form_login_password']->label_ja ?? '') }}"
                                            >
                                        </div>
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_password[label_en]"
                                                class="form-control"
                                                value="{{ old('login_form_login_password.label_en', $form['login_form_login_password']->label_en ?? '') }}"
                                            >
                                        </div>
                                    </div>
                                    <label>
                                        <input
                                            type="checkbox"
                                            name="login_form_login_password[required]"
                                            value="1"
                                            {{ old('login_form_login_password.required', $form['login_form_login_password']->required ?? 0) ? 'checked' : '' }}
                                        > {{config('const.required') }}
                                    </label>

                                    <div class="d-block mt-2">
                                        <label for="title">{{config('const.placeholder') }}{{config('const.lang') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_password[placeholder_ja]"
                                                class="form-control"
                                                value="{{ old('login_form_login_password.placeholder_ja', $form['login_form_login_password']->placeholder_ja ?? '') }}"
                                            >
                                        </div>
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_password[placeholder_en]"
                                                class="form-control"
                                                value="{{ old('login_form_login_password.placeholder_en', $form['login_form_login_password']->placeholder_en ?? '') }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="d-block mt-2">
                                        <label for="title">{{config('const.errormessage') }}{{config('const.lang') }}</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_password[error_message_ja]"
                                                class="form-control"
                                                value="{{ old('login_form_login_password.error_message_ja', $form['login_form_login_password']->error_message_ja ?? '') }}"
                                            >
                                        </div>
                                        <div class="col-6">
                                            <input
                                                type="text"
                                                name="login_form_login_password[error_message_en]"
                                                class="form-control"
                                                value="{{ old('login_form_login_password.error_message_en', $form['login_form_login_password']->error_message_en ?? '') }}"
                                            >
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    保存
                </button>
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
        lang: 'ja-JP'
    });
});
</script>
@stop
