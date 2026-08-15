<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SankaList;
use Illuminate\Http\Request;
use App\Services\SankaFormService;
use App\Http\Requests\SankaParticipantStoreRequest;
use App\Services\SankaParticipantService;
use App\Models\SankaParticipant;
use App\Models\SankaFormItem;
use App\Models\SankaFeeItem;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationMail;

class SankaListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        // 参加者テーブル
        $headers = SankaFormItem::query()
            // 有効かつ一覧表示対象のみ取得する
            ->where('status', 1)
            ->where('list_display', 1)
            // 受付番号を必ず先頭にする
            ->orderByRaw("CASE WHEN name = 'reception_number' THEN 0 ELSE 1 END")
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                // []で囲まれた文字をすべて除去する
                $item->label_ja = preg_replace('/\[[^\]]*\]/u', '', $item->label_ja);

                return $item;
            });
        //
        // 参加者を受付番号順で取得する
        $lists = SankaParticipant::query()
            ->orderBy('reception_serial')
            ->get();

        return view('admin.sanka.list', compact('lists', 'headers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(
        SankaFormService $sankaFormService
    ) {

        // 参加入力フォームを取得する
        $formItems = SankaFormItem::query()
            ->where('status', 1)
            ->with([
                'options' => function ($query) {
                    // 有効な選択肢のみ取得する
                    $query->where('status', 1)
                        ->orderBy('sort_order');
                },
            ])
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                // []内の文字を取得する
                preg_match('/\[([^\]]+)\]/u', $item->label_ja, $matches);
                preg_match('/\[([^\]]+)\]/u', $item->label_en, $matchesen);

                // []内の文字を別キーに保持する
                $item->required_text = $matches[1] ?? '';
                $item->required_text_en = $matchesen[1] ?? '';

                // []部分を表示文字から除去する
                $item->label_ja = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $item->label_ja)
                );
                $item->label_en = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $item->label_en)
                );

                return $item;
            })
            ->keyBy('name');


        // 参加費関連を3テーブルまとめて取得する
        $feeItems = SankaFeeItem::query()
            ->where('status', 1)
            ->with([
                'options' => function ($query) {
                    // 有効な選択肢のみ取得する
                    $query->where('status', 1)
                        ->orderBy('sort_order');
                },
                'options.prices' => function ($query) {
                    // 有効な金額のみ取得する
                    $query->where('status', 1);
                },
            ])
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                // []内の文字を取得する
                preg_match('/\[([^\]]+)\]/u', $item->label_ja, $matches);
                preg_match('/\[([^\]]+)\]/u', $item->label_en, $matchesen);

                // []内の文字を別キーに保持する
                $item->required_text = $matches[1] ?? '';
                $item->required_text_en = $matchesen[1] ?? '';

                // []部分を表示文字から除去する
                $item->label_ja = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $item->label_ja)
                );
                $item->label_en = trim(
                    preg_replace('/\[[^\]]*\]/u', '', $item->label_en)
                );

                return $item;
            })
            ->keyBy('name');

        return view(
            'admin.sanka.create',
            compact(
                'formItems',
                'feeItems',
            )
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        SankaParticipantStoreRequest $request,
        SankaParticipantService $service
    ) {
        // DB定義で検証済みの入力値を登録する
        // フォームから送信された値を取得する
        $data = $request->except('_token');


        //$service->create($data);
        // 参加者にメールを送る
        if ($data['send']) {
            $mailAddress = "chiba00807@gmail.com";
            $subject = "あいうえお";
            $body = "あああ";
            Mail::to($mailAddress)->send(
                new RegistrationMail(
                    $subject,
                    $body
                )
            );
        }
        echo "send";
        exit();
        return redirect()
            ->route('sanka.list.editform')
            ->with('success', '参加者を登録しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(SankaList $sankaList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SankaList $sankaList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SankaList $sankaList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SankaList $sankaList)
    {
        //
    }

    /**
     * 参加者登録フォーム編集
     */
    public function editform(Request $request)
    {
        $lists = [];
        return view('admin.sanka.editform', compact('lists'));

    }
}
