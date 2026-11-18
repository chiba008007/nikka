<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KoenParticipantForm;
use App\Models\KoenParticipantHistory;
use App\Models\KoenParticipantAuthorHistory;
use App\Models\KoenParticipantAffiliationHistory;

class KoenParticipantHistoryController extends Controller
{
    public function index()
    {
        // 現在有効な講演フォーム定義
        $formItems = KoenParticipantForm::query()
            ->where('page_type', 'koenform')
            ->where('status', 1)
            ->with([
                'options' => function ($query) {
                    $query->where('status', 1)
                        ->orderBy('sort_order');
                },
            ])
            ->get()
            ->keyBy('name');

        // 履歴画面に表示する可変カラム
        $historyColumns = [];

        for ($i = 1; $i <= 50; $i++) {
            $columnName = 'add_column_' . $i;
            $input = $formItems->get($columnName);

            if (!$input) {
                continue;
            }

            $label = trim(preg_replace(
                '/\[[^\]]*\]/u',
                '',
                strip_tags($input->label_ja ?? '')
            ));

            $historyColumns[] = [
                'name' => $columnName,
                'label' => $label ?: $columnName,
                'input' => $input,
            ];
        }

        // 古い順に取得して直前の履歴と比較
        $histories = KoenParticipantHistory::with('participant')
            ->orderByDesc('operated_at')
            ->orderByDesc('id')
            ->get()
            ->sort(function ($a, $b) {
                return [$a->operated_at, $a->id]
                    <=> [$b->operated_at, $b->id];
            });

        $historyRows = collect();

        foreach ($histories->groupBy('koen_participant_id') as $items) {
            $previous = null;

            foreach ($items as $history) {
                $values = [];
                $changedColumns = [];
                $operation = strtoupper($history->operation ?? '');

                foreach ($historyColumns as $column) {
                    $name = $column['name'];
                    $currentValue = $history->{$name};

                    $values[$name] = $this->formatValue(
                        $column['input'],
                        $currentValue
                    );

                    if (
                        $operation === 'INSERT'
                        && $currentValue !== null
                        && $currentValue !== ''
                    ) {
                        $changedColumns[] = $name;
                    }

                    if ($operation === 'UPDATE' && $previous) {
                        if (
                            ($previous->{$name} ?? '') !==
                            ($currentValue ?? '')
                        ) {
                            $changedColumns[] = $name;
                        }
                    }
                }

                $historyRows->push([
                    'id' => $history->id,
                    'koen_number' => $history->koen_number,
                    'participant_id' => $history->participant_id,
                    'operation' => $operation,
                    'status' => $history->status,
                    'values' => $values,
                    'operated_at' => $history->operated_at,
                    'changed_columns' => $changedColumns,
                    'is_insert' => $operation === 'INSERT',
                    'participant_name' => trim(
                        ($history->participant?->add_column_1 ?? '') . ' ' . ($history->participant?->add_column_2 ?? '')
                    ),
                    'announcenumber' => $history->announcenumber,
                    'authors' => collect(),
                    'affiliations' => collect(),
                    'operation_id' => $history->operation_id,
                    'koen_participant_id' => $history->koen_participant_id,
                ]);

                $previous = $history;
            }
        }

        $historyRows = $historyRows
            ->sortByDesc('operated_at')
            ->values();
        $details = collect();

        foreach ([
            'authors' => KoenParticipantAuthorHistory::class,
            'affiliations' => KoenParticipantAffiliationHistory::class,
        ] as $key => $model) {
            $model::whereNotNull('operation_id')->get()
                ->groupBy('operation_id')
                ->each(function ($items, $operationId) use ($details, $key) {
                    $group = $details->get($operationId, [
                        'koen_participant_id' => $items->first()->koen_participant_id,
                        'authors' => collect(),
                        'affiliations' => collect(),
                        'operated_at' => $items->first()->operated_at,
                    ]);

                    $group[$key] = $items->sortBy(
                        $key === 'authors' ? 'author_number' : 'affiliation_number'
                    )->values();

                    $details->put($operationId, $group);
                });
        }

        $usedOperations = [];

        $historyRows = $historyRows->map(function ($row) use ($details, &$usedOperations) {
            $operationId = $row['operation_id'];

            if ($operationId && $details->has($operationId)) {
                $detail = $details->get($operationId);

                $row['authors'] = $detail['authors'];
                $row['affiliations'] = $detail['affiliations'];
                $usedOperations[$operationId] = true;
            }

            return $row;
        });

        foreach ($details as $operationId => $detail) {
            if (isset($usedOperations[$operationId])) {
                continue;
            }

            $parent = $historyRows->firstWhere(
                'koen_participant_id',
                $detail['koen_participant_id']
            );

            $historyRows->push([
                'id' => 0,
                'koen_participant_id' => $detail['koen_participant_id'],
                'operation_id' => $operationId,
                'koen_number' => $parent['koen_number'] ?? '',
                'announcenumber' => $parent['announcenumber'] ?? '',
                'participant_name' => $parent['participant_name'] ?? '',
                'participant_id' => $parent['participant_id'] ?? null,
                'operation' => 'UPDATE',
                'status' => $parent['status'] ?? null,
                'values' => $parent['values'] ?? [],
                'changed_columns' => [],
                'is_insert' => false,
                'operated_at' => $detail['operated_at'],
                'authors' => $detail['authors'],
                'affiliations' => $detail['affiliations'],
            ]);
        }

        $historyRows = $historyRows
            ->sortByDesc('operated_at')
            ->values();


        $previousDetails = [];

        $historyRows = $historyRows->sortBy('operated_at')->map(function ($row) use (&$previousDetails) {
            $participantId = $row['koen_participant_id'];
            $operationId = $row['operation_id'];

            foreach (['authors', 'affiliations'] as $key) {
                $current = collect($row[$key] ?? [])
                    ->map(function ($item) use ($key) {
                        return $key === 'authors'
                            ? [
                                $item->author_number,
                                $item->family_name_ja,
                                $item->given_name_ja,
                                $item->family_name_en,
                                $item->given_name_en,
                                $item->affiliation_numbers,
                                $item->is_presenter,
                                $item->is_award_contact,
                            ]
                            : [
                                $item->affiliation_number,
                                $item->organization,
                                $item->department,
                                $item->short_name,
                                $item->english,
                                $item->english_short,
                            ];
                    })->values()->all();

                $groupKey = $participantId . ':' . $key;
                $row[$key . '_changed'] = false;

                if ($operationId && count($current) > 0) {
                    $row[$key . '_changed'] =
                        isset($previousDetails[$groupKey])
                        && $previousDetails[$groupKey] !== $current;

                    $previousDetails[$groupKey] = $current;
                }
            }

            return $row;
        })->sortByDesc('operated_at')->values();

        $historyRows = $historyRows
            ->sortByDesc('operated_at')
            ->take(1000)
            ->values();

        return view(
            'admin.koen.history',
            compact('historyRows', 'historyColumns')
        );
    }

    // 履歴値を表示用に変換
    private function formatValue($input, $value)
    {
        if ($value === null || $value === '') {
            return '';
        }

        if ($input->group_key === 'password') {
            return '********';
        }

        if ($input->group_key === 'checkbox') {
            $decoded = json_decode($value, true);

            if (!is_array($decoded)) {
                return strip_tags((string) $value);
            }

            $selected = $decoded['values'] ?? $decoded;
            $other = $decoded['other'] ?? '';

            $labels = [];

            foreach ($selected as $selectedValue) {
                $option = $input->options
                    ->firstWhere('value', (string) $selectedValue);

                $labels[] = $option
                    ? $option->label_ja
                    : (string) $selectedValue;
            }

            if ($other !== '') {
                $labels[] = $other;
            }

            return implode('、', array_map('strip_tags', $labels));
        }

        if (
            $input->type_code === 'radio'
            || $input->type_code === 'select'
        ) {
            $option = $input->options
                ->firstWhere('value', (string) $value);

            return strip_tags((string) ($option?->label_ja ?? $value));
        }

        // JSON配列の場合も選択肢名に変換
        $decoded = json_decode((string) $value, true);

        if (is_array($decoded)) {
            $selected = $decoded['values'] ?? $decoded;
            $labels = [];

            foreach ($selected as $selectedValue) {
                $option = $input->options
                    ->firstWhere('value', (string) $selectedValue);

                $labels[] = strip_tags((string) (
                    $option?->label_ja ?? $selectedValue
                ));
            }

            if (!empty($decoded['other'])) {
                $labels[] = strip_tags($decoded['other']);
            }

            return implode('、', $labels);
        }

        return strip_tags((string) $value);
    }
}
