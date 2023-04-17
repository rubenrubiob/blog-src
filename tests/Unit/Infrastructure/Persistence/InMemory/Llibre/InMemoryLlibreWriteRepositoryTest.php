<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\Persistence\InMemory\Llibre;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Infrastructure\Persistence\InMemory\Llibre\InMemoryLlibreWriteRepository;
use rubenrubiob\Tests\Common\Generator\Llibre\LlibreGenerator;

final class InMemoryLlibreWriteRepositoryTest extends TestCase
{
    private readonly InMemoryLlibreWriteRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new InMemoryLlibreWriteRepository();
    }

    public function test_that_add_Llibre_saves_it(): void
    {
        $firstLlibre = LlibreGenerator::one();
        $secondLlibre = LlibreGenerator::another();

        self::assertCount(0, $this->repository->llibres);

        $this->repository->afegir($firstLlibre);
        $this->repository->afegir($secondLlibre);

        self::assertCount(2, $this->repository->llibres);
        self::assertArrayHasKey(
            $firstLlibre->llibreId()->toString(),
            $this->repository->llibres
        );
        self::assertArrayHasKey(
            $secondLlibre->llibreId()->toString(),
            $this->repository->llibres
        );
    }
}
