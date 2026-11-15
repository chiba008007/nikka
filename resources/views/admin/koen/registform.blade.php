@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>講演登録</h1>
@stop
@php
    $lang = "(日本語/英語)";
@endphp
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <form method="POST" action="{{ route('koen.list.regist.koenRegists') }}" enctype="multipart/form-data">

        {{-- CSRF対策 --}}
        @csrf
        <button type="submit" id="save-button" class="btn btn-primary mb-2 w-100 sticky-save" disabled>
            保存
        </button>
        <x-koen-regist-form
            :code="$code"
            :endai="$endai"
            :koenFormItems="$koenFormItems"
            :description="$description"
            :authorOptions="$authorOptions"
            :form="$form"
        />

        <div class="card">
            <div class="card-body">

                <div class="jp">
                    {!! $authorOptions->get('author_draft')->note_ja !!}
                </div>
                <div class="en">
                    {!! $authorOptions->get('author_draft')->note_en !!}
                </div>

                <div class="mt-3">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="mb-3">
                            <input
                                type="file"
                                name="uploadfile{{ $i }}"
                                class="form-control">

                            @if (!empty($form["uploadfile{$i}"]))
                                <div class="mt-1">
                                    <a href="{{ route('koen.download', [
                                        'id' => $form['id'],
                                        'file' => "uploadfile{$i}"
                                    ]) }}">
                                        {{ basename($form["uploadfile{$i}"]) }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endfor
                </div>

                <div class="mt-3">
                    <label>事務局用</label>
                    <div class="d-flex align-items-center">
                        <label class="mr-2">発表番号</label>
                        <input
                            type="text"
                            name="announcenumber"
                            class="form-control"
                            style="max-width: 250px;"
                            value="{{ old('announcenumber', $form['announcenumber'] ?? '') }}"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <label class="mr-4">
                <input type="checkbox"
                    name="presentation_mail"
                    value="1"
                    @checked(old('presentation_mail'))>
                講演内容メール
            </label>

            <label>
                <input type="checkbox"
                    name="manuscript_mail"
                    value="1"
                    @checked(old('manuscript_mail'))>
                予行原稿メール
            </label>
        </div>

    </form>
@stop

@section('js')
<script>
$(function () {

});
</script>
@vite(['resources/js/app.js'])
@stop
@section('css')
<style>
.sticky-save {
    position: sticky;
    top: 10px;
    z-index: 1030;
}
</style>
@stop
