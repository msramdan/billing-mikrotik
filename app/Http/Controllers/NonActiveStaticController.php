<?php

namespace App\Http\Controllers;

use App\Models\NonActiveStatic;
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;

class NonActiveStaticController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:non active static view')->only('index', 'show');
    }

    public function index()
    {
        if (request()->ajax()) {
            $client = setRoute();
            $staticNonAktif = (new Query('/tool/netwatch/print'))
                ->where('status', 'down');
            $staticNonAktif = $client->query($staticNonAktif)->read();
            return DataTables::of($staticNonAktif)
                ->toJson();
        }
        return view('non-active-statics.index');
    }
}
