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
