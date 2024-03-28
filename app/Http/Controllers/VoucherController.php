<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Http\Requests\{StoreVoucherRequest};

class VoucherController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:voucher create')->only('index');
        $this->middleware('permission:voucher create')->only('create');
    }

    public function index()
    {
        return view('vouchers.create');
    }

    public function store(StoreVoucherRequest $request)
    {

        Voucher::create($request->validated());

        return redirect()
            ->route('vouchers.index')
            ->with('success', __('The voucher was created successfully.'));
    }
}
