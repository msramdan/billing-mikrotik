<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use App\Http\Requests\{StorePrivacyPolicyRequest, UpdatePrivacyPolicyRequest};
use Yajra\DataTables\Facades\DataTables;

class PrivacyPolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:privacy policy view')->only('index', 'show');
        $this->middleware('permission:privacy policy edit')->only('edit', 'update');
    }

    public function index()
    {
        $privacyPolicy = PrivacyPolicy::findOrFail(1)->first();
        return view('privacy-policies.edit', compact('privacyPolicy'));
    }

    public function update(UpdatePrivacyPolicyRequest $request, PrivacyPolicy $privacyPolicy)
    {

        $privacyPolicy->update($request->validated());

        return redirect()
            ->route('privacy-policies.index')
            ->with('success', __('The privacyPolicy was updated successfully.'));
    }
}
