<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\{StoreCompanyRequest, UpdateCompanyRequest};
use Yajra\DataTables\Facades\DataTables;
use Image;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:company view')->only('index', 'show');
        $this->middleware('permission:company create')->only('create', 'store');
        $this->middleware('permission:company edit')->only('edit', 'update');
        $this->middleware('permission:company delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $companies = Company::with('paket:id,nama_paket');

            return Datatables::of($companies)
                ->addColumn('alamat', function($row){
                    return str($row->alamat)->limit(100);
                })
				->addColumn('deskripsi_perusahaan', function($row){
                    return str($row->deskripsi_perusahaan)->limit(100);
                })
				->addColumn('footer_pesan_wa_tagihan', function($row){
                    return str($row->footer_pesan_wa_tagihan)->limit(100);
                })
				->addColumn('footer_pesan_wa_pembayaran', function($row){
                    return str($row->footer_pesan_wa_pembayaran)->limit(100);
                })
				->addColumn('paket', function ($row) {
                    return $row->paket ? $row->paket->nama_paket : '';
                })
                ->addColumn('logo', function ($row) {
                    if ($row->logo == null) {
                    return 'https://via.placeholder.com/350?text=No+Image+Avaiable';
                }
                    return asset('storage/uploads/logos/' . $row->logo);
                })
                ->addColumn('favicon', function ($row) {
                    if ($row->favicon == null) {
                    return 'https://via.placeholder.com/350?text=No+Image+Avaiable';
                }
                    return asset('storage/uploads/favicons/' . $row->favicon);
                })

                ->addColumn('action', 'companies.include.action')
                ->toJson();
        }

        return view('companies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
        $attr = $request->validated();

        if ($request->file('logo') && $request->file('logo')->isValid()) {

            $path = storage_path('app/public/uploads/logos/');
            $filename = $request->file('logo')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('logo')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            $attr['logo'] = $filename;
        }
        if ($request->file('favicon') && $request->file('favicon')->isValid()) {

            $path = storage_path('app/public/uploads/favicons/');
            $filename = $request->file('favicon')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('favicon')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            $attr['favicon'] = $filename;
        }

        Company::create($attr);

        return redirect()
            ->route('companies.index')
            ->with('success', __('The company was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        $company->load('paket:id,nama_paket', );

		return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $company->load('paket:id,nama_paket', );

		return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $attr = $request->validated();

        if ($request->file('logo') && $request->file('logo')->isValid()) {

            $path = storage_path('app/public/uploads/logos/');
            $filename = $request->file('logo')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('logo')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            // delete old logo from storage
            if ($company->logo != null && file_exists($path . $company->logo)) {
                unlink($path . $company->logo);
            }

            $attr['logo'] = $filename;
        }
        if ($request->file('favicon') && $request->file('favicon')->isValid()) {

            $path = storage_path('app/public/uploads/favicons/');
            $filename = $request->file('favicon')->hashName();

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            Image::make($request->file('favicon')->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->upsize();
				$constraint->aspectRatio();
            })->save($path . $filename);

            // delete old favicon from storage
            if ($company->favicon != null && file_exists($path . $company->favicon)) {
                unlink($path . $company->favicon);
            }

            $attr['favicon'] = $filename;
        }

        $company->update($attr);

        return redirect()
            ->route('companies.index')
            ->with('success', __('The company was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try {
            $path = storage_path('app/public/uploads/logos/');

            if ($company->logo != null && file_exists($path . $company->logo)) {
                unlink($path . $company->logo);
            }
    $path = storage_path('app/public/uploads/favicons/');

            if ($company->favicon != null && file_exists($path . $company->favicon)) {
                unlink($path . $company->favicon);
            }

            $company->delete();

            return redirect()
                ->route('companies.index')
                ->with('success', __('The company was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('companies.index')
                ->with('error', __("The company can't be deleted because it's related to another table."));
        }
    }
}
