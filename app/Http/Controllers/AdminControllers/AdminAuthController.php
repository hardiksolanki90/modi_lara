<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function initContent()
    {
        return view('admin.login');
    }

    public function initProcessLogin(Request $req)
    {
        pre('here');
    }
}
