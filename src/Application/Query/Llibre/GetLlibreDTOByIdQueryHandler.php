<?php

declare(strict_types=1);

namespace rubenrubiob\Application\Query\Llibre;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\Exception\Repository\Llibre\LlibreDTONotFound;
use rubenrubiob\Domain\Repository\Llibre\GetLlibreDTOByLlibreIdRepository;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;

final readonly class GetLlibreDTOByIdQueryHandler
{
    public function __construct(
        private GetLlibreDTOByLlibreIdRepository $getLlibreDTOByLlibreIdRepository
    ) {
    }

    /** @throws LlibreDTONotFound */
    public function __invoke(GetLlibreDTOByIdQuery $query): LlibreDTO
    {
        return $this->getLlibreDTOByLlibreIdRepository->__invoke(
            LlibreId::fromString($query->id),
        );
    }
}
