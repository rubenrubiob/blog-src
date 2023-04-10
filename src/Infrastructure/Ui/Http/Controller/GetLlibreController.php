<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Controller;

use rubenrubiob\Application\Query\Llibre\GetLlibreDTOByIdQuery;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Infrastructure\QueryBus\QueryBus;

final readonly class GetLlibreController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    public function __invoke(string $llibreId): LlibreDTO
    {
        return $this->queryBus->__invoke(
            new GetLlibreDTOByIdQuery(
                $llibreId
            )
        );
    }
}
