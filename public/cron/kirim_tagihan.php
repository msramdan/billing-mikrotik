<?php
// Cron jalan per 10 menit
date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';
// cek notif wa aktif gk
$cekNotifWa = "SELECT * FROM wa_gateways where id='1'";
$queryCekNotifWa = mysqli_query($koneksi, $cekNotifWa);
$datanya = mysqli_fetch_array($queryCekNotifWa);

// get data company
$companies = "SELECT * FROM companies where id='1'";
$querycompanies= mysqli_query($koneksi, $companies);
$a = mysqli_fetch_array($querycompanies);

if ($datanya['is_active'] == 'Yes') {
    $sql = "SELECT tagihans.*,pelanggans.nama,pelanggans.no_wa, pelanggans.kirim_tagihan_wa,pelanggans.jatuh_tempo FROM tagihans
    join pelanggans on pelanggans.id = tagihans.pelanggan_id where tagihans.status_bayar='Belum Bayar' and is_send='No' limit 1";
    $query = mysqli_query($koneksi, $sql);
    while ($data = mysqli_fetch_array($query)) {
        try {
            $url = $datanya['url'] . 'send-message';
            $message = 'Pelanggan ' . $a['nama_perusahaan'] . ' Yth. ' . $data['nama'] . "\n\n";
            $message .= 'Kami sampaikan tagihan layanan internet bulan *' . tanggal_indonesia($data['periode'])  . '*' . "\n";
            $message .= 'Dengan no tagihan *' . $data['no_tagihan'] . '* sebesar *' . rupiah($data['total_bayar']) . '*' . "\n";
            $message .= 'Pembayaran paling lambat di tanggal *' . addHari($data['tanggal_create_tagihan'],$data['jatuh_tempo']) . '* Untuk Menghindari Isolir otomatis di tempat anda.'." \n\n";
            $message .= "_*Note : Abaikan pesan ini jika sudah membayar*_ \n\n";
            $message .= $datanya['footer_pesan_wa_tagihan'];
            if ($data['kirim_tagihan_wa'] == 'Yes') {
                $dataPesan = array(
                    'api_key'  => $datanya['api_key'],
                    'receiver' => $data['no_wa'],
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

                if($res->status==true || $res->status =='true'){
                    // update is send
                    $tagihan_di =$data['id'];
                    $sqlUpdate = "UPDATE tagihans SET is_send='Yes' WHERE id='$tagihan_di'";
                    mysqli_query($koneksi, $sqlUpdate);
                }

            }
        } catch (Throwable $t) {
            continue;
        }
    }
    echo "Cron berhasil kirim notif pak sawit";
} else {
    echo "Cron berhasil tapi tidak kirim notif";
}

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
    $tgl    = date('Y-m-d', strtotime('+'.$jatuh_tempo.'days', strtotime($tgl)));
    return $tgl;
}

