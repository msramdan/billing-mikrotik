<?php
// Jalan craete tagihan tiap hari jam 8
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';
// get data pelanggan aktif


$tgl = date('d');
if ($tgl < 27) {
    // ambil data karyawan yg daftar tgl tersebut
    $query = "select pelanggans.*,packages.harga from pelanggans join packages on packages.id =pelanggans.paket_layanan
    where pelanggans.status_berlangganan='Aktif' and DAY(tanggal_daftar)='$tgl' or
    pelanggans.status_berlangganan='Tunggakan' and DAY(tanggal_daftar)='$tgl'";
    $dataX = mysqli_query($koneksi, $query);
} else {
    // 28, 29, 30, 31
    $query = "select pelanggans.*,packages.harga from pelanggans join packages on packages.id =pelanggans.paket_layanan
    where pelanggans.status_berlangganan='Aktif' and DAY(tanggal_daftar)>'$tgl' or
    pelanggans.status_berlangganan='Tunggakan' and DAY(tanggal_daftar)>'$tgl'";
    $dataX = mysqli_query($koneksi, $query);
}

$dateNow = date('Y-m-d H:i:s');
$periode = date('Y-m');
// get setting wa
$cekNotifWa = "SELECT * FROM wa_gateways where id='1'";
$queryCekNotifWa = mysqli_query($koneksi, $cekNotifWa);
$datanya = mysqli_fetch_array($queryCekNotifWa);

// get data company
$companies = "SELECT * FROM companies where id='1'";
$querycompanies = mysqli_query($koneksi, $companies);
$a = mysqli_fetch_array($querycompanies);

$permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

if ($dataX->num_rows > 0) {
    while ($row = mysqli_fetch_array($dataX)) {
        try {
            // cek udah ada tagihan di bulan ini blm
            $pelanggan_id = $row['id'];
            $nama_pelanggan = $row['nama'];
            $harga = $row['harga'];
            $ppn = $row['ppn'];
            $tglDaftar = substr($row['tanggal_daftar'], 8, 2);
            $generateTgl = date('Y-m-') .$tglDaftar;
            if ($ppn == 'Yes') {
                $nominalPpn = $harga * 0.11;
                $totalBayar = $harga + $nominalPpn;
            } else {
                $nominalPpn = 0;
                $totalBayar =  $harga;
            }
            $cekTagihan = mysqli_query($koneksi, "select * from tagihans where pelanggan_id='$pelanggan_id' and periode='$periode'");
            $jml = mysqli_num_rows($cekTagihan);
            if ($jml < 1) {
                //    create tagihan
                $noTag = generate_string($permitted_chars, 10);
                mysqli_query($koneksi, "INSERT INTO tagihans
            (no_tagihan,pelanggan_id,periode,status_bayar,nominal_bayar,potongan_bayar,ppn,nominal_ppn,total_bayar,tanggal_create_tagihan,is_send)
            VALUES
            ('$noTag', '$pelanggan_id','$periode','Belum Bayar',$harga,0,'$ppn',$nominalPpn,$totalBayar,'$dateNow','No')");
                echo "berhasil generate tagihan bulan " . $periode . " pelanggan " . $nama_pelanggan;
                echo "<br>";
            }else{
                echo "Skip";
            }
        } catch (Throwable $t) {
            continue;
        }
    }
} else {
    echo "0 results";
}

// Close connection
$koneksi->close();


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
