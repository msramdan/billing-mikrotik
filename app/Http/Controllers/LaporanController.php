<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan view')->only('index', 'show');
    }

    public function index(Request $request)
    {
        $from = date('Y-m-01') . " 00:00:00";
        $to = date('Y-m-d') . " 23:59:59";
        $microFrom = strtotime($from) * 1000;
        $microTo = strtotime($to) * 1000;
        $start_date = $request->query('start_date') !== null ? intval($request->query('start_date')) : $microFrom;
        $end_date = $request->query('end_date') !== null ? intval($request->query('end_date')) : $microTo;
        return view('laporans.index', [
            'microFrom' => $start_date,
            'microTo' => $end_date,
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
