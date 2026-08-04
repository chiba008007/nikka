<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SankaList;
use Illuminate\Http\Request;
use App\Services\SankaFormService;
use App\Http\Requests\SankaParticipantStoreRequest;
use App\Services\SankaParticipantService;
use App\Models\SankaParticipant;

class SankaListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        // 参加者を受付番号順で取得する
        $lists = SankaParticipant::query()
            ->orderBy('reception_serial')
            ->get();

        return view('admin.sanka.list', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(
        SankaFormService $sankaFormService
    ) {

        // 共通フォームの選択肢を取得する
        $addressTypes = $sankaFormService->getAddressTypes();
        $expertiseTypes = $sankaFormService->getExpertiseTypes();
        $societyTypes = $sankaFormService->getSocietyTypes();
        $joinTypes = $sankaFormService->getJoinTypes();
        return view(
            'admin.sanka.create',
            compact(
                'addressTypes',
                'expertiseTypes',
                'societyTypes',
                'joinTypes'
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
        $service->create($request->validated());

        return redirect()
            ->route('sanka.list.index')
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
