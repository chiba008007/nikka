<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageTop;
use App\Models\Banner;

class TopController extends Controller
{
    public function index()
    {
        $pageTops = PageTop::whereBetween('num', [1, 100])->get();
        $banners = Banner::where('status', 1)
            ->orderBy('sort')
            ->orderBy('id')
            ->get();
        return view('guest.top', compact('pageTops', 'banners'));
    }
    public function koen()
    {

        $pageTops = PageTop::where('num', '>=', 101)->get()->keyBy('num');
        $banners = Banner::where('status', 1)
            ->orderBy('sort')
            ->orderBy('id')
            ->get();
        return view('guest.koen', compact('pageTops', 'banners'));
    }
}
