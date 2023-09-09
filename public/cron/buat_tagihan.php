<?php
// Jalan craete tagihan jam 1 malam tiap tgl 1
date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';
// get data pelanggan aktif
$data = mysqli_query($koneksi, "select pelanggans.*,packages.harga from pelanggans
join packages on packages.id =pelanggans.paket_layanan
where pelanggans.status_berlangganan='Aktif'");
$dateNow = date('Y-m-d H:i:s');
$periode = date('Y-m');
while ($d = mysqli_fetch_array($data)) {
    // cek udah ada tagihan di bulan ini blm
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pelanggan_id = $d['id'];
    $harga = $d['harga'];
    $ppn = $d['ppn'];
    if($ppn =='Yes'){
        $nominalPpn = $harga * 0.11;
        $totalBayar = $harga + $nominalPpn ;
    }else{
        $nominalPpn = 0 ;
        $totalBayar =  $harga ;
    }
    $cekTagihan = mysqli_query($koneksi, "select * from tagihans where pelanggan_id='$pelanggan_id' and periode='$periode'");
    $jml = mysqli_num_rows($cekTagihan);
    if ($jml < 1) {
        //    create tagihan
        $noTag = generate_string($permitted_chars, 10);
        mysqli_query($koneksi, "INSERT INTO tagihans
        (no_tagihan,pelanggan_id,periode,status_bayar,nominal_bayar,potongan_bayar,ppn,nominal_ppn,total_bayar,tanggal_create_tagihan)
        VALUES
        ('$noTag', '$pelanggan_id','$periode','Belum Bayar',$harga,0,'$ppn',$nominalPpn,$totalBayar,'$dateNow')");
    }
}
echo "berhasil generate tagihan bulan " .$periode;


function generate_string($input, $strength = 10) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return 'INV-SSL-' .$random_string;
}
