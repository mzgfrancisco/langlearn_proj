<?php

namespace App\Http\Controllers\Admin_side;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageUserController extends Controller
{
    public function index()
    {
        return view('admin_side.users'); // make sure this Blade file exists
    }
}
