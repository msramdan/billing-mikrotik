<?php

namespace App\Http\Controllers;

use App\Models\ActiveStatic;
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;

class ActiveStaticController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:active static view')->only('index', 'show');
    }


    public function index()
    {
        if (request()->ajax()) {
            $client = setRoute();
            $staticAktif = (new Query('/tool/netwatch/print'))
                ->where('status', 'up');
            $staticAktif = $client->query($staticAktif)->read();
            return DataTables::of($staticAktif)
                ->toJson();
        }
        return view('active-statics.index');
    }
}
