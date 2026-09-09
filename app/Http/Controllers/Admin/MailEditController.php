<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailTemplate;
use App\Models\SankaFormItem;

class MailEditController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */

    public function edit(Request $request)
    {
        // メール種別一覧を取得する
        $mailType = config('const.MAIL_TYPE');

        // queryがあればそれを使う
        $selectedMailType = $request->query('mail_type');

        // queryがなければ一番上を使う
        if (!$selectedMailType) {
            $selectedMailType = array_key_first($mailType);
        }

        // 選択されたメール種別のテンプレートを取得する
        $mailTemplate = MailTemplate::where(
            'mail_type',
            $selectedMailType
        )->first();

        $sankaFormItem = SankaFormItem::where('status', 1)
            ->get()
            ->map(function ($item) {
                // [必須] など [] 内の文字を削除する
                $item->label_ja = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $item->label_ja)
                );

                return $item;
            })
            ->keyBy('name');

        return view(
            'admin.mailEdit.edit',
            compact(
                'mailTemplate',
                'mailType',
                'selectedMailType',
                'sankaFormItem'
            )
        );
    }

    public function update(Request $request)
    {

        // メール種別を取得する
        $mailType = $request->input('mail_type');

        // メール種別ごとに登録・更新する
        MailTemplate::updateOrCreate(
            [
                'mail_type' => $mailType,
            ],
            [
                'create_subject' => $request->input('create_subject'),
                'update_subject' => $request->input('update_subject'),
                'body' => $request->input('body'),
                'status' => 1,
            ]
        );

        return back()
            ->with('success', 'メール内容を更新しました。');

    }
}
