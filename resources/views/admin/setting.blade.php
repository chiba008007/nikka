@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', "設定")

@section('content_header')
    <p class="h4">{{ __('設定') }}</p>
@stop

@section('content')

@include('layouts.flash-message')

<form method="POST" action="{{ route('home.list.setting.edit') }}">

    {{-- CSRF対策 --}}
    @csrf
    <button type="submit" class="btn btn-primary mb-2 w-100 sticky-save">
        保存
    </button>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title d-block">
                参加受付番号
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    参加受付番号{{ config('const.lang') }}
                    <input type="text" name="sankanumber[name_ja]" value="{{ old('sankanumber.name_ja', $form['sankanumber']->name_ja ?? '') }}" class="form-control" />
                </div>
                <div class="col-6">
                    &nbsp;
                    <input type="text" name="sankanumber[name_en]" value="{{ old('sankanumber.name_en', $form['sankanumber']->name_en ?? '') }}" class="form-control" />
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-1">
                    コード①
                    <input type="text" name="sankacode1[name_ja]" value="{{ old('sankacode1.name_ja', $form['sankacode1']->name_ja ?? '') }}" class="form-control" />
                </div>
                <div class="col-2">
                    コード②
                    <input type="text" name="sankacode2[name_ja]" value="{{ old('sankacode2.name_ja', $form['sankacode2']->name_ja ?? '') }}" class="form-control" />
                </div>
                <div class="col-2">
                    コード③
                    <input type="text" name="sankacode3[name_ja]" value="{{ old('sankacode3.name_ja', $form['sankacode3']->name_ja ?? '') }}" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-12">参加受付番号:例)
                    <span id="sankacode1">{{$form['sankacode1']->name_ja}}</span>0000-
                    <span id="sankacode2">{{$form['sankacode2']->name_ja}}</span>-
                    <span id="sankacode3">{{$form['sankacode3']->name_ja}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-header">
            <h3 class="card-title d-block">
                講演受付番号
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    講演受付番号{{ config('const.lang') }}
                    <input type="text" name="koennumber[name_ja]" value="{{ old('koennumber.name_ja', $form['koennumber']->name_ja ?? '') }}" class="form-control" />
                </div>
                <div class="col-6">
                    &nbsp;
                    <input type="text" name="koennumber[name_en]" value="{{ old('koennumber.name_en', $form['koennumber']->name_en ?? '') }}" class="form-control" />
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-1">
                    コード①
                    <input type="text" name="koencode1[name_ja]" value="{{ old('koencode1.name_ja', $form['koencode1']->name_ja ?? '') }}" class="form-control" />
                </div>
                <div class="col-2">
                    コード②
                    <input type="text" name="koencode2[name_ja]" value="{{ old('koencode2.name_ja', $form['koencode2']->name_ja ?? '') }}" class="form-control" />
                </div>
                <div class="col-2">
                    コード③
                    <input type="text" name="koencode3[name_ja]" value="{{ old('koencode3.name_ja', $form['koencode3']->name_ja ?? '') }}" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-12">講演受付番号:例)
                    <span id="koencode1">{{$form['koencode1']->name_ja}}</span>0000-
                    <span id="koencode2">{{$form['koencode2']->name_ja}}</span>-
                    <span id="koencode3">{{$form['koencode3']->name_ja}}</span>
                </div>
            </div>
        </div>
    </div>


</form>

@stop
@section('js')
<script>
$(function () {
    $('input[name="sankacode1[name_ja]"]').on('input', function () {
        $('#sankacode1').text($(this).val());
    });

    $('input[name="sankacode2[name_ja]"]').on('input', function () {
        $('#sankacode2').text($(this).val());
    });

    $('input[name="sankacode3[name_ja]"]').on('input', function () {
        $('#sankacode3').text($(this).val());
    });

    $('input[name="koencode1[name_ja]"]').on('input', function () {
        $('#koencode1').text($(this).val());
    });

    $('input[name="koencode2[name_ja]"]').on('input', function () {
        $('#koencode2').text($(this).val());
    });

    $('input[name="koencode3[name_ja]"]').on('input', function () {
        $('#koencode3').text($(this).val());
    });
});
</script>
@stop
