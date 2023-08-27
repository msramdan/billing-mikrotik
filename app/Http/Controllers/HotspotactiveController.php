<?php

namespace App\Http\Controllers;

use App\Models\Hotspotactive;
use App\Http\Requests\{StoreHotspotactiveRequest, UpdateHotspotactiveRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;

class HotspotactiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:hotspotactive view')->only('index', 'show');
        $this->middleware('permission:hotspotactive create')->only('create', 'store');
        $this->middleware('permission:hotspotactive edit')->only('edit', 'update');
        $this->middleware('permission:hotspotactive delete')->only('destroy');
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
            $query = new Query('/ip/hotspot/active/print');
            $hotspotactives = $client->query($query)->read();

            return DataTables::of($hotspotactives)
                ->addColumn('action', 'hotspotactives.include.action')
                ->toJson();
        }

        return view('hotspotactives.index');
    }


    public function destroy(Hotspotactive $hotspotactive)
    {
        try {
            $hotspotactive->delete();

            return redirect()
                ->route('hotspotactives.index')
                ->with('success', __('The hotspotactive was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('hotspotactives.index')
                ->with('error', __("The hotspotactive can't be deleted because it's related to another table."));
        }
    }
}
