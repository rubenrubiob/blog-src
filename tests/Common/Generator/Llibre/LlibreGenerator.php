<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Common\Generator\Llibre;

use rubenrubiob\Domain\Model\Llibre;
use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;

final readonly class LlibreGenerator
{
    private const FIRST_ID = '24455e19-e74e-4600-9c7b-7abefda5bac6';
    private const FIRST_TITOL = 'Odissea';
    private const FIRST_AUTOR = 'Homer';

    private const SECOND_ID = 'ddeb7bc3-8964-4b75-8211-28f916f77d6f';
    private const SECOND_TITOL = 'Llibre de l\'Ordre de Cavalleria';
    private const SECOND_AUTOR = 'Ramon Llull';

    public static function one(
        string $llibreId = self::FIRST_ID,
        string $llibreTitol = self::FIRST_TITOL,
        string $autorNom = self::FIRST_AUTOR,
    ): Llibre {
        return Llibre::create(
            LlibreId::fromString($llibreId),
            LlibreTitol::create($llibreTitol),
            AutorNom::create($autorNom),
        );
    }

    public static function another(
        string $llibreId = self::SECOND_ID,
        string $llibreTitol = self::SECOND_TITOL,
        string $autorNom = self::SECOND_AUTOR,
    ): Llibre {
        return Llibre::create(
            LlibreId::fromString($llibreId),
            LlibreTitol::create($llibreTitol),
            AutorNom::create($autorNom),
        );
    }
}
