<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use Illuminate\Support\Facades\DB;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;


class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan view')->only('index', 'show');
    }

    public function index(Request $request)
    {
        if (isset($request->start_date)) {
            $start_date = intval($request->query('start_date'));
            $end_date = intval($request->query('end_date'));
        } else {
            $from = date('Y-m-01') . " 00:00:00";
            $to = date('Y-m-d') . " 23:59:59";
            $start_date = strtotime($from) * 1000;
            $end_date = strtotime($to) * 1000;
        }

        // Mengubah milidetik ke format Y-m-d
        $start = date('Y-m-d', $start_date / 1000);
        $end = date('Y-m-d', $end_date / 1000);
        // =============================================================
        $nominalpemasukan = DB::table('pemasukans')
            ->where('company_id', '=', session('sessionCompany'))
            ->whereBetween('tanggal', [
                $start . ' 00:00:00',
                $end . ' 23:59:59'
            ])
            ->sum('pemasukans.nominal');

        $nominalpengeluaran = DB::table('pengeluarans')
            ->where('company_id', '=', session('sessionCompany'))
            ->whereBetween('tanggal', [
                $start . ' 00:00:00',
                $end . ' 23:59:59'
            ])
            ->sum('pengeluarans.nominal');

        $pemasukans = DB::table('pemasukans')
            ->leftJoin('category_pemasukans', 'pemasukans.category_pemasukan_id', '=', 'category_pemasukans.id')
            ->select(
                'pemasukans.category_pemasukan_id',
                'category_pemasukans.nama_kategori_pemasukan',
                DB::raw('COUNT(pemasukans.id) as total_transaksi'),
                DB::raw('SUM(pemasukans.nominal) as total_nominal')
            )
            ->where('company_id', '=', session('sessionCompany'))
            ->whereBetween('tanggal', [
                $start . ' 00:00:00',
                $end . ' 23:59:59'
            ])
            ->groupBy('pemasukans.category_pemasukan_id', 'category_pemasukans.nama_kategori_pemasukan')
            ->get();
        $pemasukansBySumber = DB::table('pemasukans')
            ->select(
                'pemasukans.metode_bayar',
                DB::raw('COUNT(pemasukans.id) as total_transaksi'),
                DB::raw('SUM(pemasukans.nominal) as total_nominal')
            )
            ->where('company_id', '=', session('sessionCompany'))
            ->whereBetween('tanggal', [
                $start . ' 00:00:00',
                $end . ' 23:59:59'
            ])
            ->groupBy('pemasukans.metode_bayar')
            ->get();

        $pengeluarans = DB::table('pengeluarans')
            ->leftJoin('category_pengeluarans', 'pengeluarans.category_pengeluaran_id', '=', 'category_pengeluarans.id')
            ->select(
                'pengeluarans.category_pengeluaran_id',
                'category_pengeluarans.nama_kategori_pengeluaran',
                DB::raw('COUNT(pengeluarans.id) as total_transaksi'),
                DB::raw('SUM(pengeluarans.nominal) as total_nominal')
            )
            ->where('company_id', '=', session('sessionCompany'))
            ->whereBetween('pengeluarans.tanggal', [$start, $end])
            ->groupBy('pengeluarans.category_pengeluaran_id', 'category_pengeluarans.nama_kategori_pengeluaran')
            ->get();
        return view('laporans.index', [
            'microFrom' => $start_date,
            'microTo' => $end_date,
            'start' => $start,
            'end' => $end,
            'nominalpemasukan' => $nominalpemasukan,
            'pemasukans' => $pemasukans,
            'pengeluarans' => $pengeluarans,
            'nominalpengeluaran' => $nominalpengeluaran,
            'pemasukansBySumber' => $pemasukansBySumber,
        ]);
    }

    public function getPelangganData(Request $request)
    {
        // Mengambil start_date dan end_date dari request
        $startDate = Carbon::createFromTimestampMs($request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::createFromTimestampMs($request->input('end_date'))->format('Y-m-d');
        $viewOption = $request->input('view_option', 'daily'); // Default ke 'daily'

        // Mulai query dasar
        $query = DB::table('pelanggans')
            ->select(DB::raw('COUNT(*) as count'));

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_daftar', [$startDate, $endDate]);
        }

        // Kondisi untuk setiap viewOption
        if ($viewOption == 'monthly') {
            // Query untuk pengelompokan berdasarkan bulan dan tahun
            $query->addSelect(DB::raw('YEAR(tanggal_daftar) as year'), DB::raw('MONTH(tanggal_daftar) as month'))
                ->groupBy(DB::raw('YEAR(tanggal_daftar), MONTH(tanggal_daftar)'))
                ->orderBy(DB::raw('YEAR(tanggal_daftar), MONTH(tanggal_daftar)'));
        } elseif ($viewOption == 'yearly') {
            // Query untuk pengelompokan berdasarkan tahun
            $query->addSelect(DB::raw('YEAR(tanggal_daftar) as year'))
                ->groupBy(DB::raw('YEAR(tanggal_daftar)'))
                ->orderBy(DB::raw('YEAR(tanggal_daftar)'));
        } else {
            // Default: Query untuk pengelompokan harian
            $query->addSelect(DB::raw('DATE(tanggal_daftar) as date'))
                ->groupBy(DB::raw('DATE(tanggal_daftar)'))
                ->orderBy(DB::raw('DATE(tanggal_daftar)'));
        }

        // Menjalankan query dan mengambil data
        $data = $query->get();

        // Mengembalikan data dalam format JSON untuk frontend
        return response()->json($data);
    }
}
