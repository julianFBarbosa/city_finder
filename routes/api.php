<?php

use App\Http\Controllers\V1\CityController;
use App\Http\Middleware\VerifyApiIntegrity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/v1/cities/{state}", [CityController::class, "index"])
    ->middleware(VerifyApiIntegrity::class);
// Por limitação de tempo optei por não criar Controller, Resource, Repository e Service pra esse endpoint
Route::get("/v1/states", [CityController::class, "states"]);

Route::any('{path}', function () {
    return response()->json([
        "error" => 'Route not found'
    ], 404);
})->where('path', '.*');

Route::any('/', function () {
    return response()->json([
        "error" => 'Route not found'
    ], 404);
})->where('path', '.*');
