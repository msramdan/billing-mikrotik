<?php

use \RouterOS\Client;
use Illuminate\Support\Facades\DB;
use \RouterOS\Exceptions\ConnectException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\Package;
use App\Models\Pelanggan;
use App\Models\Tagihan;

function formatBytes($bytes, $decimal = null)
{
    $satuan = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes > 1024) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, $decimal) . ' ' . $satuan[$i];
}

function setRoute()
{
    $router = DB::table('settingmikrotiks')->where('is_active', 'Yes')->first();
    if ($router) {
        try {
            $client = new Client([
                'host' => $router->host,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => $router->port,
            ]);
            return $client;
        } catch (ConnectException $e) {
            echo $e->getMessage() . PHP_EOL;
            die();
        }
    } else {
        echo "Belum ada router / Router tidak aktif";
        die();
    }
}

function getRouteName()
{
    $router = DB::table('settingmikrotiks')->where('is_active', 'Yes')->first();
    if ($router) {
        return $router->identitas_router;
    } else {
        return '-';
    }
}

function getCompany()
{
    $data = DB::table('companies')->first();
    return $data;
}

function getCustomer()
{
    $data = DB::table('pelanggans')->where('id', Session::get('id-customer'))->first();
    return $data;
}

function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function sendNotifWa($url,$api_key, $request, $typePesan, $no_penerima)
{


    if ($typePesan == 'daftar') {
        $paket = Package::findOrFail($request->paket_layanan)->first();
        $customer = Pelanggan::where('email', $request->email)->firstOrFail();
        $url_detail = url('/pelanggans/'.$customer->id);
        $message = 'Hello. admin ' . getCompany()->nama_perusahaan . "\n\n";
        $message .= "Ada calon customer baru yang melakukan pendaftaran \n\n";
        $message .= "*Nama :* " . $request->nama . "\n";
        $message .= '*Email :* ' . $request->email . "\n";
        $message .= '*No Wa :* ' . $request->no_wa . "\n";
        $message .= '*No KTP :* ' .  $request->no_ktp . " \n";
        $message .= '*Alamat :* ' .  $request->alamat . "\n";
        $message .= '*Paket pilihan :* ' . $paket->nama_layanan . "\n\n";
        $message .= "Detail pendaftaran bisa admin lihat disini : $url_detail \n\n";
    }else if($typePesan == 'bayar'){
        $message = 'Yth. ' . $request->nama_pelanggan . "\n\n";
        $message .= "Berikut ini adalah data pembayaran yang telah kami terima : \n\n";
        $message .= "*No Tagihan :* " . $request->no_tagihan . "\n";
        $message .= '*Nama Pelanggan :* ' . $request->nama_pelanggan . "\n";
        $message .= '*Nominal :* ' . rupiah($request->nominal ) . "\n";
        $message .= '*Metode Pembayaran :* ' .  $request->metode_bayar . " \n";
        $message .= '*Tanggal :* ' . date('Y-m-d H:i:s') . "\n\n";
        $message .= "Terima Kasih.";
    }

    $endpoint_wa = $url . 'send-message';
    $response = Http::post($endpoint_wa, [
        'api_key' => $api_key,
        'receiver' => strval($no_penerima) ,
        'data' => [
            "message" => $message,
        ]
    ]);
    \Log::info($response);
}

function totalStatusBayar($status)
{
    $totalStatus = Tagihan::where('status_bayar', $status)
        ->get();
    return  $totalStatus->count();
}
