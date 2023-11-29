<?php

namespace Tests\Feature;

use Tests\Feature\Traits\DocumentTrait;
use Tests\TestCase;

class ApiStructureTest extends TestCase
{
    use DocumentTrait;

    /**
     * Test if the function can return a document list or a error response
     *
     *  @dataProvider requestOtions
     */
    public function test_deve_retornar_uma_lista_de_estados($input, $expected_output)
    {
        $response = $this->call('GET', "api/v1/states");
        $response->assertStatus($expected_output['status_code']);
        $response->assertJsonStructure($expected_output['payload_structure']);
    }

    public function test_endpoint_de_cidades_deve_retornar_um_json_valido()
    {
        $mockState = "MG";
        $response = $this->get("api/v1/cities/" . $mockState);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                [
                    "name",
                    "ibge_code"
                ]
            ]);
    }

    public function test_endpoint_de_listagem_deve_retornar_erro_ao_enviar_sigla_invalida()
    {
        $mockState = "ABC";
        $response = $this->get("api/v1/cities/" . $mockState);

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                "error"
            ]);
    }

    public function test_endpoint_de_listagem_deve_retornar_erro_ao_nao_enviar_sigla()
    {
        $mockState = "";
        $response = $this->get("api/v1/cities/" . $mockState);

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                "error"
            ]);
    }
}
