@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>講演確認画面</h1>
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
    <form method="POST" action="{{ route('koen.list.confirm.update') }}">
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
                        <label class="mb-0">説明{{ config('const.lang') }}</label>
                        <textarea
                              type="text"
                              rows=4
                              class="form-control description"
                              name="authors[confirmform][note_ja]"
                            >{{ old('authors.confirmform.note_ja', $form['confirmform']->note_ja) }}</textarea>
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <textarea
                            rows=4
                            class="form-control description"
                            name="authors[confirmform][note_en]"
                            >{{ old('authors.confirmform.note_en', $form['confirmform']->note_en) }}</textarea>
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
