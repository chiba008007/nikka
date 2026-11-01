<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SankaFormItem;
use App\Models\SankaFeeItem;
use App\Models\SankaFeeOption;
use App\Models\SankaFeeOptionPrice;
use App\Services\SankaFeeService;
use App\Models\SankaParticipant;
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
                    'explain_jp',
                    'explain_en',
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
                // title1 ～ title50 の演題登録画面表示フラグ
                if (preg_match('/^title([1-9]|[1-4][0-9]|50)$/', $key)) {
                    $updateData['endai_regist_flag'] =
                        isset($data['endai_regist_flag']) ? 1 : 0;
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
        $form = SankaFormItem::orderBy('sort_order')
            ->get()
            ->keyBy('name');

        return view('admin.sanka.confirm', compact('form'));

    }
    public function confirmUpdate(Request $request)
    {

        $data = $request->input('description_confirm', []);

        $item = SankaFormItem::where('name', 'description_confirm')->first();

        if ($item) {
            $item->update([
                'label_ja' => $data['label_ja'] ?? '',
                'label_en' => $data['label_en'] ?? ''
            ]);
        }
        return redirect()
            ->back()
            ->with('success', '更新しました。');
    }

    /**
     * 参加者登録確認フォーム編集
     */
    public function complete(Request $request)
    {
        // title の設定を1件取得
        $form = SankaFormItem::orderBy('sort_order')
            ->get()
            ->keyBy('name');

        return view('admin.sanka.complete', compact('form'));
    }
    public function completeUpdate(Request $request)
    {
        DB::transaction(function () use ($request) {

            foreach ([
                'complete_title',
                'complete_join_id',
                'complete_message',
                'complete_explain',
                ] as $key) {

                $data = $request->input($key, []);

                $item = SankaFormItem::where('name', $key)->first();

                if (!$item) {
                    continue;
                }

                $item->update([
                    'label_ja' => $data['label_ja'] ?? '',
                    'label_en' => $data['label_en'] ?? '',
                ]);
            }
        });

        return redirect()
            ->back()
            ->with('success', '更新しました。');
    }

    /**
     * ajaxで参加者情報を取得
     */

    public function searchParticipant(Request $request)
    {
        $data = $request->validate([
            'serial' => 'required|digits:4',
        ]);

        // 演題登録画面の表示対象
        $titles = SankaFormItem::where('endai_regist_flag', 1)
            ->pluck('name')
            ->flip();

        $inputs = SankaFormItem::where('name', 'like', 'add_column_%')
            ->with(['options' => fn ($query) => $query->where('status', 1)])
            ->get(['id', 'name', 'column', 'group_key'])
            ->keyBy('name');

        $groups = [];

        for ($i = 1; $i <= 50; $i++) {
            if (!$titles->has('title' . $i)) {
                continue;
            }

            $input = $inputs->get('add_column_' . $i);

            if (!$input || $input->group_key === 'password') {
                continue;
            }

            $group = [$input->name];

            $titleKey = 'title' . $i;

            // 2分割の場合は次のカラムと結合する
            if ((int) $input->column === 2 && $i < 50) {
                $next = $inputs->get('add_column_' . ($i + 1));

                if ($next && $next->group_key !== 'password') {
                    $group[] = $next->name;
                    $i++;
                }
            }

            $groups[$titleKey] = $group;
        }

        $columns = collect($groups)->flatten()->unique()->all();

        $participant = SankaParticipant::where(
            'reception_serial',
            (int) $data['serial']
        )->first(array_merge(['id', 'reception_number'], $columns));

        if ($participant) {
            $request->session()->put('koen_participant_id', $participant->id);
        } else {
            $request->session()->forget('koen_participant_id');
        }

        $values = [];

        if ($participant) {
            foreach ($groups as $titleKey => $group) {
                $ja = '';
                $en = '';

                foreach ($group as $name) {
                    $raw = (string) ($participant->{$name} ?? '');
                    $input = $inputs->get($name);

                    $option = $input?->group_key === 'radio'
                        ? $input->options->firstWhere('value', $raw)
                        : null;

                    $ja .= $option?->label_ja ?? $raw;
                    $en .= $option?->label_en ?? $raw;
                }

                $values[$titleKey] = [
                    'ja' => $ja,
                    'en' => $en,
                ];
            }
        }

        return response()->json([
            'participant' => $participant ? [
                'id' => $participant->id,
                'reception_number' => $participant->reception_number,
                'values' => $values,
            ] : null,
        ]);
    }

    /**
     * 参加者登録確認フォーム編集
     */
    public function loginForm(Request $request)
    {
        // title の設定を1件取得
        $form = SankaFormItem::orderBy('sort_order')
            ->get()
            ->keyBy('name');

        return view('admin.sanka.loginForm', compact('form'));
    }
    public function loginUpdate(Request $request)
    {
        DB::transaction(function () use ($request) {

            foreach ([
                'login_form_title',
                'login_form_descript',
                'login_form_login_id',
                'login_form_login_password',
                ] as $key) {

                $data = $request->input($key, []);

                $item = SankaFormItem::where('name', $key)->first();

                if (!$item) {
                    continue;
                }

                $item->update([
                    'label_ja' => $data['label_ja'] ?? '',
                    'label_en' => $data['label_en'] ?? '',
                ]);
            }

            foreach ([
                'login_form_login_id',
                'login_form_login_password',
                ] as $key) {

                $data = $request->input($key, []);

                $item = SankaFormItem::where('name', $key)->first();

                if (!$item) {
                    continue;
                }

                $item->update([
                    'required' => $data['required'] ?? 0,
                    'placeholder_ja' => $data['placeholder_ja'] ?? '',
                    'placeholder_en' => $data['placeholder_en'] ?? '',
                    'error_message_ja' => $data['error_message_ja'] ?? '',
                    'error_message_en' => $data['error_message_en'] ?? '',
                ]);
            }


        });

        return redirect()
            ->back()
            ->with('success', '更新しました。');
    }


}
