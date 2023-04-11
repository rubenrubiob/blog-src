<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Application\Query\Llibre;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Application\Query\Llibre\FindLlibreDTOsQuery;
use rubenrubiob\Application\Query\Llibre\FindLlibreDTOsQueryHandler;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Infrastructure\Persistence\Dummy\Llibre\DummyFindLlibreDTOsRepository;

final class FindLlibreDTOsQueryHandlerTest extends TestCase
{
    private readonly FindLlibreDTOsQueryHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new FindLlibreDTOsQueryHandler(
            new DummyFindLlibreDTOsRepository(),
        );
    }

    public function test_that_it_only_returns_instances_of_LlibreDTO(): void
    {
        $llibres = $this->handler->__invoke(
            new FindLlibreDTOsQuery(),
        );

        self::assertContainsOnlyInstancesOf(LlibreDTO::class, $llibres);
        self::assertCount(2, $llibres);
    }
}
