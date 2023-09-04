<?php

namespace App\Http\Controllers;

use App\Models\Odc;
use App\Http\Requests\{StoreOdcRequest, UpdateOdcRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;
use Illuminate\Support\Facades\DB;

class OdcController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:odc view')->only('index', 'show');
        $this->middleware('permission:odc create')->only('create', 'store');
        $this->middleware('permission:odc edit')->only('edit', 'update');
        $this->middleware('permission:odc delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $odcs = DB::table('odcs')
            ->leftJoin('area_coverages', 'odcs.wilayah_odc', '=', 'area_coverages.id')
            ->select('odcs.*', 'area_coverages.nama')
            ->get();

            return Datatables::of($odcs)
                ->addColumn('description', function($row){
                    return str($row->description)->limit(100);
                })
				->addColumn('area_coverage', function ($row) {
                    return $row->nama;
                })

                ->addColumn('action', 'odcs.include.action')
                ->toJson();
        }

        return view('odcs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('odcs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOdcRequest $request)
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

        Odc::create($attr);

        return redirect()
            ->route('odcs.index')
            ->with('success', __('The odc was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Odc $odc
     * @return \Illuminate\Http\Response
     */
    public function show(Odc $odc)
    {
        $odc->load('area_coverage:id,kode_area');

		return view('odcs.show', compact('odc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Odc $odc
     * @return \Illuminate\Http\Response
     */
    public function edit(Odc $odc)
    {
        $odc->load('area_coverage:id,kode_area');

		return view('odcs.edit', compact('odc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Odc $odc
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOdcRequest $request, Odc $odc)
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
            if ($odc->document != null && file_exists($path . $odc->document)) {
                unlink($path . $odc->document);
            }

            $attr['document'] = $filename;
        }

        $odc->update($attr);

        return redirect()
            ->route('odcs.index')
            ->with('success', __('The odc was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Odc $odc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Odc $odc)
    {
        try {
            $path = storage_path('app/public/uploads/documents/');

            if ($odc->document != null && file_exists($path . $odc->document)) {
                unlink($path . $odc->document);
            }

            $odc->delete();

            return redirect()
                ->route('odcs.index')
                ->with('success', __('The odc was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('odcs.index')
                ->with('error', __("The odc can't be deleted because it's related to another table."));
        }
    }

    public function odc($id)
    {
        $data = DB::table('odcs')->where('wilayah_odc', $id)->get();
        $message = 'Berhasil mengambil data kota';
        return response()->json(compact('message', 'data'));
    }

}
