<?php

namespace App\Services;

use App\Http\Resources\CityResource;
use App\Repositories\Contracts\CityRepositoryInterface;

class CityService
{
    protected $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * get all cities within a state
     * @return array
    */
    public function getCityListByState($state)
    {
        return $this->cityRepository->getCityListByState($state);
    }

    public function validateState($state)
    {
        if(is_null($state)) {
            return null;
        }

        $stateList = $this->cityRepository->getStateList();
        $isStateValid =  CityResource::validateState($stateList, strtoupper($state));

        return $isStateValid;
    }
}
