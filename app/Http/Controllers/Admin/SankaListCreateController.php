<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SankaFormItem;
use App\Models\SankaFeeItem;
use App\Models\SankaFeeOption;
use App\Models\SankaFeeOptionPrice;
use App\Services\SankaFeeService;
use Illuminate\Support\Facades\DB;

class SankaListCreateController extends Controller
{
    /**
     * 参加者登録フォーム編集
     */
    public function editform(Request $request)
    {
        // title の設定を1件取得
        $form = SankaFormItem::with('options')
            ->orderBy('sort_order')
            ->get()
            ->keyBy('name');
        return view('admin.sanka.editform', compact('form'));

    }

    public function update(Request $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->except('_token', '_method') as $key => $data) {

                // 配列以外は処理しない
                if (!is_array($data)) {
                    continue;
                }

                // nameをキーに対象項目を取得
                $item = SankaFormItem::where('name', $key)->first();

                if (!$item) {
                    continue;
                }

                $updateData = [];

                // 日本語ラベル
                if (array_key_exists('label_ja', $data)) {
                    $updateData['label_ja'] = $data['label_ja'] ?? '';
                }

                // 英語ラベル
                if (array_key_exists('label_en', $data)) {
                    $updateData['label_en'] = $data['label_en'] ?? '';
                }

                // 戻る・次へ・印刷ボタン用
                if (array_key_exists('title_jp', $data)) {
                    $updateData['label_ja'] = $data['title_jp'] ?? '';
                }

                if (array_key_exists('title_en', $data)) {
                    $updateData['label_en'] = $data['title_en'] ?? '';
                }

                // その他の項目
                foreach ([
                    'group_key',
                    'type',
                    'placeholder_ja',
                    'placeholder_en',
                    'error_message_ja',
                    'error_message_en',
                    'checkbox_note_description',
                    'checkbox_note_description_en',
                ] as $field) {
                    if (array_key_exists($field, $data)) {
                        $updateData[$field] = $data[$field];
                    }
                }

                // descriptionにはstatusがないため更新しない
                if ($key !== 'description' && $key !== 'reception_number') {
                    $updateData['status'] = isset($data['status']) ? 1 : 0;
                }

                // reception_numberは固定項目のため一覧表示フラグを変更しない
                if ($key !== 'reception_number') {
                    $updateData['list_display'] = isset($data['list_display']) ? 1 : 0;
                }

                // add_column_1 ～ add_column_50のみ
                if (str_starts_with($key, 'add_column_')) {
                    $updateData['required'] = isset($data['required']) ? 1 : 0;
                    $updateData['column'] = isset($data['column']) ? 2 : 1;
                }

                // 本体更新
                if (!empty($updateData)) {
                    $item->update($updateData);
                }

                // 選択肢更新
                if (isset($data['options']) && is_array($data['options'])) {
                    foreach ($data['options'] as $sortOrder => $optionData) {
                        $labelJa = $optionData['label_ja'] ?? '';
                        $labelEn = $optionData['label_en'] ?? '';

                        // 両方空なら既存データを触らない
                        if ($labelJa === '' && $labelEn === '') {
                            continue;
                        }

                        // 既存なら更新、なければ追加
                        $item->options()->updateOrCreate(
                            [
                                'sort_order' => $sortOrder,
                            ],
                            [
                                'label_ja' => $labelJa,
                                'label_en' => $labelEn,
                                'value' => $sortOrder,
                                'status' => 1,
                            ]
                        );
                    }
                }
            }
        });

        // 更新後に同じ画面へ戻す
        return redirect()
            ->back()
            ->with('success', '更新しました。');
    }

    // 参加登録費・懇親会費
    public function fee(Request $request)
    {
        // 参加登録費を取得
        $feeItem = SankaFeeItem::with([
            'options' => function ($query) {
                // 表示順で取得
                $query->orderBy('sort_order');
            },
        ])
            ->where('name', 'registration_fee')
            ->firstOrFail();

        // 懇親会費と区分別料金を取得
        $banquetFee = SankaFeeItem::with([
            'options' => function ($query) {
                // 表示順で取得
                $query->orderBy('sort_order');
            },
            'options.prices' => function ($query) {
                // 参加区分順で取得
                $query->orderBy('join_type_id');
            },
        ])
            ->where('name', 'banquet_fee')
            ->firstOrFail();

        $feeItems = SankaFeeItem::query()
            ->orderBy('sort_order')
            ->get()
            ->keyBy('name');

        return view(
            'admin.sanka.fee',
            compact('feeItem', 'banquetFee', 'feeItems')
        );
    }

    /**
     * 参加登録費・懇親会費更新
     */
    public function feeUpdate(
        Request $request,
        SankaFeeService $sankaFeeService
    ) {

        // 参加登録費・懇親会費を更新
        $sankaFeeService->update($request);

        // 更新後に同じ画面へ戻す
        return redirect()
            ->back()
            ->with('success', '更新しました。');
    }

    /**
     * 参加者登録確認フォーム編集
     */
    public function confirm(Request $request)
    {
        // title の設定を1件取得
        $form = SankaFormItem::where('status', 1)
            ->orderBy('sort_order')
            ->get()
            ->keyBy('name');

        return view('admin.sanka.confirm', compact('form'));

    }
    public function confirmUpdate(Request $request)
    {
        $lists = [];
        return view('admin.sanka.confirm', compact('lists'));

    }
}
