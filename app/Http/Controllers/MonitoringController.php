<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

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
        $statusMapping = [
            'INTEGER: 1' => 'Loss',
            'INTEGER: 2' => 'Sync Mib',
            'INTEGER: 3' => '-',
            'INTEGER: 4' => 'Power Failed',
        ];

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
                'critical' =>  '-',
                'statusMapping' => $statusMapping
            ]);
        }

        $hasil = oltExec();
        $total_auth = $hasil['online'] + $hasil['offline'];

        return view('monitorings.index', [
            'olts' => Olt::where('company_id', session('sessionCompany'))->get(),
            'list_olt' => $hasil['var'],
            'online' => $hasil['online'],
            'offline' => $hasil['offline'],
            'total_auth' => $total_auth,
            'power_fail' => $hasil['power_fail'],
            'los' => $hasil['los'],
            'sync' => $hasil['sync'],
            'low_signal' => $hasil['low_signal'],
            'warning' =>  $hasil['warning'],
            'critical' =>  $hasil['critical'],
            'statusMapping' => $statusMapping
        ]);
    }

    public function oltSelect(Request $request)
    {
        try {
            $request->validate([
                'selectedValue' => 'required|exists:olts,id',
            ]);

            session()->forget('sessionOlt');

            $oltSettings = Olt::findOrFail($request->input('selectedValue'));

            $testVar = snmpget($oltSettings->host, $oltSettings->ro, '.1.3.6.1.2.1.1.1.0');

            if ($testVar === false) {
                return response()->json(['success' => false]);
            }

            session(['sessionOlt' => $oltSettings->id]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
