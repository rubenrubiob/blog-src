<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\Model\Llibre;
use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;

final class LlibreTest extends TestCase
{
    private const ID = '24455e19-e74e-4600-9c7b-7abefda5bac6';
    private const TITOL = 'Odissea';
    private const AUTOR = 'Homer';

    public function test_that_Llibre_is_constructed(): void
    {
        $llibre = Llibre::create(
            LlibreId::fromString(self::ID),
            LlibreTitol::create(self::TITOL),
            AutorNom::create(self::AUTOR),
        );

        self::assertSame(self::ID, $llibre->llibreId()->toString());
        self::assertSame(self::TITOL, $llibre->llibreTitol()->toString());
        self::assertSame(self::AUTOR, $llibre->autorNom()->toString());
    }
}
