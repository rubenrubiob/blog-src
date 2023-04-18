<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Functional\Llibre;

use PHPUnit\Framework\Attributes\DataProvider;
use rubenrubiob\Domain\Repository\Llibre\LlibreWriteRepository;
use rubenrubiob\Infrastructure\Persistence\InMemory\Llibre\InMemoryLlibreWriteRepository;
use rubenrubiob\Tests\Functional\FunctionalBaseTestCase;
use Symfony\Component\HttpFoundation\Response;

use function Safe\json_encode;

final class CreateLlibreTest extends FunctionalBaseTestCase
{
    private const KEY_TITOL = 'titol';
    private const KEY_AUTOR = 'autor';

    private const REQUEST_METHOD = 'POST';
    private const URI = '/llibres';

    private readonly InMemoryLlibreWriteRepository $llibreWriteRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->llibreWriteRepository = self::getContainer()->get(LlibreWriteRepository::class);
    }

    #[DataProvider('invalidRequestProvider')]
    public function test_peticio_incorrecta(array $requestContent): void
    {
        $this->client->request(
            method: self::REQUEST_METHOD,
            uri: self::URI,
            content: json_encode($requestContent),
        );

        $response = $this->client->getResponse();

        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertCount(0, $this->llibreWriteRepository->llibres);

        $this->openApiResponseAssert->__invoke($response, self::URI, self::REQUEST_METHOD);
    }

    public static function invalidRequestProvider(): array
    {
        return [
            'titol missing' => [
                [],
            ],
            'titol not string' => [
                [
                    self::KEY_TITOL => 1,
                ],
            ],
            'autor missing' => [
                [
                    self::KEY_TITOL => 'foo',
                ],
            ],
            'autor not string' => [
                [
                    self::KEY_TITOL => 'foo',
                    self::KEY_AUTOR => 1,
                ],
            ],
            'llibre i autor empty string' => [
                [
                    self::KEY_TITOL => ' ',
                    self::KEY_AUTOR => ' ',
                ],
            ],
        ];
    }

    public function test_retorna_resposta_valida(): void
    {
        $this->client->request(
            method: self::REQUEST_METHOD,
            uri: self::URI,
            content: json_encode(
                [
                    self::KEY_TITOL => 'Curial e Güelfa',
                    self::KEY_AUTOR => 'Anònim',
                ]
            ),
        );

        $response = $this->client->getResponse();

        self::assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        self::assertEmpty($this->client->getResponse()->getContent());

        self::assertCount(1, $this->llibreWriteRepository->llibres);

        $this->openApiResponseAssert->__invoke($response, self::URI, self::REQUEST_METHOD);
    }
}
