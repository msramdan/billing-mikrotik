<?php

namespace App\Http\Controllers;

use App\Models\Hotspotuser;
use App\Http\Requests\{StoreHotspotuserRequest, UpdateHotspotuserRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;


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
    public function index()
    {
        if (request()->ajax()) {
            $client = setRoute();
            $query = new Query('/ip/hotspot/user/print');
            $hotspotusers = $client->query($query)->read();
            return DataTables::of($hotspotusers)
                ->addColumn('bytes_out', function ($row) {
                    return formatBytes($row['bytes-out'], 2);
                })
                ->addColumn('bytes_in', function ($row) {
                    return formatBytes($row['bytes-in'], 2);
                })
                ->addColumn('action', 'hotspotusers.include.action')
                ->toJson();
        }

        return view('hotspotusers.index');
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
        $attr = $request->validated();
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

        return redirect()
            ->route('hotspotusers.index')
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
            return redirect()
                ->route('hotspotusers.index')
                ->with('success', __('The Hotspot User was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('hotspotusers.index')
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
        return redirect()
            ->route('hotspotusers.index')
            ->with('success', __('The Hotspot was disable successfully.'));
    }

    public function enable($id)
    {
        $client = setRoute();
        $query = (new Query('/ip/hotspot/user/enable'))
            ->equal('.id', $id);
        $client->query($query)->read();
        return redirect()
            ->route('hotspotusers.index')
            ->with('success', __('The Hotspot was enable successfully.'));
    }

    public function reset($id)
    {
        $client = setRoute();
        $query = (new Query('/ip/hotspot/user/reset-counters'))
            ->equal('.id', $id);
        $client->query($query)->read();
        return redirect()
            ->route('hotspotusers.index')
            ->with('success', __('The Hotspot was reset counter successfully.'));
    }

    public function mikhmon()
    {
        return redirect('/mikhmon');
    }
}
