@extends('adminlte::page')

@section('title', 'ダッシュボード')
@section('plugins.Chartjs', true)

@section('content_header')

@stop

@section('content')

<div class="row mt-2">
    @php
        $items = [
            ['参加登録数', 125, 'info', 'users', 'sanka.list.index'],
            ['講演登録数', 82, 'success', 'microphone', 'koen.list.index'],
            ['要旨原稿登録数', 65, 'warning', 'file-alt', 'koen.list.index'],
            ['協賛バナー数', 8, 'danger', 'image', 'edit.top.banner.index'],
        ];
    @endphp

    @foreach ($items as [$label, $count, $color, $icon, $route])
        <div class="col-lg-3 col-6">
            <div class="small-box bg-{{ $color }}">
                <div class="inner">
                    <h3>{{ $count }}</h3>
                    <p>{{ $label }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-{{ $icon }}"></i>
                </div>
                <a href="{{ route($route) }}" class="small-box-footer">
                    一覧を見る <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    @endforeach
</div>

<div class="row mt-2">

    <div class="card d-block w-100">
        <div class="card-body">
            <h5 class="card-title float-none">事前参加登録のご案内ページの編集を行います。</h5>
            <div class="d-block">
                <p class="card-text">
                    <p>▼事前参加申込URL</p>
                    <a href="{{ secure_url('/top') }}" target="_blank" rel="noopener noreferrer">
                        {{ secure_url('/top') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script>
$(function () {

});
</script>
@stop
