<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Functional\Llibre;

use rubenrubiob\Tests\Functional\FunctionalBaseTestCase;
use Symfony\Component\HttpFoundation\Response;

use function Safe\json_decode;

final class FindLlibresTest extends FunctionalBaseTestCase
{
    private const REQUEST_METHOD = 'GET';
    private const URI = '/llibres';

    public function test_retorna_resposta_valida(): void
    {
        $this->client->request(
            self::REQUEST_METHOD,
            self::URI,
        );

        $response = $this->client->getResponse();
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertCount(2, $responseContent);

        self::assertEquals(
            [
                [
                    'id' => '080343dc-cb7c-497a-ac4d-a3190c05e323',
                    'titol' => 'Curial e Güelfa',
                    'autor' => 'Anònim',
                ],
                [
                    'id' => '95c544c1-6654-4477-a2c1-e89fc9a02356',
                    'titol' => 'Tirant Lo Blanc',
                    'autor' => 'Joanot Martorell',
                ],
            ],
            $responseContent,
        );

        $this->openApiResponseAssert->__invoke($response, self::URI, self::REQUEST_METHOD);
    }
}
