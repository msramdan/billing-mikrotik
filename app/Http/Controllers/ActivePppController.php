<?php

namespace App\Http\Controllers;

use App\Models\ActivePpp;
use App\Http\Requests\{StoreActivePppRequest, UpdateActivePppRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Client;
use \RouterOS\Query;

class ActivePppController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:active ppp view')->only('index', 'show');
        $this->middleware('permission:active ppp create')->only('create', 'store');
        $this->middleware('permission:active ppp edit')->only('edit', 'update');
        $this->middleware('permission:active ppp delete')->only('destroy');
    }

    public function index()
    {
        if (request()->ajax()) {
            $client = setRoute();
            $query = new Query('/ppp/active/print');
            $activePpps = $client->query($query)->read();
            return DataTables::of($activePpps)
                ->addColumn('action', 'active-ppps.include.action')
                ->toJson();
        }
        return view('active-ppps.index');
    }

    public function show($name)
    {
        $client = setRoute();
        $pppuser = (new Query('/ppp/secret/print'))
            ->where('name', $name);
        $pppuser = $client->query($pppuser)->read();


        $pppactive = (new Query('/ppp/active/print'))
            ->where('name', $name);
        $pppactive = $client->query($pppactive)->read();
        return view('active-ppps.show',[
            'pppuser' =>$pppuser,
            'pppactive' =>$pppactive
        ]);
    }

    public function destroy($id)
    {
        try {
            $client = setRoute();
            $queryDelete = (new Query('/ppp/active/remove'))
                ->equal('.id', $id);
            $client->query($queryDelete)->read();
            return redirect()
                ->route('active-ppps.index')
                ->with('success', __('The active PPP was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('active-ppps.index')
                ->with('error', __("The active PPP can't be deleted because it's related to another table."));
        }
    }
}
