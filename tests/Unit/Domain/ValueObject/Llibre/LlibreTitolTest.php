<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Domain\ValueObject\Llibre;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\Exception\ValueObject\Llibre\LlibreTitolIsEmpty;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;

final class LlibreTitolTest extends TestCase
{
    private const TITOL = 'Curial e Güelfa';
    private const TITOL_WITH_SPACES = ' Curial e Güelfa ';

    public function test_that_with_empty_value_throws_exception(): void
    {
        $this->expectException(LlibreTitolIsEmpty::class);

        LlibreTitol::create('  ');
    }

    public function test_that_with_valid_value_returns_it(): void
    {
        self::assertSame(
            self::TITOL,
            LlibreTitol::create(self::TITOL_WITH_SPACES)->toString(),
        );
    }
}
