<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Application\Command\Llibre;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Application\Command\Llibre\CrearLlibreCommand;
use rubenrubiob\Application\Command\Llibre\CrearLlibreCommandHandler;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Infrastructure\Persistence\Dummy\Llibre\DummyGetLlibreNextIdentityRepository;
use rubenrubiob\Infrastructure\Persistence\InMemory\Llibre\InMemoryLlibreWriteRepository;

final class CrearLlibreCommandHandlerTest extends TestCase
{
    private const ID = 'a802fd41-a829-4b7b-9a85-8ec5b27afcaa';
    private const TITOL = 'Curial e Güelfa';
    private const AUTOR = 'Anònim';

    private readonly InMemoryLlibreWriteRepository $writeRepository;
    private readonly CrearLlibreCommandHandler $handler;

    protected function setUp(): void
    {
        $this->writeRepository = new InMemoryLlibreWriteRepository();

        $this->handler = new CrearLlibreCommandHandler(
            new DummyGetLlibreNextIdentityRepository(
                LlibreId::fromString(self::ID)
            ),
            $this->writeRepository
        );
    }

    public function test_that_Llibre_is_saved_in_repository(): void
    {
        $this->handler->__invoke(
            new CrearLlibreCommand(
                self::TITOL,
                self::AUTOR
            )
        );

        self::assertCount(1, $this->writeRepository->llibres);
        self::assertArrayHasKey(self::ID, $this->writeRepository->llibres);
    }
}
