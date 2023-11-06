<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpseclib3\Net\SNMP;

class OltController extends Controller
{
    public function getOnuList()
    {
        // SNMP Configuration
        $hostname = '103.122.65.234'; // IP address of the device
        $community = 'your_snmp_community'; // SNMP community string

        // SNMP Command
        $oid = '1.3.6.1.4.1.3902.1012.3.28.1.1.6'; // Replace with the actual OID for "show gpon onu uncf"

        // SNMP Get
        $snmp = new SNMP(SNMP::VERSION_2C, $hostname, $community);
        $result = $snmp->get($oid);

        // Display result
        return response()->json(['snmp_result' => $result]);
    }
}
