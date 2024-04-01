<?php

namespace App\Http\Controllers;

use \RouterOS\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $getProfile = (new Query('/ip/hotspot/user/profile/print'))
            ->where('name', $profile);
        $getProfile = $client->query($getProfile)->read();
        // get harga/nilai dari profile
        $ponlogin = isset($getProfile[0]['on-login']) ? $getProfile[0]['on-login'] : '';
        $getexpmode = explode(",", $ponlogin);
        if (isset($getexpmode[2])) {
            if ($getexpmode[2] == '' || $getexpmode[2] == '0') {
                $nilai = 0;
            } else {
                $nilai = $getexpmode[2];
            }
        } else {
            $nilai = 0;
        }

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
        // simpan ke table generate voucher
        $generate_voucher_id = DB::table('generate_voucher')->insertGetId([
            'company_id' => session('sessionCompany'),
            'comment' => $commt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
                $exe = $client->query($query)->read();
                // simpan ke table voucher_hotspot
                if ($exe) {
                    DB::table('voucher_hotspot')->insert([
                        'generate_voucher_id' => $generate_voucher_id,
                        'name' => $u[$i],
                        'password' => $p[$i],
                        'profile' => $profile,
                        'price' => $nilai,
                        'is_aktif' => 'No',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        if ($user == "vc") {
            $shuf = ($userl - $a[$userl]);
            for ($i = 1; $i <= $qty; $i++) {
                if ($char == "lower") {
                    $u[$i] = randLC($shuf);
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
                } elseif ($char == "upper") {
                    $u[$i] = randUC($shuf);
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
                } elseif ($char == "upplow") {
                    $u[$i] = randULC($shuf);
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
                } elseif ($char == "num") {
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
                } elseif ($char == "mix") {
                    $p[$i] = randNLC($userl);
                    $u[$i] = "$prefix$p[$i]";
                } elseif ($char == "mix1") {
                    $p[$i] = randNUC($userl);
                    $u[$i] = "$prefix$p[$i]";
                } elseif ($char == "mix2") {
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
                $exe = $client->query($query)->read();
                if ($exe) {
                    DB::table('voucher_hotspot')->insert([
                        'generate_voucher_id' => $generate_voucher_id,
                        'name' => $u[$i],
                        'password' => $u[$i],
                        'profile' => $profile,
                        'price' =>  $nilai,
                        'is_aktif' => 'No',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        return redirect()
            ->route('hotspotusers.index')
            ->with('success', __('The voucher was created successfully.'));
    }
}
