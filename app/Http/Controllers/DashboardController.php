<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use App\Models\AreaCoverage;

class DashboardController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        $countAreaCoverage = AreaCoverage::count();
        $countPelanggan = Pelanggan::count();
        $countPelangganAktif = Pelanggan::where('status_berlangganan', 'Aktif')->count();
        $countPelangganNon = Pelanggan::where('status_berlangganan', 'Non Aktif')->count();
        $countPelangganMenunggu = Pelanggan::where('status_berlangganan', 'Menungu')->count();

        return view('dashboard',[
            'pelanggan' => $pelanggan,
            'countAreaCoverage' => $countAreaCoverage,
            'countPelanggan' => $countPelanggan,
            'countPelangganAktif' => $countPelangganAktif,
            'countPelangganNon' => $countPelangganNon,
            'countPelangganMenunggu' => $countPelangganMenunggu
        ]);
    }
}
