<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Functional;

use rubenrubiob\Domain\Repository\Llibre\LlibreWriteRepository;
use rubenrubiob\Infrastructure\Persistence\InMemory\Llibre\InMemoryLlibreWriteRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

use function Safe\json_encode;

final class CreateLlibreTest extends WebTestCase
{
    private readonly InMemoryLlibreWriteRepository $llibreWriteRepository;
    private readonly KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->llibreWriteRepository = self::getContainer()->get(LlibreWriteRepository::class);
    }

    public function test_retorna_resposta_valida(): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/llibres',
            content: json_encode(
                [
                    'titol' => 'Curial e Güelfa',
                    'autor' => 'Anònim',
                ]
            ),
        );

        $response = $this->client->getResponse();

        self::assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        self::assertEmpty($this->client->getResponse()->getContent());

        self::assertCount(1, $this->llibreWriteRepository->llibres);
    }
}
