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
    <form method="POST" action="{{ route('koen.list.regist.koenRegists') }}">

        {{-- CSRF対策 --}}
        @csrf
        <button type="submit" id="save-button" class="btn btn-primary mb-2 w-100 sticky-save" disabled>
            保存
        </button>
        <x-koen-regist-form
            :code="$code"
            :endai="$endai"
            :koenFormItems="$koenFormItems"
        />

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
