<style>
    /* 参加区分1行分 */
    .join-type-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 12px 16px;
        margin-bottom: 8px;
        cursor: pointer;
        background: #fff;
    }

    /* 左側のラジオと名称 */
    .join-type-left {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: bold;
    }

    /* 金額を横並びで表示する */
    .join-type-price {
        display: flex;
        align-items: baseline;
        justify-content: flex-end;
        gap: 4px;
        min-width: 100px;
        color: #333;
    }

    .join-type-price-main {
        font-size: 18px;
        font-weight: bold;
    }

    .join-type-price-unit {
        font-size: 13px;
        color: #666;
    }

    /* フォーム内の項目見出し */
    .section-title {
        margin-bottom: 12px;
        padding: 8px 12px;
        border-left: 4px solid #007bff;
        font-size: 16px;
        font-weight: bold;
    }

    /* 必須表示 */
    .required-label {
        margin-left: 6px;
        color: #dc3545;
        font-size: 13px;
    }
</style>

@props([
    'action',
    'method' => 'POST',
    'addressTypes' => [],
    'expertiseTypes' => [],
    'societyTypes' => [],
    'joinTypes' => [],
])
{{-- バリデーションエラーを表示する --}}
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

{{-- 管理画面・公開画面で共通利用する参加者フォーム --}}
<form action="{{ $action }}" method="POST">
    @csrf

    {{-- POST以外の場合はLaravelのHTTPメソッドを指定する --}}
    @if (strtoupper($method) !== 'POST')
        @method($method)
    @endif

    <div class="card">
        <div class="card-body">

            <div class="form-group">
                <div class="section-title">
                    参加者氏名
                    <span class="required-label">必須</span>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <input
                            type="text"
                            name="name1"
                            id="name1"
                            class="form-control"
                            value="{{ old('name1') }}"
                            placeholder="姓を入力"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <input
                            type="text"
                            name="name2"
                            id="name2"
                            class="form-control"
                            value="{{ old('name2') }}"
                            placeholder="名を入力"
                            required
                        >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="section-title">
                    参加者氏名（カナ）
                    <span class="required-label">必須</span>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <input
                            type="text"
                            name="kana1"
                            id="kana1"
                            class="form-control"
                            value="{{ old('kana1') }}"
                            placeholder="姓（カナ）を入力"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <input
                            type="text"
                            name="kana2"
                            id="kana2"
                            class="form-control"
                            value="{{ old('kana2') }}"
                            placeholder="名（カナ）を入力"
                            required
                        >
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="section-title">
                    所属機関（大学・勤務先）
                    <span class="required-label">必須</span>
                </div>
                <input
                    type="text"
                    name="daigaku"
                    id="daigaku"
                    class="form-control"
                    value="{{ old('daigaku') }}"
                    placeholder="所属機関を入力してください"
                    required
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    所属機関（学部・部署）
                    <span class="required-label">必須</span>
                </div>
                <input
                    type="text"
                    name="gakubu"
                    id="gakubu"
                    class="form-control"
                    value="{{ old('gakubu') }}"
                    placeholder="学部・部署を入力してください"
                    required
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    所属機関（研究室）
                </div>
                <input
                    type="text"
                    name="kenkyu"
                    id="kenkyu"
                    class="form-control"
                    value="{{ old('kenkyu') }}"
                    placeholder="研究室を入力してください"
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    連絡先
                    <span class="required-label">必須</span>
                </div>
                <div>
                    @foreach ($addressTypes as $value => $label)
                      <label class="mr-4">
                          <input
                              type="radio"
                              name="address_type"
                              value="{{ $value }}"
                              {{ old('address_type') == $value ? 'checked' : '' }}
                              required
                          >
                          {{ $label }}
                      </label>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <div class="section-title">
                    連絡先郵便番号
                    <span class="required-label">必須</span>
                </div>
                <input
                    type="text"
                    name="post"
                    id="post"
                    class="form-control"
                    value="{{ old('post') }}"
                    placeholder="例：000-0000"
                    required
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    連絡先住所
                    <span class="required-label">必須</span>
                </div>
                <input
                    type="text"
                    name="address"
                    id="address"
                    class="form-control"
                    value="{{ old('address') }}"
                    placeholder="住所を入力してください"
                    required
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    連絡先電話番号
                    <span class="required-label">必須</span>
                </div>
                <input
                    type="text"
                    name="tel"
                    id="tel"
                    class="form-control"
                    value="{{ old('tel') }}"
                    placeholder="電話番号を入力してください"
                    required
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    連絡先FAX番号
                </div>
                <input
                    type="text"
                    name="fax"
                    id="fax"
                    class="form-control"
                    value="{{ old('fax') }}"
                    placeholder="FAX番号を入力してください"
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    メールアドレス
                    <span class="required-label">必須</span>
                </div>
                <input
                    type="email"
                    name="mail"
                    id="mail"
                    class="form-control"
                    value="{{ old('mail') }}"
                    placeholder="メールアドレスを入力してください"
                    required
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    メールアドレス（確認）
                    <span class="required-label">必須</span>
                </div>
                <input
                    type="email"
                    name="mail2"
                    id="mail2"
                    class="form-control"
                    value="{{ old('mail2') }}"
                    placeholder="メールアドレスをもう一度入力してください"
                    required
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    パスワード
                    <span class="required-label">必須</span>
                </div>
                <div class="input-group">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="パスワードを入力してください"
                        required
                    >

                    <div class="input-group-append">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            id="password-display"
                        >
                            表示
                        </button>
                    </div>
                </div>
            </div>



            <div class="form-group">
                <div class="section-title">
                    専門分野
                    <span class="required-label">必須</span>
                </div>
                <div class="row">
                    @foreach ($expertiseTypes as $key => $label)
                     <div class="col-md-6">
                        <label class="mr-4">
                            <input
                                type="checkbox"
                                name="sankaformselect[{{ $key }}]"
                                value="{{ $label }}"
                                {{ old("sankaformselect.$key") ? 'checked' : '' }}
                            >
                            {{ $label }}
                        </label>
                     </div>
                    @endforeach
                </div>

                <input
                    type="text"
                    name="sankaformselectother"
                    class="form-control mt-2"
                    value="{{ old('sankaformselectother') }}"
                    placeholder="その他の分野名を入力してください"
                >
            </div>

            <div class="form-group">
                <div class="section-title">
                    所属学協会
                    <span class="required-label">必須</span>
                </div>
                <div class="row">
                  {{-- 所属学協会を表示する --}}
                  @foreach ($societyTypes as $key => $label)
                    <div class="col-md-6">
                      <label class="mr-4">
                          <input
                              type="checkbox"
                              name="syozokuSankaformselect[{{ $key }}]"
                              value="{{ $label }}"
                              {{ old("syozokuSankaformselect.$key") ? 'checked' : '' }}
                          >
                          {{ $label }}
                      </label>
                    </div>
                  @endforeach
                </div>

                <input
                    type="text"
                    name="syozokuSankaformselectOther"
                    class="form-control mt-2"
                    value="{{ old('syozokuSankaformselectOther') }}"
                    placeholder="その他の所属状況を入力してください"
                >
            </div>

            <div class="form-group">
                <div class="section-title">備考</div>
                <textarea
                    name="other_text"
                    class="form-control"
                    rows="5"
                >{{ old('other_text') }}</textarea>
            </div>

            <div class="form-group">
                <div class="section-title">
                    参加登録費（事前）
                    <span class="required-label">必須</span>
                </div>
                @foreach ($joinTypes as $key => $joinType)
                    <label for="join_type-{{ $key }}" class="join-type-row">
                        <div class="join-type-left">
                            <input
                                type="radio"
                                class="join-type"
                                name="join_type"
                                value="{{ $key }}"
                                data-price="{{ $joinType['price'] }}"
                                data-banquet-price="{{ $joinType['banquet_price'] }}"
                            >
                            <span>{{ $joinType['label'] }}</span>
                        </div>

                        <div class="join-type-price">
                          <span class="join-type-price-main">
                              {{ number_format($joinType['price']) }}
                          </span>
                          <span class="join-type-price-unit">円</span>
                      </div>
                    </label>
                @endforeach
            </div>

            <div class="form-group">
                <label>
                    <input
                        type="checkbox"
                        name="tourtype"
                        value="1"
                        {{ old('tourtype') == '1' ? 'checked' : '' }}
                    >
                    旅費補助を希望する
                </label>

                <small class="form-text text-danger">
                    自費参加の高校教員のみ対象です。希望金額は備考欄に記入してください。
                </small>
            </div>

            <div class="form-group">
                <label>
                    <input
                        type="checkbox"
                        name="konshinkai"
                        id="konshinkai"
                        value="1"
                        {{ old('konshinkai') == '1' ? 'checked' : '' }}
                    >
                    懇親会に参加する
                </label>

                <small class="form-text">
                    一般・教育：9,000円／学生：4,000円
                </small>
            </div>

            <div class="form-group">
                <label>合計金額</label>
                <p class="h4">
                    <span id="total">0</span>円
                </p>

                <input
                    type="hidden"
                    name="all"
                    id="all"
                    value="0"
                >
            </div>

            <div class="form-group">
                <label>
                    <input
                        type="checkbox"
                        name="mail_send"
                        value="on"
                        {{ old('mail_send') === 'on' ? 'checked' : '' }}
                    >
                    参加者へメールを送る
                </label>
            </div>

            <div class="form-group">
                <div class="section-title">
                    管理用備考
                </div>
                <textarea
                    name="bikou"
                    class="form-control"
                    rows="3"
                >{{ old('bikou') }}</textarea>
            </div>

            <div class="form-group">
                <label class="mr-4">
                    <input
                        type="radio"
                        name="selecter"
                        value="1"
                        {{ old('selecter') == '1' ? 'checked' : '' }}
                    >
                    選考委員
                </label>

                <label>
                    <input
                        type="radio"
                        name="selecter"
                        value="0"
                        {{ old('selecter', '0') == '0' ? 'checked' : '' }}
                    >
                    非選考委員
                </label>
            </div>

            <button
                type="submit"
                name="regist"
                value="on"
                class="btn btn-primary"
            >
                登録する
            </button>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const password = document.getElementById('password');
    const displayButton = document.getElementById('password-display');
    const joinTypes = document.querySelectorAll('.join-type');
    const banquet = document.getElementById('konshinkai');
    const total = document.getElementById('total');
    const totalInput = document.getElementById('all');

    // パスワードの表示・非表示を切り替える
    displayButton?.addEventListener('click', function () {
        password.type = password.type === 'password' ? 'text' : 'password';
        displayButton.textContent = password.type === 'password' ? '表示' : '非表示';
    });

    // 参加費と懇親会費の合計を計算する
    function calculateTotal() {
        const selectedJoinType = document.querySelector('.join-type:checked');

        if (!selectedJoinType) {
            total.textContent = '0';
            totalInput.value = '0';
            return;
        }

        // DB由来の金額をdata属性から取得する
        const participationFee = Number(selectedJoinType.dataset.price || 0);
        const banquetFee = banquet.checked
            ? Number(selectedJoinType.dataset.banquetPrice || 0)
            : 0;

        const amount = participationFee + banquetFee;

        total.textContent = amount.toLocaleString();
        totalInput.value = amount;
    }

    joinTypes.forEach(function (element) {
        element.addEventListener('change', calculateTotal);
    });

    banquet?.addEventListener('change', calculateTotal);

    calculateTotal();
});
</script>
