<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Event;

use DateTimeImmutable;

interface DomainEvent
{
    /** @return non-empty-string */
    public function aggregateRootId(): string;

    /** @return non-empty-string */
    public function type(): string;

    public function occurredOn(): DateTimeImmutable;

    /** @return array<non-empty-string, mixed> */
    public function payload(): array;
}
