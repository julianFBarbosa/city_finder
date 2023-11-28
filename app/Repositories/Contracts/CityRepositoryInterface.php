<?php


namespace App\Repositories\Contracts;

interface CityRepositoryInterface
{
    public function getCityListByState($state);
    public function getStateList();
}
