<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Http\Requests\{StoreVoucherRequest};
use \RouterOS\Query;

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:voucher view')->only('index');
        $this->middleware('permission:voucher create')->only('create');
    }

    public function create()
    {
        $client = setRoute();
        $hotspotprofile = new Query('/ip/hotspot/user/profile/print');
        $hotspotprofile = $client->query($hotspotprofile)->read();
        $srvlist = new Query('/ip/hotspot/print');
        $srvlist = $client->query($srvlist)->read();

        $hotspotprofile = new Query('/ip/hotspot/user/profile/print');
        $hotspotprofile = $client->query($hotspotprofile)->read();
        return view('vouchers.create',[
            'srvlist' => $srvlist,
            'getprofile' => $hotspotprofile
        ]);
    }

    public function store(StoreVoucherRequest $request)
    {

        Voucher::create($request->validated());
        return redirect()
            ->route('vouchers.index')
            ->with('success', __('The voucher was created successfully.'));
    }
}
