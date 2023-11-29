<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Contracts\CityRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class CityRepository implements CityRepositoryInterface
{
    protected $entity;
    protected $time = 300;

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
        if (Cache::has("cities-" . $state)) {
            return Cache::get("cities-" . $state);
        }

        $request = Http::get(env("BRASIL_API_URL") . $state);

        if ($request->successful()) {
            $response = $this->storeCityListData($request->json(), "BRASIL_API", $state);
            return $response;
        }

        $request = Http::get(env("IBGE_API_URL") . $state . "/municipios");


        if ($request->successful()) {
            $response = $this->storeCityListData($request->json(), "IBGE_API", $state);
            return $response;
        }

        return [
            "error" => "Não foi possível entrar em contato com as APIs de busca."
        ];
    }

    public function getStateList()
    {
        if (Cache::has("states")) {
            dd("cached");
            return Cache::get("states");
        }

        $request = Http::get(env("BRASIL_UF_API_URL"));

        if ($request->successful()) {
            return $request->json();
        }

        $this->storeStateData($request->successful(), $request->json());

        $request = Http::get(env("IBGE_API_URL"));

        if ($request->successful()) {
            return $request->json();
        }

        return null;
    }

    private function storeStateData($isSuccessful, $list)
    {
        if ($isSuccessful) {
            Cache::add('state-list', $list, $this->time);
            return $list;
        }
    }

    private function storeCityListData($list, $source, $state)
    {
        $data = [
            "list" => $list,
            "source" => $source
        ];

        Cache::add('cities-' . $state, $data, $this->time);
        return $data;
    }
}
