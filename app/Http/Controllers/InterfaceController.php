<?php

namespace App\Http\Controllers;

use App\Models\Interface;
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Client;
use \RouterOS\Query;


class InterfaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:interface view')->only('index', 'show');
    }

    public function index()
    {
        if (request()->ajax()) {
            $client = new Client([
                'host' => '103.122.65.234',
                'user' => 'sawitskylink',
                'pass' => 'sawit064199',
                'port' => 83,
            ]);
            $query = (new Query('/interface/print'))
                ->where('mtu', 1500);
            $interfaces = $client->query($query)->read();
            return DataTables::of($interfaces)
                ->addColumn('tx-byte', function ($row) {
                    return formatBytes($row['tx-byte'], 3);
                })
                ->addColumn('rx-byte', function ($row) {
                    return formatBytes($row['rx-byte'], 2);
                })
                ->toJson();
        }
        return view('interfaces.index');
    }
}
