<?php

declare(strict_types=1);

namespace rubenrubiob\Application\Command\Llibre;

use rubenrubiob\Domain\Model\Llibre;
use rubenrubiob\Domain\Repository\Llibre\GetLlibreNextIdentityRepository;
use rubenrubiob\Domain\Repository\Llibre\LlibreWriteRepository;
use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;

final readonly class CrearLlibreCommandHandler
{
    public function __construct(
        private GetLlibreNextIdentityRepository $nextIdentityRepository,
        private LlibreWriteRepository $writeRepository
    ) {
    }

    public function __invoke(CrearLlibreCommand $command): void
    {
        $llibre = Llibre::create(
            $this->nextIdentityRepository->__invoke(),
            LlibreTitol::create($command->llibreTitol),
            AutorNom::create($command->autorNom),
        );

        $this->writeRepository->afegir($llibre);
    }
}
