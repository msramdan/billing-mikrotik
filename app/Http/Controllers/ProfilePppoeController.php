<?php

namespace App\Http\Controllers;

use App\Models\ProfilePppoe;
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
            $client = setRoute();
            $query = new Query('/ppp/profile/print');
            $profile = $client->query($query)->read();
            return DataTables::of($profile)
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
