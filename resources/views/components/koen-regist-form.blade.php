
@props([
    'code',
    'endai',
    'koenFormItems',
    'description',
    'authorOptions',
    'form' => []
])

<div class="card">
    <div class="card-header">
        <h3 class="card-title d-block">講演登録</h3>
        <x-language-switch />
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <div class="row">
            <div class="col-12 d-flex">
                <div class="col-12 d-flex px-0">
                  <label class="jp">{{ $code['sankanumber']->name_ja }}</label>
                  <label class="en">{{ $code['sankanumber']->name_en }}</label>

                  <div class="d-flex ml-5">
                    <span class="pt-2">{{ $code['sankacode1']->name_ja }}</span>
                    <input type="text" id="reception_number" name="reception_number" value="{{ old('reception_number', $form['reception_number'] ?? '') }}" class="form-control" placeholder="例)0001" />
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
                                      $checked = old($item->name, $form[$item->name] ?? null) == $option->value;
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
                                        {{ old($item->name, $form[$item->name] ?? null) == $option->value ? 'selected' : '' }}>
                                        {{ $option->label_ja }}
                                    </option>
                                @endforeach
                            </select>
                            @break

                        @case('checkbox')
                            @foreach ($item->options as $option)
                                <label class="mr-3">

                                    @php
                                        $saved = $form[$item->name] ?? [];
                                        $saved = is_string($saved) ? (json_decode($saved, true) ?? []) : $saved;
                                        $selected = old($item->name, $saved);
                                    @endphp
                                    <input type="checkbox"
                                           name="{{ $item->name }}[]"
                                           value="{{ $option->value }}"
                                            @checked(in_array(
                                                (string) $option->value,
                                                array_map('strval', (array) $selected),
                                                true
                                            ))
                                        >
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
                                      data-placeholder-en="{{ $item->placeholder_en }}">{{ old($item->name, $form[$item->name] ?? null) }}</textarea>
                            @break

                        @default
                            <input type="{{ $item->type_code === 'password' ? 'password' : 'text' }}"
                                   name="{{ $item->name }}"
                                   class="form-control js-language-input"
                                   value="{{ $item->type_code === 'password' ? '' : old($item->name, $form[$item->name] ?? null) }}"
                                   placeholder="{{ $item->placeholder_ja }}"
                                   data-placeholder-ja="{{ $item->placeholder_ja }}"
                                   data-placeholder-en="{{ $item->placeholder_en }}">
                    @endswitch
                </div>
            </div>
        @endforeach

        @if ($description)
            <div class="jp">{!! $description->note_ja !!}</div>
            <div class="en">{!! $description->note_en !!}</div>
        @endif

        <!-- 著者の所属機関 -->

        @php
            $labels = $authorOptions->keyBy('type');
            $note = fn ($key, $lang = 'ja') =>
                $labels->get($key)?->getAttribute('note_' . $lang) ?? '';

            $maxCount = 10;
            $affCount = min($maxCount, max(1, (int) old(
                'affiliation_count',
                count($form['affiliations'] ?? [])
            )));

            $authorCount = min($maxCount, max(1, (int) old(
                'author_count',
                count($form['authors'] ?? [])
            )));
        @endphp

        <div id="koen-author-ui" class="mt-4">

            {{-- 著者の所属機関 --}}
            <h5 class="koen-section-title">
                <span class="jp">{{ $note('author_title') }}</span>
                <span class="en">{{ $note('author_title', 'en') }}</span>
            </h5>

            <div class="koen-count">
                <label for="affiliation-count">
                    <span class="jp">
                        {{ preg_replace('/[0-9]+$/u', '', $note('author_count')) }}
                    </span>
                    <span class="en">{{ $note('author_count', 'en') }}</span>
                </label>

                <select id="affiliation-count"
                        name="affiliation_count"
                        class="form-control form-control-sm">
                    @for ($i = 1; $i <= $maxCount; $i++)
                        <option value="{{ $i }}" @selected($affCount === $i)>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="koen-explain">
                <div class="jp">{{ $note('author_explain') }}</div>
                <div class="en">{{ $note('author_explain', 'en') }}</div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered koen-input-table">
                    <colgroup>
                        <col style="width: 4%">
                        <col style="width: 32%">
                        <col style="width: 32%">
                        <col style="width: 32%">
                    </colgroup>
                    <thead>
                        <tr>
                            @foreach ([
                                'author_number',
                                'author_kikan',
                                'author_ryaku',
                                'author_english'
                            ] as $key)
                                <th>
                                    <span class="jp">{{ $note($key) }}</span>
                                    <span class="en">{{ $note($key, 'en') }}</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody id="affiliation-rows">
                        @for ($i = 1; $i <= $maxCount; $i++)
                            <tr>
                                <td class="text-center">{{ $i }}</td>

                                <td>
                                    <input type="text"
                                        name="affiliations[{{ $i }}][organization]"
                                        class="form-control form-control-sm mb-1 js-language-input"
                                        value="{{ old("affiliations.$i.organization", $form['affiliations'][$i]['organization'] ?? '') }}"
                                        placeholder="{{ $note('author_kikan_placeholder') }}"
                                        data-placeholder-ja="{{ $note('author_kikan_placeholder') }}"
                                        data-placeholder-en="{{ $note('author_kikan_placeholder', 'en') }}">

                                    <input type="text"
                                        name="affiliations[{{ $i }}][department]"
                                        class="form-control form-control-sm js-language-input"
                                        value="{{ old("affiliations.$i.department", $form['affiliations'][$i]['department'] ?? '') }}"
                                        placeholder="{{ $note('author_kikan_gakubu_placeholder') }}"
                                        data-placeholder-ja="{{ $note('author_kikan_gakubu_placeholder') }}"
                                        data-placeholder-en="{{ $note('author_kikan_gakubu_placeholder', 'en') }}">
                                </td>

                                <td>
                                    <input type="text"
                                        name="affiliations[{{ $i }}][short_name]"
                                        class="form-control form-control-sm js-language-input"
                                        value="{{ old("affiliations.$i.short_name", $form['affiliations'][$i]['short_name'] ?? '') }}"
                                        placeholder="{{ $note('author_ryaku_placeholder') }}"
                                        data-placeholder-ja="{{ $note('author_ryaku_placeholder') }}"
                                        data-placeholder-en="{{ $note('author_ryaku_placeholder', 'en') }}">
                                </td>

                                <td>
                                    <input type="text"
                                        name="affiliations[{{ $i }}][english]"
                                        class="form-control form-control-sm mb-1 js-language-input"
                                        value="{{ old("affiliations.$i.english", $form['affiliations'][$i]['english'] ?? '') }}"
                                        placeholder="{{ $note('author_english_placeholder') }}"
                                        data-placeholder-ja="{{ $note('author_english_placeholder') }}"
                                        data-placeholder-en="{{ $note('author_english_placeholder', 'en') }}">

                                    <input type="text"
                                        name="affiliations[{{ $i }}][english_short]"
                                        class="form-control form-control-sm js-language-input"
                                        value="{{ old("affiliations.$i.english_short", $form['affiliations'][$i]['english_short'] ?? '') }}"
                                        placeholder="{{ $note('author_english_ryaku_placeholder') }}"
                                        data-placeholder-ja="{{ $note('author_english_ryaku_placeholder') }}"
                                        data-placeholder-en="{{ $note('author_english_ryaku_placeholder', 'en') }}">
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            {{-- 著者名 --}}
            <h5 class="koen-section-title mt-4">
                <span class="jp">{{ $note('author_name') }}</span>
                <span class="en">{{ $note('author_name', 'en') }}</span>
            </h5>

            <div class="koen-count">
                <label for="author-count">
                    <span class="jp">{{ $note('author_name_count') }}</span>
                    <span class="en">{{ $note('author_name_count', 'en') }}</span>
                </label>

                <select id="author-count"
                        name="author_count"
                        class="form-control form-control-sm">
                    @for ($i = 1; $i <= $maxCount; $i++)
                        <option value="{{ $i }}" @selected($authorCount === $i)>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="koen-explain mt-3">
                <div class="jp">{!! $note('author_name_explain') !!}</div>
                <div class="en">{!! $note('author_name_explain', 'en') !!}</div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered koen-input-table">
                    <colgroup>
                        <col style="width: 5%">
                        <col style="width: 9%">
                        <col style="width: 32%">
                        <col style="width: 32%">
                        <col style="width: 22%">
                    </colgroup>
                    <thead>
                        <tr>
                            @foreach ([
                                'author_speak',
                                'author_contact',
                                'author_speak_ja',
                                'author_speak_en',
                                'author_connect_number'
                            ] as $key)
                                <th>
                                    <span class="jp">{{ $note($key) }}</span>
                                    <span class="en">{{ $note($key, 'en') }}</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody id="author-rows">
                        @for ($i = 1; $i <= $maxCount; $i++)
                            <tr>
                                <td class="text-center">
                                    <input type="radio"
                                        name="presenter_index"
                                        value="{{ $i }}"
                                        @checked((int) old('presenter_index', $form['presenter_index'] ?? 1) === $i)
                                    >
                                </td>

                                <td class="text-center">
                                    <input type="radio"
                                        name="award_contact_index"
                                        value="{{ $i }}"
                                        @checked((int) old('award_contact_index', $form['award_contact_index'] ?? 0) === $i)
                                    >
                                </td>

                                <td>
                                    <div class="koen-name-inputs">
                                        <input type="text"
                                            name="authors[{{ $i }}][family_name_ja]"
                                            class="form-control form-control-sm"
                                            value="{{ old("authors.$i.family_name_ja", $form['authors'][$i]['family_name_ja'] ?? '') }}"
                                            placeholder="{{ $note('author_speak_ja_sei') }}">

                                        <input type="text"
                                            name="authors[{{ $i }}][given_name_ja]"
                                            class="form-control form-control-sm"
                                            value="{{ old("authors.$i.given_name_ja", $form['authors'][$i]['given_name_ja'] ?? '') }}"
                                            placeholder="{{ $note('author_speak_ja_mei') }}">
                                    </div>
                                </td>

                                <td>
                                    <div class="koen-name-inputs">
                                        <input type="text"
                                            name="authors[{{ $i }}][given_name_en]"
                                            class="form-control form-control-sm"

                                            value="{{ old("authors.$i.given_name_en", $form['authors'][$i]['given_name_en'] ?? '') }}"
                                            placeholder="{{ $note('author_speak_en_sei') }}">

                                        <input type="text"
                                            name="authors[{{ $i }}][family_name_en]"
                                            class="form-control form-control-sm"
                                            value="{{ old("authors.$i.family_name_en", $form['authors'][$i]['family_name_en'] ?? '') }}"
                                            placeholder="{{ $note('author_speak_en_mei') }}">
                                    </div>
                                </td>

                                <td>
                                    <input type="number"
                                        min=1
                                        name="authors[{{ $i }}][affiliation_numbers]"
                                        class="form-control form-control-sm"
                                        value="{{ old("authors.$i.affiliation_numbers", $form['authors'][$i]['affiliation_numbers'] ?? '') }}"
                                        placeholder="{{ $note('author_speak_syozoku_number') }}">
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
        <div class="jp">
            {!! $authorOptions->get('author_other')->note_ja !!}
        </div>
        <div class="en">
            {!! $authorOptions->get('author_other')->note_en !!}
        </div>
        <textarea class="form-control" name="othertext">{{ old('othertext', $form['othertext'] ?? '') }}</textarea>

    </div>
</div>

@section('js')
@vite(['resources/js/app.js'])
<script>
$(function () {
    if ($('#reception_number').val()) {
        $('#reception_number').trigger('input');
    }
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

    // 登録後、復元された参加受付番号でデータを再取得
    if ($('#reception_number').val().trim()) {
        $('#reception_number').trigger('input');
    }

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


    function setupCount(selectId, tbodyId) {
        const select = document.getElementById(selectId);
        const tbody = document.getElementById(tbodyId);

        if (!select || !tbody) return;

        function updateRows() {
            const count = Number(select.value);

            Array.from(tbody.rows).forEach((row, index) => {
                const visible = index < count;

                row.hidden = !visible;

                row.querySelectorAll('input').forEach(input => {
                    input.disabled = !visible;
                });
            });
        }

        select.addEventListener('change', updateRows);
        updateRows();
    }

    setupCount('affiliation-count', 'affiliation-rows');
    setupCount('author-count', 'author-rows');

});

</script>
@stop
<style>
    .required-label {
        margin-left: 6px;
        color: #dc3545;
        font-size: 13px;
    }

    #koen-author-ui {
        font-size: 13px;
    }

    #koen-author-ui .koen-section-title {
        font-size: 14px;
        font-weight: bold;
        border-bottom: 1px solid #ccc;
        padding-bottom: 4px;
        margin-bottom: 8px;
    }

    #koen-author-ui .koen-count {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 5px;
    }

    #koen-author-ui .koen-count label {
        margin: 0;
    }

    #koen-author-ui .koen-count select {
        width: 95px;
        height: 25px;
        padding: 2px 5px;
    }

    #koen-author-ui .koen-explain {
        white-space: pre-line;
        margin-bottom: 8px;
        line-height: 1.5;
    }

    #koen-author-ui .koen-input-table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        font-size: 12px;
    }

    #koen-author-ui .koen-input-table th {
        background: #f4f4f8;
        text-align: center;
        vertical-align: middle;
        padding: 7px 4px;
        border: 1px solid #ccc;
        overflow-wrap: anywhere;
    }

    #koen-author-ui .koen-input-table td {
        padding: 4px;
        vertical-align: middle;
        border: 1px solid #ccc;
    }

    #koen-author-ui .koen-input-table .form-control {
        width: 100%;
        min-width: 0;
        height: 27px;
        font-size: 12px;
        border-radius: 0;
    }

    #koen-author-ui .koen-name-inputs {
        display: flex;
        gap: 4px;
    }

    #koen-author-ui .koen-name-inputs input {
        flex: 1;
        width: 0;
    }

    #koen-author-ui tbody tr[hidden] {
        display: none !important;
    }

</style>
