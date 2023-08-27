<?php

namespace App\Http\Controllers;

use App\Models\Settingmikrotik;
use App\Http\Requests\{StoreSettingmikrotikRequest, UpdateSettingmikrotikRequest};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
            $settingmikrotiks = Settingmikrotik::query();

            return DataTables::of($settingmikrotiks)
                ->addColumn('is_active', function ($row) {
                    if ($row->is_active == 'Yes') {
                        return '<a href="' . url('/setActive?id=' . $row->id) . '" class="btn btn-success btn-block">Aktive</a>';
                    } else {
                        return '<a href="' . url('/setActive?id=' . $row->id) . '" class="btn btn-danger btn-block">Non Aktive</a>';
                    }
                })
                ->addColumn('action', 'settingmikrotiks.include.action')
                ->rawColumns(['is_active', 'action'])
                ->toJson();
        }

        return view('settingmikrotiks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settingmikrotiks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingmikrotikRequest $request)
    {
        $attr = $request->validated();
        $attr['password'] = $request->password;
        $attr['is_active'] = 'No';
        Settingmikrotik::create($attr);
        return redirect()
            ->route('settingmikrotiks.index')
            ->with('success', __('The settingmikrotik was created successfully.'));
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

    public function setActive(Request $request)
    {
        try {
            DB::table('settingmikrotiks')
                ->update(['is_active' => 'No']);
            DB::table('settingmikrotiks')
                ->where('id', $request->id)
                ->update(['is_active' => 'Yes']);
            return redirect()
                ->route('settingmikrotiks.index')
                ->with('success', __('The Router was activated successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('settingmikrotiks.index')
                ->with('error', __("The Router can't be activated because error"));
        }
    }
}
