<?php

namespace App\Services;

use App\Models\SankaFeeItem;
use App\Models\SankaFormItem;

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
            ->get()
            ->map(function ($item) {
                // []内の文字を取得する
                preg_match('/\[([^\]]+)\]/u', $item->label_ja, $matches);
                preg_match('/\[([^\]]+)\]/u', $item->label_en, $matchesen);

                // []内の文字を別キーに保持する
                $item->required_text = $matches[1] ?? '';
                $item->required_text_en = $matchesen[1] ?? '';

                // []部分を表示文字から除去する
                $item->label_ja = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $item->label_ja)
                );
                $item->label_en = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $item->label_en)
                );

                return $item;
            })
            ->keyBy('name');


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
            ->get()
            ->map(function ($item) {
                // []内の文字を取得する
                preg_match('/\[([^\]]+)\]/u', $item->label_ja, $matches);
                preg_match('/\[([^\]]+)\]/u', $item->label_en, $matchesen);

                // []内の文字を別キーに保持する
                $item->required_text = $matches[1] ?? '';
                $item->required_text_en = $matchesen[1] ?? '';

                // []部分を表示文字から除去する
                $item->label_ja = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $item->label_ja)
                );
                $item->label_en = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $item->label_en)
                );

                return $item;
            })
            ->keyBy('name');


        return [
            'formItems' => $formItems,
            'feeItems' => $feeItems,
        ];
    }

}
