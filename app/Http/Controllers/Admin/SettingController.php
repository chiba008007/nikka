<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    //
    public function index(Request $request)
    {
        $form = [];

        $form = Setting::get()->keyBy('type');

        return view('admin.setting', compact('form'));
    }

    // 設定更新
    public function edit(Request $request)
    {
        $data = $request->validate([
            'sankanumber.name_ja' => 'required|string|max:1280',
            'sankanumber.name_en' => 'nullable|string|max:1280',
            'sankacode1.name_ja' => 'required|string|max:1280',
            'sankacode2.name_ja' => 'required|string|max:1280',
            'sankacode3.name_ja' => 'required|string|max:1280',
            'koennumber.name_ja' => 'required|string|max:1280',
            'koennumber.name_en' => 'nullable|string|max:1280',
            'koencode1.name_ja' => 'required|string|max:1280',
            'koencode2.name_ja' => 'required|string|max:1280',
            'koencode3.name_ja' => 'required|string|max:1280',
        ]);

        foreach ($data as $type => $values) {
            Setting::where('type', $type)->update($values);
        }

        return redirect()
            ->route('home.list.setting')
            ->with('success', '更新しました。');
    }
}
