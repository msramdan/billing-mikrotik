<?php

use \RouterOS\Client;
use Illuminate\Support\Facades\DB;
use \RouterOS\Exceptions\ConnectException;

function formatBytes($bytes, $decimal = null)
{
    $satuan = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes > 1024) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, $decimal) . ' ' . $satuan[$i];
}

function setRoute()
{
    $router = DB::table('settingmikrotiks')->where('is_active', 'Yes')->first();
    if ($router) {
        try {
            $client = new Client([
                'host' => $router->host,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => $router->port,
            ]);
            return $client;
        } catch (ConnectException $e) {
            echo $e->getMessage() . PHP_EOL;
            die();
        }
    } else {
        echo "Belum ada router / Router tidak aktif";
        die();
    }
}

function getRouteName()
{
    $router = DB::table('settingmikrotiks')->where('is_active', 'Yes')->first();
    if ($router) {
        return $router->identitas_router;
    } else {
        return '-';
    }
}

function getCompany()
{
    $data = DB::table('companies')->first();
    return $data;
}

function rupiah($angka){

	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;

}
