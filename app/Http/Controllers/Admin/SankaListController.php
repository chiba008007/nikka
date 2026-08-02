<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SankaList;
use Illuminate\Http\Request;

class SankaListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
        $lists = [];
        return view('admin.sanka.list', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lists = [];
        return view('admin.sanka.create', compact('lists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
