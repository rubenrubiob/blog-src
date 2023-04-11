<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Persistence\Dummy\Llibre;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\Exception\Repository\Llibre\LlibreDTONotFound;
use rubenrubiob\Domain\Repository\Llibre\FindLlibreDTOsRepository;
use rubenrubiob\Domain\Repository\Llibre\GetLlibreDTOByLlibreIdRepository;
use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;

final readonly class DummyFindLlibreDTOsRepository implements FindLlibreDTOsRepository
{
    public function __construct()
    {
    }

    /** @inheritDoc */
    public function __invoke(): array
    {
        return [
            new LlibreDTO(
                LlibreId::fromString('080343dc-cb7c-497a-ac4d-a3190c05e323'),
                LlibreTitol::create('Curial e Güelfa'),
                AutorNom::create('Anònim'),
            ),
            new LlibreDTO(
                LlibreId::fromString('95c544c1-6654-4477-a2c1-e89fc9a02356'),
                LlibreTitol::create('Tirant Lo Blanc'),
                AutorNom::create('Joanot Martorell'),
            ),
        ];
    }
}
