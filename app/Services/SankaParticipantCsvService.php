<?php

namespace App\Services;

use App\Models\SankaFormItem;
use App\Models\SankaParticipant;

class SankaParticipantCsvService
{
    private SankaParticipantListService $listService;

    public function __construct(
        SankaParticipantListService $listService
    ) {
        $this->listService = $listService;
    }

    public function download()
    {
        /*
         * フォーム定義
         */
        $formItems = SankaFormItem::query()
            ->where('status', 1)
            ->with([
                'options' => function ($query) {
                    $query->where('status', 1)
                        ->orderBy('sort_order');
                },
            ])
            ->get()
            ->keyBy('name');

        /*
         * 一覧表示用
         * 参加種別・金額・支払状態の取得に使用
         */
        $displayHeaders = SankaFormItem::query()
            ->where('status', 1)
            ->where('list_display', 1)
            ->orderBy('sort_order')
            ->get();

        /*
         * 参加者
         */
        $lists = SankaParticipant::with(
            'participationOption',
            'banquetOption.prices'
        )
            ->orderBy('reception_serial')
            ->get();

        $displayValues = $this->listService->makeDisplayValues(
            $lists,
            $displayHeaders
        );

        /*
         * CSV可変項目
         *
         * title1       → add_column_1
         * title2       → add_column_2
         * ...
         *
         * column = 2 の場合は次のadd_columnも出力
         */
        $csvItems = [];

        for ($i = 1; $i <= 50; $i++) {
            $title = $formItems->get('title' . $i);
            $input = $formItems->get('add_column_' . $i);

            if (!$title || !$input) {
                continue;
            }

            // メールアドレス確認用はCSV対象外
            if ($input->group_key === 'mailcheck') {
                continue;
            }

            $label = trim(
                preg_replace(
                    '/\[[^\]]*\]/u',
                    '',
                    $title->label_ja
                )
            );

            $csvItems[] = [
                'label' => $label,
                'input' => $input,
            ];

            if ($input->column == 2) {
                $secondInput = $formItems->get(
                    'add_column_' . ($i + 1)
                );

                $secondTitle = $formItems->get(
                    'title' . ($i + 1)
                );

                if ($secondInput) {
                    // 2つ目もmailcheckなら出さない
                    if ($secondInput->group_key !== 'mailcheck') {
                        $secondLabel = $secondTitle
                            ? trim(
                                preg_replace(
                                    '/\[[^\]]*\]/u',
                                    '',
                                    $secondTitle->label_ja
                                )
                            )
                            : (
                                trim($secondInput->label_ja ?? '')
                                ?: trim($secondInput->placeholder_ja ?? '')
                            );

                        $csvItems[] = [
                            'label' => $secondLabel,
                            'input' => $secondInput,
                        ];
                    }

                    $i++;
                }
            }
        }

        return response()->streamDownload(
            function () use (
                $lists,
                $csvItems,
                $displayValues
            ) {
                $stream = fopen('php://output', 'w');

                // Excel文字化け対策
                fwrite($stream, "\xEF\xBB\xBF");

                /*
                 * CSVヘッダ
                 */
                $csvHeaders = [
                    '参加受付番号',
                ];

                foreach ($csvItems as $item) {
                    $input = $item['input'];

                    $csvHeaders[] = $item['label'];

                    /*
                     * checkboxはその他を別列にする
                     */
                    if ($input->group_key === 'checkbox') {
                        $csvHeaders[] =
                            $item['label'] . '(その他)';
                    }
                }

                $csvHeaders[] = '参加登録種別';
                $csvHeaders[] = '懇親会参加';
                $csvHeaders[] = '講演会参加費';
                $csvHeaders[] = '懇親会参加費';
                $csvHeaders[] = '合計';
                $csvHeaders[] = '参加費確認';
                $csvHeaders[] = '更新日';

                fputcsv($stream, $csvHeaders);

                /*
                 * CSVデータ
                 */
                foreach ($lists as $participant) {
                    $values =
                        $displayValues[$participant->id] ?? [];

                    $row = [
                        $participant->reception_number,
                    ];

                    /*
                     * 可変項目
                     */
                    foreach ($csvItems as $item) {
                        $input = $item['input'];

                        $raw =
                            $participant->{$input->name};

                        /*
                         * パスワード
                         * DBにはハッシュしかないため空欄
                         */
                        if ($input->group_key === 'password') {
                            $row[] = '';
                            continue;
                        }

                        /*
                         * checkbox
                         */
                        if ($input->group_key === 'checkbox') {
                            $decoded = json_decode(
                                $raw ?? '',
                                true
                            );

                            $selected = [];
                            $other = '';

                            if (
                                is_array($decoded)
                                && isset($decoded['values'])
                            ) {
                                // 現在形式
                                $selected =
                                    $decoded['values'] ?? [];

                                $other =
                                    $decoded['other'] ?? '';

                            } elseif (is_array($decoded)) {
                                // 旧形式
                                $selected = $decoded;
                            }

                            $labels = [];

                            foreach (
                                $selected as $selectedValue
                            ) {
                                $option = $input->options
                                    ->firstWhere(
                                        'value',
                                        $selectedValue
                                    );

                                $labels[] = $option
                                    ? $option->label_ja
                                    : $selectedValue;
                            }

                            $row[] = implode(
                                '、',
                                $labels
                            );

                            $row[] = $other;

                            continue;
                        }

                        /*
                         * radio / select
                         */
                        if (
                            $input->group_key === 'radio'
                            || $input->group_key === 'select'
                        ) {
                            $option = $input->options
                                ->firstWhere(
                                    'value',
                                    $raw
                                );

                            $row[] = $option
                                ? $option->label_ja
                                : ($raw ?? '');

                            continue;
                        }

                        /*
                         * 通常項目
                         */
                        $row[] = $raw ?? '';
                    }

                    /*
                     * 参加費関連
                     */
                    $row[] =
                        $values['participation_type']
                        ?? '';

                    $row[] =
                        $values['banquet_type']
                        ?? '';

                    $participationAmount =
                        $values['participation_amount']
                        ?? '0';

                    $banquetAmount =
                        $values['banquet_amount']
                        ?? '0';

                    $row[] = $participationAmount;
                    $row[] = $banquetAmount;

                    /*
                     * 合計
                     */
                    $total =
                        (int) str_replace(
                            ',',
                            '',
                            $participationAmount
                        )
                        +
                        (int) str_replace(
                            ',',
                            '',
                            $banquetAmount
                        );

                    $row[] = number_format($total);

                    /*
                     * 参加費確認
                     */
                    $row[] =
                        $values[
                            'participation_payment_status'
                        ]
                        ?? '';

                    /*
                     * 更新日
                     */
                    $row[] =
                        $participant->updated_at
                            ? $participant->updated_at
                                ->format('Y/m/d H:i:s')
                            : '';
                    fputcsv($stream, $row);
                }

                fclose($stream);
            },
            'participants_'
                . now()->format('YmdHis')
                . '.csv',
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }
}
