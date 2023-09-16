<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormMikrotikController extends Controller
{
    public function form(){
        return view('form-router');
    }

    public function cekrouter(Request $request){
        // $input = $request->all();

        // Log::info($input);

        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }
}
