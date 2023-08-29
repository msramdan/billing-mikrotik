<?php

namespace App\Http\Controllers;

use App\Models\Odp;
use App\Http\Requests\{StoreOdpRequest, UpdateOdpRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;
use Illuminate\Support\Facades\DB;

class OdpController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:odp view')->only('index', 'show');
        $this->middleware('permission:odp create')->only('create', 'store');
        $this->middleware('permission:odp edit')->only('edit', 'update');
        $this->middleware('permission:odp delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $odps = DB::table('odps')
            ->leftJoin('odcs', 'odps.kode_odc', '=', 'odcs.id')
            ->leftJoin('area_coverages', 'odps.wilayah_odp', '=', 'area_coverages.id')
            ->select('odps.*', 'area_coverages.nama', 'odcs.kode_odc')
            ->get();

            return Datatables::of($odps)
                ->addColumn('description', function($row){
                    return str($row->description)->limit(100);
                })
				->addColumn('odc', function ($row) {
                    return $row->kode_odc;
                })->addColumn('area_coverage', function ($row) {
                    return $row->nama;
                })
                ->addColumn('document', function ($row) {
                    if ($row->document == null) {
                    return 'https://via.placeholder.com/350?text=No+Image+Avaiable';
                }
                    return asset('storage/uploads/documents/' . $row->document);
                })

                ->addColumn('action', 'odps.include.action')
                ->toJson();
        }

        return view('odps.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('odps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOdpRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('document') && $request->file('document')->isValid()) {

            $path = storage_path('app/public/uploads/documents/');
            $filename = $request->file('document')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('document')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            $attr['document'] = $filename;
        }

        Odp::create($attr);

        return redirect()
            ->route('odps.index')
            ->with('success', __('The odp was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Odp $odp
     * @return \Illuminate\Http\Response
     */
    public function show(Odp $odp)
    {
        $odp->load('odc:id,kode_odc', 'area_coverage:id,kode_area');

		return view('odps.show', compact('odp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Odp $odp
     * @return \Illuminate\Http\Response
     */
    public function edit(Odp $odp)
    {
        $odp->load('odc:id,kode_odc', 'area_coverage:id,kode_area');

		return view('odps.edit', compact('odp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Odp $odp
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOdpRequest $request, Odp $odp)
    {
        $attr = $request->validated();

        if ($request->file('document') && $request->file('document')->isValid()) {

            $path = storage_path('app/public/uploads/documents/');
            $filename = $request->file('document')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('document')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            // delete old document from storage
            if ($odp->document != null && file_exists($path . $odp->document)) {
                unlink($path . $odp->document);
            }

            $attr['document'] = $filename;
        }

        $odp->update($attr);

        return redirect()
            ->route('odps.index')
            ->with('success', __('The odp was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Odp $odp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Odp $odp)
    {
        try {
            $path = storage_path('app/public/uploads/documents/');

            if ($odp->document != null && file_exists($path . $odp->document)) {
                unlink($path . $odp->document);
            }

            $odp->delete();

            return redirect()
                ->route('odps.index')
                ->with('success', __('The odp was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('odps.index')
                ->with('error', __("The odp can't be deleted because it's related to another table."));
        }
    }
}
