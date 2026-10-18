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
    <form method="POST" action="{{ route('koen.list.finish.update') }}">
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
                            name="authors[finishtitle][note_ja]"
                            value="{{ old('authors.finishtitle.note_ja', $form['finishtitle']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[finishtitle][note_en]"
                            value="{{ old('authors.finishtitle.note_en', $form['finishtitle']->note_en) }}"
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
                              name="authors[finishform][note_ja]"
                            >{{ old('authors.finishform.note_ja', $form['finishform']->note_ja) }}</textarea>
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <textarea
                            rows=4
                            class="form-control description"
                            name="authors[finishform][note_en]"
                            >{{ old('authors.finishform.note_en', $form['finishform']->note_en) }}</textarea>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">講演登録ID{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[finishid][note_ja]"
                            value="{{ old('authors.finishid.note_ja', $form['finishid']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[finishid][note_en]"
                            value="{{ old('authors.finishid.note_en', $form['finishid']->note_en) }}"
                        >
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">講演登録ページへボタン{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[finishnextbutton][note_ja]"
                            value="{{ old('authors.finishnextbutton.note_ja', $form['finishnextbutton']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[finishnextbutton][note_en]"
                            value="{{ old('authors.finishnextbutton.note_en', $form['finishnextbutton']->note_en) }}"
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
