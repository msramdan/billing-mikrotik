<?php

use \RouterOS\Client;
use Illuminate\Support\Facades\DB;
use \RouterOS\Exceptions\ConnectException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\Package;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Settingmikrotik;

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
                'port' => (int) $router->port,
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
    $data = DB::table('companies')
        ->join('paket_langganan', 'companies.paket_langganan_id', '=', 'paket_langganan.id')
        ->select('companies.*', 'paket_langganan.nama_paket', 'paket_langganan.jumlah_router','paket_langganan.jumlah_pelanggan')
        ->first();
    return $data;
}

function hitungRouter(){
    $count = Settingmikrotik::count();
    return $count;
}

function hitungPelanggan(){
    $count = Pelanggan::count();
    return $count;
}


function getTripay()
{
    $data = DB::table('payment_tripays')->first();
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

function rupiah2($angka)
{

    $a = number_format($angka, 0, ',', '.');
    return $a;
}

function sendNotifWa($url, $api_key, $request, $typePesan, $no_penerima, $footer)
{


    if ($typePesan == 'daftar') {
        $paket = Package::findOrFail($request->paket_layanan)->first();
        $customer = Pelanggan::where('email', $request->email)->firstOrFail();
        $url_detail = url('/pelanggans/' . $customer->id);
        $message = 'Hello. admin ' . getCompany()->nama_perusahaan . "\n\n";
        $message .= "Ada calon customer baru yang melakukan pendaftaran \n\n";
        $message .= "*Nama :* " . $request->nama . "\n";
        $message .= '*Email :* ' . $request->email . "\n";
        $message .= '*No Wa :* ' . $request->no_wa . "\n";
        $message .= '*No KTP :* ' .  $request->no_ktp . " \n";
        $message .= '*Alamat :* ' .  $request->alamat . "\n";
        $message .= '*Paket pilihan :* ' . $paket->nama_layanan . "\n\n";
        $message .= "Detail pendaftaran bisa admin lihat disini : $url_detail \n\n";
    } else if ($typePesan == 'bayar') {
        $message = 'Yth. ' . $request->nama_pelanggan . "\n\n";
        $message .= "Berikut ini adalah data pembayaran yang telah kami terima : \n\n";
        $message .= "*No Tagihan :* " . $request->no_tagihan . "\n";
        $message .= '*Nama Pelanggan :* ' . $request->nama_pelanggan . "\n";
        $message .= '*Nominal :* ' . rupiah($request->nominal) . "\n";
        $message .= '*Metode Pembayaran :* ' .  $request->metode_bayar . " \n";
        $message .= '*Tanggal :* ' . date('Y-m-d H:i:s') . "\n\n";
        $message .= $footer;
    }

    $endpoint_wa = $url . 'send-message';
    $response = Http::post($endpoint_wa, [
        'api_key' => $api_key,
        'receiver' => strval($no_penerima),
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

function hitungUang($type)
{
    if ($type == 'Pemasukan') {
        $pemasukan = DB::table('pemasukans')
            // ->where('categories.kind', '=', 1)
            ->sum('pemasukans.nominal');
        return $pemasukan;
    } else {
        $pengeluaran = DB::table('pengeluarans')
            ->sum('pengeluarans.nominal');
        return $pengeluaran;
    }
}

function tanggal_indonesia($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );

    $pecahkan = explode('-', $tanggal);
    return $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
