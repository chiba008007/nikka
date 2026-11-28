
@extends('adminlte::page')

@section('title', '学会公式サイト講演登録')

@section('content_header')
@stop

@section('content')
<div class="conference-page">
<x-top.koen :is-admin="false" :pageTops=$pageTops :banners="$banners" />
</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/top.css') }}">
    <style>
        body.public-top .main-sidebar,
        body.public-top .main-header,
        body.public-top .main-footer,
        body.public-top .content-header {
            display: none !important;
        }

        body.public-top .content-wrapper {
            margin-left: 0 !important;
            min-height: 100vh !important;
            background: #fff;
        }

        body.public-top .content,
        body.public-top .content > .container-fluid {
            padding: 0 !important;
        }
    </style>
@stop

@section('js')
<script>
    document.body.classList.add('public-top');
</script>
@stop
