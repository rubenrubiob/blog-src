<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Common\Generator\Llibre;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;

final readonly class LlibreDTOGenerator
{
    private const ID = '24455e19-e74e-4600-9c7b-7abefda5bac6';
    private const TITOL = 'Odissea';
    private const AUTOR = 'Homer';

    public static function one(
        string $llibreId = self::ID,
        string $llibreTitol = self::TITOL,
        string $autorNom = self::AUTOR,
    ): LlibreDTO {
        return new LlibreDTO(
            LlibreId::fromString($llibreId),
            LlibreTitol::create($llibreTitol),
            AutorNom::create($autorNom),
        );
    }
}
