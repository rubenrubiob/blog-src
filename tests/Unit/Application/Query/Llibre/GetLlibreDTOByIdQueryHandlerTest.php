<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Application\Query\Llibre;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Application\Query\Llibre\GetLlibreDTOByIdQuery;
use rubenrubiob\Application\Query\Llibre\GetLlibreDTOByIdQueryHandler;
use rubenrubiob\Domain\Exception\Repository\Llibre\LlibreDTONotFound;
use rubenrubiob\Infrastructure\Persistence\Dummy\Llibre\DummyGetLlibreDTOByLlibreIdRepository;

final class GetLlibreDTOByIdQueryHandlerTest extends TestCase
{
    private const EXISTING_ID = '080343dc-cb7c-497a-ac4d-a3190c05e323';
    private const NON_EXISTING_ID = '24197dfa-8912-46fa-af5f-57eee7943647';

    private readonly GetLlibreDTOByIdQueryHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new GetLlibreDTOByIdQueryHandler(
            new DummyGetLlibreDTOByLlibreIdRepository()
        );
    }

    public function test_that_with_non_existing_llibreId_throws_exception(): void
    {
        $this->expectException(LlibreDTONotFound::class);

        $this->handler->__invoke(
            new GetLlibreDTOByIdQuery(
                self::NON_EXISTING_ID
            )
        );
    }

    public function test_that_with_existing_llibreId_returns_LlibreDTO(): void
    {
        $this->handler->__invoke(
            new GetLlibreDTOByIdQuery(
                self::EXISTING_ID
            )
        );

        $this->expectNotToPerformAssertions();
    }
}
