@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('title', __('sanka.title.mailedit'))

@section('content_header')
    <p class="h4">{{ __('sanka.header.mailedit') }}</p>
@stop

@section('content')

<div class="row">
  <div class="col-6">
      <div class="card p-3">
          <h4>{{ __('sanka.header.mailedit') }}</h4>

          <form
              method="POST"
              action="{{ route('home.list.mail.update') }}"
            >
              @csrf

              <div class="row">
                  <div class="col-12">

                      {{-- メール種別 --}}
                      <label class="mt-3">メール種別</label>
                      <select
                            name="mail_type"
                            class="form-control"
                        >
                            @foreach ($mailType as $key => $value)
                                <option
                                    value="{{ $key }}"
                                    {{ old('mail_type', $selectedMailType) === $key ? 'selected' : '' }}
                                >
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>

                      {{-- 新規登録時件名 --}}
                      <label class="mt-3">新規登録時の件名</label>
                      <input
                          type="text"
                          name="create_subject"
                          class="form-control"
                          value="{{ old('create_subject', $mailTemplate->create_subject ?? '') }}"
                      >

                      {{-- 編集時件名 --}}
                      <label class="mt-3">登録内容変更時の件名</label>
                      <input
                          type="text"
                          name="update_subject"
                          class="form-control"
                          value="{{ old('update_subject', $mailTemplate->update_subject ?? '') }}"
                      >

                      {{-- 本文 --}}
                      <label class="mt-3">本文</label>
                      <textarea
                          name="body"
                          class="form-control"
                          rows="20"
                      >{{ old('body', $mailTemplate->body ?? '') }}</textarea>

                      {{-- 更新ボタン --}}
                      <button
                          type="submit"
                          class="btn btn-primary mt-3"
                      >
                          更新する
                      </button>

                  </div>
              </div>
          </form>
      </div>
  </div>
  <div class="col-6">
    <div class="card p-3">
      <div class="d-flex">
        <h4>置き換え</h4>
        <span class="mt-2 ml-2">メール内容に貼付けしてください。</span>
      </div>
        @for ($i = 1; $i <= 50; $i++)
            @php
                $title = $sankaFormItem['title' . $i] ?? null;
                $column = $sankaFormItem['add_column_' . $i] ?? null;
            @endphp

            @if ($title && $column)
                <div class="mt-2 ">
                    <b>{{ $title->label_ja }}</b>
                </div>

                <div class="row">
                    <div class="{{ $column->column == 2 ? 'col-4' : 'col-12' }}">
                        ##{{ $column->name }}##
                    </div>

                    @if ($column->column == 2)
                        @php
                            $nextColumn = $sankaFormItem['add_column_' . ($i + 1)] ?? null;
                        @endphp

                        @if ($nextColumn)
                            <div class="col-8">
                                ##{{ $nextColumn->name }}##
                            </div>
                        @endif

                        @php
                            $i++;
                        @endphp
                    @endif
                </div>
            @endif
        @endfor
    </div>
  </div>
</div>
@stop
@section('js')
<script>
$(function () {
  $("[name=mail_type]").change(function(){
    var mail_type = $(this).val();
    location.href = "/home/list/mail?mail_type="+mail_type;
  });
});
</script>
@stop
