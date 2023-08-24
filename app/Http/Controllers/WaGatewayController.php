<?php

namespace App\Http\Controllers;

use App\Models\WaGateway;
use App\Http\Requests\{StoreWaGatewayRequest, UpdateWaGatewayRequest};
use Yajra\DataTables\Facades\DataTables;

class WaGatewayController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:wa gateway view')->only('index', 'show');
        $this->middleware('permission:wa gateway edit')->only('edit', 'update');
    }

    public function index()
    {
        $waGateway = WaGateway::findOrFail(1)->first();
        return view('wa-gateways.edit', compact('waGateway'));
    }

    public function update(UpdateWaGatewayRequest $request, WaGateway $waGateway)
    {

        $waGateway->update($request->validated());

        return redirect()
            ->route('wa-gateways.index')
            ->with('success', __('The waGateway was updated successfully.'));
    }
}
