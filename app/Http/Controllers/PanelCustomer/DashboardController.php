<?php

namespace App\Http\Controllers\PanelCustomer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use PDF;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $metode_bayar = $request->query('metode_bayar');
            $status_bayar = $request->query('status_bayar');
            $tanggal = $request->query('tanggal'); //2023-10
            $tagihans = DB::table('tagihans')
                ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
                ->select('tagihans.*', 'pelanggans.nama', 'pelanggans.id as pelanggan_id');
            if (isset($metode_bayar) && !empty($metode_bayar)) {
                if ($metode_bayar != 'All') {
                    $tagihans = $tagihans->where('tagihans.metode_bayar', $metode_bayar);
                }
            }

            if (isset($status_bayar) && !empty($status_bayar)) {
                if ($status_bayar != 'All') {
                    $tagihans = $tagihans->where('tagihans.status_bayar', $status_bayar);
                }
            }

            if (isset($tanggal) && !empty($tanggal)) {
                if ($tanggal != 'All') {
                    $tagihans = $tagihans->where('tagihans.periode', $tanggal);
                }
            }
            $tagihans = $tagihans->where('pelanggan_id', getCustomer()->id)->orderBy('tagihans.id', 'DESC')->get();
            return DataTables::of($tagihans)
                ->addIndexColumn()
                ->addColumn('nominal_bayar', function ($row) {
                    return rupiah($row->nominal_bayar);
                })
                ->addColumn('potongan_bayar', function ($row) {
                    return rupiah($row->potongan_bayar);
                })
                ->addColumn('total_bayar', function ($row) {
                    return rupiah($row->total_bayar);
                })
                ->addColumn('nominal_ppn', function ($row) {
                    return rupiah($row->nominal_ppn);
                })
                ->addColumn('pelanggan', function ($row) {
                    return $row->nama;
                })->addColumn('action', 'panel-customer.include.action')
                ->toJson();
        }
        return view('panel-customer.dashboard');
    }

    public function showTagihan($id)
    {
        $tagihan = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->select('tagihans.*', 'pelanggans.nama')
            ->where('tagihans.id', '=', $id)
            ->first();

        return view('panel-customer.showTagihan', compact('tagihan'));
    }

    public function caraPembayaran()
    {
        $bankAccounts = DB::table('bank_accounts')
            ->leftJoin('banks', 'bank_accounts.bank_id', '=', 'banks.id')
            ->select('bank_accounts.*', 'banks.nama_bank', 'banks.logo_bank')
            ->get();

        return view('panel-customer.caraPembayaran',[
            'bankAccounts' => $bankAccounts
        ]);
    }



    public function invoiceTagihan($id)
    {
        $data = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
            ->select('tagihans.*', 'pelanggans.nama', 'pelanggans.jatuh_tempo', 'pelanggans.email as email_customer', 'pelanggans.alamat as alamat_customer', 'packages.nama_layanan', 'pelanggans.no_layanan')
            ->where('tagihans.id', '=', $id)
            ->first();;
        $pdf = PDF::loadView('tagihans.pdf', compact('data'));
        // return $pdf->download('Invoice.pdf');
        return $pdf->stream();
    }
}
