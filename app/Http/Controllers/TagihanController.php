<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Http\Requests\{StoreTagihanRequest, UpdateTagihanRequest};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class TagihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:tagihan view')->only('index', 'show');
        $this->middleware('permission:tagihan create')->only('create', 'store');
        $this->middleware('permission:tagihan edit')->only('edit', 'update');
        $this->middleware('permission:tagihan delete')->only('destroy');
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $pelanggans = intval($request->query('pelanggans'));
            $metode_bayar = $request->query('metode_bayar');
            $status_bayar = $request->query('status_bayar');
            $tanggal = $request->query('tanggal'); //2023-10

            $tagihans = DB::table('tagihans')
                ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
                ->select('tagihans.*', 'pelanggans.nama');

            if (isset($pelanggans) && !empty($pelanggans)) {
                if ($pelanggans != 'All') {
                    $tagihans = $tagihans->where('tagihans.pelanggan_id', $pelanggans);
                }
            }

            if (isset($metode_bayar) && !empty($metode_bayar)) {
                if ($metode_bayar != 'All') {
                    $tagihans = $tagihans->where('tagihans.metode_bayar', $metode_bayar);
                }
            }

            if (isset($status_bayar) && !empty($status_bayar)) {
                if ($status_bayar != 'All') {
                    $tagihans = $tagihans->where('tagihans.status_bayar', $status_bayar);
                }
            }

            if (isset($tanggal) && !empty($tanggal)) {
                if ($tanggal != 'All') {
                    $tagihans = $tagihans->where('tagihans.periode', $tanggal);
                }
            }

            $tagihans = $tagihans->orderBy('tagihans.id', 'DESC')->get();
            return DataTables::of($tagihans)
                ->addIndexColumn()
                ->addColumn('nominal_bayar', function ($row) {
                    return rupiah($row->nominal_bayar);
                })
                ->addColumn('potongan_bayar', function ($row) {
                    return rupiah($row->potongan_bayar);
                })
                ->addColumn('total_bayar', function ($row) {
                    return rupiah($row->total_bayar);
                })
                ->addColumn('nominal_ppn', function ($row) {
                    return rupiah($row->nominal_ppn);
                })
                ->addColumn('pelanggan', function ($row) {
                    return $row->nama;
                })->addColumn('action', 'tagihans.include.action')
                ->toJson();
        }

        $pelanggans = DB::table('pelanggans')->get();

        return view('tagihans.index', [
            'pelanggans' => $pelanggans
        ]);
    }

    public function create()
    {
        return view('tagihans.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'no_tagihan' => 'required|string|max:50',
                'pelanggan_id' => 'required|exists:App\Models\Pelanggan,id',
                'nominal_bayar' => 'required|numeric',
                'potongan_bayar' => 'required|numeric',
                'total_bayar' => 'required|numeric',
                'periode' => 'required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        if ($request->ppn == 'Yes') {
            $nominal_ppn =  0.11 * ($request->nominal_bayar - $request->potongan_bayar);
        } else {
            $nominal_ppn =  0;
        }
        DB::table('tagihans')->insert([
            'no_tagihan' => 'INV-SSL-' . $request->no_tagihan,
            'pelanggan_id' => $request->pelanggan_id,
            'nominal_bayar' => $request->nominal_bayar,
            'potongan_bayar' => $request->potongan_bayar,
            'total_bayar' => $request->total_bayar,
            'periode' => $request->periode,
            'ppn' => $request->ppn,
            'nominal_ppn' => $nominal_ppn,
            'status_bayar' => 'Belum Bayar',
            'tanggal_create_tagihan' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        return redirect()
            ->route('tagihans.index')
            ->with('success', __('The tagihan was created successfully.'));
    }

    public function show(Tagihan $tagihan)
    {
        $tagihan = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->select('tagihans.*', 'pelanggans.nama')
            ->where('tagihans.id', '=', $tagihan->id)
            ->first();

        return view('tagihans.show', compact('tagihan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(Tagihan $tagihan)
    {
        $tagihan->load('pelanggan:id,coverage_area');

        return view('tagihans.edit', compact('tagihan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tagihan $tagihan)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'no_tagihan' => 'required|string|max:50',
                'pelanggan_id' => 'required|exists:App\Models\Pelanggan,id',
                'nominal_bayar' => 'required|numeric',
                'potongan_bayar' => 'required|numeric',
                'total_bayar' => 'required|numeric',
                'periode' => 'required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        if ($request->ppn == 'Yes') {
            $nominal_ppn =  0.11 * ($request->nominal_bayar - $request->potongan_bayar);
        } else {
            $nominal_ppn =  0;
        }
        DB::table('tagihans')
            ->where('id', $tagihan->id)
            ->update(
                [
                    'no_tagihan' => 'INV-SSL-' . $request->no_tagihan,
                    'pelanggan_id' => $request->pelanggan_id,
                    'nominal_bayar' => $request->nominal_bayar,
                    'potongan_bayar' => $request->potongan_bayar,
                    'ppn' => $request->ppn,
                    'nominal_ppn' =>  $nominal_ppn,
                    'total_bayar' => $request->total_bayar,
                    'periode' => $request->periode,
                    'status_bayar' => 'Belum Bayar',
                ]
            );
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        return redirect()
            ->route('tagihans.index')
            ->with('success', __('The tagihan was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tagihan $tagihan)
    {
        try {
            $tagihan->delete();

            return redirect()
                ->route('tagihans.index')
                ->with('success', __('The tagihan was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('tagihans.index')
                ->with('error', __("The tagihan can't be deleted because it's related to another table."));
        }
    }

    public function invoice($id)
    {
        $data = DB::table('tagihans')
            ->leftJoin('pelanggans', 'tagihans.pelanggan_id', '=', 'pelanggans.id')
            ->leftJoin('packages', 'pelanggans.paket_layanan', '=', 'packages.id')
            ->select('tagihans.*', 'pelanggans.nama','pelanggans.jatuh_tempo', 'pelanggans.email as email_customer', 'pelanggans.alamat as alamat_customer', 'packages.nama_layanan', 'pelanggans.no_layanan')
            ->where('tagihans.id', '=', $id)
            ->first();;
        $pdf = PDF::loadView('tagihans.pdf', compact('data'));
        // return $pdf->download('Invoice.pdf');
        return $pdf->stream();
    }
}
