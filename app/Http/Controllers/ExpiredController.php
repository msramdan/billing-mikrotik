<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \RouterOS\Client;
use \RouterOS\Exceptions\ConnectException;
use Illuminate\Support\Facades\DB;

class ExpiredController extends Controller
{
    public function expired()
    {
        $companies = DB::table('companies')->where('id', 1)->first();
        $currentDateTime = date('Y-m-d H:i:s');
        if ($currentDateTime <= $companies->expired) {
            return redirect('/');
        } else {
            return view('page-expired');
        }
    }
}
