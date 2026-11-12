<?php

return [
    // メール種別
    'MAIL_TYPE' => [
        'PRESENTATION_APPLICATION' => '講演申込み',
        'PARTICIPATION_APPLICATION' => '参加申込み',
        'MANUSCRIPT_REGISTRATION' => '予行原稿登録',
        'PRESENTATION_APPLICATION_EN' => '講演申込み(英語)',
        'PARTICIPATION_APPLICATION_EN' => '参加申込み(英語)',
        'MANUSCRIPT_REGISTRATION_EN' => '予行原稿登録(英語)',
    ],

    // メールの置き換え
    'MAIL_REPLACE_SANKA' => [
        'sanka_code' => '参加登録ID',
        'sanka_money' => '参加者合計金額',
        'sanka_syubetu' => '参加種別金額',
        'konsinkai_money' => '懇親会費',
        'konsinkai_join' => '懇親会参加(する/しない)',
    ],
    'MAIL_REPLACE_KOEN' => [
        'koen_code' => '講演登録ID',
        'syozoku_total' => '所属機関総数',
        'syozoku_kikan' => '所属機関(番号/名称/略称/英語)',
        'tyosya_total' => '著者総数',
        'tyosya_name' => '著者名(和名/英名/所属番号)',
        'koen_name' => '講演者名',
        'teacher_name' => '指導教員名',
        'other' => '備考',
        'happyo_number' => '発表番号'
    ],

    // ステータス
    'STATUS' => [
        'DISABLED' => 0,
        'ENABLED' => 1,
    ],


    'enable' => '有効',
    'list_display' => '一覧表示',
    'required' => '必須',
    'column' => '2分割',

    'enable_message' =>
        '「有効」を選択すると、この項目が画面に表示されます。',

    'column_message' =>
        '「2分割」を選択すると、この項目と次の項目が横2列で表示されます。次の項目のタイトルは表示されません。',

    'lang' => '(日本語/英語)',

    'required_message' =>
        '※ []で囲まれた文字は赤文字で表示されます。',

    'error_type' => 'エラーチェック型式',
    'placeholder' => '仮置きメッセージ',
    'select_holder' => '選択肢メッセージ',
    'errormessage' => 'エラーメッセージ',
    'title' => 'タイトル',

    'type_array' => [
        'text',
        'numeric',
        'alpha',
        'alphanumeric',
        'kana',
    ],

    'type_message' =>
        '「text」はすべての文字、「numeric」は数字のみ、「alpha」は英字のみ、「alphanumeric」は半角英数記号のみ、「kana」はカナのみ入力できます。',

    'group_key_array' => [
        'text',
        'radio',
        'select',
        'checkbox',
        'postcode',
        'address',
        'mail',
        'mailcheck',
        'password',
        'textarea',
    ],

    'other_message' => '備考説明文',

    'banquet_participation' => [
        'not_participate' => [
            'value' => 0,
            'label' => '参加しない',
        ],
        'participate' => [
            'value' => 1,
            'label' => '参加する',
        ],
    ],
    'payment_status' => [
        'unpaid' => [
            'value' => 0,
            'label' => '未支払',
        ],
        'paid' => [
            'value' => 1,
            'label' => '支払済',
        ],
    ],

];
