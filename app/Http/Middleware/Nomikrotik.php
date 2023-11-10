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
    public function handle(Request $request, Closure $next): Response
    {
        $router = DB::table('settingmikrotiks')
            ->where('id', '=', session('sessionRouter'))->first();
        if ($router) {
            try {
                new Client([
                    'host' => $router->host,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => (int) $router->port,
                ]);
                return $next($request);
            } catch (ConnectException $e) {
                return redirect('nomikrotik');
            }
            return $next($request);
        } else {
            return redirect('nomikrotik');
        }
    }
}
