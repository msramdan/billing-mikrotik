<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use \RouterOS\Query;
use Illuminate\Support\Facades\DB;
use \RouterOS\Client as RouterOSClient;
use \RouterOS\Exceptions\ConnectException;

class MonitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:monitoring view')->only('index', 'show');
    }

    public function index()
    {
        if (!session('sessionOlt')) {
            return view('monitorings.index', [
                'olts' => Olt::where('company_id', session('sessionCompany'))->get(),
                'list_olt' => [],
                'online' => '-',
                'offline' => '-',
                'total_auth' => '-',
                'uncf' =>  '-',
                'list_uncf' => [],
                'groupedCounts' =>  [],
                'missing_values' => [],
                'max_values' => [],
            ]);
        }

        // get data ke vm
        $hasil = oltExec();
        $data = $hasil->getData();
        $data1 = $data->onuName->data;
        $data2 = $data->status->data;
        $data3 = $data->uncf->data;
        $groupedCounts = [];

        $result = self::processOnuData($data2);
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
            'groupedCounts' => $groupedCounts,
            'missing_values' => $result["missing_values"],
            'max_values' => $result["max_values"]
        ]);
    }

    public function processOnuData($data)
    {
        $groups = array();
        foreach ($data as $item) {
            $onu_index_parts = explode(":", $item->onu_index);
            $group = $onu_index_parts[0];
            $groups[$group][] =  $item->onu_index;
        }

        $missing_values = array();
        $max_values = array();

        foreach ($groups as $group => $values) {
            $values = array_map(function ($value) {
                return intval(substr($value, strrpos($value, ":") + 1));
            }, $values);

            $max_value = max($values);
            $max_values[$group] = $max_value;

            $missing_values[$group] = array_diff(range(1, $max_value), $values);
        }

        return array("missing_values" => $missing_values, "max_values" => $max_values);
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

            $zteServer4 = env('ZTE_SERVER_4');
            $zteServer5 = env('ZTE_SERVER_5');
            $zteServer6 = env('ZTE_SERVER_6');
            $vlan = $zteServer4 . '/vlan';
            $sn = $zteServer5 . '/sn';
            $redaman = $zteServer6 . '/redaman';
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
            session()->forget('sessionOltName');

            $oltSettings = Olt::findOrFail($request->input('selectedValue'));

            // cek koneksi ke ip vps
            $requestData = [
                'host' =>  $oltSettings->host,
                'port' => (int) $oltSettings->port,
                'username' =>  $oltSettings->username,
                'password' =>  $oltSettings->password,
            ];
            $zteServer7 = env('ZTE_SERVER_7');
            $response = Http::post($zteServer7 . '/cek-koneksi', $requestData);
            if ($response->successful()) {
                $data = $response->json();
                if ($data['status'] === true) {
                    session([
                        'sessionOlt' => $oltSettings->id,
                        'sessionOltName' => $oltSettings->name
                    ]);
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

    public function oltReboot(Request $request)
    {
        try {
            $onuId = $request->input('onu_id');
            $oltSettings = Olt::findOrFail(session('sessionOlt'));
            $requestData = [
                'host' => $oltSettings->host,
                'port' => (int) $oltSettings->port,
                'username' => $oltSettings->username,
                'password' => $oltSettings->password,
                'onu_id' =>  $onuId,
            ];

            $client = new \GuzzleHttp\Client();
            $zteServer7 = env('ZTE_SERVER_7');

            $response = $client->post($zteServer7 . '/reboot', [
                'json' => $requestData,
            ]);

            // Check the response from the Telnet server and return a corresponding JSON response
            $responseData = json_decode($response->getBody(), true);
            if ($responseData['status']) {
                return response()->json([
                    'success' => true,
                    'message' => $responseData['message'],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $responseData['message'],
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function oltReset(Request $request)
    {
        try {
            $onuId = $request->input('onu_id');
            $oltSettings = Olt::findOrFail(session('sessionOlt'));
            $requestData = [
                'host' => $oltSettings->host,
                'port' => (int) $oltSettings->port,
                'username' => $oltSettings->username,
                'password' => $oltSettings->password,
                'onu_id' =>  $onuId,
            ];

            $client = new \GuzzleHttp\Client();
            $zteServer7 = env('ZTE_SERVER_7');
            $response = $client->post($zteServer7 . '/reset', [
                'json' => $requestData,
            ]);

            // Check the response from the Telnet server and return a corresponding JSON response
            $responseData = json_decode($response->getBody(), true);
            if ($responseData['status']) {
                return response()->json([
                    'success' => true,
                    'message' => $responseData['message'],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $responseData['message'],
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function oltHapus(Request $request)
    {
        try {
            $onuId = $request->input('onu_id');
            $updatedString = str_replace("onu", "olt", $onuId);
            $number = $request->input('number');
            $oltSettings = Olt::findOrFail(session('sessionOlt'));
            $requestData = [
                'host' => $oltSettings->host,
                'port' => (int) $oltSettings->port,
                'username' => $oltSettings->username,
                'password' => $oltSettings->password,
                'onu_id' =>  $updatedString,
                'number' =>  $number
            ];

            $client = new \GuzzleHttp\Client();
            $zteServer7 = env('ZTE_SERVER_7');
            $response = $client->post($zteServer7 . '/hapus', [
                'json' => $requestData,
            ]);

            // Check the response from the Telnet server and return a corresponding JSON response
            $responseData = json_decode($response->getBody(), true);
            if ($responseData['status']) {
                return response()->json([
                    'success' => true,
                    'message' => $responseData['message'],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $responseData['message'],
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }

    public function getProfile(Request $request)
    {
        $selectedRouter = $request->input('selectedRouter');
        $router = DB::table('settingmikrotiks')->where('id', $selectedRouter)->first();

        if ($router) {
            try {
                $client =  new RouterOSClient([
                    'host' => $router->host,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => (int) $router->port,
                ]);
                $query = new Query('/ppp/profile/print');
                $profile = $client->query($query)->read();
                return response()->json(['success' => true, 'data' => $profile]);
            } catch (\Exception $e) {

                return response()->json(['success' => false, 'error' => $e->getMessage()]);
            }
        }
        return response()->json(['success' => false, 'error' => 'Router not found']);
    }
}
