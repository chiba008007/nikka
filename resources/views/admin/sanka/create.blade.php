@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.create'))

@section('content_header')
    <p class="h4">{{ __('sanka.header.create') }}</p>
@stop

@section('content')
<x-participant-form
    :action="route('sanka.list.store')"
    :address-types="$addressTypes"
    :expertise-types="$expertiseTypes"
    :society-types="$societyTypes"
    :join-types="$joinTypes"
/>

@stop
@section('js')
<script>
$(function () {

});
</script>
@stop
