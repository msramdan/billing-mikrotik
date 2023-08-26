<?php

namespace App\Http\Controllers;

use App\Models\Dhcp;
use App\Http\Requests\{StoreDhcpRequest, UpdateDhcpRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Client;
use \RouterOS\Query;


class DhcpController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dhcp view')->only('index', 'show');
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
            $query = new Query('/ip/dhcp-server/lease/print');
            $dhcps = $client->query($query)->read();

            return DataTables::of($dhcps)
                ->addColumn('action', 'dhcps.include.action')
                ->toJson();
        }

        return view('dhcps.index');
    }
}
