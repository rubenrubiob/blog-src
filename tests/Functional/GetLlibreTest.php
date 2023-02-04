<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function Safe\json_decode;

final class GetLlibreTest extends WebTestCase
{
    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function test_amb_llibre_retorna_resposta_valida(): void
    {
        $this->client->request(
            'GET',
            '/llibre/08d591eb-9ab5-454d-9464-09dcea8a3c8b',
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(
            [
                'id' => '08d591eb-9ab5-454d-9464-09dcea8a3c8b',
                'titol' => 'Curial e Güelfa',
                'autor' => 'Anònim',
            ],
            $response,
        );
    }
}
