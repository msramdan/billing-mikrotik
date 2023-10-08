<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class Expired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $companies = DB::table('companies')->where('id', 1)->first();
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
