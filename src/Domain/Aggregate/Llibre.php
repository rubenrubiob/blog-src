<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Aggregate;

use Safe\DateTimeImmutable;
use rubenrubiob\Domain\Event\LlibreWasCreated;
use rubenrubiob\Domain\Service\Event\EventStore;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;

final readonly class Llibre
{
    private LlibreId $llibreId;

    public function __construct(LlibreId $llibreId)
    {
        $this->llibreId = $llibreId;

        EventStore::getInstance()->publish(
            new LlibreWasCreated(
                $this->llibreId,
                new DateTimeImmutable(),
            )
        );
    }
}
