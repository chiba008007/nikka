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
@section('js')
<script>

$(function () {
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
});

</script>
@stop
