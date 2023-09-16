<?php

// di jalankan tiap hari jam 00:01

date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';
include 'routeros_api.class.php';

$API = new RouterosAPI();
$API->debug = false;
$router = mysqli_query($koneksi, "select * from settingmikrotiks where is_active='Yes'")->fetch_assoc();

// get data tagihan
$sql = "SELECT tagihans.*, pelanggans.auto_isolir,pelanggans.jatuh_tempo,pelanggans.user_pppoe FROM tagihans
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
            if ($API->connect($router['host'], $router['port'], $router['username'], $router['password'])) {
                // $API->write('/ppp/profile/print');
                $a = $API->comm("/ppp/secret/print",  array(
                    '?name' => $data['user_pppoe'],
                ));
                $idSecret = $a[0]['.id'];
                // set expire
                $comment = 'Di set expired Tanggal : ' . date('Y-m-d H:i:s');
                $API->comm("/ppp/secret/set", array(
                    ".id"     => $idSecret ,
                    "profile"  => "EXPIRED",
                    "comment"      => $comment
                 ));
                 // get name from active ppp
                 $b = $API->comm("/ppp/active/print",  array(
                    '?name' => $data['user_pppoe'],
                ));
                $idActive = $b[0]['.id'];
                // remove session
                $API->comm("/ppp/active/remove", array(
                    ".id"     => $idActive
                 ));
            }
            $API->disconnect();
        }
    }
}

echo "Auto isolir berjalan";
function addHari($tgl, $jatuh_tempo)
{
    $tgl    = date('Y-m-d', strtotime('+' . $jatuh_tempo . 'days', strtotime($tgl)));
    return $tgl;
}
