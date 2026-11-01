<style>
  .required-label {
    margin-left: 6px;
    color: #dc3545;
    font-size: 13px;
  }
</style>
@props([
    'code',
    'endai',
    'koenFormItems',
])

<div class="card">
    <div class="card-header">
        <h3 class="card-title d-block">講演登録</h3>
        <x-language-switch />
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-12 d-flex">
                <div class="col-12 d-flex px-0">
                  <label class="jp">{{ $code['sankanumber']->name_ja }}</label>
                  <label class="en">{{ $code['sankanumber']->name_en }}</label>

                  <div class="d-flex ml-5">
                    <span class="pt-2">{{ $code['sankacode1']->name_ja }}</span>
                    <input type="text" id="reception_number" value="" class="form-control" placeholder="例)0001" />
                  </div>
                  <div class="pt-2"> - {{ $code['sankacode2']->name_ja }} - </div>
                  <div class="pt-2">{{ $code['sankacode3']->name_ja }}</div>
                </div>
            </div>
        </div>

        @foreach ($endai as $item)
          @if($item->label_ja)
            <div class="row mt-3">
                <div class="col-3">
                    <label class="jp">
                        {{ $item->label_ja }}
                        @if ($item->required_text)
                            <span class="required-label">
                                {{ $item->required_text }}
                            </span>
                        @endif
                    </label>

                    <label class="en">
                        {{ $item->label_en }}
                        @if ($item->required_text_en)
                            <span class="required-label">
                                {{ $item->required_text_en }}
                            </span>
                        @endif
                    </label>
                </div>
                <div class="col-8">
                    <span class="participant-value jp ml-2" data-title="{{ $item->name }}"></span>
                    <span class="participant-value en ml-2" data-title="{{ $item->name }}"></span>
                </div>
            </div>
          @endif
        @endforeach
    </div>
</div>

<div class="card">
    <div class="card-body">
        @foreach ($koenFormItems as $item)
            <div class="row mt-3 koen-form-item"
              data-name="{{ $item->name }}"
              data-source="{{ $item->enable_source_name }}"
              data-value="{{ $item->enable_source_value }}">
                <div class="col-3">
                    <label class="jp">
                        {{ $item->label_ja }}
                        @if ($item->required_text)
                            <span class="required-label">
                                {{ $item->required_text }}
                            </span>
                        @endif
                    </label>

                    <label class="en">
                        {{ $item->label_en }}
                        @if ($item->required_text_en)
                            <span class="required-label">
                                {{ $item->required_text_en }}
                            </span>
                        @endif
                    </label>
                </div>
                <div class="col-8">
                    <div class="jp pa-0 ">{{ $item->explain_jp }}</div>
                    <div class="en pa-0 ">{{ $item->explain_en }}</div>
                    <div class="jp pa-0 ">{{ $item->checkbox_note_description }}</div>
                    <div class="en pa-0 ">{{ $item->checkbox_note_description_en }}</div>

                    @switch($item->type_code)
                      @case('radio')
                          <div class="d-flex flex-wrap" data-toggle="buttons">
                              @foreach ($item->options as $option)
                                  @php
                                      $checked = old($item->name) == $option->value;
                                  @endphp

                                  <label class="btn btn-outline-primary mr-2 mb-2
                                      {{ $checked ? 'active' : '' }}">
                                      <input type="radio"
                                            data-label-ja="{{ $option->label_ja }}"
                                            name="{{ $item->name }}"
                                            value="{{ $option->value }}"
                                            autocomplete="off"
                                            {{ $checked ? 'checked' : '' }}>

                                      <span class="jp">{{ $option->label_ja }}</span>
                                      <span class="en">{{ $option->label_en }}</span>
                                  </label>
                              @endforeach
                          </div>
                          @break

                        @case('select')
                            <select name="{{ $item->name }}" class="form-control">
                                <option value="">-</option>
                                @foreach ($item->options as $option)
                                    <option value="{{ $option->value }}"
                                        data-label-ja="{{ $option->label_ja }}"
                                        {{ old($item->name) == $option->value ? 'selected' : '' }}>
                                        {{ $option->label_ja }}
                                    </option>
                                @endforeach
                            </select>
                            @break

                        @case('checkbox')
                            @foreach ($item->options as $option)
                                <label class="mr-3">
                                    <input type="checkbox"
                                           name="{{ $item->name }}[]"
                                           value="{{ $option->value }}"
                                           {{ in_array((string) $option->value, array_map('strval', old($item->name, []))) ? 'checked' : '' }}>
                                    <span class="jp">{{ $option->label_ja }}</span>
                                    <span class="en">{{ $option->label_en }}</span>
                                </label>
                            @endforeach
                            @break

                        @case('textarea')
                            <textarea name="{{ $item->name }}"
                                      class="form-control js-language-input description"
                                      placeholder="{{ $item->placeholder_ja }}"
                                      data-placeholder-ja="{{ $item->placeholder_ja }}"
                                      data-placeholder-en="{{ $item->placeholder_en }}">{{ old($item->name) }}</textarea>
                            @break

                        @default
                            <input type="{{ $item->type_code === 'password' ? 'password' : 'text' }}"
                                   name="{{ $item->name }}"
                                   class="form-control js-language-input"
                                   value="{{ $item->type_code === 'password' ? '' : old($item->name) }}"
                                   placeholder="{{ $item->placeholder_ja }}"
                                   data-placeholder-ja="{{ $item->placeholder_ja }}"
                                   data-placeholder-en="{{ $item->placeholder_en }}">
                    @endswitch
                </div>
            </div>
        @endforeach
    </div>
</div>

@section('js')
@vite(['resources/js/app.js'])
<script>
$(function () {
    initSummernote('.description', 40);

    // 説明文をリッチテキストエディタにする
    $('.description').summernote({
        height: 40,
        lang: 'ja-JP',
    });
    $('#reception_number').on('input', function () {

        // 入力が変わったら保存を無効化
        $('#save-button').prop('disabled', true);
        $('.participant-value').text('');

        const serial = $(this).val().trim();
        // 前回取得した表示内容をクリア
        $('.participant-value').text('');
        if (!/^\d{4}$/.test(serial)) return;

        $.ajax({
            url: "{{ route('koen.participant.search') }}",
            type: 'GET',
            data: { serial: serial },
            success: function (response) {
              const values = response.participant?.values ?? {};

              $('.participant-value').each(function () {
                  const title = $(this).data('title');
                  const lang = $(this).hasClass('en') ? 'en' : 'ja';

                  $(this).text(values[title]?.[lang] ?? '');
              });

              // データ取得成功時のみ有効化
              $('#save-button').prop('disabled', false);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
            }
        });
    });

    function updateEnabledFields() {
      $('.koen-form-item').each(function () {
          const $row = $(this);
          const source = $row.attr('data-source');
          const expected = $row.attr('data-value');

          if (!source) return;

          const $input = $('[name]').filter(function () {
              return this.name === source;
          });

          const $selected = $input.is('select')
              ? $input.find('option:selected')
              : $input.filter(':checked');

          const label = $selected.attr('data-label-ja') ?? '';
          const enabled = !$input.prop('disabled') && label === expected;

          $row.find(':input').prop('disabled', !enabled);
      });
    }

    $(document).on('change', '.koen-form-item :input', updateEnabledFields);
    updateEnabledFields();

});

</script>
@stop
