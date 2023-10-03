<?php

namespace App\Http\Controllers;

use App\Models\ActivePpp;
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;

class ActiveNonPppController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:non active ppp view')->only('index');
    }

    public function index()
    {
        if (request()->ajax()) {
            $client = setRoute();
            $query = new Query('/ppp/secret/print');
            $secretPpps = $client->query($query)->read();
            $query = new Query('/ppp/active/print');
            $activePpps = $client->query($query)->read();
            $arrSecret = [];
            foreach ($secretPpps as $key => $value) {
                array_push($arrSecret, $value['name']);
            }
            $arrActive = [];
            foreach ($activePpps as $key => $value) {
                array_push($arrActive, $value['name']);
            }
            $notInArray2 = array_diff($arrSecret, $arrActive);
            foreach ($notInArray2 as $key => $value) {
                $data[$key] = [
                    'name' => $value
                ];
            }
            return DataTables::of($data)
                ->addColumn('status', function ($row) {
                    return
                        '<button class="btn btn-pill btn-danger btn-air-danger btn-xs" type="button" title="">Offline</button>';
                })
                ->rawColumns(['status'])
                ->toJson();
        }
        return view('non-active-ppps.index');
    }
}
