@extends('adminlte::page')

@section('title', isset($banner) ? 'バナー編集' : 'バナー新規登録')

@section('content_header')
    <p class="h4">
        {{ isset($banner) ? 'バナー編集' : 'バナー新規登録' }}
    </p>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ isset($banner)
            ? route('edit.top.banner.update', $banner->id)
            : route('edit.top.banner.store') }}"
            method="POST" enctype="multipart/form-data">

            @csrf

            @if(isset($banner))
                @method('PUT')
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <label>バナー画像</label>
                @if(isset($banner))
                    <img src="{{ asset('storage/' . $banner->image) }}"
                        class="mb-3" style="max-width: 200px;">
                @endif

                <input type="file" name="image"
                      class="form-control-file"
                      accept="image/*"
                      @required(!isset($banner))>
            </div>

            <div class="form-group">
                <label>リンク先URL</label>
                <input type="url" name="url"
                       class="form-control"
                       value="{{ old('url', $banner->url ?? '') }}">
            </div>

            <div class="form-group">
                <label>表示順</label>
                <input type="number" name="sort"
                       class="form-control w-25"
                       value="{{ old('sort', $banner->sort ?? 0) }}" required>
            </div>

            <div class="form-group">
                <label>公開状態</label>
                <select name="status" class="form-control w-25">
                  <option value="1" @selected(old('status', $banner->status ?? 1) == 1)>公開</option>
                  <option value="0" @selected(old('status', $banner->status ?? 1) == 0)>非公開</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                {{ isset($banner) ? '更新' : '登録' }}
            </button>

            <a href="{{ route('edit.top.banner.index') }}"
               class="btn btn-secondary">
                一覧に戻る
            </a>
        </form>

    </div>
</div>

@stop
