<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use App\Http\Requests\{StoreOltRequest, UpdateOltRequest};
use Yajra\DataTables\Facades\DataTables;
use Alert;

class OltController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:olt view')->only('index', 'show');
        $this->middleware('permission:olt create')->only('create', 'store');
        $this->middleware('permission:olt edit')->only('edit', 'update');
        $this->middleware('permission:olt delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $olts = Olt::where('company_id', '=', session('sessionCompany'))->get();
            return DataTables::of($olts)
                ->addColumn('action', 'olts.include.action')
                ->toJson();
        }

        return view('olts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (hitungOlt() >= getCompany()->jumlah_olt) {
            Alert::error('Limit OLT', 'Anda terkena limit OLT silahkan uprage paket');
            return redirect()
                ->route('olts.index');
        } else {
            return view('olts.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOltRequest $request)
    {
        if (hitungOlt() >= getCompany()->jumlah_olt) {
            Alert::error('Limit OLT', 'Anda terkena limit OLT silahkan uprage paket');
            return redirect()
                ->route('olts.index');
        } else {
            $attr = $request->validated();
            $attr['company_id'] =  session('sessionCompany');
            Olt::create($attr);
            return redirect()
                ->route('olts.index')
                ->with('success', __('The olt was created successfully.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Olt  $olt
     * @return \Illuminate\Http\Response
     */
    public function show(Olt $olt)
    {
        return view('olts.show', compact('olt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Olt  $olt
     * @return \Illuminate\Http\Response
     */
    public function edit(Olt $olt)
    {
        return view('olts.edit', compact('olt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Olt  $olt
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOltRequest $request, Olt $olt)
    {

        $olt->update($request->validated());

        return redirect()
            ->route('olts.index')
            ->with('success', __('The olt was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Olt  $olt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Olt $olt)
    {
        try {
            $olt->delete();

            return redirect()
                ->route('olts.index')
                ->with('success', __('The olt was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('olts.index')
                ->with('error', __("The olt can't be deleted because it's related to another table."));
        }
    }
}
