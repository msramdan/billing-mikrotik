<?php

namespace App\Http\Controllers;

use App\Models\CategoryPengeluaran;
use App\Http\Requests\{StoreCategoryPengeluaranRequest, UpdateCategoryPengeluaranRequest};
use Yajra\DataTables\Facades\DataTables;

class CategoryPengeluaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:category pengeluaran view')->only('index', 'show');
        $this->middleware('permission:category pengeluaran create')->only('create', 'store');
        $this->middleware('permission:category pengeluaran edit')->only('edit', 'update');
        $this->middleware('permission:category pengeluaran delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $categoryPengeluarans = CategoryPengeluaran::query()->orderBy('id', 'desc');

            return DataTables::of($categoryPengeluarans)
                ->addIndexColumn()
                ->addColumn('action', 'category-pengeluarans.include.action')
                ->toJson();
        }

        return view('category-pengeluarans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category-pengeluarans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryPengeluaranRequest $request)
    {

        CategoryPengeluaran::create($request->validated());

        return redirect()
            ->route('category-pengeluarans.index')
            ->with('success', __('The categoryPengeluaran was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryPengeluaran  $categoryPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryPengeluaran $categoryPengeluaran)
    {
        return view('category-pengeluarans.show', compact('categoryPengeluaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryPengeluaran  $categoryPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryPengeluaran $categoryPengeluaran)
    {
        return view('category-pengeluarans.edit', compact('categoryPengeluaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryPengeluaran  $categoryPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryPengeluaranRequest $request, CategoryPengeluaran $categoryPengeluaran)
    {

        $categoryPengeluaran->update($request->validated());

        return redirect()
            ->route('category-pengeluarans.index')
            ->with('success', __('The categoryPengeluaran was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryPengeluaran  $categoryPengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryPengeluaran $categoryPengeluaran)
    {
        try {
            $categoryPengeluaran->delete();

            return redirect()
                ->route('category-pengeluarans.index')
                ->with('success', __('The categoryPengeluaran was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('category-pengeluarans.index')
                ->with('error', __("The categoryPengeluaran can't be deleted because it's related to another table."));
        }
    }
}
