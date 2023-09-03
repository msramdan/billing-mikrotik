<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function loginClient()
    {
        return view('frontend.login');
    }

    public function registerClient()
    {
        $paket = DB::table('packages')->get();
        return view('frontend.register',[
            'paket' => $paket
        ]);
    }

    public function submitRegister(Request $request,)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required|string',
                'email' => 'required|email|unique:pelanggans,email',
                'no_wa' => 'required|string|max:15|phone_number',
                'no_ktp' => 'required|string|max:50',
                'alamat' => 'required|string',
                'password' => 'required',
                'paket_layanan' => 'required|exists:App\Models\Package,id',
                // 'photo_ktp' => 'image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
            ],
            [
                'no_wa.phone_number'    => 'Harus diawali dengan 62, Cth : 6283874731480',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
    }

    public function cekTagihan()
    {
        return view('frontend.tagihan');
    }

    public function areaCoverage()
    {
        return view('frontend.coverage');
    }

    public function speedTest()
    {
        return view('frontend.speed');
    }
}
