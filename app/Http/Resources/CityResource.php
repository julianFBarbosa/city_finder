<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    static function normalizeData($data)
    {
        $source = $data["source"];
        $cityList = $data["list"];

        $microregion = "microrregiao";
        $imediateRegion = "regiao-imediata";

        if ($source == "BRASIL_API") {
            $ibgeCode = "codigo_ibge";
            $name = "nome";
            // using the *&* symbol to make sure that we're modifying the original subArray
            foreach ($cityList as &$list) {
                if (array_key_exists($name, $list)) {
                    $list["name"] = $list[$name];
                    unset($list[$name]);
                }
                if (array_key_exists($ibgeCode, $list)) {
                    $list["ibge_code"] = $list[$ibgeCode];
                    unset($list[$ibgeCode]);
                }
            }
            return $cityList;
        }

        if ($source == "IBGE_API") {
            $ibgeCode = "id";
            $name = "nome";
            // using the *&* symbol to make sure that we're modifying the original subArray
            foreach ($cityList as &$list) {
                if (array_key_exists($microregion, $list)) {
                    unset($list[$microregion]);
                }
                if (array_key_exists($imediateRegion, $list)) {
                    unset($list[$imediateRegion]);
                }
                if (array_key_exists($name, $list)) {
                    $list["name"] = $list[$name];
                    unset($list[$name]);
                }
                if (array_key_exists($ibgeCode, $list)) {
                    $list["ibge_code"] = strval($list[$ibgeCode]);
                    unset($list[$ibgeCode]);
                }
            }
            return $cityList;
        }
    }

    static function validateState($data, $state)
    {
        $acronym = "sigla";
        $isStateValid = null;

        foreach ($data as $list) {
            if (array_key_exists($acronym, $list) AND $list[$acronym] == $state) {
                $isStateValid = true;
            }
        }

        return $isStateValid;
    }
}
