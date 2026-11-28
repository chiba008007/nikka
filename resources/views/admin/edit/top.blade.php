@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.dashboard'))
@section('plugins.Summernote', true)
@section('content_header')
    <p class="h4">事前参加登録のご案内編集</p>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
@stop

@section('content')

<div class="conference-page">
<x-top.hero :is-admin="true" :pageTops=$pageTops :banners="$banners"/>
</div>

@stop
@section('js')
<script src="{{ asset('js/top.js') }}"></script>
@stop
