<?php

namespace Tests\Feature\Traits;

trait DocumentTrait
{
    public static  function requestOtions()
    {
        return [
            'É enviado uma lista de Estados' => [
                'input' => [
                    'type' => 'successfulRequest',
                ],
                'expected_output' => [
                    'status_code' => 200,
                    'payload_structure' => [
                        "*" => [
                            "id",
                            "sigla",
                            "nome",
                            "regiao" => [
                                "id",
                                "sigla",
                                "nome",
                            ],
                        ],
                    ],
                ],
            ]
        ];
    }
}
