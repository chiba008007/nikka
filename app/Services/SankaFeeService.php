<?php

namespace App\Services;

use App\Models\SankaFeeItem;
use App\Models\SankaFeeOption;
use App\Models\SankaFeeOptionPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SankaFeeService
{
    /**
     * 参加登録費・懇親会費を更新
     */
    public function update(Request $request): void
    {

        DB::transaction(function () use ($request) {

            /*
             * 参加登録費
             */
            $feeItem = SankaFeeItem::where('name', 'registration_fee')
                ->firstOrFail();

            $registration = $request->input('registration', []);

            // 参加登録費の基本情報を更新
            $feeItem->update([
                'label_ja' => $registration['label_ja'] ?? '',
                'label_en' => $registration['label_en'] ?? '',
                'description_ja' => $registration['description_ja'] ?? null,
                'description_en' => $registration['description_en'] ?? null,
                'currency_label_ja' => $registration['currency_label_ja'] ?? '円',
                'currency_label_en' => $registration['currency_label_en'] ?? 'yen',
                'status' => isset($registration['status']) ? 1 : 0,
            ]);

            // 参加登録費の選択肢を更新
            foreach ($registration['options'] ?? [] as $index => $data) {

                // 削除ボタンを押した場合は物理削除せず無効化
                if (!empty($data['id']) && !empty($data['deleted'])) {
                    SankaFeeOption::where('id', $data['id'])
                        ->where('sanka_fee_item_id', $feeItem->id)
                        ->update([
                            'status' => 0,
                        ]);

                    continue;
                }

                // 既存データ更新
                if (!empty($data['id'])) {
                    SankaFeeOption::where('id', $data['id'])
                        ->where('sanka_fee_item_id', $feeItem->id)
                        ->update([
                            'label_ja' => $data['label_ja'] ?? '',
                            'label_en' => $data['label_en'] ?? '',
                            'amount' => (int) ($data['amount'] ?? 0),
                            'sort_order' => $index + 1,
                            'status' => 1,
                        ]);

                    continue;
                }

                // 新規行が空なら登録しない
                if (
                    empty($data['label_ja']) &&
                    empty($data['label_en'])
                ) {
                    continue;
                }

                // 新規選択肢を登録
                SankaFeeOption::create([
                    'sanka_fee_item_id' => $feeItem->id,
                    'label_ja' => $data['label_ja'] ?? '',
                    'label_en' => $data['label_en'] ?? '',
                    'value' => ((int) SankaFeeOption::where(
                        'sanka_fee_item_id',
                        $feeItem->id
                    )->max('value')) + 1,
                    'amount' => (int) ($data['amount'] ?? 0),
                    'sort_order' => $index + 1,
                    'status' => 1,
                ]);
            }

            /*
             * 懇親会費
             */
            $banquetFee = SankaFeeItem::where('name', 'banquet_fee')
                ->firstOrFail();

            $banquet = $request->input('banquet', []);

            // 懇親会費の基本情報を更新
            $banquetFee->update([
                'label_ja' => $banquet['label_ja'] ?? '',
                'label_en' => $banquet['label_en'] ?? '',
                'currency_label_ja' => $banquet['currency_label_ja'] ?? '円',
                'currency_label_en' => $banquet['currency_label_en'] ?? 'yen',
                'status' => isset($banquet['status']) ? 1 : 0,
            ]);

            // 「参加する」などの表示名を更新
            foreach ($banquet['options'] ?? [] as $data) {
                if (empty($data['id'])) {
                    continue;
                }

                SankaFeeOption::where('id', $data['id'])
                    ->where('sanka_fee_item_id', $banquetFee->id)
                    ->update([
                        'label_ja' => $data['label_ja'] ?? '',
                        'label_en' => $data['label_en'] ?? '',
                    ]);
            }

            // 参加区分別の懇親会費を更新
            // 懇親会費の選択肢を取得
            $banquetOption = SankaFeeOption::where(
                'sanka_fee_item_id',
                $banquetFee->id
            )
                ->orderBy('sort_order')
                ->firstOrFail();


            // 参加区分別の懇親会費を更新・追加
            foreach ($banquet['prices'] ?? [] as $data) {

                // 既存ID
                $priceId = $data['id'] ?? null;


                // 削除指定された既存データは無効化
                if ($priceId && !empty($data['deleted'])) {
                    SankaFeeOptionPrice::where('id', $priceId)
                        ->where('sanka_fee_option_id', $banquetOption->id)
                        ->update([
                            'status' => 0,
                        ]);

                    continue;
                }


                // 参加区分が未指定なら処理しない
                if (
                    !isset($data['join_type_id']) ||
                    $data['join_type_id'] === ''
                ) {
                    continue;
                }


                // 既存データ更新
                if ($priceId) {
                    SankaFeeOptionPrice::where('id', $priceId)
                        ->where('sanka_fee_option_id', $banquetOption->id)
                        ->update([
                            'join_type_id' => $data['join_type_id'],
                            'amount' => (int) ($data['amount'] ?? 0),
                            'status' => 1,
                        ]);

                    continue;
                }


                // 新規データ追加
                SankaFeeOptionPrice::updateOrCreate(
                    [
                        'sanka_fee_option_id' => $banquetOption->id,
                        'join_type_id' => $data['join_type_id'],
                    ],
                    [
                        'amount' => (int) ($data['amount'] ?? 0),
                        'status' => 1,
                    ]
                );
            }
        });

    }
}
