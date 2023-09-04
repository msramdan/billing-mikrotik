<?php

namespace App\Http\Controllers;

use App\Models\SecretPpp;
use App\Http\Requests\{StoreSecretPppRequest, UpdateSecretPppRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Query;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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

    public function create()
    {
        $client = setRoute();
        $query = new Query('/ppp/profile/print');
        $profile = $client->query($query)->read();
        return view('secret-ppps.create', [
            'profiles' => $profile
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'service' => 'required|string|max:255',
                'profile' => 'required|string|max:255',
                'komentar' => 'required|string|max:255',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }
        $client = setRoute();
        $queryAdd = (new Query('/ppp/secret/add'))
            ->equal('name', $request->username)
            ->equal('password', $request->password)
            ->equal('service', $request->service)
            ->equal('profile', $request->profile)
            ->equal('comment',  $request->komentar);
        $client->query($queryAdd)->read();
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
            if ($data) {
                // remove session
                $idActive = $data[0]['.id'];
                $removeSession = (new Query('/ppp/active/remove'))
                    ->equal('.id', $idActive);
                $client->query($removeSession)->read();
            }

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
