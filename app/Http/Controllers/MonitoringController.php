<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use Yajra\DataTables\Facades\DataTables;

class MonitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:monitoring view')->only('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $olts = Olt::where('company_id', '=', session('sessionCompany'))->get();
        return view('monitorings.index',[
            'olts' => $olts
        ]);
    }
}
