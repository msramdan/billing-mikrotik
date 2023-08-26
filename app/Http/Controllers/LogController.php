<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Http\Requests\{StoreLogRequest, UpdateLogRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Client;
use \RouterOS\Query;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:log view')->only('index', 'show');
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
            $query = new Query('/log/print');
            $logs = $client->query($query)->read();
            return DataTables::of($logs)
                ->addColumn('id', function ($row) {
                    return $row['.id'];
                })
                ->addColumn('action', 'logs.include.action')
                ->toJson();
        }
        return view('logs.index');
    }
}
