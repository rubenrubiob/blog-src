<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Domain\ValueObject\Llibre;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\Exception\ValueObject\Llibre\AutorNomIsEmpty;
use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;

final class AutorNomTest extends TestCase
{
    private const NOM = 'Anònim';
    private const NOM_WITH_SPACES = ' Anònim ';

    public function test_that_with_empty_value_throws_exception(): void
    {
        $this->expectException(AutorNomIsEmpty::class);

        AutorNom::create('  ');
    }

    public function test_that_with_valid_value_returns_it(): void
    {
        self::assertSame(
            self::NOM,
            AutorNom::create(self::NOM_WITH_SPACES)->toString(),
        );
    }
}
