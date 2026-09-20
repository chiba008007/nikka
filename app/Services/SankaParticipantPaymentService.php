<?php

namespace App\Services;

use App\Models\SankaParticipant;

class SankaParticipantPaymentService
{
    /**
     * 支払ステータスを更新する
     */
    public function updatePaymentStatus(
        SankaParticipant $participant,
        string $paymentType,
        bool $isPaid
    ): array {
        $paymentStatus = config('const.payment_status');

        $column = match ($paymentType) {
            'participation' => 'participation_payment_status',
            'banquet' => 'banquet_payment_status',
        };

        $status = $isPaid
            ? $paymentStatus['paid']
            : $paymentStatus['unpaid'];

        $participant->update([
            $column => $status['value'],
        ]);

        return [
            'value' => $status['value'],
            'label' => $status['label'],
        ];
    }
}
