<?php

namespace App\Http\Controllers;

use App\Models\PaymentTripay;
use App\Http\Requests\{StorePaymentTripayRequest, UpdatePaymentTripayRequest};
use Yajra\DataTables\Facades\DataTables;

class PaymentTripayController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:payment tripay view')->only('index');
        $this->middleware('permission:payment tripay edit')->only('update');
    }

    public function index()
    {
        $paymentTripay = PaymentTripay::findOrFail(1)->first();
        return view('payment-tripays.edit', compact('paymentTripay'));

    }


    public function update(UpdatePaymentTripayRequest $request, PaymentTripay $paymentTripay)
    {

        $paymentTripay->update($request->validated());

        return redirect()
            ->route('payment-tripays.index')
            ->with('success', __('The paymentTripay was updated successfully.'));
    }

}
