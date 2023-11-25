<?php

date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';
include 'routeros_api.class.php';

// mulai cron
$pesan = "✅✅ [CRON AUTO ISOLIR] ✅✅\n";
$pesan .= "Mulai Cron :  " . date('Y-m-d H:i:s') . "\n";
sendTelegramNotification($pesan);

$API = new RouterosAPI();
$API->debug = false;
// get data tagihan
$sql = "SELECT tagihans.*,pelanggans.nama,pelanggans.router, pelanggans.auto_isolir,pelanggans.tanggal_daftar,pelanggans.jatuh_tempo,pelanggans.user_pppoe FROM tagihans
    join pelanggans on pelanggans.id = tagihans.pelanggan_id
    where tagihans.status_bayar='Belum Bayar'";
$query = mysqli_query($koneksi, $sql);

while ($row = mysqli_fetch_array($query)) {
    if ($row['auto_isolir'] == 'Yes') {
        $id_mikrotik = $row['router'];
        // get data mikrotik
        $router = mysqli_query($koneksi, "select * from settingmikrotiks where  id='$id_mikrotik'")->fetch_assoc();
        // tgl jatuh tempo
        $jatuh_tempo = $row['jatuh_tempo'];
        $pelanggan_id = $row['pelanggan_id'];
        $tglDaftar = substr($row['tanggal_daftar'], 8, 2);
        $generateTgl = date('Y-m-') . $tglDaftar;
        $tgl_jatuh_tempo = addHari($generateTgl, $jatuh_tempo);
        $date_now = date('Y-m-d');
        if ($tgl_jatuh_tempo <= $date_now) {
            // set status pelanggan ke non aktif
            mysqli_query($koneksi, "UPDATE pelanggans
            SET status_berlangganan = 'Non Aktif'
            WHERE id='$pelanggan_id'");
            // ganti profile ke expired
            if ($API->connect($router['host'], $router['port'], $router['username'], $router['password'])) {
                // $API->write('/ppp/profile/print');
                $a = $API->comm("/ppp/secret/print",  array(
                    '?name' => $row['user_pppoe'],
                ));
                $idSecret = $a[0]['.id'];
                // set expire
                $comment = 'Di set expired Tanggal : ' . date('Y-m-d H:i:s');
                $API->comm("/ppp/secret/set", array(
                    ".id"     => $idSecret,
                    "profile"  => "EXPIRED",
                    "comment"      => $comment
                ));
                // get name from active ppp
                $b = $API->comm("/ppp/active/print",  array(
                    '?name' => $row['user_pppoe'],
                ));
                $idActive = $b[0]['.id'];
                // remove session
                $API->comm("/ppp/active/remove", array(
                    ".id"     => $idActive
                ));
                $pesan = "✅✅ [CRON AUTO ISOLIR] ✅✅\n";
                $pesan .= "Set Expired Berhasil!\n";
                $pesan .= "Pelanggan:  " . $row['nama'] . "\n";
                sendTelegramNotification($pesan);
            }
            $API->disconnect();
        }
    }
}
$koneksi->close();
// selesai cron
$pesan = "✅✅ [CRON AUTO ISOLIR] ✅✅\n";
$pesan .= "Selesai Cron :  " . date('Y-m-d H:i:s') . "\n";
sendTelegramNotification($pesan);

function addHari($tgl, $jatuh_tempo)
{
    $tgl    = date('Y-m-d', strtotime('+' . $jatuh_tempo . 'days', strtotime($tgl)));
    return $tgl;
}

function sendTelegramNotification($message)
{
    $botToken = "6864401107:AAGCnHJwNlHxUsESzH4gBMasWyA4zulVdiA";
    $chatId = "-4023321213";

    $apiUrl = "https://api.telegram.org/bot$botToken/sendMessage";
    $params = [
        'chat_id' => $chatId,
        'text' => $message,
    ];

    $query = http_build_query($params);
    $url = $apiUrl . '?' . $query;

    // Use cURL to send the message
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
