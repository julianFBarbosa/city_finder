<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\CityResource as V1CityResource;
use App\Services\CityService;
use App\Services\V1\CityService as V1CityService;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="Cities API",
 *   description="Listagem de cidades dentro de um Estado válido",
 *   @OA\Attachable()
 * )
 */
class CityController extends Controller
{
    protected $cityService;

    public function __construct(V1CityService $cityService)
    {

        $this->cityService = $cityService;
    }


    /**
     * @OA\Get(
     *     path="/v1/api/cities/{state}",
     *     summary="Query a list of cities within a valid state",
     *     @OA\Parameter(
     *         name="state",
     *         in="path",
     *         description="A Valid Acronym of a brazilian state",
     *         @OA\Schema(type="string"),
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="List of cities within a state"),
     *     @OA\Response(response="400", description="State not found"),
     *     @OA\Response(response="500", description="internal error")
     * )
     */
    public function index(Request $request, $state)
    {
        $isStateValid = $this->cityService->validateState($state);

        if (is_null($isStateValid)) {
            return response()->json(["error" => "Estado não encontrado"], 404);
        }

        $cities = $this->cityService->getCityListByState($state);
        return V1CityResource::normalizeData($cities);
    }
}
