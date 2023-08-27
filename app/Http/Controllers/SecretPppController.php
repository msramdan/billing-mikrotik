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
            $client = setRoute();
            $query = new Query('/ppp/secret/print');
            $secretPpps = $client->query($query)->read();
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

    public function show(SecretPpp $secretPpp)
    {
        return view('secret-ppps.show', compact('secretPpp'));
    }

    public function enable($id)
    {
        $client = setRoute();
        // set komen
        $comment = 'Di Aktifkan Tanggal : ' . date('Y-m-d H:i:s');
        $queryComment = (new Query('/ppp/secret/set'))
            ->equal('.id', $id)
            ->equal('comment', $comment);
        $client->query($queryComment)->read();

        // set enable
        $query = (new Query('/ppp/secret/enable'))
            ->equal('.id', $id);
        $client->query($query)->read();
        return redirect()
            ->route('secret-ppps.index')
            ->with('success', __('The Secret PPP was enable successfully.'));
    }

    public function disable($id, $name)
    {
        $client = setRoute();
        // set komen
        $comment = 'Di Non-Aktifkan Tanggal : ' . date('Y-m-d H:i:s');
        $queryComment = (new Query('/ppp/secret/set'))
            ->equal('.id', $id)
            ->equal('comment', $comment);
        $client->query($queryComment)->read();

        // set disable
        $queryDisable = (new Query('/ppp/secret/disable'))
            ->equal('.id', $id);
        $client->query($queryDisable)->read();

        // get name
        $queryGet = (new Query('/ppp/active/print'))
            ->where('name', $name);
        $data = $client->query($queryGet)->read();
        // remove session
        $idActive = $data[0]['.id'];
        $queryDelete = (new Query('/ppp/active/remove'))
            ->equal('.id', $idActive);
        $client->query($queryDelete)->read();

        return redirect()
            ->route('secret-ppps.index')
            ->with('success', __('The Secret PPP was disable successfully.'));
    }

    public function deleteSecret($id, $name)
    {
        try {
            $client = setRoute();
            $queryDelete = (new Query('/ppp/secret/remove'))
                ->equal('.id', $id);
            $client->query($queryDelete)->read();
            // get id
            $queryGet = (new Query('/ppp/active/print'))
                ->where('name', $name);
            $data = $client->query($queryGet)->read();
            // remove session
            $idActive = $data[0]['.id'];
            $removeSession = (new Query('/ppp/active/remove'))
                ->equal('.id', $idActive);
            $client->query($removeSession)->read();
            return redirect()
                ->route('secret-ppps.index')
                ->with('success', __('The active PPP was deleted successfully.'));
        } catch (\Throwable $th) {
            return redirect()
                ->route('secret-ppps.index')
                ->with('error', __("The active PPP can't be deleted because it's related to another table."));
        }
    }
}
