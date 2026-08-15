<?php

namespace App\Http\Requests;

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
        return [];
        /*
        return [
            // 氏名
            'name1' => ['required', 'string', 'max:100'],
            'name2' => ['required', 'string', 'max:100'],
            'kana1' => ['required', 'string', 'max:100'],
            'kana2' => ['required', 'string', 'max:100'],

            // 所属情報
            'daigaku' => ['required', 'string', 'max:255'],
            'gakubu' => ['required', 'string', 'max:255'],
            'kenkyu' => ['nullable', 'string', 'max:255'],

            // 連絡先
            'address_type' => ['required', 'integer'],
            'post' => ['required', 'string', 'max:8'],
            'address' => ['required', 'string', 'max:500'],
            'tel' => ['required', 'string', 'max:30'],
            'fax' => ['nullable', 'string', 'max:30'],
            'mail' => ['required', 'email', 'max:255'],
            'mail2' => ['required', 'same:mail'],

            // その他
            'password' => ['required', 'string', 'min:8'],
            'sankaformselect' => ['nullable', 'array'],
            'sankaformselectother' => ['nullable', 'string', 'max:255'],
            'syozokuSankaformselect' => ['nullable', 'array'],
            'syozokuSankaformselectOther' => ['nullable', 'string', 'max:255'],
            'join_type' => ['required', 'integer'],
            'tourtype' => ['nullable'],
            'konshinkai' => ['nullable'],
            'other_text' => ['nullable', 'string'],
            'bikou' => ['nullable', 'string'],
            'mail_send' => ['nullable'],
            'selecter' => ['nullable', 'in:0,1'],
        ];
        */
    }
}
