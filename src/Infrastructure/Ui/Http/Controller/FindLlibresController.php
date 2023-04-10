<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Controller;

use rubenrubiob\Application\Query\Llibre\FindLlibreDTOsQuery;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Infrastructure\QueryBus\QueryBus;

final readonly class FindLlibresController
{
    public function __construct(private QueryBus $queryBus)
    {
    }

    /** @return list<LlibreDTO> */
    public function __invoke(): array
    {
        return $this->queryBus->__invoke(
            new FindLlibreDTOsQuery()
        );
    }
}
