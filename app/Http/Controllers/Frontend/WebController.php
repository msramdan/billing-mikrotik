<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function loginClient()
    {
        return view('frontend.login');
    }

    public function registerClient()
    {
        return view('frontend.register');
    }

    public function cekTagihan()
    {
        return view('frontend.tagihan');
    }

    public function areaCoverage()
    {
        return view('frontend.coverage');
    }

    public function speedTest()
    {
        return view('frontend.speed');
    }
}
