<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Contracts\CityRepositoryInterface;
use Illuminate\Support\Facades\Http;

class CityRepository implements CityRepositoryInterface
{
    protected $entity;

    public function __construct(City $city)
    {
        $this->entity = $city;
    }

    public function getCityListByState($state)
    {
        $cityList = $this->getCityList($state);
        return $cityList;
    }

    private function getCityList($state)
    {
        $request = Http::get(env("BRASIL_API_URL").$state);

        if ($request->successful()) {
            return [
                "list" => $request->json(),
                "source" => "BRASIL_API"
            ];
        }

        $request = Http::get(env("IBGE_API_URL").$state."/municipios");

        if ($request->successful()) {
            return [
                "list" => $request->json(),
                "source" => "IBGE_API"
            ];
        }

        return null;
    }
}
