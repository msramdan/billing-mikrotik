<?php

namespace App\Http\Controllers;

use App\Models\Statusrouter;
use App\Http\Requests\{StoreStatusrouterRequest, UpdateStatusrouterRequest};
use Yajra\DataTables\Facades\DataTables;

class StatusrouterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:statusrouter view')->only('index', 'show');
    }

    public function index()
    {
        return view('statusrouters.show');
    }
}
