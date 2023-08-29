<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('companies')->insert([
            'nama_perusahaan' => 'SawitSkyLink',
            'nama_pemilik' => 'I ketut mistrawan',
            'telepon_perusahaan' => '6287762793064',
            'no_wa' => '6287762793064',
            'email' => 'mistrawan_villain@yahoo.com',
            'alamat' => 'Desa ambengan banjar ambengan',
            'deskripsi_perusahaan' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
            'logo' => null,
            'favicon' => null,
        ]);
    }
}
