@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.create'))

@section('content_header')
    <p class="h4">{{ __('sanka.header.create') }}</p>
@stop

@section('content')

@include('layouts.flash-message')
<x-participant-form
    :action="route('sanka.list.store')"
    :formItems="$formItems"
    :feeItems="$feeItems"
/>

@stop
@section('js')
<script>
$(function () {

});
</script>
@stop
