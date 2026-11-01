<?php

namespace App\Services;

use App\Models\SankaFeeItem;
use App\Models\SankaFormItem;
use Illuminate\Support\Collection;

class SankaFormService
{
    // SankaFormService.php
    public function getFormData()
    {
        // 参加入力フォームを取得する
        $formItems = SankaFormItem::query()
            ->where('status', 1)
            ->with([
                'options' => function ($query) {
                    // 有効な選択肢のみ取得する
                    $query->where('status', 1)
                        ->orderBy('sort_order');
                },
            ])
            ->orderBy('sort_order')
            ->get();


        // 参加費関連を3テーブルまとめて取得する
        $feeItems = SankaFeeItem::query()
            ->where('status', 1)
            ->with([
                'options' => function ($query) {
                    // 有効な選択肢のみ取得する
                    $query->where('status', 1)
                        ->orderBy('sort_order');
                },
                'options.prices' => function ($query) {
                    // 有効な金額のみ取得する
                    $query->where('status', 1);
                },
            ])
            ->orderBy('sort_order')
            ->get();

        $formItems = $this->formatLabels($formItems);
        $feeItems = $this->formatLabels($feeItems);
        return [
            'formItems' => $formItems,
            'feeItems' => $feeItems,
        ];
    }
    public function formatLabels(Collection $items): Collection
    {
        return $items->map(function ($item) {
            foreach (['ja', 'en'] as $lang) {
                $field = 'label_' . $lang;
                $text = $item->{$field} ?? '';

                preg_match('/\[([^\]]+)\]/u', $text, $matches);

                $requiredField = $lang === 'ja'
                    ? 'required_text'
                    : 'required_text_en';

                $item->{$requiredField} = $matches[1] ?? '';

                $item->{$field} = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $text)
                );
            }

            return $item;
        })->keyBy('name');
    }
}
