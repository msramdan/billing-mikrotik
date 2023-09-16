<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use \RouterOS\Client;
use \RouterOS\Exceptions\ConnectException;

class Nomikrotik
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // cek ada atw tinggal mikrotik aktive
        $router = DB::table('settingmikrotiks')->where('is_active', 'Yes')->first();
        if ($router) {
            try {
                new Client([
                    'host' => $router->host,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => $router->port,
                ]);
                return $next($request);
            } catch (ConnectException $e) {
                return redirect('form');
            }
        } else {
            return redirect('form');
        }
    }
}
