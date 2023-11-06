<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpseclib3\Net\SSH2;

class OltController extends Controller
{
    public function getOnuList()
    {
        define('NET_SSH2_LOGGING', 2);
        $host = '103.122.65.234';
        $port = 85;
        $username = 'zte';
        $password = 'zte';

        $ssh = new SSH2($host, $port);
        if (!$ssh->login($username, $password)) {
            return response()->json(['error' => 'Login Failed'], 500);
        }

        // Execute commands to get the list of ONUs
        $command = 'show gpon onu state';
        $output = $ssh->exec($command);
        $ssh->disconnect();
        // Process $output to extract the list of ONUs
        // Parse $output based on the format of the 'show onu' command response

        $onuList = []; // Your parsed ONU list
        dd($command);

        return response()->json(['onuList' => $onuList]);
    }
}
