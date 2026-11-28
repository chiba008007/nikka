<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageTop;
use App\Models\Banner;

class EditPageController extends Controller
{
    //
    public function top()
    {

        $pageTops = PageTop::whereBetween('num', [1, 100])->get();
        $banners = Banner::where('status', 1)
            ->orderBy('sort')
            ->orderBy('id')
            ->get();

        return view('admin.edit.top', compact('pageTops', 'banners'));
    }

    public function edit(Request $request)
    {
        $validated = $request->validate([
            'num' => 'required|integer|exists:page_top,num',
            'note' => 'required|string',
        ]);

        $pageTop = PageTop::where('num', $validated['num'])->firstOrFail();

        $pageTop->update([
            'note' => $validated['note'],
        ]);

        return response()->json(['success' => true]);
    }

    public function koen()
    {

        $pageTops = PageTop::where('num', '>=', 101)->get()->keyBy('num');
        $banners = Banner::where('status', 1)
            ->orderBy('sort')
            ->orderBy('id')
            ->get();

        return view('admin.edit.topkoen', compact('pageTops', 'banners'));
    }

}
