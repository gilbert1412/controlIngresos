<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


class GuardianesController extends Controller
{
    public function index()
    {
        return view('admin.guardianes.index');
    }
}
