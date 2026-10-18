@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>要旨原稿登録フォーム編集</h1>
@stop
@php
    $enable = "有効";
@endphp
@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <form method="POST" action="{{ route('koen.manual.form.update') }}">
        <button type="submit" class="btn btn-primary mb-2 w-100">
            保存
        </button>
        {{-- CSRF対策 --}}
        @csrf

        <div class="card">
            <div class="card-body">
                <input type="hidden" name="status" value="1" />

                <div>{{ config('const.required_message') }}</div>

                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">タイトル{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualformtitle][note_ja]"
                            value="{{ old('authors.manualformtitle.note_ja', $form['manualformtitle']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualformtitle][note_en]"
                            value="{{ old('authors.manualformtitle.note_en', $form['manualformtitle']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">説明{{ config('const.lang') }}</label>
                        <textarea
                              type="text"
                              rows=4
                              class="form-control description"
                              name="authors[manualformexplain][note_ja]"
                            >{{ old('authors.manualformexplain.note_ja', $form['manualformexplain']->note_ja) }}</textarea>
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <textarea
                            rows=4
                            class="form-control description"
                            name="authors[manualformexplain][note_en]"
                            >{{ old('authors.manualformexplain.note_en', $form['manualformexplain']->note_en) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">フラッシュ発表用PPTファイルアップロード{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflash][note_ja]"
                            value="{{ old('authors.manualflash.note_ja', $form['manualflash']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflash][note_en]"
                            value="{{ old('authors.manualflash.note_en', $form['manualflash']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">添付ファイル削除{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflashdelete][note_ja]"
                            value="{{ old('authors.manualflashdelete.note_ja', $form['manualflashdelete']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflashdelete][note_en]"
                            value="{{ old('authors.manualflashdelete.note_en', $form['manualflashdelete']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">添付ファイルリンク{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflashlink][note_ja]"
                            value="{{ old('authors.manualflashlink.note_ja', $form['manualflashlink']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflashlink][note_en]"
                            value="{{ old('authors.manualflashlink.note_en', $form['manualflashlink']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">登録ボタン{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflashregistbutton][note_ja]"
                            value="{{ old('authors.manualflashregistbutton.note_ja', $form['manualflashregistbutton']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflashregistbutton][note_en]"
                            value="{{ old('authors.manualflashregistbutton.note_en', $form['manualflashregistbutton']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">エラーメッセージ{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflasherrormessage][note_ja]"
                            value="{{ old('authors.manualflasherrormessage.note_ja', $form['manualflasherrormessage']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualflasherrormessage][note_en]"
                            value="{{ old('authors.manualflasherrormessage.note_en', $form['manualflasherrormessage']->note_en) }}"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">ポスターデータ(PDF)ファイルアップロード{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopy][note_ja]"
                            value="{{ old('authors.manualcopy.note_ja', $form['manualcopy']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopy][note_en]"
                            value="{{ old('authors.manualcopy.note_en', $form['manualcopy']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">添付ファイル削除{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopydelete][note_ja]"
                            value="{{ old('authors.manualcopydelete.note_ja', $form['manualcopydelete']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopydelete][note_en]"
                            value="{{ old('authors.manualcopydelete.note_en', $form['manualcopydelete']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">添付ファイルリンク{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopylink][note_ja]"
                            value="{{ old('authors.manualcopylink.note_ja', $form['manualcopylink']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopylink][note_en]"
                            value="{{ old('authors.manualcopylink.note_en', $form['manualcopylink']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">登録ボタン{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopyregistbutton][note_ja]"
                            value="{{ old('authors.manualcopyregistbutton.note_ja', $form['manualcopyregistbutton']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopyregistbutton][note_en]"
                            value="{{ old('authors.manualcopyregistbutton.note_en', $form['manualcopyregistbutton']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">エラーメッセージ{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopyerrormessage][note_ja]"
                            value="{{ old('authors.manualcopyerrormessage.note_ja', $form['manualcopyerrormessage']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualcopyerrormessage][note_en]"
                            value="{{ old('authors.manualcopyerrormessage.note_en', $form['manualcopyerrormessage']->note_en) }}"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">予稿現行登録ファイルアップロード{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfile][note_ja]"
                            value="{{ old('authors.manualfile.note_ja', $form['manualfile']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfile][note_en]"
                            value="{{ old('authors.manualfile.note_en', $form['manualfile']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">添付ファイル削除{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfiledelete][note_ja]"
                            value="{{ old('authors.manualfiledelete.note_ja', $form['manualfiledelete']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfiledelete][note_en]"
                            value="{{ old('authors.manualfiledelete.note_en', $form['manualfiledelete']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">添付ファイルリンク{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfilelink][note_ja]"
                            value="{{ old('authors.manualfilelink.note_ja', $form['manualfilelink']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfilelink][note_en]"
                            value="{{ old('authors.manualfilelink.note_en', $form['manualfilelink']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">登録ボタン{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfileregistbutton][note_ja]"
                            value="{{ old('authors.manualfileregistbutton.note_ja', $form['manualfileregistbutton']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfileregistbutton][note_en]"
                            value="{{ old('authors.manualfileregistbutton.note_en', $form['manualfileregistbutton']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">エラーメッセージ{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfileerrormessage][note_ja]"
                            value="{{ old('authors.manualfileerrormessage.note_ja', $form['manualfileerrormessage']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfileerrormessage][note_en]"
                            value="{{ old('authors.manualfileerrormessage.note_en', $form['manualfileerrormessage']->note_en) }}"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="text-h4">要旨原稿登録フォーム完了画面</h4>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">要旨原稿登録フォーム完了画面{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfinish][note_ja]"
                            value="{{ old('authors.manualfinish.note_ja', $form['manualfinish']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfinish][note_en]"
                            value="{{ old('authors.manualfinish.note_en', $form['manualfinish']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">要旨原稿登録フォーム完了メッセージ{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfinishmessage][note_ja]"
                            value="{{ old('authors.manualfinishmessage.note_ja', $form['manualfinishmessage']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfinishmessage][note_en]"
                            value="{{ old('authors.manualfinishmessage.note_en', $form['manualfinishmessage']->note_en) }}"
                        >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">講演申込ページへ戻るボタン{{ config('const.lang') }}</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfinishback][note_ja]"
                            value="{{ old('authors.manualfinishback.note_ja', $form['manualfinishback']->note_ja) }}"
                        >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            class="form-control"
                            type="text"
                            name="authors[manualfinishback][note_en]"
                            value="{{ old('authors.manualfinishback.note_en', $form['manualfinishback']->note_en) }}"
                        >
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('js')
@vite(['resources/js/app.js'])

<script>
$(function () {
    initSummernote('.description', 200);

    // 説明文をリッチテキストエディタにする
    $('.description').summernote({
        height: 150,
        lang: 'ja-JP',
    });
});
</script>
@stop
@section('css')
<style >

</style>
@stop
