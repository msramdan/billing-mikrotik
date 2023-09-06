<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;

class DashboardController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('dashboard',[
            'pelanggan' => $pelanggan
        ]);
    }
}
