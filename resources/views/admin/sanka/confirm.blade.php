@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>確認ページ</h1>
@stop
@php
    $enable = "有効";
    $lang = "(日本語/英語)";
@endphp
@section('content')
    <form method="POST" action="{{ route('sanka.list.confirm.update') }}">

        {{-- CSRF対策 --}}
        @csrf

        <div class="card">
            <div class="card-body">

                <div class="form-group">
                    <div class="card mt-3">
                        <div class="card-body ">
                            <div class="form-group">
                                <label for="title">説明文 {{$lang}}</label>
                                <textarea
                                    class="description"
                                    name="description_confirm[label_ja]"
                                >
                                {{ old('description_confirm.label_ja', $form['description_confirm']->label_ja ?? '') }}</textarea>
                                <textarea
                                    class="description"
                                    name="description_confirm[label_en]"
                                >
                                {{ old('description_confirm.label_en', $form['description_confirm']->label_en ?? '') }}</textarea>
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
        height: 300,
        lang: 'ja-JP'
    });
});
</script>
@stop
