<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Response;

use function Safe\json_decode;
use function sprintf;

final class GetLlibreTest extends WebTestCase
{
    private const EXISTING_LLIBRE_ID = '080343dc-cb7c-497a-ac4d-a3190c05e323';
    private const NON_EXISTING_LLIBRE_ID = '4bb201e9-2c07-4a3a-b423-eca329d2f081';
    private const INVALID_LLIBRE_ID = 'foo';
    private const EMPTY_LLIBRE_ID = ' ';

    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
    }

    public function test_amb_llibreId_buit_retorna_400(): void
    {
        $this->client->request(
            'GET',
            $this->url(self::EMPTY_LLIBRE_ID),
        );

        $response = $this->client->getResponse();

        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function test_amb_llibreId_not_valid_retorna_400(): void
    {
        $this->client->request(
            'GET',
            $this->url(self::INVALID_LLIBRE_ID),
        );

        $response = $this->client->getResponse();

        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function test_amb_non_existing_llibre_retorna_404(): void
    {
        $this->client->request(
            'GET',
            $this->url(self::NON_EXISTING_LLIBRE_ID),
        );

        $response = $this->client->getResponse();

        self::assertSame(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function test_amb_llibre_retorna_resposta_valida(): void
    {
        $this->client->request(
            'GET',
            $this->url(self::EXISTING_LLIBRE_ID),
        );

        $response = $this->client->getResponse();
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertEquals(
            [
                'id' => self::EXISTING_LLIBRE_ID,
                'titol' => 'Curial e Güelfa',
                'autor' => 'Anònim',
            ],
            $responseContent,
        );
    }

    private function url(string $llibreId): string
    {
        return sprintf(
            '/llibres/%s',
            $llibreId
        );
    }
}
