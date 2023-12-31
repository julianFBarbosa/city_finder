<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\CityResource as V1CityResource;
use App\Services\V1\CityService as V1CityService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
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
    protected $perPage = 15;

    public function __construct(V1CityService $cityService)
    {

        $this->cityService = $cityService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/cities/{state}",
     *     summary="Query a City list within a valid State",
     *     @OA\Parameter(
     *         name="state",
     *         in="path",
     *         description="A Valid Acronym of a Brazilian Btate",
     *         @OA\Schema(type="string"),
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="City List within a state"),
     *     @OA\Response(response="404", description="State not found"),
     *     @OA\Response(response="500", description="internal error")
     * )
     */
    public function index(Request $request, string $state)
    {
        $state = strtoupper($state);
        $isStateValid = $this->cityService->validateState($state);

        if (is_null($isStateValid)) {
            return response()->json(["error" => "Estado não encontrado"], 404);
        }

        $page = $request->get("page");
        $cities = $this->cityService->getCityListByState($state);

        if (array_key_exists("error", $cities)) {
            return response()->json(["error" => $cities["error"]], 500);
        }

        if (is_null($page)) {
            return V1CityResource::normalizeData($cities);
        }

        $collection = new Collection($cities["list"]);
        $paginatedData = new LengthAwarePaginator(
            $collection->forPage($page, $this->perPage),
            $collection->count(),
            $this->perPage,
            $page,
            ["path" => url("/cities")],
        );

        return response()->json($paginatedData)->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/states",
     *     summary="Query a Brazilian State list",
     *     @OA\Response(response="200", description="Brazilian State list"),
     *     @OA\Response(response="500", description="internal error")
     * )
     */
    public function states(Request $request) {
        $response = $this->cityService->getStateList();


        if (is_null($response)) {
            return response()->json(["error" => "Não foi possível buscar a lista de Estados"], 404);
        }

        return response()->json($response);
    }
}
