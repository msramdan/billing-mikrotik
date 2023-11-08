<?php

namespace App\Http\Controllers;

use App\Models\AreaCoverage;
use App\Http\Requests\{StoreAreaCoverageRequest, UpdateAreaCoverageRequest};
use Yajra\DataTables\Facades\DataTables;

class AreaCoverageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:area coverage view')->only('index', 'show');
        $this->middleware('permission:area coverage create')->only('create', 'store');
        $this->middleware('permission:area coverage edit')->only('edit', 'update');
        $this->middleware('permission:area coverage delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $areaCoverages = AreaCoverage::where('area_coverages.company_id', '=', session('sessionCompany'))->get();

            return DataTables::of($areaCoverages)
                ->addColumn('alamat', function($row){
                    return str($row->alamat)->limit(100);
                })
				->addColumn('keterangan', function($row){
                    return str($row->keterangan)->limit(100);
                })
				->addColumn('action', 'area-coverages.include.action')
                ->toJson();
        }

        return view('area-coverages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('area-coverages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAreaCoverageRequest $request)
    {
        $attr = $request->validated();
        $attr['company_id'] =  session('sessionCompany');
        AreaCoverage::create($attr);

        return redirect()
            ->route('area-coverages.index')
            ->with('success', __('The areaCoverage was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AreaCoverage  $areaCoverage
     * @return \Illuminate\Http\Response
     */
    public function show(AreaCoverage $areaCoverage)
    {
        return view('area-coverages.show', compact('areaCoverage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AreaCoverage  $areaCoverage
     * @return \Illuminate\Http\Response
     */
    public function edit(AreaCoverage $areaCoverage)
    {
        return view('area-coverages.edit', compact('areaCoverage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaCoverage  $areaCoverage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAreaCoverageRequest $request, AreaCoverage $areaCoverage)
    {

        $areaCoverage->update($request->validated());

        return redirect()
            ->route('area-coverages.index')
            ->with('success', __('The areaCoverage was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaCoverage  $areaCoverage
     * @return \Illuminate\Http\Response
     */
    public function destroy(AreaCoverage $areaCoverage)
    {
        try {
            $areaCoverage->delete();

            return redirect()
                ->route('area-coverages.index')
                ->with('success', __('The areaCoverage was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('area-coverages.index')
                ->with('error', __("The areaCoverage can't be deleted because it's related to another table."));
        }
    }
}
