<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\Persistence\Dummy\Llibre;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\Exception\Repository\Llibre\LlibreDTONotFound;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Infrastructure\Persistence\Dummy\Llibre\DummyGetLlibreDTOByLlibreIdRepository;

final class DummyGetLlibreDTOByLlibreIdRepositoryTest extends TestCase
{
    private const EXISTING_ID = '080343dc-cb7c-497a-ac4d-a3190c05e323';
    private const NON_EXISTING_ID = '24197dfa-8912-46fa-af5f-57eee7943647';

    private readonly DummyGetLlibreDTOByLlibreIdRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new DummyGetLlibreDTOByLlibreIdRepository();
    }

    public function test_that_with_non_existing_llibre_id_throws_exception(): void
    {
        $this->expectException(LlibreDTONotFound::class);

        $this->repository->__invoke(LlibreId::fromString(self::NON_EXISTING_ID));
    }

    public function test_that_with_existing_llibre_id_returns_expected_dto(): void
    {
        $this->repository->__invoke(LlibreId::fromString(self::EXISTING_ID));

        $this->expectNotToPerformAssertions();
    }
}
