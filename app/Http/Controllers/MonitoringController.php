<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        if (!session('sessionOlt')) {
            return view('monitorings.index', [
                'olts' => Olt::where('company_id', session('sessionCompany'))->get(),
                'list_olt' => [],
                'online' => '-',
                'offline' => '-',
                'total_auth' => '-',
                'power_fail' => '-',
                'los' => '-',
                'sync' => '-',
                'low_signal' => '-',
                'warning' => '-',
                'critical' =>  '-'
            ]);
        }

        // get data ke vm
        $hasil = oltExec();
        $data = $hasil->getData();
        $data1 = $data->onuName->data;
        $data2 = $data->status->data;
        $data3 = $data->uncf->data;
        $groupedCounts = [];
        if (count($data1) === count($data2)) {
            for ($i = 0; $i < count($data1); $i++) {
                $data1[$i] = (object) array_merge((array) $data1[$i], (array) $data2[$i]);
                // Menghitung jumlah data grup berdasarkan 'phase' dari $data2
                $phase = $data2[$i]->phase;
                if (!isset($groupedCounts[$phase])) {
                    $groupedCounts[$phase] = 0;
                }
                $groupedCounts[$phase]++;
            }
        } else {
            echo "Jumlah elemen dalam dua array tidak sama.";
            die();
        }
        $jumlahWorking = isset($groupedCounts['working']) ? $groupedCounts['working'] : 0;
        return view('monitorings.index', [
            'olts' => Olt::where('company_id', session('sessionCompany'))->get(),
            'list_olt' => $data1,
            'online' => $jumlahWorking,
            'offline' => count($data1) - $jumlahWorking,
            'total_auth' =>  count($data1),
            'uncf' =>  count($data3),
            'list_uncf' =>  $data3,
            'groupedCounts' => $groupedCounts
        ]);
    }

    public function detailOlt(Request $request)
    {
        try {
            $onuId = $request->input('onu_id');
            $oltSettings = Olt::findOrFail(session('sessionOlt'));
            $requestData = [
                'host' => $oltSettings->host,
                'port' => (int) $oltSettings->port,
                'username' => $oltSettings->username,
                'password' => $oltSettings->password,
                'onu_id' =>  $onuId
            ];
            $vlan = 'http://103.176.79.206:9005/vlan';
            $sn = 'http://103.176.79.206:9005/sn';
            $redaman = 'http://103.176.79.206:9005/redaman';
            $result = asyncApiCalls($requestData, $vlan, $sn, $redaman);
            return response()->json([
                'success' => true,
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'result' => ''
                ]
            );
        }
    }

    public function oltSelect(Request $request)
    {
        try {
            $request->validate([
                'selectedValue' => 'required|exists:olts,id',
            ]);

            session()->forget('sessionOlt');

            $oltSettings = Olt::findOrFail($request->input('selectedValue'));

            // cek koneksi ke ip vps
            $requestData = [
                'host' =>  $oltSettings->host,
                'port' => (int) $oltSettings->port,
                'username' =>  $oltSettings->username,
                'password' =>  $oltSettings->password,
            ];

            $response = Http::post('http://103.176.79.206:9005/cek-koneksi', $requestData);
            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === true) {
                    session(['sessionOlt' => $oltSettings->id]);
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false]);
                }
            } else {
                return response()->json(['success' => false]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
}
