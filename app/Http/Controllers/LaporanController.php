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
        if (isset($request->filter_bulan)) {
            $month = $request->filter_bulan;
        } else {
            $month = date('Y-m');
        }

        $tagiahnBayar = Tagihan::where('periode', $month)
            ->where('status_bayar', 'Sudah Bayar')
            ->where('company_id', '=', session('sessionCompany'))
            ->count();

        $nominalTagiahnBayar = DB::table('tagihans')
            ->where('periode', $month)
            ->where('status_bayar', 'Sudah Bayar')
            ->where('company_id', '=', session('sessionCompany'))
            ->sum('tagihans.total_bayar');

        $nominalTagiahnBayarCash = DB::table('tagihans')
            ->where('periode', $month)
            ->where('status_bayar', 'Sudah Bayar')
            ->where('metode_bayar', 'Cash')
            ->where('company_id', '=', session('sessionCompany'))
            ->sum('tagihans.total_bayar');

        $nominalTagiahnBayarPayment = DB::table('tagihans')
            ->where('periode', $month)
            ->where('status_bayar', 'Sudah Bayar')
            ->where('metode_bayar', 'Payment Tripay')
            ->where('company_id', '=', session('sessionCompany'))
            ->sum('tagihans.total_bayar');

        $nominalTagiahnBayarTrf = DB::table('tagihans')
            ->where('periode', $month)
            ->where('status_bayar', 'Sudah Bayar')
            ->where('metode_bayar', 'Transfer Bank')
            ->where('company_id', '=', session('sessionCompany'))
            ->sum('tagihans.total_bayar');

        $tagiahnBelumBayar = Tagihan::where('periode', $month)
            ->where('status_bayar', 'Belum Bayar')
            ->where('company_id', '=', session('sessionCompany'))
            ->count();
        $nominalTtagiahnBayar = DB::table('tagihans')
            ->where('periode', $month)
            ->where('status_bayar', 'Belum Bayar')
            ->where('company_id', '=', session('sessionCompany'))
            ->sum('tagihans.total_bayar');
        // =====================
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $totalpemasukan = DB::table('pemasukans')
            ->where('company_id', '=', session('sessionCompany'))
            ->whereBetween('tanggal', [$start, $end])
            ->count();
        $nominalpemasukan = DB::table('pemasukans')
            ->where('company_id', '=', session('sessionCompany'))
            ->whereBetween('tanggal', [$start, $end])
            ->sum('pemasukans.nominal');

        $totalpengeluaran = DB::table('pengeluarans')
            ->where('company_id', '=', session('sessionCompany'))
            ->whereBetween('tanggal', [$start, $end])
            ->count();
        $nominalpengeluaran = DB::table('pengeluarans')
            ->where('company_id', '=', session('sessionCompany'))
            ->whereBetween('tanggal', [$start, $end])
            ->sum('pengeluarans.nominal');

        return view('laporans.index', [
            'month' => $month,
            'tagiahnBayar' => $tagiahnBayar,
            'nominalTagiahnBayarCash' => $nominalTagiahnBayarCash,
            'nominalTagiahnBayarPayment' => $nominalTagiahnBayarPayment,
            'nominalTagiahnBayarTrf' => $nominalTagiahnBayarTrf,
            'nominalTagiahnBayar' => $nominalTagiahnBayar,
            'tagiahnBelumBayar' => $tagiahnBelumBayar,
            'nominalTtagiahnBayar' => $nominalTtagiahnBayar,
            'totalpemasukan' => $totalpemasukan,
            'nominalpemasukan' => $nominalpemasukan,
            'totalpengeluaran' => $totalpengeluaran,
            'nominalpengeluaran' => $nominalpengeluaran,
        ]);
    }
}
