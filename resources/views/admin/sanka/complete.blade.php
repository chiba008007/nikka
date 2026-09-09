@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>完了ページ</h1>
@stop
@php
    $enable = "有効";
    $lang = "(日本語/英語)";
@endphp
@section('content')
    <form method="POST" action="{{ route('sanka.list.complete.update') }}">

        {{-- CSRF対策 --}}
        @csrf

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">タイトル {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            type="text"
                            name="complete_title[label_ja]"
                            class="form-control"
                            value="{{ old('complete_title.label_ja', $form['complete_title']->label_ja ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            type="text"
                            name="complete_title[label_en]"
                            class="form-control"
                            value="{{ old('complete_title.label_en', $form['complete_title']->label_en ?? '') }}"
                        >
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">登録完了メッセージ {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <textarea
                            class="description"
                            name="complete_message[label_ja]"
                        >
                        {{ old('complete_message.label_ja', $form['complete_message']->label_ja ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <textarea
                            class="description"
                            name="complete_message[label_en]"
                        >
                        {{ old('complete_message.label_en', $form['complete_message']->label_en ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">参加登録ID {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <input
                            type="text"
                            name="complete_join_id[label_ja]"
                            class="form-control"
                            value="{{ old('complete_join_id.label_ja', $form['complete_join_id']->label_ja ?? '') }}"
                        >
                    </div>
                    <div class="col-6">
                        <input
                            type="text"
                            name="complete_join_id[label_en]"
                            class="form-control"
                            value="{{ old('complete_join_id.label_en', $form['complete_join_id']->label_en ?? '') }}"
                        >
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">登録完了説明文 {{$lang}}</div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <textarea
                            class="description"
                            name="complete_explain[label_ja]"
                        >
                        {{ old('complete_explain.label_ja', $form['complete_explain']->label_ja ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <textarea
                            class="description"
                            name="complete_explain[label_en]"
                        >
                        {{ old('complete_explain.label_en', $form['complete_explain']->label_en ?? '') }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-2">
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
