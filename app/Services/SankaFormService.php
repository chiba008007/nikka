<?php

namespace App\Services;

class SankaFormService
{
    /**
     * 連絡先種別を取得する
     */
    public function getAddressTypes(): array
    {
        // TODO: 将来的にDBから取得する
        return [
            1 => '勤務先',
            2 => '自宅',
        ];
    }
    /**
    * 専門分野を取得する
    */
    public function getExpertiseTypes(): array
    {
        // TODO: 将来的にDBから取得する
        return [
            1 => '無機化学',
            2 => '分析化学',
            3 => '環境化学',
            4 => '物理化学',
            5 => '有機化学',
            6 => '化学工学',
            7 => '高分子化学',
            8 => '繊維化学',
            9 => '材料化学',
            10 => '電気化学',
            11 => '化学教育',
            12 => 'その他',
            13 => 'なし',
        ];
    }
    /**
     * 所属学協会を取得する
     */
    public function getSocietyTypes(): array
    {
        // TODO: 将来的にDBから取得する
        return [
            1 => '日本化学会',
            2 => '高分子学会',
            3 => '日本分析化学会',
            4 => '化学工学会',
            5 => '有機合成化学協会',
            6 => '電気化学会',
            7 => '日本材料学会',
            8 => '繊維学会',
            9 => '無機マテリアル学会',
            10 => '分子科学会',
            11 => '日本セラミックス協会',
            12 => '日本接着学会',
            13 => '化学教育協議会',
            14 => 'その他',
        ];
    }

    /**
 * 参加区分を取得する
 */
    public function getJoinTypes(): array
    {
        // TODO: 将来的にDBから取得する
        return [
            1 => [
                'label' => '一般',
                'price' => 4000,
                'banquet_price' => 9000,
            ],
            2 => [
                'label' => '教育（日本化学会教育会員）',
                'price' => 2000,
                'banquet_price' => 9000,
            ],
            3 => [
                'label' => '小・中・高・高専教員・ブース出展企業',
                'price' => 0,
                'banquet_price' => 9000,
            ],
            4 => [
                'label' => '大学院生',
                'price' => 2000,
                'banquet_price' => 4000,
            ],
            11 => [
                'label' => '中学生・高校生・高専生・学部生',
                'price' => 0,
                'banquet_price' => 4000,
            ],
            99 => [
                'label' => '招待',
                'price' => 0,
                'banquet_price' => 0,
            ],
        ];
    }

}
