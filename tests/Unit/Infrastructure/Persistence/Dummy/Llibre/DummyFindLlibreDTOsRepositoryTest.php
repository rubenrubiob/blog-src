<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\Persistence\Dummy\Llibre;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Infrastructure\Persistence\Dummy\Llibre\DummyFindLlibreDTOsRepository;

final class DummyFindLlibreDTOsRepositoryTest extends TestCase
{
    private readonly DummyFindLlibreDTOsRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new DummyFindLlibreDTOsRepository();
    }

    public function test_only_returns_LlibreDTOs(): void
    {
        $llibres = $this->repository->__invoke();

        self::assertContainsOnlyInstancesOf(LlibreDTO::class, $llibres);
        self::assertCount(2, $llibres);
    }
}
