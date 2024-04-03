<?php

namespace App\Http\Controllers;

use App\Models\Hotspotuser;
use App\Http\Requests\{StoreHotspotuserRequest, UpdateHotspotuserRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HotspotuserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:hotspotuser view')->only('index', 'show');
        $this->middleware('permission:hotspotuser create')->only('create', 'store');
        $this->middleware('permission:hotspotuser edit')->only('edit', 'update');
        $this->middleware('permission:hotspotuser delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter_profile = request()->query('filter_profile');
        $filter_comment = request()->query('filter_comment');
        $client = setRoute();
        if (isset($filter_profile) && !empty($filter_profile)) {
            $query = (new Query('/ip/hotspot/user/print'))
                ->where('profile', $filter_profile);
        } else if (isset($filter_comment) && !empty($filter_comment)) {
            $query = (new Query('/ip/hotspot/user/print'))
                ->where('comment', $filter_comment);
        } else {
            $query = new Query('/ip/hotspot/user/print');
        }
        $hotspotusers = $client->query($query)->read();
        $client = setRoute();
        $query = new Query('/ip/hotspot/user/profile/print');
        $getprofile = $client->query($query)->read();
        return view('hotspotusers.index', [
            'hotspotusers' => $hotspotusers,
            'getprofile' => $getprofile,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $client = setRoute();
        $hotspotprofile = new Query('/ip/hotspot/user/profile/print');
        $hotspotprofile = $client->query($hotspotprofile)->read();
        $hotspotserver = new Query('/ip/hotspot/print');
        $hotspotserver = $client->query($hotspotserver)->read();
        return view('hotspotusers.create', [
            'hotspotprofile' => $hotspotprofile,
            'hotspotserver' => $hotspotserver,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHotspotuserRequest $request)
    {
        $client = setRoute();
        $query = (new Query('/ip/hotspot/user/add'))
            ->equal('name',  $request->name)
            ->equal('password', $request->password)
            ->equal('profile', $request->profile)
            ->equal('server', $request->server_hotspot)
            ->equal('comment', $request->comment);
        $client->query($query)->read();
        return redirect()
            ->route('hotspotusers.index')
            ->with('success', __('The Hotspot User was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotspotuser  $hotspotuser
     * @return \Illuminate\Http\Response
     */
    public function show(Hotspotuser $hotspotuser)
    {
        return view('hotspotusers.show', compact('hotspotuser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotspotuser  $hotspotuser
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = setRoute();
        $query = (new Query('/ip/hotspot/user/print'))
            ->where('.id', $id);
        $hotspotuser = $client->query($query)->read();

        $hotspotprofile = new Query('/ip/hotspot/user/profile/print');
        $hotspotprofile = $client->query($hotspotprofile)->read();

        $hotspotserver = new Query('/ip/hotspot/print');
        $hotspotserver = $client->query($hotspotserver)->read();
        return view('hotspotusers.edit', [
            'hotspotuser' => $hotspotuser,
            'hotspotprofile' => $hotspotprofile,
            'hotspotserver' => $hotspotserver,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotspotuser  $hotspotuser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHotspotuserRequest $request, Hotspotuser $hotspotuser)
    {
        $hotspotuser->update($request->validated());
        return redirect()->back()
            ->with('success', __('The Hotspot User was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotspotuser  $hotspotuser
     * @return \Illuminate\Http\Response
     */
    public function deleteHotspot($id, $user)
    {
        try {
            $client = setRoute();
            $queryDelete = (new Query('/ip/hotspot/user/remove'))
                ->equal('.id',  $id);
            $client->query($queryDelete)->read();

            $queryGet = (new Query('/ip/hotspot/active/print'))
                ->where('user', $user);
            $data = $client->query($queryGet)->read();
            if ($data) {
                $idActive = $data[0]['.id'];
                $queryDelete = (new Query('/ip/hotspot/active/remove'))
                    ->equal('.id', $idActive);
                $client->query($queryDelete)->read();
            }
            return redirect()->back()->with('success', __('The Hotspot User was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', __("The Hotspot User can't be deleted because it's related to another table."));
        }
    }

    public function disable($id, $user)
    {
        $client = setRoute();
        // set disable
        $queryDisable = (new Query('/ip/hotspot/user/disable'))
            ->equal('.id', $id);
        $client->query($queryDisable)->read();
        // get name
        $queryGet = (new Query('/ip/hotspot/active/print'))
            ->where('user', $user);
        $data = $client->query($queryGet)->read();
        if ($data) {
            $idActive = $data[0]['.id'];
            $queryDelete = (new Query('/ip/hotspot/active/remove'))
                ->equal('.id', $idActive);
            $client->query($queryDelete)->read();
        }
        return redirect()->back()
            ->with('success', __('The Hotspot was disable successfully.'));
    }

    public function enable($id)
    {
        $client = setRoute();
        $query = (new Query('/ip/hotspot/user/enable'))
            ->equal('.id', $id);
        $client->query($query)->read();
        return redirect()->back()
            ->with('success', __('The Hotspot was enable successfully.'));
    }

    public function reset($id)
    {
        $client = setRoute();
        $query = (new Query('/ip/hotspot/user/reset-counters'))
            ->equal('.id', $id);
        $client->query($query)->read();
        return redirect()->back()
            ->with('success', __('The Hotspot was reset counter successfully.'));
    }

    public function cetakVoucher()
    {
        $client = setRoute();
        $query = (new Query('/ip/hotspot/user/print'))
            ->where('comment', request()->query('filter_comment'))
            ->where('uptime', "0s");
        $hotspotusers = $client->query($query)->read();



        $getuprofile = $hotspotusers[0]['profile'];

        $getProfile = (new Query('/ip/hotspot/user/profile/print'))
            ->where('name', $getuprofile);
        $getProfile = $client->query($getProfile)->read();
        $ponlogin = isset($getProfile[0]['on-login']) ? $getProfile[0]['on-login'] : '';
        $getexpmode = explode(",", $ponlogin);
        if (isset($getexpmode[4])) {
            if ($getexpmode[4] == '' || $getexpmode[4] == '0') {
                $seller_price = 0;
            } else {
                $seller_price = $getexpmode[2];
            }
        } else {
            $seller_price = 0;
        }

        $validity = isset($getexpmode[3]) ? $getexpmode[3] : '';
        return view('vouchers.print', [
            'company' => getCompany(),
            'seller_price' => $seller_price,
            'validity' => $validity,
            'timelimit' =>'',
            'datalimit' =>'',
            'hotspotusers' => $hotspotusers
        ]);
    }

    public function deleteByComment()
    {
        $comment = request()->query('filter_comment');
        $client = setRoute();

        // Hapus data dari tabel generate_voucher
        $deletedVoucherCount = DB::table('generate_voucher')
            ->where('comment', $comment)
            ->delete();

        // Jika ada data yang dihapus, lanjutkan dengan menghapus pengguna hotspot
        if ($deletedVoucherCount > 0) {
            $query = (new Query('/ip/hotspot/user/print'))
                ->where('comment', $comment)
                ->where('uptime', "00:00:00");
            $getList = $client->query($query)->read();
            $deletedUsersCount = 0;

            // Hapus pengguna hotspot
            for ($i = 0; $i < count($getList); $i++) {
                $userdetails = $getList[$i];
                $uid = $userdetails['.id'];
                $query = (new Query('/ip/hotspot/user/remove'))
                    ->equal('.id', $uid);
                $client->query($query)->read();
                $deletedUsersCount++;
            }

            return response()->json([
                'message' => 'Deleted ' . $deletedVoucherCount . ' vouchers and ' . $deletedUsersCount . ' users successfully.'
            ]);
        }
        // Jika tidak ada data yang dihapus dari tabel generate_voucher
        return response()->json([
            'message' => 'No vouchers deleted for the given comment.'
        ]);
    }
}
