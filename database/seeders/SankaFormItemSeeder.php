<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SankaFormItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sanka_form_item_options')->truncate();
        DB::table('sanka_form_items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $now = Carbon::now();

        $items = [
            ['basic', 'name1', '参加者氏名（姓）', 'Participant family name', 'text', '姓入力', 'Family name', 1, 1, 2],
            ['basic', 'name2', '参加者氏名（名）', 'Participant first name', 'text', '名入力', 'First name', 1, 2, 2],
            ['basic', 'kana1', '参加者氏名（カナ・姓）', 'Family name in Katakana', 'text', '姓（カナ）入力', 'Family Name', 1, 3, 2],
            ['basic', 'kana2', '参加者氏名（カナ・名）', 'First name in Katakana', 'text', '名（カナ）入力', 'First Name', 1, 4, 2],

            ['organization', 'daigaku', '所属機関(大学 / 勤務先)', 'Organization', 'text', '所属機関(大学 / 勤務先)を入力してください', 'Please enter your organization.', 1, 5, 1],
            ['organization', 'gakubu', '所属機関(学部 / 部署)', 'Department', 'text', '所属機関(学部 / 部署)を入力してください', 'Please enter your department.', 1, 6, 1],
            ['organization', 'kenkyu', '所属機関(研究室)', 'Laboratory', 'text', '所属機関(研究室)を入力してください', 'Please enter your laboratory.', 0, 7, 1],

            ['contact', 'address_type', '連絡先選択', 'Type of contact address', 'radio', null, null, 1, 8, 1],
            ['contact', 'post', '連絡先郵便番号', 'Postal code', 'text', '例 ) 000-0000', '000-0000', 1, 9, 1],
            ['contact', 'address', '連絡先住所', 'Contact address', 'text', '住所を入力してください', 'Enter your contact address.', 1, 10, 1],
            ['contact', 'tel', '連絡先電話番号', 'Phone number', 'text', '電話番号を入力してください', 'Enter your phone number.', 1, 11, 1],
            ['contact', 'fax', '連絡先FAX番号', 'Fax number', 'text', 'FAX番号を入力してください', 'Enter your fax number.', 0, 12, 1],

            ['account', 'mail', 'メールアドレス', 'E-mail address', 'email', 'メールアドレスを入力してください', 'Enter your e-mail address.', 1, 13, 1],
            ['account', 'mail2', 'メールアドレス(確認)', 'E-mail address confirmation', 'email', 'メールアドレス(確認)を入力してください', 'Re-enter your e-mail address.', 1, 14, 1],
            ['account', 'password', 'パスワード', 'Password', 'password', 'パスワードを入力してください', 'Enter the password of your choice.', 1, 15, 1],

            ['expertise', 'sankaformselect', '専門分野', 'Fields of expertise', 'checkbox', null, null, 1, 16, 1],
            ['expertise', 'sankaformselectother', 'その他専門分野', 'Other field of expertise', 'text', '分野名', 'Enter the field of expertise', 0, 17, 1],

            ['society', 'syozokuSankaformselect', '所属学協会', 'Academic societies and organizations', 'checkbox', null, null, 1, 18, 1],
            ['society', 'syozokuSankaformselectOther', 'その他所属学協会', 'Other academic society', 'text', null, null, 0, 19, 1],

            ['other', 'other_text', '備考', 'Remarks', 'textarea', null, null, 0, 20, 1],
        ];

        foreach ($items as [$groupKey, $name, $labelJa, $labelEn, $type, $phJa, $phEn, $required, $sortOrder, $column]) {
            DB::table('sanka_form_items')->insert([
                'group_key' => $groupKey,
                'name' => $name,
                'label_ja' => $labelJa,
                'label_en' => $labelEn,
                'type' => $type,
                'placeholder_ja' => $phJa,
                'placeholder_en' => $phEn,
                'required' => $required,
                'sort_order' => $sortOrder,
                'column' => $column,
                'error_flag' => $required ? 1 : 0,
                'error_messages' => $required ? json_encode([
                    'required' => [
                        'ja' => $labelJa . 'を入力または選択してください',
                        'en' => 'Please enter or select ' . $labelEn,
                    ],
                ], JSON_UNESCAPED_UNICODE) : null,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
