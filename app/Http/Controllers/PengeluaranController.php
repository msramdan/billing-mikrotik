<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Http\Requests\{StorePengeluaranRequest, UpdatePengeluaranRequest};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;


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
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $pengeluarans = Pengeluaran::where('pengeluarans.company_id', '=', session('sessionCompany'));
            $start_date = intval($request->query('start_date'));
            $end_date = intval($request->query('end_date'));

            if (isset($start_date) && !empty($start_date)) {
                $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
                $pengeluarans = $pengeluarans->where('tanggal', '>=', $from);
            } else {
                $from = date('Y-m-d') . " 00:00:00";
                $pengeluarans = $pengeluarans->where('tanggal', '>=', $from);
            }
            if (isset($end_date) && !empty($end_date)) {
                $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
                $pengeluarans = $pengeluarans->where('tanggal', '<=', $to);
            } else {
                $to = date('Y-m-d') . " 23:59:59";
                $pengeluarans = $pengeluarans->where('tanggal', '<=', $to);
            }

            $pengeluarans = $pengeluarans->orderBy('pengeluarans.id', 'DESC');
            return DataTables::of($pengeluarans)
                ->addIndexColumn()
                ->addColumn('nominal', function ($row) {
                    return rupiah($row->nominal);
                })
                ->addColumn('keterangan', function ($row) {
                    return str($row->keterangan)->limit(100);
                })
                ->addColumn('action', 'pengeluarans.include.action')
                ->toJson();
        }
        $from = date('Y-m-d') . " 00:00:00";
        $to = date('Y-m-d') . " 23:59:59";
        $microFrom = strtotime($from) * 1000;
        $microTo = strtotime($to) * 1000;
        $start_date = $request->query('start_date') !== null ? intval($request->query('start_date')) : $microFrom;
        $end_date = $request->query('end_date') !== null ? intval($request->query('end_date')) : $microTo;
        return view('pengeluarans.index', [
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
        $attr = $request->validated();
        $attr['company_id'] =  session('sessionCompany');
        Pengeluaran::create($attr);

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
