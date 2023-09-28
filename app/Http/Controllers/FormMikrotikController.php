<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \RouterOS\Client;
use \RouterOS\Exceptions\ConnectException;
use Illuminate\Support\Facades\DB;

class FormMikrotikController extends Controller
{
    public function form()
    {
        return view('form-router');
    }

    public function cekrouter(Request $request)
    {

        try {

            $data = [
                'host' => $request->host,
                'user' => $request->username,
                'pass' => $request->password,
                'port' => (int) $request->port,
            ];

            $dataInput = [
                'name' => $request->name,
                'host' => $request->host,
                'user' => $request->username,
                'pass' => $request->password,
                'port' => (int) $request->port,
            ];
            new Client($data);
            return response()->json([
                'success' => true,
                'message' => 'Koneksi ke mikrotik berhasil',
                'data' => $dataInput
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage() . PHP_EOL,
                'data' => ''
            ]);
        }
    }

    public function simpanrouter(Request $request)
    {
        try {
            // simpan data
            $simpan = DB::table('settingmikrotiks')->insert([
                'identitas_router' => $request->name,
                'host' => $request->host,
                'port' => $request->port,
                'username' => $request->username,
                'password' => $request->password,
                'is_active' => 'Yes',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Berhasil simpan data',
            ]);
        } catch (ConnectException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ada error kak',
            ]);
        }
    }
}
