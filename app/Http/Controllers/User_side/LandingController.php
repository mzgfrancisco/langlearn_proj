<?php

namespace App\Http\Controllers\User_side;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('user_side.landing');
    }
}
