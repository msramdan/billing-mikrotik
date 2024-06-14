<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\AreaCoverage;
use \RouterOS\Query;
use App\Models\Pemasukan;
use App\Models\Settingmikrotik;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $currentMonthStart = Carbon::now()->startOfMonth();
        $newPelanggan = Pelanggan::where('company_id', '=', session('sessionCompany'))
            ->where('tanggal_daftar', '>=', $currentMonthStart)->count();
        $pelanggan = Pelanggan::where('company_id', '=', session('sessionCompany'))->get();
        $countAreaCoverage = AreaCoverage::where('company_id', '=', session('sessionCompany'))->count();
        $countPelanggan = Pelanggan::where('company_id', '=', session('sessionCompany'))->count();
        $countRouter = Settingmikrotik::where('company_id', '=', session('sessionCompany'))->count();
        $countPelangganAktif = Pelanggan::where('company_id', '=', session('sessionCompany'))
            ->where('status_berlangganan', 'Aktif')->count();
        $countPelangganNon = Pelanggan::where('company_id', '=', session('sessionCompany'))
            ->where('status_berlangganan', 'Non Aktif')->count();
        $client = setRoute();
        $query = new Query('/ip/hotspot/active/print');
        $hotspotactives = $client->query($query)->read();

        $queryactivePpps = new Query('/ppp/active/print');
        $activePpps = $client->query($queryactivePpps)->read();

        $querysecretPpps = new Query('/ppp/secret/print');
        $nonactivePpps = $client->query($querysecretPpps)->read();
        // static
        $staticAktif = (new Query('/tool/netwatch/print'))
            ->where('status', 'up');
        $staticAktif = $client->query($staticAktif)->read();

        $staticNonAktif = (new Query('/tool/netwatch/print'))
            ->where('status', 'down');
        $staticNonAktif = $client->query($staticNonAktif)->read();

        $tanggalHariIniMulai = Carbon::today()->startOfDay();
        $tanggalHariIniAkhir = Carbon::today()->endOfDay();

        $pemasukans = Pemasukan::where('company_id', '=', session('sessionCompany'))
            ->whereBetween('tanggal', [$tanggalHariIniMulai, $tanggalHariIniAkhir])
            ->get();

        return view('dashboard', [
            'pelanggan' => $pelanggan,
            'countAreaCoverage' => $countAreaCoverage,
            'countPelanggan' => $countPelanggan,
            'countRouter' => $countRouter,
            'countPelangganAktif' => $countPelangganAktif,
            'countPelangganNon' => $countPelangganNon,
            'hotspotactives' => count($hotspotactives),
            'activePpps' => count($activePpps),
            'nonactivePpps' => count($nonactivePpps) - count($activePpps),
            'staticAktif' => count($staticAktif),
            'staticNonAktif' => count($staticNonAktif),
            'pemasukans' => $pemasukans,
            'newPelanggan' => $newPelanggan,
        ]);
    }
}
