<?php

namespace App\Http\Controllers;

use App\Models\Dhcp;
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Client;
use \RouterOS\Query;


class DhcpController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dhcp view')->only('index', 'show');
        $this->middleware('permission:dhcp delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $client = setRoute();
            $query = new Query('/ip/dhcp-server/lease/print');
            $dhcps = $client->query($query)->read();
            return DataTables::of($dhcps)
                ->addColumn('action', 'dhcps.include.action')
                ->toJson();
        }
        return view('dhcps.index');
    }

    public function destroy($id)
    {
        try {
            $client = setRoute();
            $queryDelete = (new Query('/ip/dhcp-server/lease/remove'))
                ->equal('.id', $id);
            $client->query($queryDelete)->read();
            return redirect()
                ->route('dhcps.index')
                ->with('success', __('The DHCP Leases was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('dhcps.index')
                ->with('error', __("The DHCP Leases can't be deleted because it's related to another table."));
        }
    }
}
