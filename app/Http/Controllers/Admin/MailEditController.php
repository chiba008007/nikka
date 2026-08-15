<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MailEditController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function edit()
    {
        //
        $items = [];
        return view('admin.mailEdit.edit', compact('items'));
    }
}
