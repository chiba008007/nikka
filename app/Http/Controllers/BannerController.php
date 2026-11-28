<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $banners = Banner::orderBy('sort')
        ->orderBy('id')
        ->get();

        return view('admin.edit.banner', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.edit.banner_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->saveBanner($request, new Banner());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $banner = Banner::findOrFail($id);

        return view('admin.edit.banner_create', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return $this->saveBanner($request, Banner::findOrFail($id));
    }

    private function saveBanner(Request $request, Banner $banner)
    {
        $isNew = !$banner->exists;

        $validated = $request->validate([
            'image' => ($isNew ? 'required' : 'nullable')
                . '|image|mimes:jpeg,png,gif,webp|max:10240',
            'url' => 'nullable|url:http,https|max:2048',
            'sort' => 'required|integer|min:0',
            'status' => 'required|boolean',
        ]);

        $oldImage = $banner->image;
        $newImage = null;

        unset($validated['image']);

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')
                ->store('banners', 'public');

            $validated['image'] = $newImage;
        }

        try {
            $banner->fill($validated)->save();
        } catch (\Throwable $e) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }
            throw $e;
        }

        if ($newImage && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()
            ->route('edit.top.banner.index')
            ->with('success', $isNew
                ? 'バナーを登録しました。'
                : 'バナーを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Banner::findOrFail($id)->delete();

        return redirect()
            ->route('edit.top.banner.index')
            ->with('success', 'バナーを削除しました。');
    }
}
