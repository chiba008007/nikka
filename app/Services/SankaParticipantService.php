<?php

namespace App\Services;

use App\Models\SankaParticipant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class SankaParticipantService
{
    public function __construct(
        private SankaFormService $sankaFormService
    ) {
    }

    /**
     * 参加者情報を登録する
     */
    public function create(array $data): SankaParticipant
    {
        return DB::transaction(function () use ($data) {
            // 次の受付通番を取得する
            $nextSerial = $this->getNextReceptionSerial();

            // 参加区分と金額を取得する
            $joinType = $this->getJoinType(
                (int) $data['join_type']
            );

            $banquetRequested = !empty($data['konshinkai']);

            // 参加区分ごとの懇親会費を取得する
            $banquetFee = $banquetRequested
                ? (int) ($joinType['banquet_price'] ?? 0)
                : 0;

            // 参加者情報を登録する
            return SankaParticipant::create([
                'reception_serial' => $nextSerial,
                'reception_number' => $this->createReceptionNumber(
                    $nextSerial
                ),
                'family_name' => $data['name1'],
                'first_name' => $data['name2'],
                'family_name_kana' => $data['kana1'],
                'first_name_kana' => $data['kana2'],
                'organization' => $data['daigaku'],
                'department' => $data['gakubu'],
                'laboratory' => $data['kenkyu'] ?? null,
                'address_type_id' => $data['address_type'],
                'postal_code' => $data['post'],
                'address' => $data['address'],
                'telephone' => $data['tel'],
                'fax' => $data['fax'] ?? null,
                'email' => $data['mail'],
                'password' => Hash::make($data['password']),

                // チェックされた項目のIDだけを保存する
                'expertise_ids' => array_map(
                    'intval',
                    array_keys($data['sankaformselect'] ?? [])
                ),
                'expertise_other' =>
                    $data['sankaformselectother'] ?? null,

                'society_ids' => array_map(
                    'intval',
                    array_keys(
                        $data['syozokuSankaformselect'] ?? []
                    )
                ),
                'society_other' =>
                    $data['syozokuSankaformselectOther'] ?? null,

                'join_type_id' => $data['join_type'],
                'travel_support_requested' =>
                    !empty($data['tourtype']),
                'banquet_requested' => $banquetRequested,
                'participation_fee' => (int) $joinType['price'],
                'banquet_fee' => $banquetFee,
                'total_amount' =>
                    (int) $joinType['price'] + $banquetFee,
                'remarks' => $data['other_text'] ?? null,
                'admin_remarks' => $data['bikou'] ?? null,
                'mail_sent' => !empty($data['mail_send']),
                'is_selector' =>
                    (string) ($data['selecter'] ?? '0') === '1',
                'status' => 1,
            ]);
        });
    }

    /**
     * 次の受付通番を取得する
     */
    private function getNextReceptionSerial(): int
    {
        // 最大通番を取得して次の番号を決定する
        $nextSerial = (
            SankaParticipant::query()
                ->lockForUpdate()
                ->max('reception_serial') ?? 0
        ) + 1;

        if ($nextSerial > 9999) {
            throw new RuntimeException(
                '参加受付番号が上限に達しました。'
            );
        }

        return $nextSerial;
    }

    /**
     * 参加受付番号を生成する
     */
    private function createReceptionNumber(int $serial): string
    {
        return sprintf(
            config('app.sanka_reception_number_format'),
            $serial
        );
    }

    /**
     * 参加区分を取得する
     */
    private function getJoinType(int $joinTypeId): array
    {
        $joinTypes = $this->sankaFormService->getJoinTypes();
        $joinType = $joinTypes[$joinTypeId] ?? null;

        if ($joinType === null) {
            throw new RuntimeException('参加区分が不正です。');
        }

        return $joinType;
    }
}
