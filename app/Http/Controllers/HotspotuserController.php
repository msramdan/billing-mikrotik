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
        return view('hotspotusers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHotspotuserRequest $request)
    {

        Hotspotuser::create($request->validated());

        return redirect()
            ->route('hotspotusers.index')
            ->with('success', __('The hotspotuser was created successfully.'));
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
    public function edit(Hotspotuser $hotspotuser)
    {
        return view('hotspotusers.edit', compact('hotspotuser'));
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
            ->with('success', __('The hotspotuser was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotspotuser  $hotspotuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotspotuser $hotspotuser)
    {
        try {
            $hotspotuser->delete();

            return redirect()
                ->route('hotspotusers.index')
                ->with('success', __('The hotspotuser was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('hotspotusers.index')
                ->with('error', __("The hotspotuser can't be deleted because it's related to another table."));
        }
    }
}
