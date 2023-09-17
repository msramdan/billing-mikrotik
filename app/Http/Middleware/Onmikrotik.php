<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use \RouterOS\Client;
use \RouterOS\Exceptions\ConnectException;

class Onmikrotik
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $router = DB::table('settingmikrotiks')->where('is_active', 'Yes')->first();
        if ($router) {
            try {
                new Client([
                    'host' => $router->host,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => $router->port,
                ]);
                return redirect('/dashboard');
            } catch (ConnectException $e) {
                return $next($request);
            }
        } else {
            return $next($request);
        }
    }
}
