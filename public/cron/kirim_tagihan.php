<?php
// Cron jalan per 10 menit
date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';

// mulai cron
$pesan = "✅✅ [CRON SEND TAGIHAN] ✅✅\n";
$pesan .= "Mulai Cron :  " . date('Y-m-d H:i:s') . "\n";
sendTelegramNotification($pesan);

$sql = "SELECT tagihans.*,tagihans.id as id_tagihan,companies.*,pelanggans.nama,pelanggans.no_wa, pelanggans.kirim_tagihan_wa,pelanggans.jatuh_tempo FROM tagihans
join companies on companies.id = tagihans.company_id
join pelanggans on pelanggans.id = tagihans.pelanggan_id
where tagihans.status_bayar='Belum Bayar' and is_send='No' limit 10";
$query = mysqli_query($koneksi, $sql);
while ($data = mysqli_fetch_array($query)) {
    try {
        $url = $data['url_wa_gateway'] . 'send-message';
        $message = 'Pelanggan ' . $data['nama_perusahaan'] . "\n\n";
        $message .= 'Yth. *' . $data['nama'] . '*' . "\n\n";
        $message .= 'Kami sampaikan tagihan layanan internet bulan *' . tanggal_indonesia($data['periode'])  . '*' . "\n";
        $message .= 'No tagihan *' . $data['no_tagihan'] . '*' . "\n\n";
        $message .= 'sebesar *' . rupiah($data['total_bayar']) . '*' . "\n\n";
        $message .= 'Pembayaran paling lambat di tanggal *' . addHari($data['tanggal_create_tagihan'], $data['jatuh_tempo']) . '*  Untuk Menghindari Isolir *(kecepatan menurun otomatis)* di jaringan anda.' . " \n\n";
        $message .= $data['footer_pesan_wa_tagihan'];
        if ($data['kirim_tagihan_wa'] == 'Yes') {
            $dataPesan = array(
                'api_key'  => $data['api_key_wa_gateway'],
                'sender'  => $data['sender'],
                'number' => $data['no_wa'],
                'message' => $message,
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
                $tagihan_id = $data['id_tagihan'];
                $sqlUpdate = "UPDATE tagihans SET is_send='Yes' WHERE id='$tagihan_id'";
                mysqli_query($koneksi, $sqlUpdate);

                $pesan = "✅✅ [CRON SEND TAGIHAN] ✅✅\n";
                $pesan .= "Send Tagihan Berhasil!\n";
                $pesan .= "No WhatApp:  " . $data['no_wa'] . "\n";
                $pesan .= "Pelanggan:  " . $data['nama'] . "\n";
                $pesan .= "Periode: " . tanggal_indonesia($data['periode']) . "\n";
                $pesan .= "No Tagihan:  " . $data['no_tagihan'] . "\n";
                sendTelegramNotification($pesan);
            }else{
                $pesan = "❌🚫 [CRON SEND TAGIHAN] ❌🚫\n";
                $pesan .= "Send Tagihan Gagal!\n";
                $pesan .= "No WhatApp:  " . $data['no_wa'] . "\n";
                $pesan .= "Pelanggan:  " . $data['nama'] . "\n";
                $pesan .= "Periode: " . tanggal_indonesia($data['periode']) . "\n";
                $pesan .= "No Tagihan:  " . $data['no_tagihan'] . "\n";
                sendTelegramNotification($pesan);
            }
        }
    } catch (Throwable $t) {
        $pesan = "❌🚫 [CRON SEND TAGIHAN] 🚫❌\n";
        $pesan .= "Ada error nih !\n";
        $pesan .= "Error occurred:  " . $t->getMessage() . "\n";
        sendTelegramNotification($pesan);
        continue;
    }
}

$koneksi->close();
$pesan = "✅✅ [CRON SEND TAGIHAN] ✅✅\n";
$pesan .= "Selesai Cron :  " . date('Y-m-d H:i:s') . "\n";
sendTelegramNotification($pesan);

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
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


function addHari($tgl, $jatuh_tempo)
{
    $tgl    = date('Y-m-d', strtotime('+' . $jatuh_tempo . 'days', strtotime($tgl)));
    return $tgl;
}

function sendTelegramNotification($message)
{
    $botToken = "6864401107:AAGCnHJwNlHxUsESzH4gBMasWyA4zulVdiA";
    $chatId = "-4022178300";

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
