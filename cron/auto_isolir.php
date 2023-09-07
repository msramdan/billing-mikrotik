<?php

// di jalankan tiap hari jam 00:01

date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';


// get data tagihan
$sql = "SELECT tagihans.*, pelanggans.auto_isolir,pelanggans.jatuh_tempo FROM tagihans
    join pelanggans on pelanggans.id = tagihans.pelanggan_id where tagihans.status_bayar='Belum Bayar'";
$query = mysqli_query($koneksi, $sql);

while ($data = mysqli_fetch_array($query)) {
    if ($data['auto_isolir'] == 'Yes') {
        // tgl jatuh tempo
        $jatuh_tempo = $data['jatuh_tempo'];
        $pelanggan_id = $data['pelanggan_id'];
        $tanggal_create_tagihan = $data['tanggal_create_tagihan'];
        $tgl_jatuh_tempo = addHari($tanggal_create_tagihan, $jatuh_tempo);
        $date_now = date('Y-m-d');

        if ($tgl_jatuh_tempo <= $date_now) {
            // set status pelanggan ke non aktif
            mysqli_query($koneksi, "UPDATE pelanggans
            SET status_berlangganan = 'Non Aktif'
            WHERE id='$pelanggan_id'");
            // ganti profile ke expired
        }
    }
}

echo "Auto isolir berjalan";
function addHari($tgl, $jatuh_tempo)
{
    $tgl    = date('Y-m-d', strtotime('+' . $jatuh_tempo . 'days', strtotime($tgl)));
    return $tgl;
}
