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
     * 参加者登録フォーム編集
     */
    public function edit(
        int $id,
        SankaFormService $sankaFormService
    ) {
        $participant = SankaParticipant::findOrFail($id);

        $data = $sankaFormService->getFormData();
        $data['participant'] = $participant;

        return view('admin.sanka.edit', $data);
    }

    public function update(
        Request $request,
        int $id,
        SankaParticipantService $service,
        SankaParticipantMailService $mailService
    ) {
        $send = $request->boolean('send');
        $participant = SankaParticipant::findOrFail($id);

        $data = $request->except([
            '_token',
            '_method',
            'regist',
            'send',
        ]);

        $service->update($participant, $data);

        /*
         * メール送信
         */
        $mailService->sendRegistrationMail(
            $data,
            $participant,
            $send
        );

        return redirect()
            ->route('sanka.list.index')
            ->with('success', '参加者情報を更新しました。');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(
        SankaFormService $sankaFormService
    ) {
        $data = $sankaFormService->getFormData();

        return view('admin.sanka.create', $data);
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
    public function destroy($id)
    {
        $participant = SankaParticipant::findOrFail($id);

        $participant->delete();

        return redirect()
            ->back()
            ->with('success', '参加者を削除しました。');
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
