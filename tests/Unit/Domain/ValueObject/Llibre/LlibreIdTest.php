<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Domain\ValueObject\Llibre;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use rubenrubiob\Domain\Exception\ValueObject\Llibre\LlibreIdFormatIsNotValid;
use rubenrubiob\Domain\Exception\ValueObject\Llibre\LlibreIdIsEmpty;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;

final class LlibreIdTest extends TestCase
{
    private const ID = '65355b9d-fca9-48f5-b297-19accd1d743f';
    private const ID_WITH_SPACES = ' 65355b9d-fca9-48f5-b297-19accd1d743f ';
    private const ID_UPPER_CASE = '65355B9D-FCA9-48F5-B297-19ACCD1D743F';
    private const ANOTHER_ID = 'f1388357-4d28-418f-bc10-335d037bcd07';

    public function test_that_with_empty_value_throws_expected_exception(): void
    {
        $this->expectException(LlibreIdIsEmpty::class);

        LlibreId::fromString(' ');
    }

    public function test_that_with_invalid_value_throws_expected_exception(): void
    {
        $this->expectException(LlibreIdFormatIsNotValid::class);

        LlibreId::fromString('foo');
    }

    public static function test_that_generate_creates_a_valid_uuid(): void
    {
        self::assertTrue(
            Uuid::isValid(
                LlibreId::generate()->toString()
            )
        );
    }

    #[DataProvider('validValueProvider')]
    public function test_that_with_valid_value_returns_it(string $id): void
    {
        self::assertSame(
            self::ID,
            LlibreId::fromString($id)->toString()
        );
    }

    public static function validValueProvider(): iterable
    {
        return [
            'id with spaces' => [self::ID_WITH_SPACES],
            'id with upper case' => [self::ID_UPPER_CASE],
        ];
    }

    public function test_that_isEqualTo_returns_correctly(): void
    {
        $firstId = LlibreId::fromString(self::ID);
        $anotherFirstId = LlibreId::fromString(self::ID);
        $anotherId = LlibreId::fromString(self::ANOTHER_ID);

        self::assertTrue($firstId->isEqualTo($anotherFirstId));
        self::assertFalse($firstId->isEqualTo($anotherId));
    }

    public function test_that_default_named_constructor_is_valid(): void
    {
        self::assertSame(
            [LlibreId::class, 'create'],
            LlibreId::defaultNamedConstructor()
        );
    }
}
