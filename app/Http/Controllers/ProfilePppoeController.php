<?php

namespace App\Http\Controllers;

use App\Models\ProfilePppoe;
use App\Http\Requests\{StoreProfilePppoeRequest, UpdateProfilePppoeRequest};
use Yajra\DataTables\Facades\DataTables;
use \RouterOS\Client;
use \RouterOS\Query;

class ProfilePppoeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:profile pppoe view')->only('index', 'show');
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
            $query = new Query('/ppp/profile/print');
            $secrets = $client->query($query)->read();
            return DataTables::of($secrets)
                ->addColumn('action', 'profile-pppoes.include.action')
                ->toJson();
        }
        return view('profile-pppoes.index');
    }

    public function show(ProfilePppoe $profilePppoe)
    {
        return view('profile-pppoes.show', compact('profilePppoe'));
    }
}
