<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            'nama_perusahaan' => "Evdigi",
            'telepon_perusahaan' => '021 111111',
            'email' => 'saepulramdan244@gmail.com',
            'no_wa' => '6283874731480',
            'alamat' => 'Perum SAI Residance Kab.Bogor',
            'deskripsi_perusahaan' => '-',
            'logo' => null,
            'favicon' => null,
            'url_wa_gateway' => 'https://sawitskylink.my.id/api/',
            'api_key_wa_gateway' => 'c851ba7398c8b2713cd424fccdd997be18b5da2b',
            'is_active' => 'No',
            'footer_pesan_wa_tagihan' => 'silahkan kunjungi link di bawah ini untuk bayar tagihan dan cek tagihan. *https://sawit.rajabilling.my.id/*
            pembayaran bisa di lakukan melalui, *indomaret*, *alfamart*, *virtual akun*,  melalui link tersebut tanpa perlu kirim bukti transfer.
            jika ingin transfer manual bisa ke req di bawah ini, dengan mengirim bukti transfer ke admin.
            *BRI* 173001008816500 (a/n= komang sutarini)
            *BPD* 0140202752037 =(a/n ketut mistrawan)
            *BCA* 8271337914 (a/n ketut mistrawan)',
            'footer_pesan_wa_pembayaran' => 'Terdepan membuka akses',
            'url_tripay' => 'Terdepan membuka akses',
            'api_key_tripay' => 'MipM6kIhJ1FZYX1VvyIxYikZXVXJovNYxjo3l5tq',
            'kode_merchant' => 'T25408',
            'private_key' => 'IyiQy-hKNM3-OnVGg-rojcs-EKHmL',
            'paket_id' => 1,
            'expired' => '2024-12-30',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
