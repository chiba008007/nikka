<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SankaFormItemOptionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $options = [
            'address_type' => [
                ['勤務先', 'Workplace', '1'],
                ['自宅', 'Home', '2'],
            ],

            'sankaformselect' => [
                ['無機化学', 'Inorganic Chemistry', '無機化学 Inorganic Chemistry'],
                ['分析化学', 'Analytical Chemistry', '分析化学 Analytical Chemistry'],
                ['環境化学', 'Environmental Chemistry', '環境化学 Environmental Chemistry'],
                ['物理化学', 'Physical Chemistry', '物理化学 Physical Chemistry'],
                ['有機化学', 'Organic Chemistry', '有機化学 Organic Chemistry'],
                ['化学工学', 'Chemical Engineering', '化学工学 Chemical Engineering'],
                ['高分子化学', 'Polymer Chemistry', '高分子化学 Polymer Chemistry'],
                ['繊維化学', 'Fiber Chemistry', '繊維化学 Fiber Chemistry'],
                ['材料化学', 'Materials Chemistry', '材料化学 Materials Chemistry'],
                ['電気化学', 'Electrochemistry', '電気化学 Electrochemistry'],
                ['化学教育', 'Chemical Education', '化学教育 Chemical Education'],
                ['その他', 'Others', 'その他 Others'],
                ['なし', 'None', 'なし None'],
            ],

            'syozokuSankaformselect' => [
                ['日本化学会', 'The Chemical Society of Japan', '日本化学会 The Chemical Society of Japan'],
                ['高分子学会', 'The Society of Polymer Science Japan (SPSJ)', '高分子学会 The Society of Polymer Science Japan (SPSJ)'],
                ['日本分析化学会', 'The Japan Society for Analytical Chemistry', '日本分析化学会 The Japan Society for Analytical Chemistry'],
                ['化学工学会', 'The Society of Chemical Engineers Japan', '化学工学会 The Society of Chemical Engineers Japan'],
                ['有機合成化学協会', 'The Society of Synthetic Organic Chemistry Japan', '有機合成化学協会 The Society of Synthetic Organic Chemistry Japan'],
                ['電気化学会', 'The Electrochemical Society of Japan', '電気化学会 The Electrochemical Society of Japan'],
                ['日本材料学会', 'The Society of Materials Science Japan', '日本材料学会 The Society of Materials Science Japan'],
                ['繊維学会', 'The Society of Fiber Science and Technology Japan', '繊維学会 The Society of Fiber Science and Technology Japan'],
                ['無機マテリアル学会', 'The Society of Inorganic Materials Japan', '無機マテリアル学会 The Society of Inorganic Materials Japan'],
                ['分子科学会', 'Japan Society of Molecular Science', '分子科学会 Japan Society of Molecular Science'],
                ['日本セラミックス協会', 'The Ceramic Society of Japan', '日本セラミックス協会 The Ceramic Society of Japan'],
                ['日本接着学会', 'The Adhesion Society of Japan', '日本接着学会 The Adhesion Society of Japan'],
                ['化学教育協議会', 'The Chemical Education Council', '化学教育協議会 The Chemical Education Council'],
                ['その他', 'Others', 'その他'],
            ],
        ];

        foreach ($options as $itemName => $rows) {
            $item = DB::table('sanka_form_items')->where('name', $itemName)->first();

            if (!$item) {
                continue;
            }

            foreach ($rows as $index => [$labelJa, $labelEn, $value]) {
                DB::table('sanka_form_item_options')->insert([
                    'sanka_form_item_id' => $item->id,
                    'label_ja' => $labelJa,
                    'label_en' => $labelEn,
                    'value' => $value,
                    'sort_order' => $index + 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
