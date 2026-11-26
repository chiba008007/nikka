<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageTop;

class TopController extends Controller
{
    public function index()
    {
        $pageTops = PageTop::all();
        return view('guest.top', compact('pageTops'));
    }
}
