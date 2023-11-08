<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use  Auth;

class Expired
{

    public function handle(Request $request, Closure $next): Response
    {
        $cek = session('sessionCompany');
        if ($cek == null || $cek == '') {
            $assign_company = DB::table('assign_company')
                ->where('user_id', Auth::id())->first();
            session(['sessionCompany' => $assign_company->company_id]);
        }
        $companies = DB::table('companies')
            ->where('companies.id', '=', session('sessionCompany'))->first();
        $currentDateTime = date('Y-m-d H:i:s');
        if ($companies) {
            if ($currentDateTime > $companies->expired) {
                return redirect('expired');
            } else {
                return $next($request);
            }
        } else {
            return redirect('expired');
        }
    }
}
