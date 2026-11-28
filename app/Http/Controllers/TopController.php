<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageTop;
use App\Models\Banner;

class TopController extends Controller
{
    public function index()
    {
        $pageTops = PageTop::all();
        $banners = Banner::where('status', 1)
            ->orderBy('sort')
            ->orderBy('id')
            ->get();
        return view('guest.top', compact('pageTops', 'banners'));
    }
}
