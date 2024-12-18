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
$sql = "SELECT tagihans.*,companies.*,pelanggans.nama,pelanggans.router, pelanggans.auto_isolir,pelanggans.tanggal_daftar,pelanggans.jatuh_tempo,pelanggans.user_pppoe,pelanggans.no_wa, pelanggans.no_layanan
    FROM tagihans
    JOIN companies ON companies.id = tagihans.company_id
    join pelanggans on pelanggans.id = tagihans.pelanggan_id
    where tagihans.status_bayar='Belum Bayar'";
$query = mysqli_query($koneksi, $sql);

while ($row = mysqli_fetch_array($query)) {
    if ($row['auto_isolir'] == 'Yes') {
        $id_mikrotik = $row['router'];
        // get data mikrotik
        $router = mysqli_query($koneksi, "select * from settingmikrotiks where id='$id_mikrotik'")->fetch_assoc();
        // tgl jatuh tempo
        $jatuh_tempo = $row['jatuh_tempo'];
        $pelanggan_id = $row['pelanggan_id'];
        $tglDaftar = substr($row['tanggal_daftar'], 8, 2);
        $generateTgl = date('Y-m-') . $tglDaftar;
        $tgl_jatuh_tempo = addHari($generateTgl, $jatuh_tempo);
        $date_now = date('Y-m-d');

        // H-1 sebelum tanggal jatuh tempo
        $h1_before = date('Y-m-d', strtotime('-1 day', strtotime($tgl_jatuh_tempo)));
        if ($h1_before == $date_now) {
            $url = $row['url_wa_gateway'] . 'send-message';
            $message = "Kepada Yth. Pelanggan " . $row['nama_perusahaan'] . ",\n\n";
            $message .= "Kami ingin memberitahukan bahwa layanan internet Anda akan diisolir mulai *" . $tgl_jatuh_tempo . "*, dikarenakan tagihan Anda belum dibayar dan telah melewati batas jatuh tempo. Selama periode isolasi, koneksi internet Anda akan terputus.\n\n";
            $message .= "Untuk menghindari gangguan lebih lanjut, harap segera melakukan pembayaran tagihan yang terutang. Pembayaran dapat dilakukan melalui *[metode pembayaran yang tersedia]*. Setelah pembayaran terverifikasi, layanan internet Anda akan segera dipulihkan.\n\n";
            $message .= "Jika Anda memiliki pertanyaan atau membutuhkan bantuan lebih lanjut, silakan hubungi kami di *[nomor kontak atau email]*.\n\n";
            $message .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
            $message .= "Salam hormat,\n";
            $message .= $row['nama_perusahaan'];
            $dataPesan = array(
                'api_key'  => $row['api_key_wa_gateway'],
                'receiver' => $row['no_wa'],
                'data'     => [
                    'message' => $message,
                ],
            );
            $body = json_encode($dataPesan);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            print_r($result);
            $res = json_decode($result);

            if ($res->status == true || $res->status == 'true') {
                $pesan = "⚠️⚠️ [PENGINGAT TAGIHAN] ⚠️⚠️\n";
                $pesan .= "Tagihan Anda akan jatuh tempo besok.\n";
                $pesan .= "Pelanggan: " . $row['nama'] . "\n";
                $pesan .= "Tanggal Jatuh Tempo: $tgl_jatuh_tempo\n";
                sendTelegramNotification($pesan);
            } else {
                $pesan = "❌❌ [GAGAL KIRIM WA] ❌❌\n";
                $pesan .= "Gagal mengirim pengingat tagihan melalui WhatsApp.\n";
                $pesan .= "Pelanggan: " . $row['nama'] . "\n";
                $pesan .= "Nomor WhatsApp: " . $row['no_wa'] . "\n";
                $pesan .= "Tanggal Jatuh Tempo: $tgl_jatuh_tempo\n";
                sendTelegramNotification($pesan);
            }
        }
        // Jika sudah jatuh tempo
        if ($tgl_jatuh_tempo <= $date_now) {
            // set status pelanggan ke non aktif
            mysqli_query($koneksi, "UPDATE pelanggans
            SET status_berlangganan = 'Non Aktif'
            WHERE id='$pelanggan_id'");
            // ganti profile ke expired
            if ($API->connect($router['host'], $router['port'], $router['username'], $router['password'])) {
                // $API->write('/ppp/profile/print');
                $a = $API->comm("/ppp/secret/print", array(
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
                $b = $API->comm("/ppp/active/print", array(
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

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}
