<?php

namespace App\Http\Controllers;

use \RouterOS\Query;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:voucher view')->only('index');
        $this->middleware('permission:voucher create')->only('create');
    }

    public function create()
    {
        $client = setRoute();
        $hotspotprofile = new Query('/ip/hotspot/user/profile/print');
        $hotspotprofile = $client->query($hotspotprofile)->read();
        $srvlist = new Query('/ip/hotspot/print');
        $srvlist = $client->query($srvlist)->read();

        $hotspotprofile = new Query('/ip/hotspot/user/profile/print');
        $hotspotprofile = $client->query($hotspotprofile)->read();
        return view('vouchers.create', [
            'srvlist' => $srvlist,
            'getprofile' => $hotspotprofile
        ]);
    }

    public function store(Request $request)
    {
        $client = setRoute();
        $qty = ($_POST['qty']);
        $server = ($_POST['server']);
        $user = ($_POST['user']);
        $userl = ($_POST['userl']);
        $prefix = ($_POST['prefix']);
        $char = ($_POST['char']);
        $profile = ($_POST['profile']);
        $timelimit = ($_POST['timelimit']);
        $datalimit = ($_POST['datalimit']);
        $adcomment = ($_POST['adcomment']);
        $mbgb = ($_POST['mbgb']);
        if ($timelimit == "") {
            $timelimit = "0";
        } else {
            $timelimit = $timelimit;
        }
        if ($datalimit == "") {
            $datalimit = "0";
        } else {
            $datalimit = $datalimit * $mbgb;
        }
        if ($adcomment == "") {
            $adcomment = "";
        } else {
            $adcomment = $adcomment;
        }

        $commt = $user . "-" . rand(100, 999) . "-" . date("m.d.y") . "-" . $adcomment;

        $a = array("1" => "", "", 1, 2, 2, 3, 3, 4);
        if ($user == "up") {
            for ($i = 1; $i <= $qty; $i++) {
                if ($char == "lower") {
                    $u[$i] = randLC($userl);
                } elseif ($char == "upper") {
                    $u[$i] = randUC($userl);
                } elseif ($char == "upplow") {
                    $u[$i] = randULC($userl);
                } elseif ($char == "mix") {
                    $u[$i] = randNLC($userl);
                } elseif ($char == "mix1") {
                    $u[$i] = randNUC($userl);
                } elseif ($char == "mix2") {
                    $u[$i] = randNULC($userl);
                }
                if ($userl == 3) {
                    $p[$i] = randN(3);
                } elseif ($userl == 4) {
                    $p[$i] = randN(4);
                } elseif ($userl == 5) {
                    $p[$i] = randN(5);
                } elseif ($userl == 6) {
                    $p[$i] = randN(6);
                } elseif ($userl == 7) {
                    $p[$i] = randN(7);
                } elseif ($userl == 8) {
                    $p[$i] = randN(8);
                }

                $u[$i] = "$prefix$u[$i]";
            }
            for ($i = 1; $i <= $qty; $i++) {
                $query = (new Query('/ip/hotspot/user/add'))
                    ->equal('server', $server)
                    ->equal('name',  $u[$i])
                    ->equal('password', $p[$i])
                    ->equal('profile', $profile)
                    ->equal('limit-uptime', $timelimit)
                    ->equal('limit-bytes-total', $datalimit)
                    ->equal('comment', $commt);
                $client->query($query)->read();
            }
        }
        if ($user == "vc") {
            $shuf = ($userl - $a[$userl]);
            for ($i = 1; $i <= $qty; $i++) {
                if ($char == "lower") {
                    $u[$i] = randLC($shuf);
                } elseif ($char == "upper") {
                    $u[$i] = randUC($shuf);
                } elseif ($char == "upplow") {
                    $u[$i] = randULC($shuf);
                }
                if ($userl == 3) {
                    $p[$i] = randN(1);
                } elseif ($userl == 4 || $userl == 5) {
                    $p[$i] = randN(2);
                } elseif ($userl == 6 || $userl == 7) {
                    $p[$i] = randN(3);
                } elseif ($userl == 8) {
                    $p[$i] = randN(4);
                }

                $u[$i] = "$prefix$u[$i]$p[$i]";
                if ($char == "num") {
                    if ($userl == 3) {
                        $p[$i] = randN(3);
                    } elseif ($userl == 4) {
                        $p[$i] = randN(4);
                    } elseif ($userl == 5) {
                        $p[$i] = randN(5);
                    } elseif ($userl == 6) {
                        $p[$i] = randN(6);
                    } elseif ($userl == 7) {
                        $p[$i] = randN(7);
                    } elseif ($userl == 8) {
                        $p[$i] = randN(8);
                    }

                    $u[$i] = "$prefix$p[$i]";
                }
                if ($char == "mix") {
                    $p[$i] = randNLC($userl);


                    $u[$i] = "$prefix$p[$i]";
                }
                if ($char == "mix1") {
                    $p[$i] = randNUC($userl);


                    $u[$i] = "$prefix$p[$i]";
                }
                if ($char == "mix2") {
                    $p[$i] = randNULC($userl);


                    $u[$i] = "$prefix$p[$i]";
                }
            }
            for ($i = 1; $i <= $qty; $i++) {

                $query = (new Query('/ip/hotspot/user/add'))
                    ->equal('server', $server)
                    ->equal('name',  $u[$i])
                    ->equal('password', $u[$i])
                    ->equal('profile', $profile)
                    ->equal('limit-uptime', $timelimit)
                    ->equal('limit-bytes-total', $datalimit)
                    ->equal('comment', $commt);
                $client->query($query)->read();
            }
        }
        return redirect()
            ->route('hotspotusers.index')
            ->with('success', __('The voucher was created successfully.'));
    }
}
