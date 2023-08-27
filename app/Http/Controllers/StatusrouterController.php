<?php

namespace App\Http\Controllers;

use App\Models\Statusrouter;
use App\Http\Requests\{StoreStatusrouterRequest, UpdateStatusrouterRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;

class StatusrouterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:statusrouter view')->only('index', 'show');
    }

    public function index()
    {
        $client = setRoute();
        $query = new Query('/ip/hotspot/user/print');
        $hotspotuser = $client->query($query)->read();

        $queryipcloud = new Query('/ip/cloud/print');
        $ipcloud = $client->query($queryipcloud)->read();

        $queryhotspotactive = new Query('/ip/hotspot/active/print');
        $hotspotactive = $client->query($queryhotspotactive)->read();

        $querypppsecrets = new Query('/ppp/secret/print');
        $pppsecrets = $client->query($querypppsecrets)->read();

        $querypppactive = new Query('/ppp/active/print');
        $pppactive = $client->query($querypppactive)->read();

        $queryidentity = new Query('/system/identity/print');
        $identity = $client->query($queryidentity)->read();

        $queryresource = new Query('/system/resource/print');
        $resource = $client->query($queryresource)->read();

        $querywaktu = new Query('/system/clock/print');
        $waktu = $client->query($querywaktu)->read();

        $querylicense = new Query('/system/license/print');
        $license = $client->query($querylicense)->read();

        $resource = json_encode($resource);
        $resource = json_decode($resource, true);
        $ipcloud = json_encode($ipcloud);
        $ipcloud = json_decode($ipcloud, true);
        $waktu = json_encode($waktu);
        $waktu = json_decode($waktu, true);
        $identity = json_encode($identity);
        $identity = json_decode($identity, true);
        $license = json_encode($license);
        $license = json_decode($license, true);

        $boardname = $resource['0']['board-name'];
        if ($boardname == 'CHR') {
            $level = $license['0']['level'];
            $software = $license['0']['system-id'];
        } else {
            $level = $license['0']['nlevel'];
            $software = $license['0']['software-id'];
        }

        $dataku = [
            'hotspotuser' => count($hotspotuser),
            'hotspotactive' => count($hotspotactive),
            'pppsecrets' => count($pppsecrets),
            'pppactive' => count($pppactive),
            'identity' => $identity['0']['name'],
            'publicrouter' => $ipcloud['0']['public-address'],
            'cpuname' => $resource['0']['cpu'],
            'cpucount' => $resource['0']['cpu-count'],
            'frequency' => $resource['0']['cpu-frequency'],
            'cpuload' => $resource['0']['cpu-load'],
            'uptime' => $resource['0']['uptime'],
            'boardname' => $resource['0']['board-name'],
            'architecture' => $resource['0']['architecture-name'],
            'freememory' => $resource['0']['free-memory'],
            'totalmemory' => $resource['0']['total-memory'],
            'freehdd' => $resource['0']['free-hdd-space'],
            'totalhdd' => $resource['0']['total-hdd-space'],
            'architecture' => $resource['0']['architecture-name'],
            'version' => $resource['0']['version'],
            'time' => $waktu['0']['time'],
            'date' => $waktu['0']['date'],
            'level' => $level,
            'software' => $software,
        ];

        return view('statusrouters.show', $dataku);
    }
}
