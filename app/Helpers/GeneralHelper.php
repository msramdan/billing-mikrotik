<?php

use App\Models\Olt;
use Illuminate\Support\Facades\DB;
use \RouterOS\Exceptions\ConnectException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Settingmikrotik;
use GuzzleHttp\Promise;
use GuzzleHttp\Client as Client;
use \RouterOS\Client as RouterOSClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;


function oltExec()
{
    try {
        $oltSettings = Olt::findOrFail(session('sessionOlt'));
        $postData = [
            'host' => $oltSettings->host,
            'port' => (int) $oltSettings->telnet_port,
            'username' => $oltSettings->telnet_username,
            'password' => $oltSettings->telnet_password,
        ];

        $key = 'olt_host_' . $oltSettings->host;
        $cached = Redis::get($key);
        if (isset($cached)) {
            $onuName = json_decode($cached);
        } else {
            $hostSnmp =  $oltSettings->host . ':' . $oltSettings->snmp_port;
            $onuName = snmpwalk($hostSnmp, $oltSettings->ro_community, '.1.3.6.1.4.1.3902.1012.3.28.1.1.2');
            Redis::set($key, json_encode($onuName), 'EX',  env('REDIS_TIME'));
        }
        $client = new Client();
        $zteServer2 = env('ZTE_SERVER_2');
        $zteServer3 = env('ZTE_SERVER_3');
        $promiseApi1 = $client->postAsync($zteServer2 . '/status', ['json' => $postData]);
        $promiseApi2 = $client->postAsync($zteServer3 . '/uncf', ['json' => $postData]);

        try {
            $responses = Promise\Utils::all([$promiseApi1, $promiseApi2])->wait();
            $response1 = json_decode($responses[0]->getBody()->getContents());
            $response2 = json_decode($responses[1]->getBody()->getContents());

            if (!$response1->status) {
                echo "<pre>";
                var_dump('response1');
                var_dump($response1);
                die();
                throw new \Exception('API response 1 status is false');
            }

            if (!$response2->status) {
                echo "<pre>";
                var_dump('response2');
                var_dump($response2);
                die();
                throw new \Exception('API response 2 status is false');
            }

            $list_olt = [];
            $workingCount = 0;
            $groupedCounts = array();
            foreach ($onuName as $key => $value) {
                $list_olt[$key]["index"] = $response1->data[$key]->onu_index;
                $list_olt[$key]["name"] = trim(str_replace(["STRING:", '"'], ["", ""], $value));
                $list_olt[$key]["phase"] = $response1->data[$key]->phase;
                if ($response1->data[$key]->phase === 'working') {
                    $workingCount++;
                }
                $phase = $response1->data[$key]->phase;
                if (!isset($groupedCounts[$phase])) {
                    $groupedCounts[$phase] = 0;
                }
                $groupedCounts[$phase]++;
            }
            return [
                'list_olt' => $list_olt,
                'status' => $response1,
                'uncf' => $response2,
                'workingCount' => $workingCount,
                'groupedCounts' => $groupedCounts,
                'oltSettings' => $oltSettings,
            ];
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    } catch (\Exception $e) {
        dd($e->getMessage());
    }
}
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

function konversiTanggal($tanggal)
{
    setlocale(LC_TIME, 'id_ID');
    $date = DateTime::createFromFormat('Y-m', $tanggal);
    $tanggal_indonesia = strftime('%B %Y', $date->getTimestamp());
    return $tanggal_indonesia;
}



function sendNotifWa($url, $api_key, $request, $typePesan, $no_penerima, $footer)
{
    if ($typePesan == 'bayar') {
        $baseUrl = url('/');
        $invoiceUrl = $baseUrl . '/invoice/' . $request->tagihan_id;
        $message = 'Yth. ' . $request->nama_pelanggan . "\n\n";
        $message .= "Berikut ini adalah data pembayaran yang telah kami terima : \n\n";
        $message .= "*ID Pelanggan :* " . $request->no_layanan . "\n";
        $message .= "*No Tagihan :* " . $request->no_tagihan . "\n";
        $message .= '*Nama Pelanggan :* ' . $request->nama_pelanggan . "\n";
        $message .= '*Nominal :* ' . rupiah($request->nominal) . "\n";
        $message .= '*Metode Pembayaran :* ' .  $request->metode_bayar . " \n";
        $message .= '*Tanggal :* ' . date('Y-m-d H:i:s') . "\n\n";
        $message .= '*Link invoice :* ' . $invoiceUrl . "\n\n";
        $message .= $footer;
    } else if ($typePesan == 'tagihan') {
        $message = 'Pelanggan ' . getCompany()->nama_perusahaan .  "\n\n";
        $message .= 'Yth. *' . $request->nama . '*' . "\n\n";

        $message .= 'Kami sampaikan tagihan layanan internet bulan *' . tanggal_indonesia($request->periode)  . '*' . "\n";
        $message .= 'Dengan ID Pelanggan *' . $request->no_layanan . '*' . "\n\n";
        $message .= 'Sebesar *' . rupiah($request->total_bayar) . '*' . "\n\n";
        $message .= 'Pembayaran paling lambat di tanggal *' . addHari($request->tanggal_create_tagihan, $request->jatuh_tempo) . '* Untuk Menghindari Isolir *(kecepatan menurun otomatis)* di jaringan anda.' . " \n\n";
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
    } else if ($typePesan == 'invoice') {
        $baseUrl = url('/');
        $invoiceUrl = $baseUrl . '/invoice/' . $request->id;
        $message = 'Yth. ' . $request->nama . "\n\n";
        $message .= "Berikut ini adalah data pembayaran yang telah kami terima : \n\n";
        $message .= "*ID Pelanggan :* " . $request->no_layanan . "\n";
        $message .= "*No Tagihan :* " . $request->no_tagihan . "\n";
        $message .= '*Nama Pelanggan :* ' . $request->nama . "\n";
        $message .= '*Nominal :* ' . rupiah($request->total_bayar) . "\n";
        $message .= '*Metode Pembayaran :* ' .  $request->metode_bayar . " \n";
        $message .= '*Tanggal :* ' . date('Y-m-d H:i:s') . "\n\n";
        $message .= '*Link invoice :* ' . $invoiceUrl . "\n\n";
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

function formatDTM($dtm)
{
    if (substr($dtm, 1, 1) == "d" || substr($dtm, 2, 1) == "d") {
        $day = explode("d", $dtm)[0] . "d";
        $day = str_replace("d", "d ", str_replace("w", "w ", $day));
        $dtm = explode("d", $dtm)[1];
    } elseif (substr($dtm, 1, 1) == "w" && substr($dtm, 3, 1) == "d" || substr($dtm, 2, 1) == "w" && substr($dtm, 4, 1) == "d") {
        $day = explode("d", $dtm)[0] . "d";
        $day = str_replace("d", "d ", str_replace("w", "w ", $day));
        $dtm = explode("d", $dtm)[1];
    } elseif (substr($dtm, 1, 1) == "w" || substr($dtm, 2, 1) == "w") {
        $day = explode("w", $dtm)[0] . "w";
        $day = str_replace("d", "d ", str_replace("w", "w ", $day));
        $dtm = explode("w", $dtm)[1];
    }

    // secs
    if (strlen($dtm) == "2" && substr($dtm, -1) == "s") {
        $format = $day . " 00:00:0" . substr($dtm, 0, -1);
    } elseif (strlen($dtm) == "3" && substr($dtm, -1) == "s") {
        $format = $day . " 00:00:" . substr($dtm, 0, -1);
        //minutes
    } elseif (strlen($dtm) == "2" && substr($dtm, -1) == "m") {
        $format = $day . " 00:0" . substr($dtm, 0, -1) . ":00";
    } elseif (strlen($dtm) == "3" && substr($dtm, -1) == "m") {
        $format = $day . " 00:" . substr($dtm, 0, -1) . ":00";
        //hours
    } elseif (strlen($dtm) == "2" && substr($dtm, -1) == "h") {
        $format = $day . " 0" . substr($dtm, 0, -1) . ":00:00";
    } elseif (strlen($dtm) == "3" && substr($dtm, -1) == "h") {
        $format = $day . " " . substr($dtm, 0, -1) . ":00:00";

        //minutes -secs
    } elseif (strlen($dtm) == "4" && substr($dtm, -1) == "s" && substr($dtm, 1, -2) == "m") {
        $format = $day . " " . "00:0" . substr($dtm, 0, 1) . ":0" . substr($dtm, 2, -1);
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm, 1, -3) == "m") {
        $format = $day . " " . "00:0" . substr($dtm, 0, 1) . ":" . substr($dtm, 2, -1);
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm, 2, -2) == "m") {
        $format = $day . " " . "00:" . substr($dtm, 0, 2) . ":0" . substr($dtm, 3, -1);
    } elseif (strlen($dtm) == "6" && substr($dtm, -1) == "s" && substr($dtm, 2, -3) == "m") {
        $format = $day . " " . "00:" . substr($dtm, 0, 2) . ":" . substr($dtm, 3, -1);

        //hours -secs
    } elseif (strlen($dtm) == "4" && substr($dtm, -1) == "s" && substr($dtm, 1, -2) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":00:0" . substr($dtm, 2, -1);
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm, 1, -3) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":00:" . substr($dtm, 2, -1);
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "s" && substr($dtm, 2, -2) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":00:0" . substr($dtm, 3, -1);
    } elseif (strlen($dtm) == "6" && substr($dtm, -1) == "s" && substr($dtm, 2, -3) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":00:" . substr($dtm, 3, -1);

        //hours -secs
    } elseif (strlen($dtm) == "4" && substr($dtm, -1) == "m" && substr($dtm, 1, -2) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":0" . substr($dtm, 2, -1) . ":00";
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "m" && substr($dtm, 1, -3) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":" . substr($dtm, 2, -1) . ":00";
    } elseif (strlen($dtm) == "5" && substr($dtm, -1) == "m" && substr($dtm, 2, -2) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":0" . substr($dtm, 3, -1) . ":00";
    } elseif (strlen($dtm) == "6" && substr($dtm, -1) == "m" && substr($dtm, 2, -3) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":" . substr($dtm, 3, -1) . ":00";

        //hours minutes secs
    } elseif (strlen($dtm) == "6" && substr($dtm, -1) == "s" && substr($dtm, 3, -2) == "m" && substr($dtm, 1, -4) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":0" . substr($dtm, 2, -3) . ":0" . substr($dtm, 4, -1);
    } elseif (strlen($dtm) == "7" && substr($dtm, -1) == "s" && substr($dtm, 3, -3) == "m" && substr($dtm, 1, -5) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":0" . substr($dtm, 2, -4) . ":" . substr($dtm, 4, -1);
    } elseif (strlen($dtm) == "7" && substr($dtm, -1) == "s" && substr($dtm, 4, -2) == "m" && substr($dtm, 1, -5) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":" . substr($dtm, 2, -3) . ":0" . substr($dtm, 5, -1);
    } elseif (strlen($dtm) == "8" && substr($dtm, -1) == "s" && substr($dtm, 4, -3) == "m" && substr($dtm, 1, -6) == "h") {
        $format = $day . " 0" . substr($dtm, 0, 1) . ":" . substr($dtm, 2, -4) . ":" . substr($dtm, 5, -1);
    } elseif (strlen($dtm) == "7" && substr($dtm, -1) == "s" && substr($dtm, 4, -2) == "m" && substr($dtm, 2, -4) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":0" . substr($dtm, 3, -3) . ":0" . substr($dtm, 5, -1);
    } elseif (strlen($dtm) == "8" && substr($dtm, -1) == "s" && substr($dtm, 4, -3) == "m" && substr($dtm, 2, -5) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":0" . substr($dtm, 3, -4) . ":" . substr($dtm, 5, -1);
    } elseif (strlen($dtm) == "8" && substr($dtm, -1) == "s" && substr($dtm, 5, -2) == "m" && substr($dtm, 2, -5) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":" . substr($dtm, 3, -3) . ":0" . substr($dtm, 6, -1);
    } elseif (strlen($dtm) == "9" && substr($dtm, -1) == "s" && substr($dtm, 5, -3) == "m" && substr($dtm, 2, -6) == "h") {
        $format = $day . " " . substr($dtm, 0, 2) . ":" . substr($dtm, 3, -4) . ":" . substr($dtm, 6, -1);
    } else {
        $format = $dtm;
    }
    return $format;
}

function formatBytes2($size, $decimals = 0)
{
    $unit = array(
        '0' => 'Byte',
        '1' => 'KiB',
        '2' => 'MiB',
        '3' => 'GiB',
        '4' => 'TiB',
        '5' => 'PiB',
        '6' => 'EiB',
        '7' => 'ZiB',
        '8' => 'YiB'
    );

    for ($i = 0; $size >= 1024 && $i <= count($unit); $i++) {
        $size = $size / 1024;
    }

    return round($size, $decimals) . ' ' . $unit[$i];
}



function randN($length)
{
    $chars = "23456789";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randUC($length)
{
    $chars = "ABCDEFGHJKLMNPRSTUVWXYZ";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}
function randLC($length)
{
    $chars = "abcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randULC($length)
{
    $chars = "ABCDEFGHJKLMNPRSTUVWXYZabcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randNLC($length)
{
    $chars = "23456789abcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randNUC($length)
{
    $chars = "23456789ABCDEFGHJKLMNPRSTUVWXYZ";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}

function randNULC($length)
{
    $chars = "23456789ABCDEFGHJKLMNPRSTUVWXYZabcdefghijkmnprstuvwxyz";
    $charArray = str_split($chars);
    $charCount = strlen($chars);
    $result = "";
    for ($i = 1; $i <= $length; $i++) {
        $randChar = rand(0, $charCount - 1);
        $result .= $charArray[$randChar];
    }
    return $result;
}
