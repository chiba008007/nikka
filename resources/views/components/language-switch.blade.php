<div
    id="language-switch"
    data-language="{{ session('language', 'jp') }}"
    data-token="{{ csrf_token() }}"
    class="w-25 d-flex ml-auto justify-content-end pt-2 pr-2"
>
    <button
        type="button"
        class="form-control w-25 btn-warning"
        id="show-jp"
    >
        JP
    </button>

    <button
        type="button"
        class="form-control w-25 btn-warning ml-2"
        id="show-en"
    >
        EN
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const languageSwitch = document.getElementById('language-switch');

    if (!languageSwitch) {
        return;
    }

    // Sessionに保存されている言語
    const currentLanguage = languageSwitch.dataset.language;

    /**
     * 表示言語を切り替える
     */
    function changeLanguage(language) {

        // 日本語
        document.querySelectorAll('.jp').forEach(function (element) {
            element.style.display = language === 'jp' ? '' : 'none';
        });

        // 英語
        document.querySelectorAll('.en').forEach(function (element) {
            element.style.display = language === 'en' ? '' : 'none';
        });

        // placeholderも切り替える
        document.querySelectorAll('.js-language-input').forEach(function (element) {

            if (language === 'en') {
                element.placeholder =
                    element.dataset.placeholderEn || '';
            } else {
                element.placeholder =
                    element.dataset.placeholderJa || '';
            }
        });
    }

    /**
     * 選択した言語をSessionへ保存する
     */
    function saveLanguage(language) {

        fetch('/language', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': languageSwitch.dataset.token
            },
            body: JSON.stringify({
                language: language
            })
        });
    }

    // JP
    document.getElementById('show-jp').addEventListener('click', function () {
        changeLanguage('jp');
        saveLanguage('jp');
    });

    // EN
    document.getElementById('show-en').addEventListener('click', function () {
        changeLanguage('en');
        saveLanguage('en');
    });

    // 初期表示
    changeLanguage(currentLanguage);
});
</script>
