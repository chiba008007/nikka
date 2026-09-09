<?php

namespace App\Http\Requests;

use App\Models\SankaFormItem;
use Illuminate\Foundation\Http\FormRequest;

class SankaParticipantStoreRequest extends FormRequest
{
    /**
     * リクエストを許可する
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        // 有効な入力項目を取得する
        $items = SankaFormItem::where('status', 1)
            ->where('name', 'like', 'add_column_%')
            ->get();

        foreach ($items as $item) {

            /*
             * checkbox
             */
            if ($item->group_key === 'checkbox') {
                $rules[$item->name . '.values'] = [
                    $item->required ? 'required' : 'nullable',
                    'array',
                    'min:1',
                ];

                $rules[$item->name . '.other'] = [
                    'nullable',
                    'string',
                ];

                continue;
            }

            /*
             * radio
             */
            if ($item->group_key === 'radio') {
                $rules[$item->name] = [
                    $item->required ? 'required' : 'nullable',
                ];

                continue;
            }

            /*
             * メールアドレス
             */
            if ($item->group_key === 'mail') {
                $rules[$item->name] = [
                    $item->required ? 'required' : 'nullable',
                    'email',
                ];

                continue;
            }

            /*
             * 確認用メールアドレス
             */
            if ($item->group_key === 'mailcheck') {
                $rules[$item->name] = [
                    $item->required ? 'required' : 'nullable',
                    'email',
                    'same:add_column_13',
                ];

                continue;
            }

            /*
             * その他
             */
            $itemRules = [
                $item->required ? 'required' : 'nullable',
            ];

            switch ($item->type) {
                case 'numeric':
                    $itemRules[] = 'numeric';
                    break;

                case 'alpha':
                    $itemRules[] = 'alpha';
                    break;

                case 'alphanumeric':
                    $itemRules[] = 'alpha_num:ascii';
                    break;

                case 'kana':
                    $itemRules[] = 'regex:/^[ァ-ヶー\s]+$/u';
                    break;

                case 'text':
                default:
                    $itemRules[] = 'string';
                    break;
            }

            $rules[$item->name] = $itemRules;
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [];

        // 現在の言語を取得する
        $language = session('language', 'jp');

        $items = SankaFormItem::where('status', 1)
            ->where('name', 'like', 'add_column_%')
            ->get();

        foreach ($items as $item) {

            // 言語に応じたメッセージを取得する
            $message = $language === 'en'
                ? $item->error_message_en
                : $item->error_message_ja;

            if (empty($message)) {
                continue;
            }

            // checkbox
            if ($item->group_key === 'checkbox') {
                $messages[$item->name . '.values.required'] = $message;
                $messages[$item->name . '.values.min'] = $message;
                continue;
            }

            // 通常項目
            $messages[$item->name . '.required'] = $message;
            $messages[$item->name . '.numeric'] = $message;
            $messages[$item->name . '.alpha'] = $message;
            $messages[$item->name . '.alpha_num'] = $message;
            $messages[$item->name . '.regex'] = $message;
            $messages[$item->name . '.email'] = $message;
            $messages[$item->name . '.same'] = $message;
            $messages[$item->name . '.string'] = $message;
        }

        return $messages;
    }

}
