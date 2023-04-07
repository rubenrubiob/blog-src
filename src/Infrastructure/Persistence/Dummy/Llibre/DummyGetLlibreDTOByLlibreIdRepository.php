<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Persistence\Dummy\Llibre;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\Exception\Repository\Llibre\LlibreDTONotFound;
use rubenrubiob\Domain\Repository\Llibre\GetLlibreDTOByLlibreIdRepository;
use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;

final readonly class DummyGetLlibreDTOByLlibreIdRepository implements GetLlibreDTOByLlibreIdRepository
{
    private const LLIBRE_ID_EXISTING = '080343dc-cb7c-497a-ac4d-a3190c05e323';

    private LlibreDTO $llibreDTO;

    public function __construct()
    {
        $this->llibreDTO = new LlibreDTO(
            LlibreId::fromString(self::LLIBRE_ID_EXISTING),
            LlibreTitol::create('Curial e Güelfa'),
            AutorNom::create('Anònim'),
        );
    }

    public function __invoke(LlibreId $llibreId): LlibreDTO
    {
        $this->failWhenLlibreIdNotExists($llibreId);

        return $this->llibreDTO;
    }

    private function failWhenLlibreIdNotExists(LlibreId $llibreId): void
    {
        if (!$llibreId->isEqualTo($this->llibreDTO->llibreId)) {
            throw LlibreDTONotFound::withLlibreId($llibreId);
        }
    }
}
