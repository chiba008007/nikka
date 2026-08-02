@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>入力ページ</h1>
@stop

@section('content')
    <form method="POST" action="{{ route('sanka.list.editform.update') }}">
        {{-- CSRF対策 --}}
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">

                {{-- タイトル --}}
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control"
                        value="{{ old('title', $form->title ?? '') }}"
                    >
                </div>

                {{-- ボタン名 --}}
                <div class="form-group">
                    <label>ボタン名</label>
                    <div class="form-row">
                        @foreach (['print', 'back', 'next', 'register'] as $name)
                            <div class="col-md-3">
                                <input
                                    type="text"
                                    name="{{ $name }}_label"
                                    class="form-control"
                                    value="{{ old($name.'_label', $form->{$name.'_label'} ?? '') }}"
                                >
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 説明文 --}}
                <div class="form-group">
                    <label for="description">説明文</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                    >{{ old('description', $form->description ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    保存
                </button>
            </div>
        </div>
    </form>
@stop

@section('js')
<script>
$(function () {
    // 説明文をリッチテキストエディタにする
    $('#description').summernote({
        height: 300,
        lang: 'ja-JP'
    });
});
</script>
@stop
