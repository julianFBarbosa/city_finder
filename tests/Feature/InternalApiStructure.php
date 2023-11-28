<?php

namespace Tests\Feature;

use Tests\TestCase;

class InternalApiStructureTest extends TestCase
{
    public function test_endpoint_de_cidades_deve_retornar_um_json_valido(): void
    {
        $mockState = "MG";
        $response = $this->get("api/cities/" . $mockState);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    "name",
                    "ibge_code"
                ]
            ]);
    }

    public function test_endpoint_de_listagem_deve_retornar_erro_ao_enviar_sigla_invalida(): void
    {
        $mockState = "ABC";
        $response = $this->get("api/cities/" . $mockState);

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                "error"
            ]);
    }

    public function test_endpoint_de_listagem_deve_retornar_erro_ao_nao_enviar_sigla(): void
    {
        $mockState = "";
        $response = $this->get("api/cities/" . $mockState);

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                "error"
            ]);
    }
}
