<?php

namespace App\Http\Controllers\PanelCustomer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
                ->addColumn('periode', function ($row) {
                    return tanggal_indonesia($row->periode);
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

        return view('panel-customer.caraPembayaran', [
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
            ->first();
        $pdf = PDF::loadView('tagihans.pdf', compact('data'));
        return $pdf->stream();
    }

    public function paymentList($id)
    {
        $url = 'https://tripay.co.id/api-sandbox/merchant/payment-channel';
        $api_key = getTripay()->api_key;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $api_key
        ])->get($url);
        $metodeBayar = json_decode($response->getBody());
        return view('panel-customer.payment', [
            'metodeBayar' => $metodeBayar->data,
            'tagihan_id' => $id
        ]);
    }

    public function doPayment($tagihan_id, $method)
    {
        $tagihans = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
            ->select('tagihans.*', 'pelanggans.nama', 'pelanggans.jatuh_tempo', 'pelanggans.email as email_customer', 'pelanggans.no_wa', 'packages.nama_layanan', 'pelanggans.no_layanan')
            ->where('tagihans.id', '=', $tagihan_id)
            ->first();
        $apiKey       = getTripay()->api_key;
        $privateKey   = getTripay()->private_key;
        $merchantCode = getTripay()->kode_merchant;
        $merchantRef  = 'SSL' . time();
        $url = 'https://tripay.co.id/api-sandbox/transaction/create';
        $amount       =  $tagihans->total_bayar;
        $data = [
            'method'         => $method,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $tagihans->nama,
            'customer_email' => $tagihans->email_customer,
            'customer_phone' => $tagihans->no_wa,
            'order_items'    => [
                [
                    'sku'         => 'Internet SawitSkyLink',
                    'name'        => 'Pembayaran Internet',
                    'price'       => $tagihans->total_bayar,
                    'quantity'    => 1,
                    'product_url' => '',
                    'image_url'   => '',
                ]
            ],
            'expired_time' => (time() + (24 * 60 * 60)),
            'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        $response = json_decode($response)->data;
        return redirect()->route('detailTagihan', [
            'id' => $response->reference
        ]);
    }
    public function detailTagihan($reference)
    {
        $apiKey = getTripay()->api_key;
        $payload = ['reference'    => $reference];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response)->data;

        return view('panel-customer.detailTagihan', [
            'detail' => $response
        ]);


    }
}
