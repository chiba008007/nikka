<?php

namespace App\Services;

use App\Models\SankaParticipant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use App\Models\SankaFormItem;

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

            // 登録データを作成する
            $insertData = [
                'reception_serial' => $nextSerial,
                'reception_number' => $this->createReceptionNumber($nextSerial),
                'status' => 1,
                'participation_status' => $data['registration_fee'] ?? 0,
                'banquet_status' => $data['banquet_fee'] ?? 0,
            ];

            // add_column_1 ～ add_column_50 をそのまま登録する
            for ($i = 1; $i <= 50; $i++) {
                $key = 'add_column_' . $i;

                if (!array_key_exists($key, $data)) {
                    continue;
                }

                $value = $data[$key];

                // checkboxなど複数値の場合はJSONで保存する
                if (is_array($value)) {
                    $value = json_encode(
                        $value,
                        JSON_UNESCAPED_UNICODE
                    );
                }

                $insertData[$key] = $value;
            }

            // パスワードをハッシュ化する
            if (!empty($insertData['add_column_15'])) {
                $insertData['add_column_15'] = Hash::make(
                    $insertData['add_column_15']
                );
            }

            // 参加者情報を登録する
            return SankaParticipant::create($insertData);
        });
    }

    /**
     * 参加者情報を更新する
     */
    public function update(
        SankaParticipant $participant,
        array $data
    ): SankaParticipant {
        return DB::transaction(function () use ($participant, $data) {

            // パスワード項目を動的に取得する
            $passwordItems = SankaFormItem::query()
                ->where('status', 1)
                ->where('group_key', 'password')
                ->pluck('name')
                ->toArray();

            $updateData = [
                'participation_status' =>
                    $data['registration_fee']
                    ?? $participant->participation_status,

                // チェックを外した場合は0
                'banquet_status' =>
                    $data['banquet_fee'] ?? 0,
            ];

            // add_column_1 ～ add_column_50
            for ($i = 1; $i <= 50; $i++) {
                $key = 'add_column_' . $i;

                if (!array_key_exists($key, $data)) {
                    continue;
                }

                $value = $data[$key];

                // パスワード項目
                if (in_array($key, $passwordItems, true)) {

                    // 空欄なら現在のパスワードを維持
                    if (empty($value)) {
                        continue;
                    }

                    $value = Hash::make($value);
                }

                // checkboxなど
                if (is_array($value)) {
                    $value = json_encode(
                        $value,
                        JSON_UNESCAPED_UNICODE
                    );
                }

                $updateData[$key] = $value;
            }

            $participant->update($updateData);

            return $participant;
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
