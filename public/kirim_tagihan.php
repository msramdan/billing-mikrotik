<?php

date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';
// cek notif wa aktif gk
$cekNotifWa = "SELECT * FROM wa_gateways where id='1'";
$queryCekNotifWa = mysqli_query($koneksi, $cekNotifWa);
$datanya = mysqli_fetch_array($queryCekNotifWa);

if ($datanya['is_active'] == 'Yes') {
    $sql = "SELECT tagihans.*,tagihans.id as id_tagihan,companies.*,pelanggans.nama,pelanggans.no_wa, pelanggans.kirim_tagihan_wa,pelanggans.jatuh_tempo FROM tagihans
    join companies on companies.id = tagihans.company_id
    join pelanggans on pelanggans.id = tagihans.pelanggan_id
    where tagihans.status_bayar='Belum Bayar' and is_send='No' limit 10";
    $query = mysqli_query($koneksi, $sql);
    while ($data = mysqli_fetch_array($query)) {
        try {
            $url = $datanya['url'] . 'send-message';
            $message = 'Pelanggan SawitSkyLink Yth. ' . $data['nama'] . "\n\n";
            $message .= 'Kami sampaikan tagihan layanan internet bulan *' . tanggal_indonesia($data['periode'])  . '*' . "\n";
            $message .= 'Dengan no tagihan *' . $data['no_tagihan'] . '* sebesar *' . rupiah($data['total_bayar']) . '*' . "\n";
            $message .= 'Pembayaran paling lambat di tanggal *' . addHari($data['tanggal_create_tagihan'], $data['jatuh_tempo']) . '* Untuk Menghindari Isolir off wifi otomatis di tempat anda.' . " \n\n";
            $message .= "*Note : Abaikan pesan ini jika sudah berbayar* \n\n";
            $message .= "Anda dapat melakukan pembayaran tagihan dengan cara : \n";
            $message .= "1. Lewat Virtual Account (Verifikasi Pembayaran Automatis) \n";
            $message .= "2. Transfer lewat Norek dengan menyerahkan bukti transfer lewat WA / datang ke kantor \n";
            $message .= "3. Bayar Cash dengan datang ke kantor \n\n";
            $message .= "Terima kasih atas kepercayaannya dalam memilih SawitSkyLink sebagai provider internet di tempat Anda. \n\n";
            $message .= "Hormat kami,  \n";
            $message .= "Admin SawitSkyLink \n";

            if ($data['kirim_tagihan_wa'] == 'Yes') {
                $data = array(
                    'api_key'  => $data['api_key_wa_gateway'],
                    'sender'  => $data['sender'],
                    'number' => $data['no_wa'],
                    'message' => $message,
                );
                $body = json_encode($data);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);
                print_r($result);
            }
        } catch (Throwable $t) {
            continue;
        }
    }
    echo "Cron berhasil kirim notif";
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
    $tgl    = date('Y-m-d', strtotime('+' . $jatuh_tempo . 'days', strtotime($tgl)));
    return $tgl;
}
