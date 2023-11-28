<?php

namespace App\Http\Controllers;

use App\Http\Resources\CityResource;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $state)
    {
        $isStateValid = $this->cityService->validateState($state);

        if(is_null($isStateValid)) {
            return response()->json(["error" => "O estado inserido não existe"], 400);
        }

        $cities = $this->cityService->getCityListByState($state);
        return CityResource::normalizeData($cities);
    }
}
