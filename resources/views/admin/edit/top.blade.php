@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.dashboard'))
@section('plugins.Summernote', true)
@section('content_header')
    <p class="h4">トップページ編集</p>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
@stop

@section('content')

<div class="conference-page">
<x-top.hero :is-admin="true" :pageTops=$pageTops />
</div>

@stop
@section('js')
<script src="{{ asset('js/top.js') }}"></script>
@stop
