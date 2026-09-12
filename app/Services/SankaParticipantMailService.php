<?php

namespace App\Services;

use App\Mail\RegistrationMail;
use App\Models\MailTemplate;
use App\Models\SankaFormItem;
use App\Models\SankaParticipant;
use Illuminate\Support\Facades\Mail;

class SankaParticipantMailService
{
    /**
     * 参加申込みメール送信
     */
    public function sendRegistrationMail(
        array $data,
        SankaParticipant $participant,
        bool $sendToParticipant = true
    ): void {
        // 参加者メールアドレス取得
        $mailAddress = $this->getParticipantMailAddress($data);

        // メールテンプレート取得
        $mailTemplate = $this->getMailTemplate();

        // ##xxx## 置換データ作成
        $replace = $this->makeReplaceData(
            $data,
            $participant
        );

        // 件名
        $subject = strtr(
            $mailTemplate->create_subject,
            $replace
        );

        // 本文
        $body = strtr(
            $mailTemplate->body,
            $replace
        );

        /*
         * 参加者
         */
        if ($sendToParticipant) {
            $this->send(
                $mailAddress,
                $subject,
                $body
            );
        }

        /*
         * 管理者
         */
        $mailAddressAdmin = env('MAIL_ADDRESS_ADMIN');

        if ($mailAddressAdmin) {
            $this->send(
                $mailAddressAdmin,
                '[管理者用]' . $subject,
                $body
            );
        }
    }

    /**
     * 参加者メールアドレス取得
     */
    private function getParticipantMailAddress(array $data): string
    {
        $mailItem = SankaFormItem::where('group_key', 'mail')
            ->where('status', 1)
            ->first();

        if (!$mailItem) {
            throw new \RuntimeException(
                'メールアドレス項目が設定されていません。'
            );
        }

        $mailAddress = $data[$mailItem->name] ?? null;

        if (!$mailAddress) {
            throw new \RuntimeException(
                'メールアドレスが入力されていません。'
            );
        }

        return $mailAddress;
    }

    /**
     * メールテンプレート取得
     */
    private function getMailTemplate(): MailTemplate
    {
        $mailTemplate = MailTemplate::where(
            'mail_type',
            'participation_application'
        )
            ->where('status', 1)
            ->first();

        if (!$mailTemplate) {
            throw new \RuntimeException(
                'メールテンプレートが設定されていません。'
            );
        }

        return $mailTemplate;
    }

    /**
     * ##xxx## の置換データ作成
     */
    private function makeReplaceData(
        array $data,
        SankaParticipant $participant
    ): array {
        $formItems = SankaFormItem::with('options')
            ->where('status', 1)
            ->get()
            ->keyBy('name');

        $replace = [];

        foreach ($data as $key => $value) {
            $item = $formItems->get($key);

            /*
             * radio / select
             */
            if (
                $item &&
                in_array($item->group_key, ['radio', 'select'])
            ) {
                $option = $item->options
                    ->where('status', 1)
                    ->firstWhere(
                        'value',
                        (string) $value
                    );

                if ($option) {
                    $value = $option->label_ja;
                }
            }

            /*
             * checkbox
             */ elseif (
                $item &&
                $item->group_key === 'checkbox'
            ) {
                $labels = [];

                foreach (
                    $value['values'] ?? [] as $selectedValue
                ) {
                    $option = $item->options
                        ->where('status', 1)
                        ->firstWhere(
                            'value',
                            (string) $selectedValue
                        );

                    if ($option) {
                        $labels[] = $option->label_ja;
                    }
                }

                /*
                 * その他
                 */
                if (!empty($value['other'])) {
                    $labels[] = $value['other'];
                }

                $value = implode('、', $labels);
            }

            /*
             * 配列はメール置換対象にしない
             */
            if (!is_array($value)) {
                $replace["##{$key}##"] =
                    $value ?? '';
            }
        }

        /*
         * 登録時に生成される値
         */
        $replace['##reception_number##'] =
            $participant->reception_number ?? '';

        $replace['##reception_serial##'] =
            $participant->reception_serial ?? '';

        return $replace;
    }

    /**
     * メール送信
     *
     * メール送信そのものは必ずここを通す
     */
    private function send(
        string $mailAddress,
        string $subject,
        string $body
    ): void {
        Mail::to($mailAddress)->send(
            new RegistrationMail(
                $subject,
                $body
            )
        );
    }
}
