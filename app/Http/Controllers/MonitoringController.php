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
        $hasil = oltExec();
        $list_olt = $hasil['list_olt'];
        $list_uncf = $hasil['uncf']->data;
        $result = self::processOnuData($hasil['status']->data);
        return view('monitorings.index', [
            'olts' => Olt::where('company_id', session('sessionCompany'))->get(),
            'list_olt' => $list_olt,
            'online' =>  $hasil['workingCount'],
            'offline' => count($list_olt) - $hasil['workingCount'],
            'list_uncf' =>  $list_uncf,
            'total_auth' =>  count($list_olt),
            'uncf' =>  count($list_uncf),
            'groupedCounts' => $hasil['groupedCounts'],
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
                'port' => (int) $oltSettings->telnet_port,
                'username' => $oltSettings->telnet_username,
                'password' => $oltSettings->telnet_password,
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
                'port' => (int) $oltSettings->telnet_port,
                'username' =>  $oltSettings->telnet_username,
                'password' =>  $oltSettings->telnet_password,
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
                'port' => (int) $oltSettings->telnet_port,
                'username' => $oltSettings->telnet_username,
                'password' => $oltSettings->telnet_password,
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
                'port' => (int) $oltSettings->telnet_port,
                'username' => $oltSettings->telnet_username,
                'password' => $oltSettings->telnet_password,
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
                'port' => (int) $oltSettings->telnet_port,
                'username' => $oltSettings->telnet_username,
                'password' => $oltSettings->telnet_password,
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


    public function onuType(Request $request)
    {
        try {
            $oltSettings = Olt::findOrFail(session('sessionOlt'));
            $requestData = [
                'host' => $oltSettings->host,
                'port' => (int) $oltSettings->telnet_port,
                'username' => $oltSettings->telnet_username,
                'password' => $oltSettings->telnet_password,
            ];

            $client = new \GuzzleHttp\Client();
            $zteServer8 = env('ZTE_SERVER_8');
            $response = $client->post($zteServer8 . '/onu-type', [
                'json' => $requestData,
            ]);

            $responseData = json_decode($response->getBody(), true);
            if ($responseData['status']) {
                return response()->json([
                    'success' => true,
                    'message' => $responseData['message'],
                    'data' => $responseData['data'],
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

    public function tCon(Request $request)
    {
        try {
            $oltSettings = Olt::findOrFail(session('sessionOlt'));
            $requestData = [
                'host' => $oltSettings->host,
                'port' => (int) $oltSettings->telnet_port,
                'username' => $oltSettings->telnet_username,
                'password' => $oltSettings->telnet_password,
            ];

            $client = new \GuzzleHttp\Client();
            $zteServer9 = env('ZTE_SERVER_9');
            $response = $client->post($zteServer9 . '/tcon', [
                'json' => $requestData,
            ]);

            $responseData = json_decode($response->getBody(), true);
            if ($responseData['status']) {
                return response()->json([
                    'success' => true,
                    'message' => $responseData['message'],
                    'data' => $responseData['data'],
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

    public function vlanProfile(Request $request)
    {
        try {
            $oltSettings = Olt::findOrFail(session('sessionOlt'));
            $requestData = [
                'host' => $oltSettings->host,
                'port' => (int) $oltSettings->telnet_port,
                'username' => $oltSettings->telnet_username,
                'password' => $oltSettings->telnet_password,
            ];

            $client = new \GuzzleHttp\Client();
            $zteServer10 = env('ZTE_SERVER_10');
            $response = $client->post($zteServer10 . '/profile-vlan', [
                'json' => $requestData,
            ]);

            $responseData = json_decode($response->getBody(), true);
            if ($responseData['status']) {
                return response()->json([
                    'success' => true,
                    'message' => $responseData['message'],
                    'data' => $responseData['data'],
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

    public function registerOnu(Request $request)
    {
        $client = setRoute();
        $queryAdd = (new Query('/ppp/secret/add'))
            ->equal('name', $request->modal_username)
            ->equal('password', $request->modal_password)
            ->equal('service', 'pppoe')
            ->equal('profile', $request->modal_profile_router)
            ->equal('comment',  '');
        $status = $client->query($queryAdd)->read();
        $cek  =  $status['after'];
        if (array_key_exists("ret", $cek)) {
            $oltSettings = Olt::findOrFail(session('sessionOlt'));
            $result = str_replace("gpon-onu_", "", $request->modal_interface);
            $requestData = [
                'host' => $oltSettings->host,
                'port' => (int) $oltSettings->telnet_port,
                'username' => $oltSettings->telnet_username,
                'password' => $oltSettings->telnet_password,
                "interface" => $result,
                "index" => $request->modal_index,
                "onu_type" => $request->modal_onu_type,
                "sn" => $request->modal_sn,
                "tcon_profile" => $request->modal_tcon,
                "onu_name" => $request->modal_onu_name,
                "cvlan" => $request->modal_cvlan,
                "service_port2" => $request->modal_service_port2,
                "pppoe_username" => $request->modal_username,
                "pppoe_password" => $request->modal_password,
                "profile_vlan" => $request->modal_profile_vlan,
                "wifi_port" => $request->modal_port_wifi,
                "eth1" => $request->modal_port_eht1,
                "eth2" => $request->modal_port_eht2
            ];

            $client = new \GuzzleHttp\Client();
            $zteServer11 = env('ZTE_SERVER_11');
            $response = $client->post($zteServer11 . '/register', [
                'json' => $requestData,
            ]);
            $responseData = json_decode($response->getBody(), true);
            if ($responseData['status']) {
                return redirect()
                    ->route('monitorings.index')
                    ->with('success', __('Submit ONU successfully.'));
            } else {
                return redirect()
                    ->route('monitorings.index')
                    ->with('error', __('Ada error register.'));
            }
        } else {
            return redirect()
                ->route('monitorings.index')
                ->with('error', __($status['after']['message']));
        }
    }
}
