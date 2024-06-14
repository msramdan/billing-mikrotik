<?php

namespace App\Http\Controllers;

use App\Models\CategoryPemasukan;
use App\Http\Requests\{StoreCategoryPemasukanRequest, UpdateCategoryPemasukanRequest};
use Yajra\DataTables\Facades\DataTables;

class CategoryPemasukanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category pemasukan view')->only('index', 'show');
        $this->middleware('permission:category pemasukan create')->only('create', 'store');
        $this->middleware('permission:category pemasukan edit')->only('edit', 'update');
        $this->middleware('permission:category pemasukan delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $categoryPemasukans = CategoryPemasukan::query()->orderBy('id', 'desc');
            return DataTables::of($categoryPemasukans)
                ->addIndexColumn()
                ->addColumn('action', 'category-pemasukans.include.action')
                ->toJson();
        }

        return view('category-pemasukans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category-pemasukans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryPemasukanRequest $request)
    {

        CategoryPemasukan::create($request->validated());

        return redirect()
            ->route('category-pemasukans.index')
            ->with('success', __('The categoryPemasukan was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryPemasukan  $categoryPemasukan
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryPemasukan $categoryPemasukan)
    {
        return view('category-pemasukans.show', compact('categoryPemasukan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryPemasukan  $categoryPemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryPemasukan $categoryPemasukan)
    {
        return view('category-pemasukans.edit', compact('categoryPemasukan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryPemasukan  $categoryPemasukan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryPemasukanRequest $request, CategoryPemasukan $categoryPemasukan)
    {

        $categoryPemasukan->update($request->validated());

        return redirect()
            ->route('category-pemasukans.index')
            ->with('success', __('The categoryPemasukan was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryPemasukan  $categoryPemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryPemasukan $categoryPemasukan)
    {
        try {
            $categoryPemasukan->delete();

            return redirect()
                ->route('category-pemasukans.index')
                ->with('success', __('The categoryPemasukan was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('category-pemasukans.index')
                ->with('error', __("The categoryPemasukan can't be deleted because it's related to another table."));
        }
    }
}
