<?php

namespace App\Http\Controllers;

use App\Models\Hotspotprofile;
use App\Http\Requests\{StoreHotspotprofileRequest, UpdateHotspotprofileRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;
use Illuminate\Http\Request;

class HotspotprofileController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:hotspotprofile view')->only('index', 'show');
        $this->middleware('permission:hotspotprofile create')->only('create', 'store');
        $this->middleware('permission:hotspotprofile edit')->only('edit', 'update');
        $this->middleware('permission:hotspotprofile delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $client = setRoute();
            $query = new Query('/ip/hotspot/user/profile/print');
            $hotspotprofiles = $client->query($query)->read();
            return DataTables::of($hotspotprofiles)
                ->addColumn('expmode', function ($row) {
                    $ponlogin = isset($row['on-login']) ? $row['on-login'] : '';
                    $getexpmode = explode(",", $ponlogin);
                    $expmode = isset($getexpmode[1]) ? $getexpmode[1] : '';
                    if ($expmode == "rem") {
                        return 'Remove';
                    } elseif ($expmode == "ntf") {
                        return 'Notice';
                    } elseif ($expmode == "remc") {
                        return 'Remove & Record';
                    } elseif ($expmode == "ntfc") {
                        return 'Notice & Record';
                    } else {
                        return '';
                    }
                })
                ->addColumn('validity', function ($row) {
                    $ponlogin = isset($row['on-login']) ? $row['on-login'] : '';
                    $getexpmode = explode(",", $ponlogin);
                    return isset($getexpmode[3]) ? $getexpmode[3] : '';
                })
                ->addColumn('lock', function ($row) {
                    $ponlogin = isset($row['on-login']) ? $row['on-login'] : '';
                    $getexpmode = explode(",", $ponlogin);
                    return isset($getexpmode[6]) ? $getexpmode[6] : '';
                })

                ->addColumn('price', function ($row) {
                    $ponlogin = isset($row['on-login']) ? $row['on-login'] : '';
                    $getexpmode = explode(",", $ponlogin);
                    if (isset($getexpmode[2])) {
                        if ($getexpmode[2] == '' || $getexpmode[2] == '0') {
                            $nilai = '';
                        } else {
                            $nilai = rupiah($getexpmode[2]);
                        }
                    } else {
                        $nilai = '';
                    }
                    return $nilai;
                })

                ->addColumn('selling', function ($row) {
                    $ponlogin = isset($row['on-login']) ? $row['on-login'] : '';
                    $getexpmode = explode(",", $ponlogin);
                    if (isset($getexpmode[4])) {
                        if ($getexpmode[4] == '' || $getexpmode[4] == '0') {
                            $nilai = '';
                        } else {
                            $nilai = rupiah($getexpmode[4]);
                        }
                    } else {
                        $nilai = '';
                    }
                    return $nilai;
                })

                ->addColumn('rate-limit', function ($row) {
                    return isset($row['rate-limit']) ? $row['rate-limit'] : '';
                })
                ->addColumn('action', 'hotspotprofiles.include.action')
                ->toJson();
        }
        return view('hotspotprofiles.index');
    }

    public function create()
    {
        $client = setRoute();
        $query = (new Query('/queue/simple/print'))
            ->where('dynamic', 'false');
        $getallqueue = $client->query($query)->read();

        $getpool = new Query('/ip/pool/print');
        $getpool = $client->query($getpool)->read();
        return view('hotspotprofiles.create', [
            'getallqueue' => $getallqueue,
            'getpool' => $getpool
        ]);
    }

    public function store(Request $request)
    {
        $name = $_POST['name'];
        $sharedusers = ($_POST['sharedusers']);
        $ratelimit = ($_POST['ratelimit']);
        $expmode = ($_POST['expmode']);
        $validity = ($_POST['validity']);
        $getprice = ($_POST['price']);
        $getsprice = ($_POST['sprice']);
        $addrpool = ($_POST['ppool']);

        if ($getprice == "") {
            $price = "0";
        } else {
            $price = $getprice;
        }
        if ($getsprice == "") {
            $sprice = "0";
        } else {
            $sprice = $getsprice;
        }
        $getlock = ($_POST['lockunlock']);
        if ($getlock == "Enable") {
            $lock = '; [:local mac $"mac-address"; /ip hotspot user set mac-address=$mac [find where name=$user]]';
        } else {
            $lock = "";
        }

        $randstarttime = "0" . rand(1, 5) . ":" . rand(10, 59) . ":" . rand(10, 59);
        $randinterval = "00:02:" . rand(10, 59);

        $parent = ($_POST['parent']);

        $record = '; :local mac $"mac-address"; :local time [/system clock get time ]; /system script add name="$date-|-$time-|-$user-|-' . $price . '-|-$address-|-$mac-|-' . $validity . '-|-' . $name . '-|-$comment" owner="$month$year" source="$date" comment="mikhmon"';

        $onlogin = ':put (",' . $expmode . ',' . $price . ',' . $validity . ',' . $sprice . ',,' . $getlock . ',"); {:local comment [ /ip hotspot user get [/ip hotspot user find where name="$user"] comment]; :local ucode [:pic $comment 0 2]; :if ($ucode = "vc" or $ucode = "up" or $comment = "") do={ :local date [ /system clock get date ];:local year [ :pick $date 7 11 ];:local month [ :pick $date 0 3 ]; /sys sch add name="$user" disable=no start-date=$date interval="' . $validity . '"; :delay 5s; :local exp [ /sys sch get [ /sys sch find where name="$user" ] next-run]; :local getxp [len $exp]; :if ($getxp = 15) do={ :local d [:pic $exp 0 6]; :local t [:pic $exp 7 16]; :local s ("/"); :local exp ("$d$s$year $t"); /ip hotspot user set comment="$exp" [find where name="$user"];}; :if ($getxp = 8) do={ /ip hotspot user set comment="$date $exp" [find where name="$user"];}; :if ($getxp > 15) do={ /ip hotspot user set comment="$exp" [find where name="$user"];};:delay 5s; /sys sch remove [find where name="$user"]';

        if ($expmode == "rem") {
            $onlogin = $onlogin . $lock . "}}";
            $mode = "remove";
        } elseif ($expmode == "ntf") {
            $onlogin = $onlogin . $lock . "}}";
            $mode = "set limit-uptime=1s";
        } elseif ($expmode == "remc") {
            $onlogin = $onlogin . $record . $lock . "}}";
            $mode = "remove";
        } elseif ($expmode == "ntfc") {
            $onlogin = $onlogin . $record . $lock . "}}";
            $mode = "set limit-uptime=1s";
        } elseif ($expmode == "0" && $price != "") {
            $onlogin = ':put (",,' . $price . ',,,noexp,' . $getlock . ',")' . $lock;
        } else {
            $onlogin = "";
        }

        $client = setRoute();
        $queryAdd = (new Query('/ip/hotspot/user/profile/add'))
            ->equal('name', $name)
            ->equal('address-pool', $addrpool)
            ->equal('rate-limit', $ratelimit)
            ->equal('shared-users', $sharedusers)
            ->equal('status-autorefresh',  "1m")
            ->equal('on-login',  $onlogin)
            ->equal('parent-queue',  $parent);
        $client->query($queryAdd)->read();

        if ($expmode != "0") {
            $bgservice = ':local dateint do={:local montharray ( "jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec" );:local days [ :pick $d 4 6 ];:local month [ :pick $d 0 3 ];:local year [ :pick $d 7 11 ];:local monthint ([ :find $montharray $month]);:local month ($monthint + 1);:if ( [len $month] = 1) do={:local zero ("0");:return [:tonum ("$year$zero$month$days")];} else={:return [:tonum ("$year$month$days")];}}; :local timeint do={ :local hours [ :pick $t 0 2 ]; :local minutes [ :pick $t 3 5 ]; :return ($hours * 60 + $minutes) ; }; :local date [ /system clock get date ]; :local time [ /system clock get time ]; :local today [$dateint d=$date] ; :local curtime [$timeint t=$time] ; :foreach i in [ /ip hotspot user find where profile="' . $name . '" ] do={ :local comment [ /ip hotspot user get $i comment]; :local name [ /ip hotspot user get $i name]; :local gettime [:pic $comment 12 20]; :if ([:pic $comment 3] = "/" and [:pic $comment 6] = "/") do={:local expd [$dateint d=$comment] ; :local expt [$timeint t=$gettime] ; :if (($expd < $today and $expt < $curtime) or ($expd < $today and $expt > $curtime) or ($expd = $today and $expt < $curtime)) do={ [ /ip hotspot user ' . $mode . ' $i ]; [ /ip hotspot active remove [find where user=$name] ];}}}';
            $schedulerAdd = (new Query('/system/scheduler/add'))
                ->equal('name', $name)
                ->equal('start-time', $randstarttime)
                ->equal('interval', $randinterval)
                ->equal('on-event', $bgservice)
                ->equal('disabled',  "no")
                ->equal('comment',  "Monitor Profile $name");
            $client->query($schedulerAdd)->read();
        }
        return redirect()
            ->route('hotspotprofiles.index')
            ->with('success', __('The hotspot profile was created successfully.'));
    }


    public function showDetail($name)
    {
        $client = setRoute();
        $query = (new Query('/ip/hotspot/user/print'))
            ->where('profile', $name);
        $counttuser = $client->query($query)->read();
        return view('hotspotprofiles.show', [
            'counttuser' => $counttuser,
            'name' => $name
        ]);
    }

    public function enable($id)
    {
        $client = setRoute();
        $queryAdd = (new Query('/ip/hotspot/user/set'))
            ->equal('.id', $id)
            ->equal('disabled', "no");
        $client->query($queryAdd)->read();
        return redirect()->back()->with('success', __('Enabled hotspot profile was successfully.'));
    }

    public function disable($id)
    {
        $client = setRoute();
        $queryAdd = (new Query('/ip/hotspot/user/set'))
            ->equal('.id', $id)
            ->equal('disabled', "yes");
        $client->query($queryAdd)->read();
        return redirect()->back()->with('success', __('Disabled hotspot profile was successfully.'));
    }


    public function edit(Hotspotprofile $hotspotprofile)
    {
        return view('hotspotprofiles.edit', compact('hotspotprofile'));
    }

    public function update(UpdateHotspotprofileRequest $request, Hotspotprofile $hotspotprofile)
    {

        $hotspotprofile->update($request->validated());

        return redirect()
            ->route('hotspotprofiles.index')
            ->with('success', __('The hotspotprofile was updated successfully.'));
    }

    public function deleteSecret($id, $name)
    {
        try {
            $client = setRoute();
            // remove profile
            $removeProfile = (new Query('/ip/hotspot/user/profile/remove'))
                ->equal('.id', $id);
            $client->query($removeProfile)->read();

            $queryGet = (new Query('/system/scheduler/print'))
                ->where('name', $name);
            $data = $client->query($queryGet)->read();
            if ($data) {
                // remove scheduler
                $idActive = $data[0]['.id'];
                $removeProfile = (new Query('/system/scheduler/remove'))
                    ->equal('.id', $idActive);
                $client->query($removeProfile)->read();
            }
            return redirect()
                ->route('hotspotprofiles.index')
                ->with('success', __('The hotspot profile was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('hotspotprofiles.index')
                ->with('error', __("The hotspot profile can't be deleted because it's related to another table."));
        }
    }
}
