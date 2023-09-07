<?php

namespace App\Http\Controllers;

use App\Models\AreaCoverage;
use Illuminate\Http\Request;
use App\Models\WaGateway;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Http;

class SendnotifController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sendnotif view')->only('index', 'show');
    }
    public function index()
    {
        $areaCoverages = AreaCoverage::all();
        return view('sendnotifs.index', [
            'areaCoverages' => $areaCoverages,
        ]);
    }

    public function kirim_pesan(Request $request)
    {
        $odp = $request->odp;
        $pelanggan = Pelanggan::where('odp', $odp)
            ->where('status_berlangganan', 'Aktif')
            ->get();
        $waGateway = WaGateway::findOrFail(1)->first();
        foreach ($pelanggan as $value) {
            $endpoint_wa = $waGateway->url . 'send-message';
            $response = Http::post($endpoint_wa, [
                'api_key' => $waGateway->api_key,
                'receiver' => strval($value->no_wa),
                'data' => [
                    "message" => $request->pesan,
                ]
            ]);
            \Log::info($response);
        }
        return redirect()
            ->route('sendnotifs.index')
            ->with('success', __('Kirim pemberitahuan WA berhasil'));
    }

}
