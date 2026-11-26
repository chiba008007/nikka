<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageTop;

class EditPageController extends Controller
{
    //
    public function top()
    {

        $pageTops = PageTop::all();
        return view('admin.edit.top', compact('pageTops'));
    }

    public function edit(Request $request)
    {
        $validated = $request->validate([
            'num' => 'required|integer|exists:page_top,id',
            'note' => 'required|string',
        ]);

        $pageTop = PageTop::findOrFail($validated['num']);

        $pageTop->update([
            'note' => $validated['note'],
        ]);

        return response()->json(['success' => true]);
    }

}
