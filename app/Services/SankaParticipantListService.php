<?php

namespace App\Services;

use App\Models\SankaFormItem;
use App\Models\SankaParticipant;

class SankaParticipantListService
{
    /**
     * 一覧表示用の値を作成する
     */
    public function makeDisplayValues($lists, $headers): array
    {
        // 支払ステータス
        $paymentStatus = config('const.payment_status');

        // 入力項目と選択肢をまとめて取得
        $formItems = SankaFormItem::with('options')
            ->where('status', 1)
            ->get()
            ->keyBy('name');

        $displayValues = [];

        foreach ($lists as $participant) {
            foreach ($headers as $header) {
                $displayValues[$participant->id][$header->name]
                    = $this->getDisplayValue(
                        $participant,
                        $header,
                        $formItems
                    );
            }
            // 参加種別
            $displayValues[$participant->id]['participation_type']
                = $participant->participationOption->label_ja ?? '';
            // 懇親会参加
            $banquetParticipation = config('const.banquet_participation');
            $displayValues[$participant->id]['banquet_type']
                = (int) $participant->banquet_status
                    === $banquetParticipation['participate']['value']
                        ? $banquetParticipation['participate']['label']
                        : $banquetParticipation['not_participate']['label'];

            // 参加費
            $displayValues[$participant->id]['participation_amount']
                = number_format(
                    $participant->participationOption->amount ?? 0
                );

            // 懇親会費
            $banquetAmount = 0;

            if (
                (int) $participant->banquet_status
                === $banquetParticipation['participate']['value']
                && $participant->banquetOption
            ) {
                $price = $participant->banquetOption->prices
                    ->firstWhere(
                        'join_type_id',
                        $participant->participation_status
                    );

                $banquetAmount = $price->amount ?? 0;
            }

            $displayValues[$participant->id]['banquet_amount']
                = number_format($banquetAmount);


            // 支払いステータス
            $displayValues[$participant->id]['participation_payment_status']
                = (int) $participant->participation_payment_status
                    === $paymentStatus['paid']['value']
                        ? $paymentStatus['paid']['label']
                        : $paymentStatus['unpaid']['label'];

            $displayValues[$participant->id]['banquet_payment_status']
                = (int) $participant->banquet_payment_status
                    === $paymentStatus['paid']['value']
                        ? $paymentStatus['paid']['label']
                        : $paymentStatus['unpaid']['label'];
        }

        return $displayValues;
    }

    /**
     * 1項目分の表示値を取得する
     */
    private function getDisplayValue(
        SankaParticipant $participant,
        SankaFormItem $header,
        $formItems
    ): string {
        /*
         * reception_number など、
         * sanka_participants に直接存在する項目
         */
        if (array_key_exists(
            $header->name,
            $participant->getAttributes()
        )) {
            return (string) (
                $participant->getAttribute($header->name) ?? ''
            );
        }

        /*
         * titleN → add_column_N
         */
        if (!preg_match(
            '/^title(\d+)$/',
            $header->name,
            $matches
        )) {
            return '';
        }

        $number = (int) $matches[1];

        $item = $formItems->get(
            'add_column_' . $number
        );

        if (!$item) {
            return '';
        }

        $values = [];

        /*
         * 1つ目の項目
         */
        $values[] = $this->formatValue(
            $participant,
            $item
        );

        /*
         * 2分割項目
         *
         * 例：
         * add_column_1 姓
         * add_column_2 名
         */
        if ((int) $item->column === 2) {

            $nextItem = $formItems->get(
                'add_column_' . ($number + 1)
            );

            if (
                $nextItem &&
                (int) $nextItem->column === 2 &&
                $nextItem->sort_order == $item->sort_order
            ) {
                $values[] = $this->formatValue(
                    $participant,
                    $nextItem
                );
            }
        }

        return implode(
            ' ',
            array_filter(
                $values,
                fn ($value) => $value !== ''
            )
        );
    }

    /**
     * DBの値を一覧表示用に変換する
     */
    private function formatValue(
        SankaParticipant $participant,
        SankaFormItem $item
    ): string {
        $value = $participant->getAttribute(
            $item->name
        );

        if ($value === null || $value === '') {
            return '';
        }

        /*
         * radio / select
         *
         * 1 → 勤務先
         */
        if (
            in_array(
                $item->group_key,
                ['radio', 'select']
            )
        ) {
            $option = $item->options
                ->where('status', 1)
                ->firstWhere(
                    'value',
                    (string) $value
                );

            return $option
                ? $option->label_ja
                : (string) $value;
        }

        /*
         * checkbox
         */
        if ($item->group_key === 'checkbox') {

            if (is_string($value)) {
                $value = json_decode(
                    $value,
                    true
                );
            }

            if (!is_array($value)) {
                return '';
            }

            $labels = [];

            foreach (
                $value['values'] ?? [] as $selectedValue
            ) {
                $option = $item->options
                    ->where('status', 1)
                    ->firstWhere(
                        'value',
                        (string) $selectedValue
                    );

                if ($option) {
                    $labels[] = $option->label_ja;
                }
            }

            /*
             * その他入力
             */
            if (!empty($value['other'])) {
                $labels[] = $value['other'];
            }

            return implode('、', $labels);
        }

        /*
         * text / mail / postcode 等
         */
        return (string) $value;
    }
}
