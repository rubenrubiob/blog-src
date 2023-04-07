<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Controller;

use rubenrubiob\Application\Query\Llibre\GetLlibreDTOByIdQuery;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\Exception\Repository\Llibre\LlibreDTONotFound;
use rubenrubiob\Infrastructure\QueryBus\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class GetLlibreController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(string $llibreId): Response
    {
        try {
            /** @var LlibreDTO $llibreDTO */
            $llibreDTO = $this->queryBus->__invoke(
                new GetLlibreDTOByIdQuery(
                    $llibreId
                )
            );
        } catch (LlibreDTONotFound $e) {
            return new JsonResponse(
                [
                    'error' => $e->getMessage(),
                ],
                Response::HTTP_NOT_FOUND,
            );
        }

        return new JsonResponse(
            [
                'id' => $llibreDTO->llibreId->toString(),
                'titol' => $llibreDTO->llibreTitol->toString(),
                'autor' => $llibreDTO->autorNom->toString(),
            ],
            Response::HTTP_OK,
        );
    }
}
