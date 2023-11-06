<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Http\Requests\{StorePengeluaranRequest, UpdatePengeluaranRequest};
use Yajra\DataTables\Facades\DataTables;

class PengeluaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pengeluaran view')->only('index', 'show');
        $this->middleware('permission:pengeluaran create')->only('create', 'store');
        $this->middleware('permission:pengeluaran edit')->only('edit', 'update');
        $this->middleware('permission:pengeluaran delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pengeluarans = Pengeluaran::where('pengeluarans.company_id', '=', session('sessionCompany'))->get();

            return DataTables::of($pengeluarans)
                ->addColumn('nominal', function ($row) {
                    return rupiah($row->nominal);
                })
                ->addColumn('keterangan', function ($row) {
                    return str($row->keterangan)->limit(100);
                })
                ->addColumn('action', 'pengeluarans.include.action')
                ->toJson();
        }

        return view('pengeluarans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengeluarans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePengeluaranRequest $request)
    {

        Pengeluaran::create($request->validated());

        return redirect()
            ->route('pengeluarans.index')
            ->with('success', __('The pengeluaran was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pengeluaran $pengeluaran)
    {
        return view('pengeluarans.show', compact('pengeluaran'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengeluaran $pengeluaran)
    {
        return view('pengeluarans.edit', compact('pengeluaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePengeluaranRequest $request, Pengeluaran $pengeluaran)
    {

        $pengeluaran->update($request->validated());

        return redirect()
            ->route('pengeluarans.index')
            ->with('success', __('The pengeluaran was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        try {
            $pengeluaran->delete();

            return redirect()
                ->route('pengeluarans.index')
                ->with('success', __('The pengeluaran was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('pengeluarans.index')
                ->with('error', __("The pengeluaran can't be deleted because it's related to another table."));
        }
    }
}
