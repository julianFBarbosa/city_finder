<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiIntegrity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ibgeApi = Http::get(env("BRASIL_API_URL"));

        if ($ibgeApi->successful()) {
            return $next($request);
        }

        $ibgeApi = Http::get(env("IBGE_API_URL"));

        if ($ibgeApi->successful()) {
            return $next($request);
        }

        return response()->json(["error" => "Não foi possível buscar os dados no momento, por favor tente mais tarde"], 502);
    }
}
