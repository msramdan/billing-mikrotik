<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;

class StaticController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:static view')->only('index', 'show');
    }

    public function index()
    {
        if (request()->ajax()) {
            $client = setRoute();
            $query = (new Query('/queue/simple/print'))
                ->where('dynamic', 'false');
            $statics = $client->query($query)->read();
            return DataTables::of($statics)
                ->addColumn('target', function ($row) {
                    return str($row['target']);
                })
                ->addColumn('max_limit', function ($row) {
                    $thismaxlimit   = $row['max-limit'];
                    $maxlimit       = explode("/", $thismaxlimit);
                    $maxlimitup     = formatBytes($maxlimit[0]);
                    $maxlimitdown   = formatBytes($maxlimit[1]);
                    return $maxlimitup . ' / ' . $maxlimitdown;
                })
                ->addColumn('limit-at', function ($row) {
                    $thislimitat    = $row['limit-at'];
                    $limitat        = explode("/", $thislimitat);
                    $limitatup      = formatBytes($limitat[0]);
                    $limitatdown    = formatBytes($limitat[1]);
                    return $limitatup . ' / ' . $limitatdown;
                })
                ->addColumn('bytes', function ($row) {
                    $thisbytes      = $row['bytes'];
                    $bytes        = explode("/", $thisbytes);
                    $bytesup      = formatBytes($bytes[0]);
                    $bytesdown    = formatBytes($bytes[1]);
                    return $bytesup . ' / ' . $bytesdown;
                })
                ->addColumn('parent', function ($row) {
                    return $row['parent'];
                })
                ->addColumn('action', 'statics.include.action')
                ->toJson();
        }
        return view('statics.index');
    }

    public function show($id)
    {
        return view('statics.show', compact('static'));
    }
}
