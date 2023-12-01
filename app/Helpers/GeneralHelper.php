<?php

use App\Models\Olt;
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
    $router = DB::table('settingmikrotiks')->where('id', session('sessionRouter'))->first();
    if ($router) {
        try {
            return new Client([
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
        $message = 'Pelanggan ' . getCompany()->nama_perusahaan . ' Yth. ' . $request->nama . "\n\n";
        $message .= 'Kami sampaikan tagihan layanan internet bulan *' . tanggal_indonesia($request->periode)  . '*' . "\n";
        $message .= 'Dengan no tagihan *' . $request->no_tagihan . '* sebesar *' . rupiah($request->total_bayar) . '*' . "\n";
        $message .= 'Pembayaran paling lambat di tanggal *' . addHari($request->tanggal_create_tagihan, $request->jatuh_tempo) . '* Untuk Menghindari Isolir off wifi otomatis di tempat anda.' . " \n\n";
        $message .= "*Note : Abaikan pesan ini jika sudah berbayar* \n\n";

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

function oltExec()
{


    $oltSettings = Olt::findOrFail(session('sessionOlt'));
    $host = $oltSettings->host;
    $com = $oltSettings->ro;
    $var = [];
    $onu = snmpwalk($host, $com, '.1.3.6.1.4.1.3902.1012.3.28.1.1.3');
    $nama = snmpwalk($host, $com, '.1.3.6.1.4.1.3902.1012.3.28.1.1.2');
    $type = snmpwalk($host, $com, '1.3.6.1.4.1.3902.1012.3.28.1.1.1');
    $status = snmpwalk($host, $com, '.1.3.6.1.4.1.3902.1012.3.28.2.1.4');
    $rx_up = snmpwalk($host, $com, '1.3.6.1.4.1.3902.1015.1010.11.2.1.2');
    foreach ($onu as $key => $value) {
        $var[$key] = [
            "onu" => trim(str_replace(["STRING:", '"'], ["", ""], $value)),
            "nama" => "",
            "type" => "",
            "mac" => "",
            "status" => "",
            "rx" => "",
        ];
    }

    foreach ($nama as $key => $value) {
        $var[$key]["nama"] = trim(str_replace(["STRING:", '"'], ["", ""], $value));
    }

    foreach ($type as $key => $value) {
        $var[$key]["type"] = trim(str_replace(["STRING:", '"'], ["", ""], $value));
    }

    $jumlahOnline = $jumlahOffline = $power_fail = $los = $sync = 0;

    foreach ($status as $key => $value) {
        $var[$key]["status"] = $value;

        if ($value == "INTEGER: 3") {
            $jumlahOnline++;
        } else {
            $jumlahOffline++;

            if ($value == "INTEGER: 1") {
                $los++;
            } elseif ($value == "INTEGER: 2") {
                $sync++;
            } elseif ($value == "INTEGER: 4") {
                $power_fail++;
            }
        }
    }

    $low_signal = 0;
    $warning = 0;
    $critical = 0;
    foreach ($rx_up as $key => $value) {
        $var[$key]["rx"] = $value;
        $num = convertIntegerToDecimal($value);
        if ($num < -26) {
            $low_signal++;
        }

        if ($num < -26 && $num >= -31) {
            $warning++;
        }

        if ($num < -31) {
            $critical++;
        }
    }

    return [
        'online' => $jumlahOnline,
        'offline' => $jumlahOffline,
        'power_fail' => $power_fail,
        'low_signal' => $low_signal,
        'warning' => $warning,
        'critical' => $critical,
        'los' => $los,
        'sync' => $sync,
        'var' => $var,
    ];
}
