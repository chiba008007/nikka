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
    <form method="POST" action="{{ route('sanka.list.editform.update') }}">
        {{-- CSRF対策 --}}
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">

                <div class="form-group">
                    <label>登録ボタン名 {{$lang}}</label>
                    <label class="row mb-2 ml-2">
                        <input
                            type="checkbox"
                            name="regist[status]"
                            value="1"
                            {{ old('regist.status', $form['regist']->status ?? 0) ? 'checked' : '' }}
                        > {{$enable}}
                    </label>
                    <div class="row">
                        <div class="col-6">
                            <input
                                type="text"
                                name="regist[title_jp]"
                                class="form-control"
                                value="{{ old('regist.title_jp', $form['regist']->label_ja ?? '') }}"
                            >
                        </div>
                        <div class="col-6">
                            <input
                                type="text"
                                name="regist[title_en]"
                                class="form-control"
                                value="{{ old('regist.title_en', $form['regist']->label_en ?? '') }}"
                            >
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
    $('#description').summernote({
        height: 300,
        lang: 'ja-JP'
    });
});
</script>
@stop
