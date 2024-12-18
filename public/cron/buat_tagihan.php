<?php
// Jalan craete tagihan tiap hari jam 7
date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';
// get data pelanggan aktif

// mulai cron
$pesan = "✅✅ [CRON CREATE TAGIHAN] ✅✅\n";
$pesan .= "Mulai Cron :  " . date('Y-m-d H:i:s') . "\n";
sendTelegramNotification($pesan);

$tgl = date('d');
if ($tgl < 27) {
    // ambil data karyawan yg daftar tgl tersebut
    $query = "select pelanggans.*,packages.harga from pelanggans join packages on packages.id =pelanggans.paket_layanan
    where pelanggans.status_berlangganan='Aktif' and DAY(tanggal_daftar) ='$tgl' or
    pelanggans.status_berlangganan='Tunggakan' and DAY(tanggal_daftar) ='$tgl'";
    $dataX = mysqli_query($koneksi, $query);
} else {
    // 28, 29, 30, 31
    $query = "select pelanggans.*,packages.harga from pelanggans join packages on packages.id =pelanggans.paket_layanan
    where pelanggans.status_berlangganan='Aktif' and DAY(tanggal_daftar) >='$tgl' or
    pelanggans.status_berlangganan='Tunggakan' and DAY(tanggal_daftar) >='$tgl'";
    $dataX = mysqli_query($koneksi, $query);
}
$dateNow = date('Y-m-d H:i:s');
$periode = date('Y-m');
$permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
echo "Jumlah data pelnggan tanggal " . $tgl . " adalah : " . $dataX->num_rows . "\n";
if ($dataX->num_rows > 0) {
    while ($row = mysqli_fetch_array($dataX)) {
        try {
            $is_generate_tagihan = $row['is_generate_tagihan'];
            $nama_pelanggan = $row['nama'];
            if ($is_generate_tagihan == 'Yes') {
                $pelanggan_id = $row['id'];
                $company_id = $row['company_id'];
                $harga = $row['harga'];
                $ppn = $row['ppn'];
                $tglDaftar = substr($row['tanggal_daftar'], 8, 2);
                if ($ppn == 'Yes') {
                    $nominalPpn = $harga * 0.11;
                    $totalBayar = $harga + $nominalPpn;
                } else {
                    $nominalPpn = 0;
                    $totalBayar =  $harga;
                }
                // cek udah ada tagihan di bulan ini blm
                $cekTagihan = mysqli_query($koneksi, "select * from tagihans where pelanggan_id='$pelanggan_id' and periode='$periode'");
                $jml = mysqli_num_rows($cekTagihan);
                if ($jml < 1) {
                    //    create tagihan
                    $noTag = generate_string($permitted_chars, 10);
                    mysqli_query($koneksi, "INSERT INTO tagihans
                (no_tagihan,pelanggan_id,periode,status_bayar,nominal_bayar,potongan_bayar,ppn,nominal_ppn,total_bayar,tanggal_create_tagihan,is_send,company_id)
                VALUES
                ('$noTag', '$pelanggan_id','$periode','Belum Bayar','$harga',0,'$ppn','$nominalPpn','$totalBayar','$dateNow','No','$company_id')");
                    echo "Berhasil Create : " . $nama_pelanggan . "\n";
                } else {
                    echo "SKIP : " . $nama_pelanggan . "\n";
                }
            }else{
                echo "SKIP karna generate off : " . $nama_pelanggan . "\n";
            }
        } catch (Throwable $t) {
            $pesan = "❌🚫 [CRON CREATE TAGIHAN] 🚫❌\n";
            $pesan .= "Ada error nih !\n";
            $pesan .= "Error occurred:  " . $t->getMessage() . "\n";
            sendTelegramNotification($pesan);
            continue;
        }
    }
} else {
    $error_message = "⚠️⚠️ [CRON CREATE TAGIHAN] ⚠️⚠️\nTidak ada daftar pelanggan daftar tanggal " . $tgl . " Yang statusnya aktif / Tunggakan ";
    sendTelegramNotification($error_message);
}
$koneksi->close();

$pesan = "✅✅ [CRON CREATE TAGIHAN] ✅✅\n";
$pesan .= "Selesai Cron :  " . date('Y-m-d H:i:s') . "\n";
sendTelegramNotification($pesan);

function generate_string($input, $strength = 10)
{
    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return 'INV-SSL-' . $random_string;
}

function sendTelegramNotification($message)
{
    $botToken = "6864401107:AAGCnHJwNlHxUsESzH4gBMasWyA4zulVdiA";
    $chatId = "-4013875269";

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
