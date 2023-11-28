<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiIntegrity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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

        return response()->json(["error" => "Não foi possível acessar a API no momento, por favor tente mais tarde"], 403);
    }
}
