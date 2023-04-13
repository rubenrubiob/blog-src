<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\Persistence\Dummy\Llibre;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Infrastructure\Persistence\Dummy\Llibre\DummyGetLlibreNextIdentityRepository;

final class DummyGetLlibreNextIdentityRepositoryTest extends TestCase
{
    private const ID = '30442d57-87ee-4de1-b81b-c5432a9a91be';

    public function test_that_with_fixed_id_always_return_id(): void
    {
        $repository = new DummyGetLlibreNextIdentityRepository(
            LlibreId::fromString(self::ID)
        );

        self::assertSame(self::ID, $repository->__invoke()->toString());
        self::assertSame(self::ID, $repository->__invoke()->toString());
    }

    public function test_that_with_not_fixed_id_always_return_a_new_one(): void
    {
        $repository = new DummyGetLlibreNextIdentityRepository();

        $firstId = $repository->__invoke();
        $secondId = $repository->__invoke();

        self::assertFalse(
            $firstId->isEqualTo($secondId)
        );
    }
}
