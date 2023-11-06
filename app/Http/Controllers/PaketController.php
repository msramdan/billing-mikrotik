<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Http\Requests\{StorePaketRequest, UpdatePaketRequest};
use Yajra\DataTables\Facades\DataTables;

class PaketController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:paket view')->only('index', 'show');
        $this->middleware('permission:paket create')->only('create', 'store');
        $this->middleware('permission:paket edit')->only('edit', 'update');
        $this->middleware('permission:paket delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pakets = Paket::query();

            return DataTables::of($pakets)
                ->addColumn('action', 'pakets.include.action')
                ->toJson();
        }

        return view('pakets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pakets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaketRequest $request)
    {
        
        Paket::create($request->validated());

        return redirect()
            ->route('pakets.index')
            ->with('success', __('The paket was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function show(Paket $paket)
    {
        return view('pakets.show', compact('paket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function edit(Paket $paket)
    {
        return view('pakets.edit', compact('paket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaketRequest $request, Paket $paket)
    {
        
        $paket->update($request->validated());

        return redirect()
            ->route('pakets.index')
            ->with('success', __('The paket was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paket $paket)
    {
        try {
            $paket->delete();

            return redirect()
                ->route('pakets.index')
                ->with('success', __('The paket was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('pakets.index')
                ->with('error', __("The paket can't be deleted because it's related to another table."));
        }
    }
}
