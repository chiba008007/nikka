<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KoenParticipantFormSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $rows = [
            [
                'page_type' => 'login',
                'type' => 'text',
                'type_code' => 'text',
                'name' => 'title',
                'label_ja' => '講演登録申込フォーム',
                'status' => 1,
                'list_display' => 0,
                'required' => 0,
            ],
            [
                'page_type' => 'login',
                'type' => 'textarea',
                'type_code' => 'text',
                'name' => 'login_form_descript',
                'status' => 1,
                'list_display' => 0,
                'required' => 0,
            ],
            [
                'page_type' => 'login',
                'type' => 'text',
                'type_code' => 'number',
                'name' => 'reception_number',
                'status' => 1,
                'list_display' => 0,
                'required' => 0,
            ],
            [
                'page_type' => 'login',
                'type' => 'text',
                'type_code' => 'password',
                'name' => 'password',
                'status' => 1,
                'list_display' => 0,
                'required' => 0,
            ],
            [
                'page_type' => 'login',
                'type' => 'button',
                'type_code' => 'button',
                'name' => 'regist_button',
                'status' => 1,
                'list_display' => 0,
                'required' => 0,
            ],
            [
                'page_type' => 'login',
                'type' => 'button',
                'type_code' => 'button',
                'name' => 'back_button',
                'status' => 1,
                'list_display' => 0,
                'required' => 0,
            ],
            [
                'page_type' => 'koenform',
                'type' => 'text',
                'type_code' => 'text',
                'name' => 'title',
                'label_ja' => '講演登録申込フォーム',
                'label_en' => 'Presentation registration form',
                'status' => 1,
                'list_display' => 0,
                'required' => 0,
            ],
            [
                'page_type' => 'koenform',
                'type' => 'text',
                'type_code' => 'text',
                'name' => 'print',
                'label_ja' => '印刷',
                'label_en' => 'PRINT',
                'status' => 1,
                'list_display' => 0,
                'required' => 0,
            ],
            [
                'page_type' => 'koenform',
                'type' => 'textarea',
                'type_code' => 'text',
                'name' => 'koen_form_descript',
                'status' => 1,
                'list_display' => 0,
                'required' => 0,
            ],
        ];

        for ($i = 1; $i <= 50; $i++) {
            $rows[] = [
                'page_type' => 'koenform',
                'type' => 'text',
                'type_code' => 'text',
                'name' => 'add_column_' . $i,
                'label_ja' => null,
                'label_en' => null,
                'placeholder_ja' => null,
                'placeholder_en' => null,
                'required' => 0,
                'sort_order' => $i,
                'column' => null,
                'note_ja' => null,
                'note_en' => null,
                'error_message' => null,
                'error_message_en' => null,
                'error_flag' => null,
                'status' => 1,
                'list_display' => 0,
                'checkbox_note_description' => null,
                'checkbox_note_description_en' => null,
            ];
        }

        foreach ($rows as &$row) {
            $row = array_merge([
                'label_ja' => null,
                'label_en' => null,
                'placeholder_ja' => null,
                'placeholder_en' => null,
                'required' => 0,
                'sort_order' => null,
                'column' => null,
                'note_ja' => null,
                'note_en' => null,
                'error_message' => null,
                'error_message_en' => null,
                'error_flag' => null,
                'status' => 1,
                'list_display' => 0,
                'checkbox_note_description' => null,
                'checkbox_note_description_en' => null,
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ], $row);
        }

        DB::table('koen_participant_form')->insert($rows);
    }
}
