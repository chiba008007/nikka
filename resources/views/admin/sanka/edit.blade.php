@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.edit'))

@section('content_header')
    <p class="h4">{{ __('sanka.header.edit') }}</p>
@stop

@section('content')

@include('layouts.flash-message')
<x-participant-form
    :action="route('sanka.list.update', $participant->id)"
    :formItems="$formItems"
    :feeItems="$feeItems"
    :participant="$participant"
    method="PUT"
/>

@stop
@section('js')
<script>
$(function () {

});
</script>
@stop
