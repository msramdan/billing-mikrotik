<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pelanggan;
use App\Models\AreaCoverage;
use \RouterOS\Query;
use App\Models\Pemasukan;
use App\Models\Settingmikrotik;


class DashboardController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        $countAreaCoverage = AreaCoverage::count();
        $countPelanggan = Pelanggan::count();
        $countRouter = Settingmikrotik::count();
        $countPelangganAktif = Pelanggan::where('status_berlangganan', 'Aktif')->count();
        $countPelangganNon = Pelanggan::where('status_berlangganan', 'Non Aktif')->count();
        $countPelangganMenunggu = Pelanggan::where('status_berlangganan', 'Menunggu')->count();

        $client = setRoute();
        $query = new Query('/ip/hotspot/active/print');
        $hotspotactives = $client->query($query)->read();

        $queryactivePpps = new Query('/ppp/active/print');
        $activePpps = $client->query($queryactivePpps)->read();

        $querysecretPpps = new Query('/ppp/secret/print');
        $nonactivePpps = $client->query($querysecretPpps)->read();

        $pemasukans = Pemasukan::orderBy('id', 'desc')->limit(10)->get();

        return view('dashboard', [
            'pelanggan' => $pelanggan,
            'countAreaCoverage' => $countAreaCoverage,
            'countPelanggan' => $countPelanggan,
            'countRouter' => $countRouter,
            'countPelangganAktif' => $countPelangganAktif,
            'countPelangganNon' => $countPelangganNon,
            'countPelangganMenunggu' => $countPelangganMenunggu,
            'hotspotactives' => count($hotspotactives),
            'activePpps' => count($activePpps),
            'nonactivePpps' => count($nonactivePpps) - count($activePpps),
            'pemasukans' => $pemasukans,
        ]);
    }
}
