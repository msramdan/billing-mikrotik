<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Http\Requests\{StoreBankRequest, UpdateBankRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:bank view')->only('index', 'show');
        $this->middleware('permission:bank create')->only('create', 'store');
        $this->middleware('permission:bank edit')->only('edit', 'update');
        $this->middleware('permission:bank delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $banks = Bank::where('company_id', '=', session('sessionCompany'))->get();
            return Datatables::of($banks)

                ->addColumn('logo_bank', function ($row) {
                    if ($row->logo_bank == null) {
                    return 'https://via.placeholder.com/350?text=No+Image+Avaiable';
                }
                    return asset('storage/uploads/logo_banks/' . $row->logo_bank);
                })

                ->addColumn('action', 'banks.include.action')
                ->toJson();
        }

        return view('banks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('logo_bank') && $request->file('logo_bank')->isValid()) {

            $path = storage_path('app/public/uploads/logo_banks/');
            $filename = $request->file('logo_bank')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('logo_bank')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            $attr['logo_bank'] = $filename;
        }

        Bank::create($attr);

        return redirect()
            ->route('banks.index')
            ->with('success', __('The bank was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        return view('banks.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankRequest $request, Bank $bank)
    {
        $attr = $request->validated();

        if ($request->file('logo_bank') && $request->file('logo_bank')->isValid()) {

            $path = storage_path('app/public/uploads/logo_banks/');
            $filename = $request->file('logo_bank')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('logo_bank')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            // delete old logo_bank from storage
            if ($bank->logo_bank != null && file_exists($path . $bank->logo_bank)) {
                unlink($path . $bank->logo_bank);
            }

            $attr['logo_bank'] = $filename;
        }

        $bank->update($attr);

        return redirect()
            ->route('banks.index')
            ->with('success', __('The bank was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        try {
            $path = storage_path('app/public/uploads/logo_banks/');

            if ($bank->logo_bank != null && file_exists($path . $bank->logo_bank)) {
                unlink($path . $bank->logo_bank);
            }

            $bank->delete();

            return redirect()
                ->route('banks.index')
                ->with('success', __('The bank was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('banks.index')
                ->with('error', __("The bank can't be deleted because it's related to another table."));
        }
    }
}
