<?php

namespace App\Http\Controllers;

use App\Models\PackageCategory;
use App\Http\Requests\{StorePackageCategoryRequest, UpdatePackageCategoryRequest};
use Yajra\DataTables\Facades\DataTables;

class PackageCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:package category view')->only('index', 'show');
        $this->middleware('permission:package category create')->only('create', 'store');
        $this->middleware('permission:package category edit')->only('edit', 'update');
        $this->middleware('permission:package category delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $packageCategories = PackageCategory::where('package_categories.company_id', '=', session('sessionCompany'))->get();
            return DataTables::of($packageCategories)
                ->addColumn('keterangan', function ($row) {
                    return str($row->keterangan)->limit(100);
                })
                ->addColumn('action', 'package-categories.include.action')
                ->toJson();
        }

        return view('package-categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('package-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageCategoryRequest $request)
    {
        $attr = $request->validated();
        $attr['company_id'] =  session('sessionCompany');
        PackageCategory::create($attr);
        return redirect()
            ->route('package-categories.index')
            ->with('success', __('The packageCategory was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PackageCategory  $packageCategory
     * @return \Illuminate\Http\Response
     */
    public function show(PackageCategory $packageCategory)
    {
        return view('package-categories.show', compact('packageCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PackageCategory  $packageCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(PackageCategory $packageCategory)
    {
        return view('package-categories.edit', compact('packageCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PackageCategory  $packageCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageCategoryRequest $request, PackageCategory $packageCategory)
    {

        $packageCategory->update($request->validated());

        return redirect()
            ->route('package-categories.index')
            ->with('success', __('The packageCategory was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PackageCategory  $packageCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackageCategory $packageCategory)
    {
        try {
            $packageCategory->delete();

            return redirect()
                ->route('package-categories.index')
                ->with('success', __('The packageCategory was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('package-categories.index')
                ->with('error', __("The packageCategory can't be deleted because it's related to another table."));
        }
    }
}
