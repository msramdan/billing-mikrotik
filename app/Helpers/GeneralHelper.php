<?php

use \RouterOS\Client;
use \RouterOS\Query;

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
    $client = new Client([
        'host' => '103.122.65.234',
        'user' => 'sawitskylink',
        'pass' => 'sawit064199',
        'port' => 83,
    ]);
    return $client;
}
