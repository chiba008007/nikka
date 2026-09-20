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
use App\Services\SankaParticipantMailService;
use App\Services\SankaParticipantListService;
use App\Services\SankaParticipantPaymentService;

class SankaListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list(
        SankaParticipantListService $listService
    ) {
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
        $lists = SankaParticipant::with(
            'participationOption',
            'banquetOption.prices'
        )
            ->orderBy('reception_serial')
            ->get();
        // 表示用データを作成
        $displayValues = $listService->makeDisplayValues(
            $lists,
            $headers
        );
        return view('admin.sanka.list', compact('lists', 'headers', 'displayValues'));
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
        SankaParticipantService $service,
        SankaParticipantMailService $mailService
    ) {
        $send = $request->boolean('send');

        $data = $request->except([
            '_token',
            'send',
        ]);

        /*
         * 参加者登録
         */
        $participant = $service->create($data);

        /*
         * メール送信
         */
        $mailService->sendRegistrationMail(
            $data,
            $participant,
            $send
        );

        return redirect()
            ->route('sanka.list.create')
            ->with('success', '参加者を登録しました。');
    }

    public function updatePaymentStatus(
        Request $request,
        SankaParticipant $participant,
        SankaParticipantPaymentService $paymentService
    ) {
        $validated = $request->validate([
            'payment_type' => [
                'required',
                'in:participation,banquet',
            ],
            'is_paid' => [
                'required',
                'boolean',
            ],
        ]);

        $result = $paymentService->updatePaymentStatus(
            $participant,
            $validated['payment_type'],
            (bool) $validated['is_paid']
        );

        return response()->json([
            'success' => true,
            'value' => $result['value'],
            'label' => $result['label'],
        ]);
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
