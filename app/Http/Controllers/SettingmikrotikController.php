<?php

namespace App\Http\Controllers;

use App\Models\Settingmikrotik;
use App\Http\Requests\{StoreSettingmikrotikRequest, UpdateSettingmikrotikRequest};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Alert;

class SettingmikrotikController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:settingmikrotik view')->only('index', 'show');
        $this->middleware('permission:settingmikrotik create')->only('create', 'store');
        $this->middleware('permission:settingmikrotik edit')->only('edit', 'update');
        $this->middleware('permission:settingmikrotik delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $settingmikrotiks = Settingmikrotik::where('company_id', '=', session('sessionCompany'))->get();

            return DataTables::of($settingmikrotiks)
                ->addColumn('action', 'settingmikrotiks.include.action')
                ->rawColumns(['action'])
                ->toJson();
        }
        $countRouter = Settingmikrotik::count();
        return view('settingmikrotiks.index', [
            'countRouter' => $countRouter
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (hitungRouter() >= getCompany()->jumlah_router) {
            Alert::error('Limit Router', 'Anda terkena limit router silahkan uprage paket');
            return redirect()
                ->route('settingmikrotiks.index');
        } else {
            return view('settingmikrotiks.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingmikrotikRequest $request)
    {
        if (hitungRouter() >= getCompany()->jumlah_router) {
            Alert::error('Limit Router', 'Anda terkena limit router silahkan uprage paket');
            return redirect()
                ->route('settingmikrotiks.index');
        } else {
            $attr = $request->validated();
            $attr['password'] = $request->password;
            $attr['company_id'] =  session('sessionCompany');
            Settingmikrotik::create($attr);
            return redirect()
                ->route('settingmikrotiks.index')
                ->with('success', __('The settingmikrotik was created successfully.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settingmikrotik  $settingmikrotik
     * @return \Illuminate\Http\Response
     */
    public function show(Settingmikrotik $settingmikrotik)
    {
        return view('settingmikrotiks.show', compact('settingmikrotik'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settingmikrotik  $settingmikrotik
     * @return \Illuminate\Http\Response
     */
    public function edit(Settingmikrotik $settingmikrotik)
    {
        return view('settingmikrotiks.edit', compact('settingmikrotik'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settingmikrotik  $settingmikrotik
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingmikrotikRequest $request, Settingmikrotik $settingmikrotik)
    {
        $attr = $request->validated();
        if ($request->password == null) {
            DB::table('settingmikrotiks')
                ->where('id', $settingmikrotik->id)
                ->update([
                    'identitas_router' => $request->identitas_router,
                    'host' => $request->host,
                    'port' => $request->port,
                    'username' => $request->username,
                    'updated_at' =>  date('Y-m-d H:i:s'),
                ]);
        } else {
            DB::table('settingmikrotiks')
                ->where('id', $settingmikrotik->id)
                ->update([
                    'identitas_router' => $request->identitas_router,
                    'host' => $request->host,
                    'port' => $request->port,
                    'username' => $request->username,
                    'password' => $request->password,
                    'updated_at' =>  date('Y-m-d H:i:s'),
                ]);
        }

        return redirect()
            ->route('settingmikrotiks.index')
            ->with('success', __('The settingmikrotik was updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settingmikrotik  $settingmikrotik
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settingmikrotik $settingmikrotik)
    {
        try {
            $settingmikrotik->delete();

            return redirect()
                ->route('settingmikrotiks.index')
                ->with('success', __('The settingmikrotik was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('settingmikrotiks.index')
                ->with('error', __("The settingmikrotik can't be deleted because it's related to another table."));
        }
    }

    public function nomikrotik()
    {
        return view('no-mikrotik');
    }

    public function getMikrotikRouters()
    {
        $routers = Settingmikrotik::where('company_id', '=', session('sessionCompany'))->get();
        $response = ['routers' => $routers];
        return response()->json($response);
    }
}
