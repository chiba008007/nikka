@extends('adminlte::page')

{{-- リッチテキストエディタを有効化 --}}
@section('plugins.Summernote', true)

@section('title', __('sanka.title.editform'))

@section('content_header')
    <h1>講演ログインフォーム</h1>
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
    <form method="POST" action="{{ route('koen.list.author.update') }}">
        <button type="submit" class="btn btn-primary mb-2 w-100">
            保存
        </button>
        {{-- CSRF対策 --}}
        @csrf

        <div class="card">
            <div class="card-body">
                <input type="hidden" name="status" value="1" />
                <!-- <div class="mb-2">
                    <label>
                        <input
                            type="checkbox"
                            name="status"
                            value="1"
                            {{ old('status', $form['author_title']->status) ? 'checked' : '' }}
                        >
                        有効
                    </label>

                    <label class="ml-3">
                        <input
                            type="checkbox"
                            name="required"
                            value="1"
                            {{ old('required', $form['author_title']->required) ? 'checked' : '' }}
                        >
                        必須
                    </label>
                </div> -->
                <div>{{ config('const.required_message') }}</div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">著者の所属機関{{ config('const.lang') }}</label>
                        <input
                              type="text"
                              name="authors[author_title][note_ja]"
                              value="{{ old('authors.author_title.note_ja', $form['author_title']->note_ja) }}"
                              class="form-control "
                              >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_title][note_en]"
                            value="{{ old('authors.author_title.note_en', $form['author_title']->note_en) }}"
                            >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">総数{{ config('const.lang') }}</label>
                        <input
                              type="text"
                              class="form-control"
                              name="authors[author_count][note_ja]"
                              value="{{ old('authors.author_count.note_ja', $form['author_count']->note_ja) }}"
                            >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control "
                            name="authors[author_count][note_en]"
                            value="{{ old('authors.author_count.note_en', $form['author_count']->note_en) }}"
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
                              name="authors[author_explain][note_ja]"
                            >{{ old('authors.author_explain.note_ja', $form['author_explain']->note_ja) }}</textarea>
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <textarea
                            rows=4
                            class="form-control description"
                            name="authors[author_explain][note_en]"
                            >{{ old('authors.author_explain.note_en', $form['author_explain']->note_en) }}</textarea>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">所属番号{{ config('const.lang') }}</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_number][note_ja]"
                            value="{{ old('authors.author_number.note_en', $form['author_number']->note_ja) }}"
                            >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_number][note_en]"
                            value="{{ old('authors.author_number.note_en', $form['author_number']->note_en) }}"
                            >
                    </div>
                </div>
                <div class="card borderarea">
                    <div class="row mt-1">
                        <div class="col-6">
                            <label class="mb-0 ">所属機関(正式名){{ config('const.lang') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_kikan][note_ja]"
                                value="{{ old('authors.author_kikan.note_en', $form['author_kikan']->note_ja) }}"
                                >
                        </div>

                        <div class="col-6">
                            <label class="mb-0">&nbsp;</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_kikan][note_en]"
                                value="{{ old('authors.author_kikan.note_en', $form['author_kikan']->note_en) }}"
                                >
                        </div>
                        <div class="col-6 mt-1">
                            <label class="mb-0 ">大学名 {{ config('const.placeholder')}}{{ config('const.lang') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_kikan_placeholder][note_ja]"
                                value="{{ old('authors.author_kikan_placeholder.note_en', $form['author_kikan_placeholder']->note_ja) }}"
                                >
                        </div>

                        <div class="col-6">
                            <label class="mb-0">&nbsp;</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_kikan_placeholder][note_en]"
                                value="{{ old('authors.author_kikan_placeholder.note_en', $form['author_kikan_placeholder']->note_en) }}"
                                >
                        </div>
                        <div class="col-6 mt-1">
                            <label class="mb-0 ">学部名 {{ config('const.placeholder')}}{{ config('const.lang') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_kikan_gakubu_placeholder][note_ja]"
                                value="{{ old('authors.author_kikan_gakubu_placeholder.note_en', $form['author_kikan_gakubu_placeholder']->note_ja) }}"
                                >
                        </div>

                        <div class="col-6">
                            <label class="mb-0">&nbsp;</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_kikan_gakubu_placeholder][note_en]"
                                value="{{ old('authors.author_kikan_gakubu_placeholder.note_en', $form['author_kikan_gakubu_placeholder']->note_en) }}"
                                >
                        </div>
                    </div>
                </div>
                <div class="card borderarea">
                    <div class="row mt-1">
                        <div class="col-6">
                            <label class="mb-0">所属機関(略称){{ config('const.lang') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_ryaku][note_ja]"
                                value="{{ old('authors.author_ryaku.note_en', $form['author_ryaku']->note_ja) }}"
                                >
                        </div>

                        <div class="col-6">
                            <label class="mb-0">&nbsp;</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_ryaku][note_en]"
                                value="{{ old('authors.author_ryaku.note_en', $form['author_ryaku']->note_en) }}"
                                >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label class="mb-0">{{ config('const.placeholder')}} {{ config('const.lang') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_ryaku_placeholder][note_ja]"
                                value="{{ old('authors.author_ryaku_placeholder.note_en', $form['author_ryaku_placeholder']->note_ja) }}"
                                >
                        </div>

                        <div class="col-6">
                            <label class="mb-0">&nbsp;</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_ryaku_placeholder][note_en]"
                                value="{{ old('authors.author_ryaku_placeholder.note_en', $form['author_ryaku_placeholder']->note_en) }}"
                                >
                        </div>
                    </div>
                </div>
                <div class="card borderarea">
                    <div class="row mt-1">
                        <div class="col-6">
                            <label class="mb-0">所属機関(英語){{ config('const.lang') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_english][note_ja]"
                                value="{{ old('authors.author_english.note_en', $form['author_english']->note_ja) }}"
                                >
                        </div>

                        <div class="col-6">
                            <label class="mb-0">&nbsp;</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_english][note_en]"
                                value="{{ old('authors.author_english.note_en', $form['author_english']->note_en) }}"
                                >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label class="mb-0">大学名 {{ config('const.placeholder')}} {{ config('const.lang') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_english_placeholder][note_ja]"
                                value="{{ old('authors.author_english_placeholder.note_en', $form['author_english_placeholder']->note_ja) }}"
                                >
                        </div>

                        <div class="col-6">
                            <label class="mb-0">&nbsp;</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_english_placeholder][note_en]"
                                value="{{ old('authors.author_english_placeholder.note_en', $form['author_english_placeholder']->note_en) }}"
                                >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-6">
                            <label class="mb-0">略 {{ config('const.placeholder')}} {{ config('const.lang') }}</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_english_ryaku_placeholder][note_ja]"
                                value="{{ old('authors.author_english_ryaku_placeholder.note_en', $form['author_english_ryaku_placeholder']->note_ja) }}"
                                >
                        </div>

                        <div class="col-6">
                            <label class="mb-0">&nbsp;</label>
                            <input
                                type="text"
                                class="form-control"
                                name="authors[author_english_ryaku_placeholder][note_en]"
                                value="{{ old('authors.author_english_ryaku_placeholder.note_en', $form['author_english_ryaku_placeholder']->note_en) }}"
                                >
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div>{{ config('const.required_message') }}</div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">著者名 {{ config('const.lang') }}</label>
                        <input
                              type="text"
                              name="authors[author_name][note_ja]"
                              value="{{ old('authors.author_name.note_ja', $form['author_name']->note_ja) }}"
                              class="form-control "
                              >
                    </div>
                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                              type="text"
                              name="authors[author_name][note_en]"
                              value="{{ old('authors.author_name.note_en', $form['author_name']->note_en) }}"
                              class="form-control "
                              >
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">著者名の総数 {{ config('const.lang') }}</label>
                        <input
                              type="text"
                              class="form-control"
                              name="authors[author_name_count][note_ja]"
                              value="{{ old('authors.author_name_count.note_ja', $form['author_name_count']->note_ja) }}"
                            >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control "
                            name="authors[author_name_count][note_en]"
                            value="{{ old('authors.author_name_count.note_en', $form['author_name_count']->note_en) }}"
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
                              name="authors[author_name_explain][note_ja]"
                            >{{ old('authors.author_name_explain.note_ja', $form['author_name_explain']->note_ja) }}</textarea>
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <textarea
                            rows=4
                            class="form-control description"
                            name="authors[author_name_explain][note_en]"
                            >{{ old('authors.author_name_explain.note_en', $form['author_name_explain']->note_en) }}</textarea>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">講演者{{ config('const.lang') }}</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_speak][note_ja]"
                            value="{{ old('authors.author_speak.note_en', $form['author_speak']->note_ja) }}"
                            >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_speak][note_en]"
                            value="{{ old('authors.author_speak.note_en', $form['author_speak']->note_en) }}"
                            >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">受賞時連絡先(指導教員){{ config('const.lang') }}</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_contact][note_ja]"
                            value="{{ old('authors.author_contact.note_en', $form['author_contact']->note_ja) }}"
                            >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_contact][note_en]"
                            value="{{ old('authors.author_contact.note_en', $form['author_contact']->note_en) }}"
                            >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">著者名(和){{ config('const.lang') }}</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_speak_ja][note_ja]"
                            value="{{ old('authors.author_speak_ja.note_en', $form['author_speak_ja']->note_ja) }}"
                            >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_speak_ja][note_en]"
                            value="{{ old('authors.author_speak_ja.note_en', $form['author_speak_ja']->note_en) }}"
                            >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">著者名(英){{ config('const.lang') }}</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_speak_en][note_ja]"
                            value="{{ old('authors.author_speak_en.note_en', $form['author_speak_en']->note_ja) }}"
                            >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_speak_en][note_en]"
                            value="{{ old('authors.author_speak_en.note_en', $form['author_speak_en']->note_en) }}"
                            >
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">所属番号(半角数値){{ config('const.lang') }}</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_connect_number][note_ja]"
                            value="{{ old('authors.author_connect_number.note_en', $form['author_connect_number']->note_ja) }}"
                            >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_connect_number][note_en]"
                            value="{{ old('authors.author_connect_number.note_en', $form['author_connect_number']->note_en) }}"
                            >
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">備考{{ config('const.lang') }}</label>
                        <textarea
                              type="text"
                              rows=4
                              class="form-control description"
                              name="authors[author_other][note_ja]"
                            >{{ old('authors.author_other.note_ja', $form['author_other']->note_ja) }}</textarea>
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <textarea
                            rows=4
                            class="form-control description"
                            name="authors[author_other][note_en]"
                            >{{ old('authors.author_other.note_en', $form['author_other']->note_en) }}</textarea>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-6">
                        <label class="mb-0">予行原稿登録{{ config('const.lang') }}</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_draft][note_ja]"
                            value="{{ old('authors.author_draft.note_en', $form['author_draft']->note_ja) }}"
                            >
                    </div>

                    <div class="col-6">
                        <label class="mb-0">&nbsp;</label>
                        <input
                            type="text"
                            class="form-control"
                            name="authors[author_draft][note_en]"
                            value="{{ old('authors.author_draft.note_en', $form['author_draft']->note_en) }}"
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
    .borderarea{
        background-color: #f8faff;
        border-left: 5px solid #007bff;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        margin-top:15px;
        padding:10px;
    }
</style>
@stop
