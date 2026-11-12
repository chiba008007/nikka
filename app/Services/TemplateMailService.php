<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Models\MailTemplate;
use App\Models\SankaParticipant;
use App\Models\SankaFormItem;
use App\Models\KoenParticipant;
use RuntimeException;
use App\Models\KoenParticipantAffiliation;
use App\Models\KoenParticipantAuthor;
use App\Models\KoenParticipantForm;

class TemplateMailService
{
    public function send(
        string $type,
        string $email,
        bool $isUpdate,
        ?int $participantId = null
    ): void {

        $mailType = app()->getLocale() === 'en'
            ? "{$type}_en"
            : $type;
        $template = MailTemplate::where('mail_type', $mailType)
          ->where('status', 1)
          ->first();

        if (!$template) {
            throw new RuntimeException("メールテンプレートがありません: {$mailType}");
        }

        $subject = $isUpdate
            ? $template->update_subject
            : $template->create_subject;
        // 参加情報と演題情報の取得

        $values = [];
        // 参加者情報
        $participant = SankaParticipant::findOrFail($participantId);
        // 講演情報
        $koen = KoenParticipant::where('participant_id', $participantId)
            ->first();


        // 固定置換項目を取得
        $replaceItems = array_merge(
            config('const.MAIL_REPLACE_SANKA', []),
            config('const.MAIL_REPLACE_KOEN', [])
        );

        // モデルから取得できる値
        $fixedValues = [
            'sanka_code' => $participant->reception_number,
            'koen_code' => $koen?->koen_number,
            'other' => $koen?->othertext,
            'happyo_number' => $koen?->announcenumber,
        ];

        foreach ($replaceItems as $key => $label) {
            if (array_key_exists($key, $fixedValues)) {
                $values["##{$key}##"] = (string) ($fixedValues[$key] ?? '');
            }
        }
        $items = SankaFormItem::with('options')
            ->where('status', 1)
            ->get()
            ->keyBy('name');


        $koenItems = KoenParticipantForm::with('options')
            ->where('page_type', 'koenform')
            ->where('status', 1)
            ->get()
            ->keyBy('name');

        // 参加者・講演項目
        $body = $template->body;
        for ($i = 1; $i <= 50; $i++) {

            $column = "add_column_{$i}";
            $raw = (string) ($participant->{$column} ?? '');
            $decoded = json_decode($raw, true);

            $options = $items->get($column)?->options;

            if (is_array($decoded)) {
                $selected = $decoded['values'] ?? $decoded;

                $labels = collect($selected)->map(
                    fn ($v) => $options?->firstWhere('value', (string) $v)?->label_ja
                        ?? (string) $v
                )->all();

                if (!empty($decoded['other'])) {
                    $labels[] = $decoded['other'];
                }

                $value = implode('、', $labels);
            } else {
                $value = $options?->firstWhere('value', $raw)?->label_ja ?? $raw;
            }


            $tag = "##add_koen_{$i}##";
            $koenValue = (string) ($koen?->{$column} ?? '');

            $koenLabel = $koenItems->get($column)?->options
                ->firstWhere('value', $koenValue)?->label_ja;
            $koenValue = strip_tags($koenLabel ?? $koenValue);

            if (trim($koenValue) === '') {
                // 値がない場合、項目名と置換文字列の行を削除
                $body = preg_replace(
                    '/^[^\r\n]*\R[ \t]*' . preg_quote($tag, '/') . '[ \t]*(?:\R|$)/m',
                    '',
                    $body
                );
            }

            $values[$tag] = $koenValue;


            $values["##{$column}##"] = $value;

        }

        // 所属機関総数
        $values['##syozoku_total##'] = $koen
            ? KoenParticipantAffiliation::where('koen_participant_id', $koen->id)
                ->whereNull('deleted_at')
                ->count()
            : 0;
        // 所属機関
        $affiliations = $koen
            ? KoenParticipantAffiliation::where('koen_participant_id', $koen->id)
                ->whereNull('deleted_at')
                ->orderBy('affiliation_number')
                ->get()
            : collect();

        $values['##syozoku_kikan##'] = $affiliations
            ->map(fn ($row) => implode(' / ', [
                $row->affiliation_number,
                $row->organization,
                $row->department,
                $row->short_name,
                $row->english,
                $row->english_short,
            ]))
            ->implode("\n");

        // 著者総数
        $authors = $koen
            ? KoenParticipantAuthor::where('koen_participant_id', $koen->id)
                ->whereNull('deleted_at')
                ->orderBy('author_number')
                ->get()
            : collect();

        $values['##tyosya_total##'] = (string) $authors->count();


        // 著者名（和名 / 英名 / 所属番号）
        $values['##tyosya_name##'] = $authors
            ->map(fn ($row) => implode(' / ', [
                trim($row->family_name_ja . ' ' . $row->given_name_ja),
                trim($row->given_name_en . ' ' . $row->family_name_en),
                $row->affiliation_numbers,
            ]))
            ->implode("\n");

        // 講演者名
        $presenter = $authors->firstWhere('is_presenter', 1);

        $values['##koen_name##'] = $presenter
            ? trim($presenter->family_name_ja . ' ' . $presenter->given_name_ja)
            : '';

        // 指導教員名
        $teacher = $authors->firstWhere('is_award_contact', 1);

        $values['##teacher_name##'] = $teacher
            ? trim($teacher->family_name_ja . ' ' . $teacher->given_name_ja)
            : '';


        // 件名・本文を置換
        $subject = strtr($subject, $values);
        $body = strtr($body, $values);

        Mail::raw($body, function ($message) use ($email, $subject) {
            $message->to($email)->subject($subject);
        });
    }
}
