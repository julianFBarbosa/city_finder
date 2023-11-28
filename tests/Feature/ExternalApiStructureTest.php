<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExternalApiStructureTest extends TestCase
{
    public function test_brasil_api_states_endpoint(): void
    {
    }

    public function test_ibge_api_endpoint(): void
    {
        $apiUrl = env("IBGE_API_URL");
        $response = Http::get($apiUrl);
        // não consegui executar uma chamada para api externa e testá-la aqui :(

        $statusCode = $response->getStatusCode();

        $this->assertEquals(200, $statusCode);

        $response
            ->assertJsonStructure([
                "data" => [
                    "id",
                    "sigla",
                    "nome",
                    "regiao" => [
                        "id",
                        "sigla",
                        "nome",
                    ],
                ]
            ]);
    }
}
