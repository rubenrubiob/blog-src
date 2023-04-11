<?php

declare(strict_types=1);

namespace rubenrubiob\Application\Query\Llibre;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\Repository\Llibre\FindLlibreDTOsRepository;

final readonly class FindLlibreDTOsQueryHandler
{
    public function __construct(private FindLlibreDTOsRepository $repository)
    {
    }

    /** @return list<LlibreDTO> */
    public function __invoke(FindLlibreDTOsQuery $query): array
    {
        return $this->repository->__invoke();
    }
}
