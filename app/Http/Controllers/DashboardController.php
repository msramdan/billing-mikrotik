<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\AreaCoverage;
use \RouterOS\Query;
use App\Models\Pemasukan;
use App\Models\Settingmikrotik;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $companyId = session('sessionCompany');
        $currentMonthStart = Carbon::now()->startOfMonth();
        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();

        // Ambil data pelanggan sekali saja
        $pelanggan = Pelanggan::select('id', 'status_berlangganan', 'tanggal_daftar')
            ->where('company_id', $companyId)
            ->get();

        // Hitung pelanggan baru, aktif, dan non-aktif tanpa query tambahan
        $newPelanggan = $pelanggan->where('tanggal_daftar', '>=', $currentMonthStart)->count();
        $countPelanggan = $pelanggan->count();
        $countPelangganAktif = $pelanggan->where('status_berlangganan', 'Aktif')->count();
        $countPelangganNon = $countPelanggan - $countPelangganAktif;

        // Gunakan caching untuk data statis
        $countAreaCoverage = Cache::remember("count_area_coverage_{$companyId}", 600, function () use ($companyId) {
            return AreaCoverage::where('company_id', $companyId)->count();
        });

        $countRouter = Cache::remember("count_router_{$companyId}", 600, function () use ($companyId) {
            return Settingmikrotik::where('company_id', $companyId)->count();
        });

        // Ambil data pemasukan hari ini
        $pemasukans = Pemasukan::where('company_id', $companyId)
            ->whereBetween('tanggal', [$todayStart, $todayEnd])
            ->get();

        // Mikrotik Queries
        $client = setRoute();
        $hotspotactives = count($client->query(new Query('/ip/hotspot/active/print'))->read());
        $activePpps = count($client->query(new Query('/ppp/active/print'))->read());
        $nonactivePpps = count($client->query(new Query('/ppp/secret/print'))->read()) - $activePpps;
        $staticAktif = count($client->query((new Query('/tool/netwatch/print'))->where('status', 'up'))->read());
        $staticNonAktif = count($client->query((new Query('/tool/netwatch/print'))->where('status', 'down'))->read());

        return view('dashboard', compact(
            'pelanggan',
            'countAreaCoverage',
            'countPelanggan',
            'countRouter',
            'countPelangganAktif',
            'countPelangganNon',
            'hotspotactives',
            'activePpps',
            'nonactivePpps',
            'staticAktif',
            'staticNonAktif',
            'pemasukans',
            'newPelanggan'
        ));
    }
}
