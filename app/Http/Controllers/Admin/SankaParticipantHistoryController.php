<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SankaFormItem;
use App\Models\SankaParticipantHistory;

class SankaParticipantHistoryController extends Controller
{
    public function index()
    {
        /*
         * 現在有効なフォーム定義
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
         * 履歴画面に表示する可変カラム
         */
        $historyColumns = [];

        for ($i = 1; $i <= 50; $i++) {

            $columnName = 'add_column_' . $i;

            /*
             * add_column自体が有効でなければ表示しない
             */
            $input = $formItems->get($columnName);

            if (!$input) {
                continue;
            }

            /*
             * 対応するタイトル
             */
            $title = $formItems->get('title' . $i);

            if ($title) {

                $label = trim(
                    preg_replace(
                        '/\[[^\]]*\]/u',
                        '',
                        strip_tags($title->label_ja)
                    )
                );

            } else {

                /*
                 * 2分割項目などtitleがない場合
                 */
                $label =
                    trim($input->label_ja ?? '')
                    ?: trim($input->placeholder_ja ?? '')
                    ?: $columnName;
            }

            $historyColumns[] = [
                'name' => $columnName,
                'label' => $label,
                'input' => $input,
            ];
        }

        /*
         * 履歴取得
         */
        $histories = SankaParticipantHistory::query()
            ->orderByDesc('operated_at')
            ->orderByDesc('id')
            ->get();

        /*
         * 画面表示用の値を作成
         */
        $historyRows = collect();

        foreach (
            $histories->groupBy('participant_id') as $participantHistories
        ) {
            $previous = null;

            foreach ($participantHistories as $history) {

                $values = [];
                $changedColumns = [];

                foreach ($historyColumns as $column) {

                    $columnName = $column['name'];
                    $currentValue = $history->{$columnName};

                    $values[$columnName] =
                        $this->formatValue(
                            $column['input'],
                            $currentValue
                        );

                    /*
                     * INSERT
                     * 値が入っている項目を強調対象にする
                     */
                    if (
                        strtoupper($history->operation) === 'INSERT'
                        && $currentValue !== null
                        && $currentValue !== ''
                    ) {
                        $changedColumns[] = $columnName;
                    }

                    /*
                     * UPDATE
                     * 一つ前の履歴と比較
                     */
                    if (
                        strtoupper($history->operation) === 'UPDATE'
                        && $previous
                    ) {
                        $previousValue =
                            $previous->{$columnName};

                        if (
                            ($previousValue ?? '') !==
                            ($currentValue ?? '')
                        ) {
                            $changedColumns[] =
                                $columnName;
                        }
                    }
                }

                /*
                 * 固定項目も比較
                 */
                $fixedColumns = [
                    'participation_status',
                    'banquet_status',
                    'participation_payment_status',
                    'banquet_payment_status',
                ];

                foreach ($fixedColumns as $columnName) {

                    if (
                        strtoupper($history->operation) === 'UPDATE'
                        && $previous
                        && (
                            ($previous->{$columnName} ?? '')
                            !==
                            ($history->{$columnName} ?? '')
                        )
                    ) {
                        $changedColumns[] = $columnName;
                    }
                }

                $historyRows->push([
                    'reception_number' =>
                        $history->reception_number,

                    'operation' =>
                        $history->operation,

                    'values' =>
                        $values,

                    'participation_status' =>
                        $history->participation_status,

                    'banquet_status' =>
                        $history->banquet_status,

                    'participation_payment_status' =>
                        $history->participation_payment_status,

                    'banquet_payment_status' =>
                        $history->banquet_payment_status,

                    'operated_at' =>
                        $history->operated_at,

                    /*
                     * 変更されたカラム名
                     */
                    'changed_columns' =>
                        $changedColumns,

                    /*
                     * INSERT判定
                     */
                    'is_insert' =>
                        strtoupper($history->operation) === 'INSERT',
                ]);

                $previous = $history;
            }
        }

        /*
         * 表示は新しい履歴から
         */
        $historyRows = $historyRows
            ->sortByDesc('operated_at')
            ->values();

        return view(
            'admin.sanka.history',
            compact(
                'historyRows',
                'historyColumns'
            )
        );
    }


    /**
     * 履歴値を表示用に変換
     */
    private function formatValue(
        $input,
        $value
    ) {
        if ($value === null || $value === '') {
            return '';
        }

        /*
         * パスワード
         */
        if ($input->group_key === 'password') {
            return '********';
        }

        /*
         * checkbox
         */
        if ($input->group_key === 'checkbox') {

            $decoded = json_decode(
                $value,
                true
            );

            if (!is_array($decoded)) {
                return $value;
            }

            $selected = [];
            $other = '';

            if (isset($decoded['values'])) {

                $selected =
                    $decoded['values'] ?? [];

                $other =
                    $decoded['other'] ?? '';

            } else {

                /*
                 * 旧形式
                 */
                $selected = $decoded;
            }

            $labels = [];

            foreach ($selected as $selectedValue) {

                $option = $input->options
                    ->firstWhere(
                        'value',
                        $selectedValue
                    );

                $labels[] = $option
                    ? $option->label_ja
                    : $selectedValue;
            }

            if ($other !== '') {
                $labels[] = $other;
            }

            return implode(
                '、',
                $labels
            );
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
                    $value
                );

            return $option
                ? $option->label_ja
                : $value;
        }

        return $value;
    }
}
