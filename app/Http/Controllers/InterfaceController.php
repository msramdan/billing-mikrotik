<?php

namespace App\Http\Controllers;

use App\Models\Interfacedata;
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
            $client = setRoute();
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
