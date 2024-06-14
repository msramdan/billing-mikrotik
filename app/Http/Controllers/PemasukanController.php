<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Http\Requests\{StorePemasukanRequest, UpdatePemasukanRequest};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pemasukan view')->only('index', 'show');
        $this->middleware('permission:pemasukan create')->only('create', 'store');
        $this->middleware('permission:pemasukan edit')->only('edit', 'update');
        $this->middleware('permission:pemasukan delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $pemasukans = Pemasukan::where('pemasukans.company_id', '=', session('sessionCompany'));
            $start_date = intval($request->query('start_date'));
            $end_date = intval($request->query('end_date'));

            if (isset($start_date) && !empty($start_date)) {
                $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
                $pemasukans = $pemasukans->where('tanggal', '>=', $from);
            } else {
                $from = date('Y-m-d') . " 00:00:00";
                $pemasukans = $pemasukans->where('tanggal', '>=', $from);
            }
            if (isset($end_date) && !empty($end_date)) {
                $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
                $pemasukans = $pemasukans->where('tanggal', '<=', $to);
            } else {
                $to = date('Y-m-d') . " 23:59:59";
                $pemasukans = $pemasukans->where('tanggal', '<=', $to);
            }
            $pemasukans = $pemasukans->orderBy('pemasukans.id', 'DESC');

            return DataTables::of($pemasukans)
                ->addIndexColumn()
                ->addColumn('nominal', function ($row) {
                    return rupiah($row->nominal);
                })
                ->addColumn('keterangan', function ($row) {
                    return str($row->keterangan)->limit(100);
                })
                ->addColumn('action', 'pemasukans.include.action')
                ->toJson();
        }

        $from = date('Y-m-d') . " 00:00:00";
        $to = date('Y-m-d') . " 23:59:59";
        $microFrom = strtotime($from) * 1000;
        $microTo = strtotime($to) * 1000;
        $start_date = $request->query('start_date') !== null ? intval($request->query('start_date')) : $microFrom;
        $end_date = $request->query('end_date') !== null ? intval($request->query('end_date')) : $microTo;
        return view('pemasukans.index', [
            'microFrom' => $start_date,
            'microTo' => $end_date,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pemasukans.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePemasukanRequest $request)
    {
        $attr = $request->validated();
        $attr['company_id'] =  session('sessionCompany');
        Pemasukan::create($attr);

        return redirect()
            ->route('pemasukans.index')
            ->with('success', __('The pemasukan was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function show(Pemasukan $pemasukan)
    {
        return view('pemasukans.show', compact('pemasukan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pemasukan $pemasukan)
    {
        return view('pemasukans.edit', compact('pemasukan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePemasukanRequest $request, Pemasukan $pemasukan)
    {

        $pemasukan->update($request->validated());

        return redirect()
            ->route('pemasukans.index')
            ->with('success', __('The pemasukan was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemasukan  $pemasukan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemasukan $pemasukan)
    {
        try {
            $pemasukan->delete();

            return redirect()
                ->route('pemasukans.index')
                ->with('success', __('The pemasukan was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('pemasukans.index')
                ->with('error', __("The pemasukan can't be deleted because it's related to another table."));
        }
    }
}
