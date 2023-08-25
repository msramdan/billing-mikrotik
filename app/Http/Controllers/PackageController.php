<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Requests\{StorePackageRequest, UpdatePackageRequest};
use Yajra\DataTables\Facades\DataTables;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:package view')->only('index', 'show');
        $this->middleware('permission:package create')->only('create', 'store');
        $this->middleware('permission:package edit')->only('edit', 'update');
        $this->middleware('permission:package delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $packages = Package::with('package_category:id,nama_kategori');

            return DataTables::of($packages)
                ->addColumn('keterangan', function($row){
                    return str($row->keterangan)->limit(100);
                })
				->addColumn('package_category', function ($row) {
                    return $row->package_category ? $row->package_category->nama_kategori : '';
                })->addColumn('action', 'packages.include.action')
                ->toJson();
        }

        return view('packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageRequest $request)
    {
        
        Package::create($request->validated());

        return redirect()
            ->route('packages.index')
            ->with('success', __('The package was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        $package->load('package_category:id,nama_kategori');

		return view('packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $package->load('package_category:id,nama_kategori');

		return view('packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        
        $package->update($request->validated());

        return redirect()
            ->route('packages.index')
            ->with('success', __('The package was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        try {
            $package->delete();

            return redirect()
                ->route('packages.index')
                ->with('success', __('The package was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('packages.index')
                ->with('error', __("The package can't be deleted because it's related to another table."));
        }
    }
}
