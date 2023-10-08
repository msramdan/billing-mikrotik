<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Http\Requests\{StoreFeatureRequest, UpdateFeatureRequest};
use Yajra\DataTables\Facades\DataTables;

class FeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:feature view')->only('index', 'show');
        $this->middleware('permission:feature create')->only('create', 'store');
        $this->middleware('permission:feature edit')->only('edit', 'update');
        $this->middleware('permission:feature delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $features = Feature::query();

            return DataTables::of($features)
                ->addColumn('keterangan', function($row){
                    return str($row->keterangan)->limit(100);
                })
				->addColumn('action', 'features.include.action')
                ->toJson();
        }

        return view('features.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('features.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeatureRequest $request)
    {

        Feature::create($request->validated());

        return redirect()
            ->route('features.index')
            ->with('success', __('The feature was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        return view('features.show', compact('feature'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        return view('features.edit', compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeatureRequest $request, Feature $feature)
    {

        $feature->update($request->validated());

        return redirect()
            ->route('features.index')
            ->with('success', __('The feature was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feature $feature)
    {
        try {
            $feature->delete();

            return redirect()
                ->route('features.index')
                ->with('success', __('The feature was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('features.index')
                ->with('error', __("The feature can't be deleted because it's related to another table."));
        }
    }
}
