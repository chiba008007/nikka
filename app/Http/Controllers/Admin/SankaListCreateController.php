<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SankaList;
use Illuminate\Http\Request;

class SankaListCreateController extends Controller
{
    /**
     * 参加者登録フォーム編集
     */
    public function editform(Request $request)
    {
        $lists = [];
        return view('admin.sanka.editform', compact('lists'));

    }
    public function update(Request $request)
    {
        $lists = [];
        return view('admin.sanka.editform', compact('lists'));

    }
}
