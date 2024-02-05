<?php

use App\Models\Olt;
use Illuminate\Support\Facades\DB;
use \RouterOS\Exceptions\ConnectException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\Package;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Settingmikrotik;
use GuzzleHttp\Promise;
use Illuminate\Http\Request;
use GuzzleHttp\Client as Client;
use \RouterOS\Client as RouterOSClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

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
    $router = DB::table('settingmikrotiks')->where('id', session('sessionRouter'))->first();
    if ($router) {
        try {
            return new RouterOSClient([
                'host' => $router->host,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => (int) $router->port,
            ]);
        } catch (ConnectException $e) {
            echo $e->getMessage() . PHP_EOL;
            die();
        }
    }
}

function getCompany()
{
    $data = DB::table('companies')
        ->join('pakets', 'companies.paket_id', '=', 'pakets.id')
        ->where('companies.id', '=', session('sessionCompany'))
        ->select('companies.*', 'pakets.nama_paket', 'pakets.jumlah_router', 'pakets.jumlah_pelanggan', 'pakets.jumlah_olt')
        ->first();
    return $data;
}

function getCompanyUser()
{
    $data = DB::table('companies')
        ->join('pakets', 'companies.paket_id', '=', 'pakets.id')
        ->where('companies.id', '=', session('sessionCompanyUser'))
        ->select('companies.*', 'pakets.nama_paket', 'pakets.jumlah_router', 'pakets.jumlah_olt')
        ->first();
    return $data;
}


function cekAssign($company_id, $user_id)
{
    return DB::table('assign_company')
        ->where('company_id', $company_id)
        ->where('user_id', $user_id)
        ->count();
}

function hitungRouter()
{
    return Settingmikrotik::where('company_id', session('sessionCompany'))->count();
}

function hitungPelanggan()
{
    return Pelanggan::where('company_id', session('sessionCompany'))->count();
}

function hitungOlt()
{
    return Olt::where('company_id', session('sessionCompany'))->count();
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
    if ($typePesan == 'bayar') {
        $message = 'Yth. ' . $request->nama_pelanggan . "\n\n";
        $message .= "Berikut ini adalah data pembayaran yang telah kami terima : \n\n";
        $message .= "*No Tagihan :* " . $request->no_tagihan . "\n";
        $message .= '*Nama Pelanggan :* ' . $request->nama_pelanggan . "\n";
        $message .= '*Nominal :* ' . rupiah($request->nominal) . "\n";
        $message .= '*Metode Pembayaran :* ' .  $request->metode_bayar . " \n";
        $message .= '*Tanggal :* ' . date('Y-m-d H:i:s') . "\n\n";
        $message .= $footer;
   } else if ($typePesan == 'tagihan') {
        $message = 'Pelanggan ' . getCompany()->nama_perusahaan .  "\n\n";
        $message .= 'Yth. *' . $request->nama . '*' . "\n\n";

        $message .= 'Kami sampaikan tagihan layanan internet bulan *' . tanggal_indonesia($request->periode)  . '*' . "\n";
        $message .= 'Dengan no tagihan *' . $request->no_tagihan . '*'. "\n\n";
        $message .= 'Sebesar *' . rupiah($request->total_bayar) . '*' . "\n\n";
        $message .= 'Pembayaran paling lambat di tanggal *' . addHari($request->tanggal_create_tagihan, $request->jatuh_tempo) . '* Untuk Menghindari Isolir (wifi mati sementara) di jaringan anda.' . " \n\n";
        $message .= $footer;
    } else if ($typePesan == 'daftar') {
        $paket = DB::table('packages')->find($request->paket_layanan);
        $user = Auth::user();
        $message = 'Selamat datang di ' . getCompany()->nama_perusahaan . "\n\n";
        $message .= "Kami senang Anda telah bergabung dengan layanan WiFi kami. \n";
        $message .= "Penting yang perlu Anda ketahui: \n\n";
        $message .= "*Nama :* " . $request->nama . "\n";
        $message .= '*Alamat :* ' . $request->alamat . "\n";
        $message .= '*Paket Layanan :* ' . $paket->nama_layanan . "\n";
        $message .= '*No Layanan :* ' .  $request->no_layanan . " \n\n";
        $message .= 'Jika Anda memiliki pertanyaan atau membutuhkan bantuan tambahan, jangan ragu untuk menghubungi kami di ' . getCompany()->no_wa  . ' atau melalui email ke ' . getCompany()->email  . ".\n\n";
        $message .= "Terima kasih atas kepercayaan Anda kepada kami. Selamat menikmati koneksi internet yang stabil dan cepat!\n\n";
        $message .= "Salam hangat,\n";
        $message .= $user->name . '-' . getCompany()->nama_perusahaan;
    }

    $endpoint_wa = $url . 'send-message';
    $response = Http::post($endpoint_wa, [
        'api_key' => $api_key,
        'receiver' => strval($no_penerima),
        'data' => [
            "message" => $message,
        ]
    ]);
    return json_decode($response);
}

function totalStatusBayar($status)
{
    $totalStatus = Tagihan::where('company_id', '=', session('sessionCompany'))->where('status_bayar', $status)
        ->get();
    return  $totalStatus->count();
}

function addHari($tgl, $jatuh_tempo)
{
    $tgl    = date('Y-m-d', strtotime('+' . $jatuh_tempo . 'days', strtotime($tgl)));
    return $tgl;
}

function hitungUang($type)
{
    if ($type == 'Pemasukan') {
        $pemasukan = DB::table('pemasukans')
            ->where('company_id', '=', session('sessionCompany'))
            ->sum('pemasukans.nominal');
        return $pemasukan;
    } else {
        $pengeluaran = DB::table('pengeluarans')
            ->where('company_id', '=', session('sessionCompany'))
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
function convertIntegerToDecimal($stringValue)
{
    // Hapus "INTEGER: " dan konversi ke desimal sesuai dengan format yang diinginkan
    $decimalValue = number_format((int) str_replace('INTEGER: ', '', $stringValue) / 1000, 1);

    return $decimalValue;
}


function oltExec()
{
    try {
        $oltSettings = Olt::findOrFail(session('sessionOlt'));
        $requestData = [
            'host' => $oltSettings->host,
            'port' => (int) $oltSettings->port,
            'username' => $oltSettings->username,
            'password' => $oltSettings->password,
        ];

        $zteServer1 = env('ZTE_SERVER_1');
        $zteServer2 = env('ZTE_SERVER_2');
        $zteServer3 = env('ZTE_SERVER_3');
        $urlOnuName = $zteServer1 . '/onu-name';
        $urlStatus = $zteServer2 . '/status';
        $urlUncf = $zteServer3 . '/uncf';
        $result = asyncApiCalls($requestData, $urlOnuName, $urlStatus, $urlUncf);

        return response()->json($result);
    } catch (\Exception $e) {
        dd('something error 3');
    }
}

function asyncApiCalls(array $requestData, string $urlOnuName, string $urlStatus, string $urlUncf): array
{
    $client = new Client();
    $promises = [
        'onuName' => asyncPostRequest($client, $urlOnuName, $requestData),
        'status' => asyncPostRequest($client, $urlStatus, $requestData),
        'uncf' => asyncPostRequest($client, $urlUncf, $requestData),
    ];

    // Menunggu hasil panggilan API paralel
    $results = [];
    foreach ($promises as $key => $promise) {
        $results[$key] = json_decode($promise->wait()->getBody()->getContents(), true);
    }

    return $results;
}

function asyncPostRequest(Client $client, string $url, array $data): \GuzzleHttp\Promise\PromiseInterface
{
    // Melakukan panggilan API asynchronous
    return $client->postAsync($url, ['json' => $data]);
}
