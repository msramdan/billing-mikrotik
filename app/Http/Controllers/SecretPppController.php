<?php

namespace App\Http\Controllers;

use App\Models\SecretPpp;
use App\Http\Requests\{StoreSecretPppRequest, UpdateSecretPppRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Client;
use \RouterOS\Query;

class SecretPppController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:secret ppp view')->only('index', 'show');
        $this->middleware('permission:secret ppp create')->only('create', 'store');
        $this->middleware('permission:secret ppp edit')->only('edit', 'update');
        $this->middleware('permission:secret ppp delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $client = new Client([
                'host' => '103.122.65.234',
                'user' => 'sawitskylink',
                'pass' => 'sawit064199',
                'port' => 83,
            ]);
            $query = new Query('/ppp/secret/print');
            $secretPpps = $client->query($query)->read();
            // dd($secretPpps);
            return DataTables::of($secretPpps)
                ->addColumn('action', 'secret-ppps.include.action')
                ->toJson();
        }

        return view('secret-ppps.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('secret-ppps.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSecretPppRequest $request)
    {

        SecretPpp::create($request->validated());

        return redirect()
            ->route('secret-ppps.index')
            ->with('success', __('The secretPpp was created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SecretPpp  $secretPpp
     * @return \Illuminate\Http\Response
     */
    public function show(SecretPpp $secretPpp)
    {
        return view('secret-ppps.show', compact('secretPpp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SecretPpp  $secretPpp
     * @return \Illuminate\Http\Response
     */
    public function edit(SecretPpp $secretPpp)
    {
        return view('secret-ppps.edit', compact('secretPpp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SecretPpp  $secretPpp
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSecretPppRequest $request, SecretPpp $secretPpp)
    {

        $secretPpp->update($request->validated());

        return redirect()
            ->route('secret-ppps.index')
            ->with('success', __('The secretPpp was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SecretPpp  $secretPpp
     * @return \Illuminate\Http\Response
     */
    public function destroy(SecretPpp $secretPpp)
    {
        try {
            $secretPpp->delete();

            return redirect()
                ->route('secret-ppps.index')
                ->with('success', __('The secretPpp was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('secret-ppps.index')
                ->with('error', __("The secretPpp can't be deleted because it's related to another table."));
        }
    }
}
