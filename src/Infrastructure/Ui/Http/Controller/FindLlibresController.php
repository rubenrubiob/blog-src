<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Controller;

use rubenrubiob\Application\Query\Llibre\FindLlibreDTOsQuery;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Infrastructure\QueryBus\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use function array_map;

final readonly class FindLlibresController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(): Response
    {
        /** @var list<LlibreDTO> $llibres */
        $llibres = $this->queryBus->__invoke(
            new FindLlibreDTOsQuery()
        );

        $formattedResponse = array_map(
            fn(LlibreDTO $llibreDTO): array =>
            [
                'id' => $llibreDTO->llibreId->toString(),
                'titol' => $llibreDTO->llibreTitol->toString(),
                'autor' => $llibreDTO->autorNom->toString(),
            ],
            $llibres,
        );

        return new JsonResponse(
            $formattedResponse,
            Response::HTTP_OK,
        );
    }
}
